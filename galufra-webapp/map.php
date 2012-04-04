<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="login.css">
		<link rel="stylesheet" type="text/css" href="map.css">
        	<script type="text/javascript" src="js/jquery/jquery.js"></script>
		<script type="text/javascript">
		    $(function() {
			$("#options").click(function ( event ) {
			    $("#optionswindow").toggle("slow");
			});
		    });
		    $(function() {
			$(".ricerca").click(function ( event ) {
			    $(".ricerca").val("");
			    $(".ricerca").css("color","black");
		
			});
		    });
		    $(function() {
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

		            	var o = $("#options").offset();
			    	o.top += $("#options").height();
			 	$("#optionswindow").offset(o);
        		
              			var myOptions = {
          			zoom: 8,
        			center: new google.maps.LatLng(-34.397, 150.644),
         			mapTypeId: google.maps.MapTypeId.ROADMAP
        		};
        		map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);
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
	</div>
        <div id="optionswindow">
		Impostazioni<br/>
		Logout
	</div>
	</body>
</html>
