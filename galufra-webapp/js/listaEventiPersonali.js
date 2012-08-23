$(document).ready(function(data){

    updatePreferiti();
    updatePersonali();

    //poichè non si visualizza una mappa non mostro eventi consigliati nella
    //parte di mappa che dovrebbe esserci
    updateConsigliati(null,true);


    //Creo l'html per visualizzare gli eventi personali sulla pagina (non sulla barra laterale)
    Pers = $('#listaeventi');
    Pers.find('.pers').remove();
    $('<div><h2 align=center>I TUOI EVENTI</h2></div>').appendTo(Pers);
    $.get("CHome.php",
    {
        'action': "getEventiPersonali"

    })
    .success(function(data) {
        var response = jQuery.parseJSON(data);
        if(response.total > 0){
        var eventi = response.eventi;
        $.each(eventi, function(i){
            $('<div class="pers">')
            .append($('<div class="box">')
                .append('<a href="CBacheca.php?id='+eventi[i].id_evento+'"><li>'+eventi[i].nome+'</li></a>')
                .append('<ul>'+eventi[i].data+'</ul>')
                .append('<ul>'+eventi[i].descrizione+'</ul>')
                .append('</div>'))
            .appendTo(Pers);
        });
        }else $('<div><h3 align=center>Non hai ancora creato un evento...</h3></div>').appendTo(Pers);
    });



});


