$(document).ready(function(){
    updatePreferiti();
    updatePersonali();
    updateBacheca(false);
    

    var map = initializeMap();
    var coord = new google.maps.LatLng(
        parseFloat(lat),
        parseFloat(lon)
        );
    map.setCenter(coord);
    marker = new google.maps.Marker({
        'position':coord,
        'map':map
    });
    //poichè non si visualizza una mappa non mostro eventi consigliati nella
    //parte di mappa che dovrebbe esserci
    updateConsigliati(null,true);

    /*$('#partecipanti').mouseover(function() {
        $('#elenco_part').append('<div>Handler for .mouseover() called.</div>').show();
    });*/

    //inserisce un messaggio in bacheca
    $('#inserisciMessaggio').click(function(){

        // Blocchiamo la submit se uno o più campi non sono riempiti       
        if(
            !($('#messaggio').val()))
            {
            showMessage('Nessun Messaggio da Scrivere...');
        }else {


            $.get("CBacheca.php",
            {
                'action': "creaMessaggio",
                'messaggio': $('#messaggio').val()
            }).success(function(data){
                var response = jQuery.parseJSON(data);
                showMessage(response.message);
                $('#messaggio').val('');
                updateBacheca(true);
            });



        }
    });

    //inserisce un annuncio in bacheca
    $('#inserisciAnnuncio').click(function(){

        if(
            !($('#annuncio').val()))
            {
            showMessage('Nessun Annuncio da Scrivere...');
        }else {


            $.get("CBacheca.php",
            {
                'action': "creaAnnuncio",
                'annuncio': $('#annuncio').val()
            }).success(function(data){
                var response = jQuery.parseJSON(data)
                showMessage(response.message);
                updateBacheca(false);
                $('#annuncio').val('');

            });

        }
    });


    //elimina un messaggio
    $('#del').live("click", function(){

        $.get("CBacheca.php",
        {
            'action': "eliminaMessaggio",
            'idMex': $(this).attr("value")
        }).success(function(data){
            var response = jQuery.parseJSON(data);
            showMessage(response.message);
            updateBacheca(true);
        });

    });

    //elimina un evento
    $('#eliminaEvento').live("click", function(){

        $.ajax({

            async:true,
            type: "GET",
            url: "CBacheca.php",
            data: {
                'action': "eliminaEvento"
            }
        });
        updatePreferiti();
        updatePersonali();
        $('#bacheca').hide('slow');

    });

});
