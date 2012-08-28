$(document).ready(function(){
    updatePreferiti();
    updatePersonali();
    //poichè non si visualizza una mappa non mostro eventi consigliati nella
    //parte di mappa che dovrebbe esserci
    updateConsigliati(null,true);
    var options, a;
    jQuery(function(){
        options = {
            serviceUrl: 'CCerca.php?action=suggest',
            noCache: true
        };
        a = $('#nome').autocomplete(options);
    });

    $('.selected').live("click", function(){
         $("form").submit();

    });
})