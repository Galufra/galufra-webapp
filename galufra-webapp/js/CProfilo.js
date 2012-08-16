$(document).ready(function(){
    updatePreferiti();
    updatePersonali();
    //poichè non si visualizza una mappa non mostro eventi consigliati nella
    //parte di mappa che dovrebbe esserci
    updateConsigliati(null,true);

    $('.password').hide();
    //mostra le input text per la password
    $('.modificaPwd').live("click", function(){
        $('.password').show('slow');
    });

    //si occupa dell'eliminazione di un utente. una volta fatto la pagina scompare
    //con un effetto
    $('#eliminaUtente').live("click", function(){

        $.ajax({

            async:true,
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

    //si occupa di aggiungere un admin
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

    //si occupa di aggiungere un superuser
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

    //Fa l'update dell'utente facendo un controllo sui campi
    $('#updateButton').click(function(){
        // Blocchiamo la submit se uno o più campi non sono riempiti,
        // o se Google non ha trovato coordinate corrispondenti all'indirizzo
        
        if(
            !($('#codice').val()) &&
            !($('#codice').val()) &&
            !($('#nome').val())  &&
            !($('#cognome').val()) &&
            !($('#city').val()) &&
            !($('#posta').val())

            ){
            showMessage('Nulla da Modificare...');
        }
        else{


            $.post("CProfilo.php", {
                'action': "update",
                'password': $('#codice').val(),
                'password1':$('#codice1').val(),
                'nome': $('#nome').val(),
                'cognome': $('#cognome').val(),
                'email': $('#posta').val(),
                'citta': $('#city').val()
            }).done(function(data){
                response = jQuery.parseJSON(data);
                showMessage(response.message);

            });

        }
        return false;
    });
});


