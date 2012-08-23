$(document).ready(function(){
    

    var map = initializeMap();
    //questa variabile mi servirà per sapere cosa mostrare all'utente'
    var logged = false;
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
        logged = response.logged;
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

    /*sono loggato richiamo i preferiti e i personali*/
    if(logged){
        updatePreferiti();
        updatePersonali();

    }
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
     * Aggiunta/rimozione di un evento ai preferiti.
     */
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

    //Si occupa di far mostrare la form di registrazione dalla infowindow dell'evento.
    //Questo avviene quando non si è loggati. Invece del link "mostra tutto" alla fine
    //della descrizione dell'evento si trova
    //il link "registrati per visualizzare "
    $('.goToReg').live("click", function(event){
        $('#logo').hide();
        $('#recuperoPwd').hide();
        $('#logo2').show('slow');
    });

    $('#backHome').live("click",function(){
        $('#logo2').hide();
        $('#recuperoPwd').hide();
        $('#logo').show('slow');
    });

    //Si occupa del login. Se non sono riempiti i campi
    //non avviene la richiesta
    $("#loginbutton").click(function(data){

        var user= $('#username').val();
        var pass= $('#pass').val();

        //controllo username
        if((user == '') || (pass =='')){
            showMessage("Inserisci un username/password valida");
            data.preventDefault();
        }
        return true;
    });

    //Viene fatto il controllo della registrazione
    //utilizzando delle espressioni regolari per validare
    //i campi. Se c'è qualcosa che non va la richiesta di registrazione
    //viene bloccata
    $("#regbutton").click(function(data){
        var reg2= /^[\w\.\-]+@([\w\-]+\.)+[a-zA-Z]/;
        var reg1=/\w/;
        var user = $('#user').val();
        var pass = $('#password').val();
        var pass1 = $('#password1').val();
        var citta = $('#citta').val();
        var email = $('#email').val();

        if( ((user == '') || (reg1.test(user)==false)) ||
            ((pass == '') || (reg1.test(pass)==false)) ||
            ((pass1 == '') || (reg1.test(pass1)==false))||
            ((citta == '') || (reg1.test(citta)==false))||
            ((email == '') || (reg2.test(email)==false)) )
            {


            showMessage("Riempi tutti i campi con dati validi!");
            data.preventDefault();

        }
        return true;
    });

    //Si occupa del recupero pwd.
    $("#recbutton").click(function(data){

        var user= $('#userRec').val();


        //controllo username
        if(user == ''){
            showMessage("Nessuna username inserita...");
            
        }else {

            $.get("CHome.php",{

                'action':"recupera",
                'username': user
                
            }).success(function(data){

                response = jQuery.parseJSON(data);

                if(response.inviata){
                    showMessage("Email inviata con successo!");
                }else {
                    showMessage("Errore...Riprova!");
                }

                $('#userRec').val('');
            });

        }

        return false;
    });

    //si allaccia al bottone "cerca" non appena si preme invio
    $("#cercaInputBox").keypress(function (event){

       if(event.which == 13){
           $('#cerca').trigger('click');
       }

    });

    //Centra la mappa nella posizione desiderata.
    $("#cerca").click(function(data){


        var coord;

        if($('#cercaInputBox').val() == '')
            showMessage("Nessuna posizione da cercare...");
        else{


            geocoder = new google.maps.Geocoder();
            geocoder.geocode(
            {
                'address': $('#cercaInputBox').val()
            },
            function(results, status) {

                if(status == 'OK'){
                    
                        google.maps.event.trigger(map, 'resize');
                        coord = results[0].geometry.location;
                        map.setCenter(coord);
                                           
                }
                else {
                    showMessage('Indirizzo non valido');
                    coord = undefined;
                }


            });
        }
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


            //ho inizializzato la mappa, posso fornire eventi consigliati
            if(logged)
                updateConsigliati(map,false);

            /* Per prima cosa eliminiamo i "vecchi" markers
             */
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
                //Settiamo i parametri del marker
                marker.id = parseInt(response[i].id_evento);
                marker.title = response[i].nome;
                marker.descrizione = response[i].descrizione;
                marker.data = response[i].data;
                //se sono loggato richiamo la funzione checkPreferito
                if(logged)
                    marker.preferito = checkPreferito(marker.id);
                //assegno una info
                marker.infoHTML = infoHTML;
                //inserisco in mappa
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
     * Formattazione del contenuto delle infoWindow, a seconda se l'utente è
     * loggato o no
     */
    function infoHTML(){
        var output;
        if(logged){
            this.preferito = checkPreferito(this.id);
            this.consigliato = checkConsigliato(this.id);
            
            output= '<div class="infowindow">'+
            '<h2>'+this.title+'</h2>'+
            '<h3>'+ formatDate(this.data);
            if (this.preferito == false){
                output +=' - <a href="#" class="addPreferiti" id="'+this.id+
                '">Ci Sarò!</a></h3>';
            }
            else {
                output +=' - <a href="#" class="removePreferiti" id="'+this.id+
                '">Non Potrò Più Esserci!</a></h3>';
            }
            output+='<p>'+this.descrizione+
            ' <a href="CBacheca.php?id='+this.id+'">(visualizza altro)</a></p>';
            if(this.consigliato == false){
                output += '<div><h3><a href="#" class="addConsigliati" id="'+this.id+'">Lo Consiglio!'+
                '</a></h3></div></div>';
            }else {
                output += '<div><h3><a href="#" class="removeConsigliati" id="'+this.id+'">Non Lo Consiglio Più!'+
                '</a></h3></div></div>';
            }
        }else {
            output= '<div class="infowindow">'+
            '<h2>'+this.title+'</h2>'+
            '<h3>'+formatDate(this.data)+'</h3>'+
            '<p>'+this.descrizione+
            ' <a href="#" class="goToReg">(registrati per visualizzare tutto)</a></p>';

        }
        return output;
    }
});
