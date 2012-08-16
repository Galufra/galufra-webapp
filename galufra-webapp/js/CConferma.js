$(document).ready(function(){
    updatePreferiti();
    updatePersonali();
    //poichè non si visualizza una mappa non mostro eventi consigliati nella
    //parte di mappa, perchè non ho le coordinate
    updateConsigliati(null,true);

   //mostra il messaggio di registrazione confermata
   $('#messaggio').show('slow');


});

