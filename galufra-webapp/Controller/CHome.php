<?php
require_once('../Foundation/FUtente.php');
require_once('../Foundation/FEvento.php');
require_once('../Entity/EUtente.php');
require_once('../Entity/EEvento.php');

class CHome{
private $utente;

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
        case('getEventi'):
            $this->getEventi(
				$_GET['neLat'], $_GET['neLon'],
				$_GET['swLat'], $_GET['swLon']
				);
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
     * Restituisce gli eventi che $this->utente può visualizzare
     * nella zona da (lat1, lon1) a (lat2, lon2)
     * (per ora carica tutti gli eventi)
     *   1+-------
     *    |      |
     *    | Map  |
     *    |      |
     *    -------+2
     *
     */
    public function getEventi($neLat, $neLon, $swLat, $swLon){
		$domtree = new DOMDocument('1.0', 'UTF-8');
		$xmlRoot = $domtree->createElement("xml");
        $xmlRoot = $domtree->appendChild($xmlRoot);
        $ev = new FEvento();
        $ev->connect();
        $ev_array = $ev->searchEventi($neLat, $neLon, $swLat, $swLon);
        foreach ($ev_array[1][1] as $evento){
			$xmlEvento = $domtree->createElement("evento");
			$xmlEvento = $xmlRoot->appendChild($xmlEvento);
			$xmlEvento->appendChild(
				$domtree->createElement('id', $evento->getIdEvento())
			);
			$xmlEvento->appendChild(
				$domtree->createElement('nome', $evento->getNome())
			);
			$xmlEvento->appendChild(
				$domtree->createElement('data', $evento->getData())
			);
			$xmlEvento->appendChild(
				$domtree->createElement('lat', $evento->getLat())
			);
			$xmlEvento->appendChild(
				$domtree->createElement('lon', $evento->getLon())
			);
		}
        echo $domtree->saveXML();

        exit;
    }
}

$home= new CHome();
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="login.css">
		<link rel="stylesheet" type="text/css" href="map.css">
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAO2zXC0wh-S8SjMgPRZfoTUGZMGHBIzZ0&sensor=false"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
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
        		var infowindow = new google.maps.InfoWindow();
        		google.maps.event.addListener(map, 'idle', getEventi);
     		/*
      		 * Visualizza sulla mappa gli eventi contenuti in
      		 * bounds (oggetto LatLngBounds di Google Maps)
      		 */
      		function getEventi(){
				bounds = map.getBounds();
				$.get("CHome.php?action=getEventi",
				{'neLat': bounds.getNorthEast().lat(),
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
						console.log($(this).find('nome').text());
						var pos = new google.maps.LatLng(
							parseFloat($(this).find('lat').text()),
							parseFloat($(this).find('lon').text()));
						var marker = new google.maps.Marker({'position':pos,
						'map':map});
						markers.nome = $(this).find('nome').text();
						markers.push(marker);
					})
					for( i=0; i<markers.length; ++i){
						google.maps.event.addListener(markers[i], 'click', function(marker){
							console.log('click');
						});
					}
				});
			}
				/* Listener per mostrare il menu
				 * delle impostazioni utente
				 */
				$("#options").click(function ( event ) {
                    var options = $('#options')
					var off = options.offset();
                    console.log(off);
					var h = options.height();
					$("#optionswindow").css({
                        'top': off.top+h,
                        'left': off.left
                    })
					.toggle("slow");
                    console.log($("#optionswindow").offset());
				});
				$(".ricerca").click(function ( event ) {
					$(".ricerca").val("")
					.css("color","black");
			
				});
				$(".ricerca").focusout(function ( event ) {
					$(".ricerca").css("color","gray")
					.val("Cerca...");
				});
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
        <div id="map_content">
		<div id="map_canvas"></div>
		<div id="map_side">
			Prossimi eventi<br>
			Eventi importanti
		</div>
		<div id="optionswindow">
			<?php echo $home->getUtente()->getNome()."<br />";  ?>
			Impostazioni<br/>
			Logout
		</div>
	</div>
	</body>
</html>
