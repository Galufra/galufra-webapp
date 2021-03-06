/* 
 * Trasforma una stringa datetime (YYYY-mm-dd hh:mm:ss)
 * in un formato più leggibile (dd-mm-YYYY hh:mm)
 */
function formatDate(datetime){
    var out = '';
    datetime = datetime.split(' ');
    var date = datetime[0].split('-');
    out = date[2] +'-' + date[1] + '-' + date[0];
    var time = datetime[1].split(':');
    out += ' ' + time[0] + ':' + time[1];
    return out;
}

/* 
 * Visualizza un messaggio nella messagebox (nel menu 'header')
 */
function showMessage(message){
    $('#messagebox').stop(true).hide().text(message)
    .fadeIn('slow')
    .delay(1300)
    .fadeOut('slow');
}

//inizializza la mappa. Di default è centrata a L'Aquila
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
        if(response.eventi){
            if(response.total > 0)
                var eventi = response.eventi;
            $.each(eventi, function(i){
                if(i==3) return false;
                $('<li class="preferito">')
                .append($('<ul>')
                    .append('<a href="CBacheca.php?id='+eventi[i].id_evento+'"><li>'+eventi[i].nome+'</li></a>')
                    //.append('<li>'+formatDate(eventi[i].data)+'</li>')
                    .append('</ul>'))
                .appendTo(Preferiti);
            });
        }
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
        if(response.eventi){
            if(response.total > 0)
                var eventi = response.eventi;
            $.each(eventi, function(i){
                if(i==3) return false;
                $('<li class="personale">')
                .append($('<ul>')
                    .append('<a href="CBacheca.php?id='+eventi[i].id_evento+'"><li>'+eventi[i].nome+'</li></a>')
                    //.append('<li>'+formatDate(eventi[i].data)+'</li>')
                    .append('</ul>'))
                .appendTo(Personali);
            });
        }
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
            if(response.eventi){
                if(response.total > 0){
                    var eventi = response.eventi;
                    $.each(eventi, function(i){
                        $('<li class="consigliato">')
                        .append($('<ul>')
                            .append('<a href="CBacheca.php?id='+eventi[i].id_evento+'"><li>'+eventi[i].nome+'</li></a>')
                            //.append('<li>'+formatDate(eventi[i].data)+'</li>')
                            .append('</ul>'))
                        .appendTo(Consigliati);
                    });
                }
            }
        });
    }else $('#boxConsigliati').remove();

}

//Aggiorna la bacheca dell'evento. Inserendo i messaggi o gli annunci appena inseriti
//il parametro scroll indica se la pagina deve tornare sulla parte più bassa
//questo può essere fatto con un effetto di scorrimento o con un focus diretto.
//Adesso lo fa con un focus diretto
function updateBacheca(scroll){
    Messaggi = $('#messaggiBacheca');
    Annuncio = $('#annuncioGestore');
    Annuncio.find('.annunci').remove();
    Messaggi.find('.messaggio').remove();
    //Messaggi.hide();
    $.get("CBacheca.php",{
        'action':"getMessaggi"

    }).success(function(data){
        var response = jQuery.parseJSON(data);
        var annuncio = response.annuncio;
        $('<div class="box annunci"><h3>Annuncio organizzatore: </h3><h2>'+annuncio+'</h3></div>').appendTo(Annuncio);
        if(response.total > 0){
            var messaggi = response.messaggi;
            var isAdmin = response.isAdmin;
            var isGestore = response.isGestore;
            
            $.each(messaggi,function(i){
                $('<div class="box messaggio">')
                .append($('<ul>')
                    .append('<h3><a href=CProfilo.php?name='+messaggi[i].utente+'>'+messaggi[i].utente+'</a>: '+messaggi[i].testo+'</h3>')
                    .append('<p>Quando? Il '+formatDate(messaggi[i].data)+'</p>')
                    .append(
                        (isGestore || isAdmin)?('<h3><a href="#" id="del" value='+messaggi[i].id_mess+'>elimina</a></h3>'):('')
                        )
           
                    .append('</ul>'))
                .appendTo(Messaggi);
           
            });

            if(scroll){
                //Da scegliere uno dei due: focus o scorrimento
                $('#inserisciMessaggio').focus();
            //$("html, body").animate({ scrollTop: $(document).height() }, "slow");

            }
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
        var response = jQuery.parseJSON(data);
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
        var response = jQuery.parseJSON(data);
        out = response;
    });
    return out;
}


/*
 * Aggiungono/rimuovono l'evento id ai preferiti e ai consigliati
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



