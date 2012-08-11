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


