$(document).ready(function(){
    updatePreferiti();
    updatePersonali();
    updateBacheca(false)

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
                updateBacheca(true);
            });



        }
    });

});