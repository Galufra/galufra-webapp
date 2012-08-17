$(document).ready(function(data){
    
    updatePreferiti();
    updatePersonali();

    //poichè non si visualizza una mappa non mostro eventi consigliati nella
    //parte di mappa che dovrebbe esserci
    updateConsigliati(null,true);


    //Creo l'html per visualizzare gli eventi preferiti sulla pagina (non sulla barra laterale)
    Pref = $('#listaeventi');
    Pref.find('.pref').remove
    $('<div><h2 align=center>EVENTI A CUI ANDRAI</h2></div>').appendTo(Pref);
    $.get("CHome.php",
    {
        'action': "getEventiPreferiti"

    })
    .success(function(data) {
        var response = jQuery.parseJSON(data);
        if(response.total > 0){
            var eventi = response.eventi;
            $.each(eventi, function(i){
                $('<div class="pref">')
                .append($('<div class="box">')
                    .append('<a href="CBacheca.php?id='+eventi[i].id_evento+'"><li>'+eventi[i].nome+'</li></a>')
                    .append('<ul>'+eventi[i].data+'</ul>')
                    .append('<ul>'+eventi[i].descrizione+'</ul>')
                    .append('</div>'))
                .appendTo(Pref);
            });
        }else $('<div><h3 align=center>Nessun evento preferito...</h3></div>').appendTo(Pref);
    });



});