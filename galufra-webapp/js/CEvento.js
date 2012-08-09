$(document).ready(function(){

    updatePreferiti();
    updatePersonali();

    var add = $('<h3><a class="addPreferiti">Aggiungi ai Preferiti</a></h3>');
    var remove = $('<h3><a class="removePreferiti">Rimuovi dai Preferiti</a></h3>');
    var pref = checkPreferito(id_evento);
    if(!pref)
        add.insertAfter($('h2'));
    else
        remove.insertAfter($('h2'));
    var map = initializeMap();

    //aggiorno i consigliati qui perchè mi serve una mappa inizializzata
    updateConsigliati(map,false);

    var latlng = new google.maps.LatLng(lat, lon);
    map.setCenter(latlng);
    var marker = new google.maps.Marker({'position':latlng, 'map':map});
});
