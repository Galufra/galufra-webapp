$(document).ready(function(){
    var options, a;
    jQuery(function(){
        options = {
            serviceUrl: 'CCerca.php?action=suggest', 
            noCache: true
        };
        a = $('#nome').autocomplete(options);
    });

});
