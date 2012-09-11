$(document).ready(function(){
    updatePreferiti();
    updatePersonali();
    updateBacheca(false);
    //nasconde la div che conterrà l'elenco partecipanti
    $('#elenco_part').hide()

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

    //Stampa una lista di partecipanti all'evento'
    $('#partecipanti').live("click",function() {
        var Elenco = $('#elenco_part');
        Elenco.find('.elenco').remove();
        $.get("CBacheca.php",{
            'action': "getPartecipanti"
        }).success(function(data){
            var response = jQuery.parseJSON(data);
            if(response.count>0){
                var utenti = response.utenti;
                $.each(utenti, function(i){
                    $('<div class="elenco">')
                    .append($('<a href="CProfilo.php?name='+utenti[i].username+'">'+utenti[i].username+'</a>'))
                    .appendTo(Elenco);
                });
                $('#elenco_part').show('slow');
            }
        });
    });

    //nasconde l'elenco dei partecipanti'
    $('#nascondi_elenco').live("click",function(){

       $('#elenco_part').hide('slow');

    });

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
