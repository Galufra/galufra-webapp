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
    {
        'action': "getEventiPreferiti"

    })
    .success(function(data) {
        var response = jQuery.parseJSON(data);
        if(response.total > 0)
            var eventi = response.eventi;
        $.each(eventi, function(i){
            //if(i==3) return false;
            $('<li class="preferito">')
            .append($('<ul>')
            .append('<li>'+eventi[i].nome+'</li>')
            .append('<li>'+eventi[i].data+'</li>')
            .append('</ul>'))
            .appendTo(Preferiti);
        });
    });
}

/*
 * Recupera gli eventi personali e li inserisce nell'apposito box
 */
function updatePersonali(){

    Personali = $('#ulPersonali');
    Personali.find('.personale').remove();
    $.get("CHome.php",
    {
        'action':"getEventiPersonali"
    }).success(function(data){
        var response = jQuery.parseJSON(data);
        if(response.total > 0)
            var eventi = response.eventi;
        $.each(eventi, function(i){
            //if(i==3) return false;
            $('<li class="personale">')
            .append($('<ul>')
            .append('<li>'+eventi[i].nome+'</li>')
            .append('<li>'+eventi[i].data+'</li>')
            .append('</ul>'))
            .appendTo(Personali);
        });

    });


}

/*
 * Recupera gli eventi consigliati e li inserisce nell'apposito box
 */
function updateConsigliati(map,mantieni){


    Consigliati = $('#ulConsigliati');
    Consigliati.find('.consigliato').remove();
    if(!mantieni){
        bounds = map.getBounds();
        $.get("CHome.php",
        {
            'action':"getEventiConsigliati",
            'neLat': bounds.getNorthEast().lat(),
            'neLon': bounds.getNorthEast().lng(),
            'swLat': bounds.getSouthWest().lat(),
            'swLon': bounds.getSouthWest().lng()
        }).success(function(data){

            var response = jQuery.parseJSON(data);
            if(response.total > 0)
                var eventi = response.eventi;
            $.each(eventi, function(i){
                //if(i==3) return false;
                $('<li class="consigliato">')
                .append($('<ul>')
                .append('<li>'+eventi[i].nome+'</li>')
                .append('<li>'+eventi[i].data+'</li>')
                .append('</ul>'))
                .appendTo(Consigliati);
            });

        });
    }else $('<li class="consigliato">Nessuna Mappa in Visualizzazione</li>').appendTo(Consigliati);

}

function updateBacheca(scroll){
    Messaggi = $('#messaggiBacheca');
    Messaggi.find('.messaggio').remove();
    //Messaggi.hide();
    $.get("CBacheca.php",{
        'action':"getMessaggi"

    }).success(function(data){
        var response = jQuery.parseJSON(data);
        if(response.total > 0)
            var messaggi = response.messaggi;
        $.each(messaggi,function(i){
            $('<div class="box messaggio">')
            .append($('<ul>')
            .append('<h2>'+messaggi[i].utente+' dice: '+messaggi[i].testo+'</h2>')
            .append('<h3>Quando? Il '+messaggi[i].data+'</h3>')
            .append('</ul>'))
            .appendTo(Messaggi);
           
        });
        if(scroll){
            //Da scegliere uno dei due
            $('#inserisciMessaggio').focus();
            //$("html, body").animate({ scrollTop: $(document).height() }, "slow");

        }
    });

}

/* Controlliamo che id faccia parte degli eventi preferiti/consigliati
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

function checkConsigliato(id){
    var out = false;
    var marker = this;
    $.ajax({
        async: false,
        url: "CEvento.php",
        data: {
            'action': "isConsigliato",
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
 * Aggiunge/rimuove l'evento id ai preferiti e ai consigliati
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

function addConsigliati(id){
    if(id){
        $.get("CEvento.php",{
            'action': "addConsigliati",
            'id':id

        }).done(function(data){
            showMessage(data);
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

function removeConsigliati(id) {

    $.get("CEvento.php", {
        'action': "removeConsigliati",
        'id': id
    })
    .done(function(data){
        showMessage(data);
    });

}



