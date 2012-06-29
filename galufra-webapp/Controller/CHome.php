<?php
require_once('../Foundation/FUtente.php');
require_once('../Foundation/FEvento.php');
require_once('../Entity/EUtente.php');
require_once('../Entity/EEvento.php');
require_once('../View/VEventiXML.php');

class CHome{
private $utente;

/*
 * Scartabellando un po' in rete ho notato che il pattern Singleton 
 * è spesso sconsigliato per una serie di ragioni... Nel dubbio lascio
 * la classe nel suo stato precedente (non che faccia molta differenza,
 * allo stato attuale :) )
 */
//~ private static $_instance = null;
//~ public static function getInstance(){
    //~ if(self::$_instance == null){   
        //~ $c = __CLASS__;
        //~ self::$_instance = new $c;
    //~ }
    //~ return self::$_instance;
//~ }

public function __construct(){
    /* Caricamento dell'utente.
     */
    $u = new Futente();
    $u->connect();
    $l = $u->load('luca');
    $this->utente = $l[1][1];
    /* Se "action" non è impostato, eseguiremo il comportamento
     * di default nello switch successivo.
     */
    if(!isset($_GET['action']))
        $_GET['action'] = '';
    switch($_GET['action']){
        case('getEventiMappa'):
            $this->getEventiMappa(
				$_GET['neLat'], $_GET['neLon'],
				$_GET['swLat'], $_GET['swLon']
				);
            break;
        case('getEventiPreferiti'):
            $this->getEventiPreferiti();
            break;
        case('addPreferiti'):
            try {
                $this->utente->addPreferiti($_GET['id_evento']);
                echo "L'evento è stato aggiunto ai tuoi preferiti.";
            } catch (dbException $e) {
                if ($e->getMessage() == '1062')
                    echo "L'evento fa già parte dei tuoi preferiti!";
                else echo "C'è stato un errore. Riprova :)";
            }
            exit;
            break;
        case('removePreferiti'):
            try {
                    $this->utente->removePreferiti($_GET['id_evento']);
                    echo "L'evento è stato rimosso dai tuoi preferiti.";
                } catch (dbException $e) {
                    echo "C'è stato un errore. Riprova :)";
                }
                exit;
            break;
        /* default: in futuro stamperà la pagina con una classe view VMap
         * Per ora un semplice break; ci porta fuori dallo switch
         */
        default: break;
        }
    }
    public function getUtente(){
        return $this->utente;
    }
    /* 
     * Crea un XML contenente gli eventi restituiti da 
     * FEvento::searchEventi().
     */
    public function getEventiMappa($neLat, $neLon, $swLat, $swLon){
        $ev = new FEvento();
        $ev->connect();
        $ev_array = $ev->searchEventiMappa($neLat, $neLon, $swLat, $swLon);
        $View = new VEventiXML($ev_array[1][1]);
        exit;
    }
    public function getEventiPreferiti(){
        $ev = new FEvento();
        $ev->connect();
        $ev_array = $ev->getEventiPreferiti($this->utente->getId());
        $View = new VEventiXML($ev_array[1]);
        exit;
    }
}

//~ $home= CHome::getInstance();

$home= new CHome();

?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="login.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAO2zXC0wh-S8SjMgPRZfoTUGZMGHBIzZ0&sensor=false"></script>

