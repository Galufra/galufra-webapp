$(document).ready(function(data){
    updatePreferiti();
    updatePersonali();

    //poichè non si visualizza una mappa non mostro eventi consigliati nella
    //parte di mappa che dovrebbe esserci
    updateConsigliati(null,true);


    //Creo l'html per visualizzare gli eventi consigliati sulla pagina (non sulla barra laterale)
    Cons = $('#listaeventi');
    Cons.find('.cons').remove();
    $('<div><h2 align=center>I PIÙ CONSIGLIATI IN ASSOLUTO</h2></div>').appendTo(Cons);
    $.get("CHome.php",
    {
        'action': "getMaxConsigliati"

    })
    .success(function(data) {
        var response = jQuery.parseJSON(data);
        if(response.total > 0){
            var eventi = response.eventi;
            $.each(eventi, function(i){
                $('<div class="cons">')
                .append($('<div class="box">')
                    .append('<a href="CBacheca.php?id='+eventi[i].id_evento+'"><li>'+eventi[i].nome+'</li></a>')
                    .append('<ul>'+eventi[i].data+'</ul>')
                    .append('<ul>'+eventi[i].descrizione+'</ul>')
                    .append('</div>'))
                .appendTo(Cons);
            });
        }else $('<div><h3 align=center>Nessun evento trovato...</h3></div>').appendTo(Cons);
    });

});

