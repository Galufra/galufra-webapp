$(document).ready(function(){
    var coord;
    $('#creaEvento').submit(function(){
        // Blocchiamo la submit se uno o più campi non sono riempiti,
        // o se Google non ha trovato coordinate corrispondenti all'indirizzo
        if( !($('#nome').val()) ||
            !($('#data').val()) ||
            !($('#ora').val())  ||
            !($('#indirizzo').val()) ||
            !($('#descrizione').val()||
            !coord
            )
        ){
            ShowError('Tutti i campi devono essere riempiti.');
        }
        else{
            var defaultConv = new AnyTime.Converter({format: "%d %M %Y %T"});
            var timestamp = defaultConv.parse($('#data').val()+" "+$('#ora').val());
            if(!timestamp){
                ShowError('La data inserita non è corretta');
                return false;
            }
            // invio della richiesta
            $.get("CCrea.php",
                {'action': "creaEvento",
                 'nome': $('#nome').val(),
                 'descrizione': $('#descrizione').val(),
                 'timestamp': timestamp,
                 'lat': coord.lat(),
                 'lon': coord.lng()
                }).success(function(data){
                    response = jQuery.parseJSON(data);
                    ShowError(response.message);
                    if(response.status == 'OK')
                        $('#creaEvento').find('input,textarea').val('');
                });
        }
        return false;
    });
    // Picker per la data e l'ora dell'evento
    AnyTime.picker( "data", {
        format: "%d %M %Y", labelTitle: 'Data',
        labelYear: 'Anno',
        labelDayOfMonth: 'Giorno',
        labelMonth: 'Mese',
        firstDOW: 1 } );
    AnyTime.picker( "ora", {
        format: "%H:%i", labelTitle: 'Ora', 
        labelHour: 'Ora',
        labelMinute: 'Minuto'} );
    
    var map, marker;
    // Bisognerebbe impostare la posizione iniziale alla città
    // dell'utente... Per ora:
    var latlng = new google.maps.LatLng(42.366, 13.3944);
    var myOptions = {
            zoom: 16,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);
    $('#map_canvas').hide();
    // Quando l'utente fornisce un indirizzo, visualizza la mappa e
    // posiziona un marker per permettere al gestore di controllare
    // la corretta "traduzione" dell'indirizzo da parte del server Google
    $('#indirizzo').change(function(){
        // Centra la mappa sull'indirizzo appena fornito
        geocoder = new google.maps.Geocoder();
        geocoder.geocode(
            {'address': $(this).val()},
            function(results, status) {
                // Cancelliamo il marker preesistente
                if (marker)
                    marker.setMap(null);
                if(status == 'OK'){
                    $('.errore').fadeOut('fast');
                    $('#map_canvas').show('slow', function(){
                        google.maps.event.trigger(map, 'resize');
                        coord = results[0].geometry.location;
                        map.setCenter(coord);
                        marker = new google.maps.Marker({
                            'position':coord,
                            'map':map
                        });
                    });
                }
                else {
                    ShowError('Indirizzo non valido');
                    $('#map_canvas').hide('slow');
                    coord = undefined;
                    
                }
        }
        );
    });
});

function ShowError(text){
    if($('.errore').length)
        $('.errore').remove();
    $('<div class="errore">'+text+'</div>')
        .hide().prependTo('.colTwo').fadeIn('fast');
}
