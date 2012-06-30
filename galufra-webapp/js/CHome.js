$(document).ready(function(){
var map;
var myOptions = {
    zoom: 16,
    mapTypeId: google.maps.MapTypeId.ROADMAP
};
map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);
// Centra la mappa sulla città dell'utente.
// geocoder trasforma indirizzi in coppie lat/lon
geocoder = new google.maps.Geocoder();
$.ajax({
    async: false,
    url: "CHome.php",
    data: {'action': "getUtente"}
})
.done(function(data){
    response = jQuery.parseJSON(data);
});
if (response.logged){
    geocoder.geocode(
        {'address': response.citta},
        function(results, status) {
            map.setCenter(results[0].geometry.location);
        }
    );
}
var markers = [];
var infowindow = new google.maps.InfoWindow({'maxWidth': 400});
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
$('.addPreferiti').live("click", function(event){
    $.get("CHome.php",
    {'action': "addPreferiti",
     'id_evento': event.target.id
    })
    .done(function(data){
        console.log(data);
    });
    for(i=0; i<markers.length; ++i){
        if(markers[i].id == event.target.id){
            markers[i].preferito = function(){return true; };
            infowindow.setContent(markers[i].infoHTML());
        }
    }
});

$('.removePreferiti').live("click", function(event){
    $.get("CHome.php",
    {'action': "removePreferiti",
     'id_evento': event.target.id
    })
    .done(function(data){
        console.log(data);
    });
    for(i=0; i<markers.length; ++i){
        if(markers[i].id == event.target.id){
            markers[i].preferito = function(){return false; };
            infowindow.setContent(markers[i].infoHTML());
        }
    }
});

/*
 * Visualizza sulla mappa gli eventi contenuti in
 * bounds (oggetto LatLngBounds di Google Maps)
 */
function getEventiMappa(){
    bounds = map.getBounds();
    $.get("CHome.php",
    {'action': "getEventiMappa",
     'neLat': bounds.getNorthEast().lat(),
     'neLon': bounds.getNorthEast().lng(),
     'swLat': bounds.getSouthWest().lat(),
     'swLon': bounds.getSouthWest().lng()
    })
    .success(function(data) {
        /* Per prima cosa eliminiamo i "vecchi" markers
         */
        if (markers){
            for(i=0; i<markers.length; ++i)
                markers[i].setMap(null);
        }
        markers.length = 0;
        /* Creazione dei nuovi markers dall'XML
         */
        $(data).find('evento').each(function(){
          //  console.log($(this).find('nome').text());
            var pos = new google.maps.LatLng(
                parseFloat($(this).find('lat').text()),
                parseFloat($(this).find('lon').text()));
            var marker = new google.maps.Marker({'position':pos,
            'map':map});
            marker.id = parseInt($(this).find('id').text());
            marker.title = $(this).find('nome').text();
            marker.descrizione = $(this).find('descrizione').text();
            marker.data = $(this).find('data').text();
            marker.preferito = checkPreferito;
            marker.infoHTML = infoHTML;
            markers.push(marker);
        });
        for( i=0; i<markers.length; ++i){
            var marker = markers[i];
            google.maps.event.addListener(marker, 'click', function () {
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
                else { 
                    infowindow.close();
                    infowindow.marker = null;
                }
            });
        }

    });
}
/* Controlliamo che un marker faccia parte degli eventi preferiti
 * dell'utente. Dobbiamo effettuare una chiamata sincrona perché
 * non possiamo scrivere la infobox senza prima sapere questo valore!
 */
function checkPreferito(){
    var out = false;
    var marker=this;
    $.ajax({
        async: false,
        url: "CHome.php",
        data: {'action': "getEventiPreferiti"}
    }).done(function(data){
            $(data).find('id').each(function(){
                if (parseInt($(this).text()) == marker.id){
                    out = true;
                    return false;
                }
            });
            /* 
             * Per le prossime volte, restituiamo semplicemente
             * il valore ottenuto anziché fare una nuova richiesta
             */
            marker.preferito = function(){ return out; }
        });
    return out;
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
    var output= '<div class="infowindow">'+
        '<h2>'+this.title+'</h2>'+
        '<h3>'+this.data;
    if (this.preferito() == false){
        output +=' - <a href="#" class="addPreferiti" id="'+this.id+
        '">Aggiungi ai Preferiti</a></h3>';
    }
    else {
        output +=' - <a href="#" class="removePreferiti" id="'+this.id+
        '">Rimuovi dai Preferiti</a></h3>';
    }
    output+='<p>'+this.descrizione+
    ' <a href="#">(visualizza altro)</a></p>'+
    '</div>';
    return output;
}
});