<script type="text/javascript">
$(document).ready(function(){

var map;
var myOptions = {
    zoom: 16,
    mapTypeId: google.maps.MapTypeId.ROADMAP
};
map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);
// Centra la mappa sulla città dell'utente.
// geocoder trasforma indirizzi in coppie lat/lon
geocoder = new google.maps.Geocoder();
var citta = "<?php echo $home->getUtente()->getCitta(); ?>";
geocoder.geocode(
    {'address': citta},
    function(results, status) {
        map.setCenter(results[0].geometry.location);
    }
);
var markers = [];
var infowindow = new google.maps.InfoWindow({'maxWidth': 400});
google.maps.event.addListener(infowindow, 'closeclick', function(){
    infowindow.marker = null;
});
google.maps.event.addListener(map, 'idle', getEventiMappa);
/*
 * Al click sulla mappa, chiudiamo la infowindow e settiamo
 * a null l'id del marker ad essa associato.
 */
google.maps.event.addListener(map, 'click', function(){
    infowindow.marker = null;
    infowindow.close();
});

/*
 * Aggiunta di un evento ai preferiti.
 */
$('.addPreferiti').live("click", function(event){
    $.get("CHome.php",
    {'action': "addPreferiti",
     'id_evento': event.target.id
    })
    .done(function(data){
        console.log(data);
    });
    for(i=0; i<markers.length; ++i){
        if(markers[i].id == event.target.id){
            markers[i].preferito = function(){return true; };
            infowindow.setContent(markers[i].infoHTML());
        }
    }
});

$('.removePreferiti').live("click", function(event){
    $.get("CHome.php",
    {'action': "removePreferiti",
     'id_evento': event.target.id
    })
    .done(function(data){
        console.log(data);
    });
    for(i=0; i<markers.length; ++i){
        if(markers[i].id == event.target.id){
            markers[i].preferito = function(){return false; };
            infowindow.setContent(markers[i].infoHTML());
        }
    }
});

/*
 * Visualizza sulla mappa gli eventi contenuti in
 * bounds (oggetto LatLngBounds di Google Maps)
 */
function getEventiMappa(){
    bounds = map.getBounds();
    $.get("CHome.php",
    {'action': "getEventiMappa",
     'neLat': bounds.getNorthEast().lat(),
     'neLon': bounds.getNorthEast().lng(),
     'swLat': bounds.getSouthWest().lat(),
     'swLon': bounds.getSouthWest().lng()
    })
    .success(function(data) {
        /* Per prima cosa eliminiamo i "vecchi" markers
         */
        if (markers){
            for(i=0; i<markers.length; ++i)
                markers[i].setMap(null);
        }
        markers.length = 0;
        /* Creazione dei nuovi markers dall'XML
         */
        $(data).find('evento').each(function(){
          //  console.log($(this).find('nome').text());
            var pos = new google.maps.LatLng(
                parseFloat($(this).find('lat').text()),
                parseFloat($(this).find('lon').text()));
            var marker = new google.maps.Marker({'position':pos,
            'map':map});
            marker.id = parseInt($(this).find('id').text());
            marker.title = $(this).find('nome').text();
            marker.descrizione = $(this).find('descrizione').text();
            marker.data = $(this).find('data').text();
            marker.preferito = checkPreferito;
            marker.infoHTML = infoHTML;
            markers.push(marker);
        });
        for( i=0; i<markers.length; ++i){
            var marker = markers[i];
            google.maps.event.addListener(marker, 'click', function () {
                google.maps.event.clearListeners(map, 'idle');
                google.maps.event.addListener(map, 'idle', mapWait);
                /* 
                 * Se la infowindow era chiusa o era posizionata
                 * su un altro marker, la posizioniamo su this
                 * e carichiamo le informazioni relative.
                 */
                if (infowindow.marker != this.id){                       
                    infowindow.marker = this.id;
                    infowindow.setContent(this.infoHTML());
                    infowindow.open(map, this);
                }
                else { 
                    infowindow.close();
                    infowindow.marker = null;
                }
            });
        }

    });
}
/* Controlliamo che un marker faccia parte degli eventi preferiti
 * dell'utente. Dobbiamo effettuare una chiamata sincrona perché
 * non possiamo scrivere 
 */
function checkPreferito(){
    var out = false;
    var marker=this;
    console.log(marker.id);
    $.ajax({
        async: false,
        url: "CHome.php",
        data: {'action': "getEventiPreferiti"},
    }).done(function(data){
            $(data).find('id').each(function(){
                if (parseInt($(this).text()) == marker.id){
                    out = true;
                    return false;
                }
            });
            /* 
             * Per le prossime volte, restituiamo semplicemente
             * il valore ottenuto anziché fare una nuova richiesta
             */
            marker.preferito = function(){ return out; }
        });
    return out;
}
/*
 * Quando viene aperta una infowindow bisogna impedire il triggering 
 * di getEventiMappa(). Altrimenti il marker verrebbe cancellato
 * e la infowindow verrebbe chiusa.
 */
function mapWait(){
    google.maps.event.clearListeners(map, 'idle');
    google.maps.event.addListener(map, 'idle', getEventiMappa);
}

/* Formattazione del contenuto delle infoWindow
 *
 */
function infoHTML(){
    var output= '<div class="infowindow">'+
        '<h2>'+this.title+'</h2>'+
        '<h3>'+this.data;
    if (this.preferito() == false){
        output +=' - <a href="#" class="addPreferiti" id="'+this.id+
        '">Aggiungi ai Preferiti</a></h3>';
    }
    else {
        output +=' - <a href="#" class="removePreferiti" id="'+this.id+
        '">Rimuovi dai Preferiti</a></h3>';
    }
    output+='<p>'+this.descrizione+
    ' <a href="#">(visualizza altro)</a></p>'+
    '</div>';
    return output;
}
});
</script>
	</head>
	<body>
        <div id="box">
            <div id="boxl">
                <input type="text" class="ricerca" value="Cerca..." />
            </div>
            <div id="boxr">
                <button class="button" id="options">Username</button>
            </div>
        </div>
		<div id="map_canvas" style='height: 600px'></div>
	</body>
</html>
