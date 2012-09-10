$(document).ready(function(){
    updatePreferiti();
    updatePersonali();
    //poichè non si visualizza una mappa non mostro eventi consigliati nella
    //parte di mappa che dovrebbe esserci
    updateConsigliati(null,true);
    
    var coord;
   
    
    $("#indirizzo").keypress(function (event){

        var input = document.getElementById('indirizzo');
        var autocomplete = new google.maps.places.Autocomplete(input, {
            types: ["geocode"]
        });

        if(event.which == 13){
            $('#submit').trigger('focus');
        }
        return true;
        
    });

    //si preoccupa della creazione dell'evento'
    $('#submit').click(function(){
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
            showMessage('Tutti i campi devono essere riempiti.');
        }
        else{

            //chiamata: sincrona perchè ho bisogno che il controller venga ricaricato per
            //controllare il numero di eventi inseriti e nel caso bloccare l'utente'
            $.ajax({

                async: false,
                type: "POST",
                url: "CCrea.php",
                data: {

                    'action': "creaEvento",
                    'nome': $('#nome').val(),
                    'descrizione': $('#descrizione').val(),
                    'timestamp': $('#data').val()+' '+$('#ora').val(),
                    'lat': coord.lat(),
                    'lon': coord.lng()
                }
            }).done(function(data){
                var response = jQuery.parseJSON(data);
                if(response){
                    showMessage(response.message);
                    updatePersonali();
                    $('#map_canvas').hide('slow');
                    $('#creaEvento :input').each(function(){
                        $(this).val('');
                    });
                }else showMessage("Errore!!")
            });
                
            
        }
        return false;
    });
    // Picker per la data e l'ora dell'evento
    AnyTime.picker( "data", {
        format: "%d-%m-%Y",
        labelTitle: 'Data',
        labelYear: 'Anno',
        labelDayOfMonth: 'Giorno',
        labelMonth: 'Mese',
        firstDOW: 1
    } );
    AnyTime.picker( "ora", {
        format: "%H:%i",
        labelTitle: 'Ora',
        labelHour: 'Ora',
        labelMinute: 'Minuto'
    } );
    
    var marker;
    var map = initializeMap();
    $('#map_canvas').hide();
    // L'utente fornisce un indirizzo: visualizza la mappa e
    // posiziona un marker per permettere al gestore di controllare
    // la corretta "traduzione" dell'indirizzo da parte del server Google
    $('#indirizzo').focusout(function(){
        // Centra la mappa sull'indirizzo appena fornito
        geocoder = new google.maps.Geocoder();
        geocoder.geocode(
        {
            'address': $(this).val()
        },
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
                    var infowindow = new google.maps.InfoWindow({
                        'maxWidth': 400
                    });
                    marker = new google.maps.Marker({
                        'position':coord,
                        'map':map
                    });
                    infowindow.marker = marker;
                    infowindow.setContent(inputDesc());
                    infowindow.open(map,marker);
                    
                });
            }
            else {
                showMessage('Indirizzo non valido');
                $('#map_canvas').hide('slow');
                coord = undefined;
                    
            }
        }
        );
    });

    function inputDesc(){
        var output;
        output = '<div class="infowindow">'+
            '<h4>Descrizione dell\'evento:</h4>'+
            '<textarea id="descrizione" rows=4'+
            'name="descrizione"></textarea></div>';

    return output;
    }

});
