$(document).ready(function(){
    updatePreferiti();
    updatePersonali();
    //poichè non si visualizza una mappa non mostro eventi consigliati nella
    //parte di mappa che dovrebbe esserci
    updateConsigliati(null,true);
    
    var coord;

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

           /* Forse c'è un bug! Non si riesce a fare la conversione della data alcune volte.
            * Viene generata una eccezione che dice che il formato giorno mese anno ora
            * che si è immesso nella form non è come quello stabilito (format: "%d %M %Y %T)
            * Per ora non passo per il parser, perchè non posso permettermi che "qualche volta non funzioni".
            * Definisco la data così come la vogliamo nel
            * db direttamente dalle impostazioni del picker qui in basso dopo la chiamata ajax

            //definisce il formato di data che vogliamo
            var defaultConv = new AnyTime.Converter({
                format: "%d %M %Y %T"
            });

            //inserisce uno spazio tra data e orario
            var timestamp = defaultConv.parse($('#data').val()+' '+$('#ora').val());
            if(!timestamp){
                showMessage('La data inserita non è corretta');
                return false;
            }


             */

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
                response = jQuery.parseJSON(data);
                showMessage(response.message);
                updatePersonali();
                $('#map_canvas').hide('slow');
                $('#creaEvento :input').each(function(){
                    $(this).val('');
                });
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
    $('#indirizzo').change(function(){
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
                    marker = new google.maps.Marker({
                        'position':coord,
                        'map':map
                    });
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

});
