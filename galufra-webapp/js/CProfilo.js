$(document).ready(function(){
    updatePreferiti();
    updatePersonali();
    //poichè non si visualizza una mappa non mostro eventi consigliati nella
    //parte di mappa che dovrebbe esserci
    updateConsigliati(null,true);
    $('.password').hide();

    $('.modificaPwd').live("click", function(event){
        $('.password').show('slow');
    });

    $('#eliminaUtente').live("click", function(){

        $.ajax({

            async:true,
            type: "POST",
            type: "POST",
            url: "CProfilo.php",
            data: {
                'action': "eliminaUtente",
                'name': $('#eliminaUtente').attr("value")
            }
        }).done(function(data){
            response = jQuery.parseJSON(data);
            showMessage(response.message);

        });
        $('#profilo').hide('slow');

    });

    $('#adminButton').click(function(){
        if( !($('#admin').val()) ){
            showMessage('nessun utente selezionato...')
        }else{

            $.post("CProfilo.php",
            {
                'action': "addAdmin",
                'user': $('#admin').val()

            }).done(function(data){

                var response = jQuery.parseJSON(data);
                
                if(response.result)
                    showMessage(response.message);
                else
                    showMessage(response.message);

                $('#admin').val('');

            });
        }

        return false;

    });

    $('#superuserButton').click(function(){
        if( !($('#superuser').val()) ){
            showMessage('nessun utente selezionato...')
        }else{

            $.post("CProfilo.php",{
                'action': "addSuperuser",
                'user': $('#superuser').val()
            }).done(function(data){

                var response = jQuery.parseJSON(data);
                
                if(response.result)
                    showMessage(response.message);
                else
                    showMessage(response.message);

                $('#superuser').val('');

            });
        }

        return false;

    });

    $('#updateButton').click(function(){
        // Blocchiamo la submit se uno o più campi non sono riempiti,
        // o se Google non ha trovato coordinate corrispondenti all'indirizzo
        if( 
            !($('#password').val()) &&
            !($('#password1').val()) &&
            !($('#nome').val())  &&
            !($('#cognome').val()) &&
            !($('#citta').val()) &&
            !($('#email').val())

            ){
            showMessage('Nulla da Modificare...');
        }
        else{
            $.ajax({
                async:false,
                type: "POST",
                url: "CProfilo.php",
                data: {
                    'action': "update",
                    'password': $('#password').val(),
                    'password1':$('#password1').val(),
                    'nome': $('#nome').val(),
                    'cognome': $('#cognome').val(),
                    'email': $('#email').val(),
                    'citta': $('#citta').val()

                }
            }).done(function(data){
                response = jQuery.parseJSON(data);
                showMessage(response.message);

            });
           
        }
        return false;
    });
});


