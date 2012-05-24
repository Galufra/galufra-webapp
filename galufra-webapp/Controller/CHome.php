<?php
require_once('../Foundation/FUtente.php');
require_once('../Entity/EUtente.php');

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
            $this->getEventi();
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
     *   1+-------
     *    |      |
     *    | Map  |
     *    |      |
     *    -------+2
     *
     */
    public function getEventi(){
        echo 'getEventi()';
        /* Dovremo caricare in un array $ev_array tutti gli eventi
         * WHERE 
         * lat BETWEEN lat1 and lat2 AND
         * lon BETWEEN lon1 and lon2 AND
         * "evento visibile da parte dell'utente" (evento pubblico 
         * o utente invitato)
         * 
         * In EEvento ho messo un metodo getCoord() per ottenere un
         * array {lat, lon} dell'evento (o meglio, del locale in cui
         * esso si svolge).
         * 
         * Se vogliamo usare XML, servirà un template Smarty per
         * generarlo. 
         * $smarty->assign('eventi', $ev_array)
         * dentro il template ci sarà un ciclo di questo genere:
         * {foreach from=$ev_array item=i}
         *      {assign var=coord value=$i->getCoord()}
         *      <evento>
         *          <nome>{$i->getNome()}</nome>
         *          <descrizione>{$i->getDescrizione()}</descrizione>
         *          <lat>{$coord.lat}</lat>
         *          <lon>{$coord.lon}</lon>
         *      </evento>
         * {/foreach}
         * 
         * Forse chiamare i metodi dal template non è "giusto", dovremmo
         * chiedere lumi al professore. In caso bisognerà lavorare in PHP
         * e passare a Smarty un array bidimensionale anziché un array di
         * oggetti. Vedremo :)
         */
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
        <script type="text/javascript" src="js/jquery/jquery.js"></script>
		<script type="text/javascript">
		    $(document).ready(function(){
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
	        <script type="text/javascript"
	            src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAO2zXC0wh-S8SjMgPRZfoTUGZMGHBIzZ0&sensor=false"></script>
	        <script type="text/javascript">
			var map;
			function initialize() {
				
				geocoder = new google.maps.Geocoder();
				var myOptions = {
          			zoom: 16,
         			mapTypeId: google.maps.MapTypeId.ROADMAP
        		};
        		map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);
        		citta = "<?php echo $home->getUtente()->getCitta(); ?>";
        		geocoder.geocode(
					{'address': citta},
					function(results, status) {
						map.setCenter(results[0].geometry.location);
					}
        		);
      			}
		</script>
	</head>
	<body onload="initialize()">
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
