$(document).ready(function(){
    
    updatePreferiti();
    updatePersonali();

    var map = initializeMap();

    /*
     * Centra la mappa sulla città dell'utente: geocoder trasforma
     * strinche (indirizzi) in coppie lat/lon. La richiesta è sincrona:
     * dobbiamo posizionare la mappa prima di chiedere al server
     * la lista di eventi.
     */
    geocoder = new google.maps.Geocoder();
    $.ajax({

        async: false,
        url: "CHome.php",
        data: {

            'action': "getUtente"

        }
    })
    .done(function(data){
        response = jQuery.parseJSON(data);
        if (response.logged){
            geocoder.geocode(
            {
                'address': response.citta
            },
            function(results, status) {
                map.setCenter(results[0].geometry.location);
            }
            );
        }
    });

    /* Markers conterrà i riferimenti ai markers che verranno inseriti
     * sulla mappa, rendendo più facile la loro modifica/cancellazione
     */
    markers = [];
    var infowindow = new google.maps.InfoWindow({
        'maxWidth': 400
    });
    google.maps.event.addListener(infowindow, 'closeclick', function(){
        infowindow.marker = null;
    });
    google.maps.event.addListener(map, 'idle', getEventiMappa);
    /*
     * Al click sulla mappa, chiudiamo la infowindow e settiamo
     * a null l'id del marker ad essa associato.
     */
    google.maps.event.addListener(map, 'click', function(){
        infowindow.marker = null;
        infowindow.close();
    });

    /*
     * Aggiunta di un evento ai preferiti.
     */
    //{if $autenticato}
    $('.addPreferiti').live("click", function(event){
        addPreferiti(event.target.id);
        if (markers)
            for(i=0; i<markers.length; ++i){
                if(markers[i].id == event.target.id){
                    infowindow.setContent(markers[i].infoHTML());
                }
            }
        return false;
    });
    //{/if}

    //{if $autenticato}
    $('.removePreferiti').live("click", function(event){
        removePreferiti(event.target.id);
        if (markers)
            for(i=0; i<markers.length; ++i){
                if(markers[i].id == event.target.id){
                    infowindow.setContent(markers[i].infoHTML());
                }
            }
        return false;
    });
    //{/if}

    //Aggiungo/tolgo un evento tra i consigliati
    $('.addConsigliati').live("click", function(event){
        addConsigliati(event.target.id);
        if (markers)
            for(i=0; i<markers.length; ++i){
                if(markers[i].id == event.target.id){
                    infowindow.setContent(markers[i].infoHTML());
                }
            }
        return false;
    });
    
   $('.removeConsigliati').live("click", function(event){
        removeConsigliati(event.target.id);
        if (markers)
            for(i=0; i<markers.length; ++i){
                if(markers[i].id == event.target.id){
                    infowindow.setContent(markers[i].infoHTML());
                }
            }
        return false;
    });
     

    /*
     * Visualizza sulla mappa gli eventi contenuti in
     * bounds (oggetto LatLngBounds di Google Maps)
     */
    function getEventiMappa(){
        updatePreferiti();
        bounds = map.getBounds();
        $.get("CHome.php",
        {
            'action': "getEventiMappa",
            'neLat': bounds.getNorthEast().lat(),
            'neLon': bounds.getNorthEast().lng(),
            'swLat': bounds.getSouthWest().lat(),
            'swLon': bounds.getSouthWest().lng()
        })
        .success(function(data) {
            /* Per prima cosa eliminiamo i "vecchi" markers
             */

            //ho inizializzato la mappa, posso fornire eventi consigliati
            updateConsigliati(map,false);

            if (markers){
                for(i=0; i<markers.length; ++i)
                    markers[i].setMap(null);
            }
            markers.length = 0;
            /* Creazione dei nuovi markers dal JSON
             */
            var response = jQuery.parseJSON(data);
            $.each(response, function(i){
                var pos = new google.maps.LatLng(
                    parseFloat(response[i].lat),
                    parseFloat(response[i].lon)
                    );
                var marker = new google.maps.Marker({
                    'position':pos,
                    'map':map
                });
                marker.id = parseInt(response[i].id_evento);
                marker.title = response[i].nome;
                marker.descrizione = response[i].descrizione;
                marker.data = response[i].data;
                marker.preferito = checkPreferito(marker.id);
                marker.infoHTML = infoHTML;
                markers.push(marker);
            });


            if (markers)
                for(i=0; i<markers.length; ++i){
                    var marker = markers[i];
                    google.maps.event.addListener(marker, 'click', function(){
                        google.maps.event.clearListeners(map, 'idle');
                        google.maps.event.addListener(map, 'idle', mapWait);
                        /*
                         * Se la infowindow era chiusa o era posizionata
                         * su un altro marker, la posizioniamo su this
                         * e carichiamo le informazioni relative.
                         */
                        if (infowindow.marker != this.id){
                            infowindow.marker = this.id;
                            infowindow.setContent(this.infoHTML());
                            infowindow.open(map, this);
                        }
                        /* Altrimenti chiudiamo la infowindow.
                         */
                        else {
                            infowindow.close();
                            infowindow.marker = null;
                        }
                    });
                }
        });
    }

    /*
     * Quando viene aperta una infowindow bisogna impedire il triggering
     * di getEventiMappa(). Altrimenti il marker verrebbe cancellato
     * e la infowindow verrebbe chiusa.
     */
    function mapWait(){
        google.maps.event.clearListeners(map, 'idle');
        google.maps.event.addListener(map, 'idle', getEventiMappa);
    }

    /*
     * Formattazione del contenuto delle infoWindow
     */
    function infoHTML(){
        this.preferito = checkPreferito(this.id);
        this.consigliato = checkConsigliato(this.id);
        console.log (this.preferito);
        var output= '<div class="infowindow">'+
        '<h2>'+this.title+'</h2>'+
        '<h3>'+this.data;
        if (this.preferito == false){
            output +=' - <a href="#" class="addPreferiti" id="'+this.id+
            '">Aggiungi ai Preferiti</a></h3>';
        }
        else {
            output +=' - <a href="#" class="removePreferiti" id="'+this.id+
            '">Rimuovi dai Preferiti</a></h3>';
        }
        output+='<p>'+this.descrizione+
        ' <a href="CBacheca.php?id='+this.id+'">(visualizza altro)</a></p>';
        if(this.consigliato == false){
            output += '<div><h3><a href="#" class="addConsigliati" id="'+this.id+'">Lo Consiglio!'+
            '</a></h3></div></div>';
        }else {
            output += '<div><h3><a href="#" class="removeConsigliati" id="'+this.id+'">Non lo Consiglio Più!'+
            '</a></h3></div></div>';
        }
        return output;
    }
});
