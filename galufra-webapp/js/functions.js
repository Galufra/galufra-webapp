/* 
 * Visualizza un messaggio nella messagebox (nel menu 'header')
 */
function showMessage(message){
    $('#messagebox').stop(true).hide().text(message)
    .fadeIn('slow')
    .delay(1300)
    .fadeOut('slow');
}

function initializeMap(){
    var myOptions = {
        zoom: 16,
        center: new google.maps.LatLng(42.354008, 13.391992),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    return new google.maps.Map($('#map_canvas')[0], myOptions);
}

/*
 * Recupera i preferiti e li inserisce nell'apposito box
 */
function updatePreferiti(){
    Preferiti = $('#ulPreferiti');
    Preferiti.find('.preferito').remove();
    $.get("CHome.php",
    {'action': "getEventiPreferiti"})
    .success(function(data) {
        var response = jQuery.parseJSON(data);
        if(response.total > 0)
            var eventi = response.eventi;
            $.each(eventi, function(i){
                $('<li class="preferito">')
                .append($('<ul>')
                .append('<li>'+eventi[i].nome+'</li>')
                .append('<li>'+eventi[i].data+'</li>'))
                .appendTo(Preferiti);
            });
        });
}

/* Controlliamo che id faccia parte degli eventi preferiti
 * dell'utente. Dobbiamo effettuare una chiamata sincrona perché
 * non possiamo scrivere la infobox senza prima sapere questo valore!
 */
function checkPreferito(id){
    var out = false;
    var marker = this;
    $.ajax({
        async: false,
        url: "CEvento.php",
        data: {
            'action': "isPreferito",
            'id': id
        }
    })
    .done(function(data){
        response = jQuery.parseJSON(data);
        out = response;
    });
    return out;
}


/*
 * Aggiunge/rimuove l'evento id ai preferiti
 */
 function addPreferiti(id){
    if(id){
        $.get("CEvento.php", {
            'action': "addPreferiti",
            'id': id
        })
        .done(function(data){
            showMessage(data);
            updatePreferiti();
        });
    }
}
function removePreferiti(id) {
    $.get("CEvento.php", {
        'action': "removePreferiti",
        'id': id
    })
    .done(function(data){
        showMessage(data);
        updatePreferiti();
    });
}
