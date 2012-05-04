<?php
require_once('utente.php');
/*
 * per ora faccio qualche prova impostando l'id a mano
 */
$u = new utente(12);
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
					o = $("#options").offset();
					o.top +=$("#options").height()
					$("#optionswindow").offset(o);
					$("#optionswindow").toggle("slow");
				});
				$(".ricerca").click(function ( event ) {
					$(".ricerca").val("");
					$(".ricerca").css("color","black");
			
				});
				$(".ricerca").focusout(function ( event ) {
					$(".ricerca").css("color","gray");
					$(".ricerca").val("Cerca...");
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
        		citta = "<?php echo $u->getCitta(); ?>";
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
			<?php echo $u->getNome()."<br />";  ?>
			Impostazioni<br/>
			Logout
		</div>
	</div>
	</body>
</html>
