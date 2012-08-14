$(document).ready(function(){
    updatePreferiti();
    updatePersonali();
    updateBacheca(false);

    //poichè non si visualizza una mappa non mostro eventi consigliati nella
    //parte di mappa che dovrebbe esserci
    updateConsigliati(null,true);


    $('#inserisciMessaggio').click(function(){
        // Blocchiamo la submit se uno o più campi non sono riempiti,
        
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
                response = jQuery.parseJSON(data);
                showMessage(response.message);
                $('#messaggio').val('');
                updateBacheca(true);
            });



        }
    });

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


    $('#del').live("click", function(){

        $.get("CBacheca.php",
        {
            'action': "eliminaMessaggio",
            'idMex': $('#del').attr("value")
        }).success(function(data){
            response = jQuery.parseJSON(data);
            showMessage(response.message);
            updateBacheca(true);
        });

    });


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