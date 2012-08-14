$(document).ready(function(){
    updatePreferiti();
    updatePersonali();
    //poichè non si visualizza una mappa non mostro eventi consigliati nella
    //parte di mappa che dovrebbe esserci
    updateConsigliati(null,true);
});