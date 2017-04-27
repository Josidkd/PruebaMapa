<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Ciudades de España</title>
	<!-- Carga css -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> <!-- CDN BOOTSTRAP -->
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="estilo.css" />
</head>
<body>
	<?php
	define('HOST_DB', 'localhost');
	define('USER_DB', 'prueba');
	define('PASS_DB', 'prueba');
	define('NAME_DB', 'prueba');
	function conectar(){
	    global $conexion;
	    $conexion = mysqli_connect(HOST_DB, USER_DB, PASS_DB, NAME_DB)
	    or die ('NO SE HA PODIDO CONECTAR A LA BASE DE DATOS');
	    mysqli_select_db($conexion, NAME_DB)
	    or die ('NO SE ENCUENTRA LA BASE DE DATOS ' . NAME_DB);
	}
	function desconectar(){
	    global $conexion;
	    mysqli_close($conexion);
	}
	function buscaComunidades() {
		  global $conexion;
		  $texto = '';
		  conectar();
	      mysqli_set_charset($conexion, 'utf8');
		  $sql = "SELECT * FROM comunidades ORDER BY nombre";
		  $resultado = mysqli_query($conexion, $sql);
	      //Si hay resultados...
		  if (mysqli_num_rows($resultado) > 0){ 

			 while($fila = mysqli_fetch_assoc($resultado)){ 
	              $texto .= '"' . $fila['nombre'] . '",';
				 }
		  }else{
				   $texto = "NO HAY RESULTADOS EN LA BBDD";	
		  }
		  mysqli_close($conexion);
		  return $texto;
	}
	$comunidades = buscaComunidades();
	?>
	<!-- Contenido web -->
	<div class="container">
		<div class="col-md-12 text-center">
			<h1>Ciudades de España</h1>
			<br><br>
			<form text-left">
				<div class="col-md-12 text-left">
					<label for="provincias">Comunidad: </label>
				</div>
				<div class="col-md-10">
					<input id="buscador" placeholder="escribe..">
				</div>
				<div class="col-md-2">
					<input id="btnBuscar" type="button" name="Buscar" value="BUSCAR">
				</div>
			</form>
			<div class="col-md-12 text-center">
				<h2 id="nombreComunidad" class="txtComunidad"></h2>
			</div>
			<div id="mapa" class="col-md-12 text-left"></div>
		</div>
	</div>
	<!-- Carga js -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> <!-- CDN JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> <!-- CDN JQUERY-ui -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> <!-- CDN BOOTSTRAP-->
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<!-- Scripts JS-->
	<script>
	/* Autocompletado */
	$( function() {
		var availableTags = [<?php echo $comunidades ?>];
		$( "#buscador" ).autocomplete({
			source: availableTags
		});
	} );
	/* Boton buscar */
	$('#btnBuscar').on('click', function(event) {
		var seleccionado = $("#buscador").val();
		var marcadores = "";
		if(seleccionado == "Andalucía"){
			$("#nombreComunidad").html("Andalucía");
			marcadores =[
			['Huelva', 37.261421 , -6.944722400000046],
			['Sevilla', 37.3890924, -5.984458899999936],
			['Córdoba', 37.8881751, -4.7793834999999945],
			['Jaén', 37.7795941, -3.7849056999999675],
			['Almería', 36.834047, -2.4637136000000055],
			['Granada', 37.1773363, -3.5985570999999936],
			['Málaga', 36.7212737, -4.42139880000002],
			['Cádiz', 36.5270612, -6.288596200000029]
			];
		}
		if(seleccionado == "Aragón"){
			$("#nombreComunidad").html("Aragón");
			marcadores =[
			['Huesca', 42.131845, -0.40780580000000555],
			['Zaragoza', 41.6488226, -0.8890853000000334],
			['Teruel', 40.3456879, -1.1064344999999776]
			];
		}
		if(seleccionado == "Asturias, Principado de"){
			$("#nombreComunidad").html("Principado de Asturias");
			marcadores =[
			['Asturias', 43.3613953, -5.859326699999997]
			];
		}
		if(seleccionado == "Balears, Illes"){
			$("#nombreComunidad").html("Islas Baleares");
			marcadores =[
			['Baleares', 39.5341789, 2.857710499999939]
			];
		}
		if(seleccionado == "Canarias"){
			$("#nombreComunidad").html("Canarias");
			marcadores =[
			['Santa Cruz de Tenerife', 28.4636296, -16.251846699999987],
			['Las Palmas', 28.1235459, -15.436257399999931]
			];
		}
		if(seleccionado == "Cantabria"){
			$("#nombreComunidad").html("Cantabria");
			marcadores =[
			['Cantabria', 43.1828396, -3.9878426999999874]
			];
		}
		if(seleccionado == "Castilla y León"){
			$("#nombreComunidad").html("Castilla y León");
			marcadores =[
			['León', 42.5987263, -5.567095900000027],
			['Palencia', 42.0096857, -4.528801599999952],
			['Burgos', 42.3439925, -3.6969060000000127],
			['Soria', 41.7665972, -2.4790305999999873],
			['Zamora', 41.5034712, -5.746787899999958],
			['Valladolid', 41.652251, -4.724532100000033],
			['Segovia', 40.9429032, -4.1088068999999905],
			['Salamanca', 40.9701039, -5.663539700000001],
			['Avila', 40.656685, -4.681208599999991]
			];
		}
		if(seleccionado == "Castilla - La Mancha"){
			$("#nombreComunidad").html("Castilla la Mancha");
			marcadores =[
			['Guadalajara', 40.632489, -3.1601699999999937],
			['Cuenca', 40.0703925, -2.1374161999999615],
			['Albacete', 38.994349, -1.858542400000033],
			['Ciudad Real', 38.9848295, -3.927377799999931],
			['Toledo', 39.8628316, -4.02732309999999]
			];
		}
		if(seleccionado == "Catalunya"){
			$("#nombreComunidad").html("Cataluña");
			marcadores =[
			['Lleida', 41.6175899, 0.6200145999999904],
			['Girona', 41.9794005, 2.821426400000064],
			['Barcelona', 41.3850639, 2.1734034999999494],
			['Tarragona', 41.1188827, 1.2444908999999598]
			];
		}
		if(seleccionado == "Comunitat Valenciana"){
			$("#nombreComunidad").html("Comunidad Valenciana");
			marcadores =[
			['Castellón', 39.9863563, -0.051324600000043574],
			['Valencia', 39.4699075, -0.3762881000000107],
			['Alicante', 38.3459963, -0.4906855000000405]
			];
		}
		if(seleccionado == "Extremadura"){
			$("#nombreComunidad").html("Extremadura");
			marcadores =[
			['Caceres', 39.4752765, -6.3724247000000105],
			['Badajoz', 38.8794495, -6.970653500000026]
			];
		}
		if(seleccionado == "Galicia"){
			$("#nombreComunidad").html("Galicia");
			marcadores =[
			['La Coruña', 43.3623436, -8.411540100000025],
			['Lugo', 43.0097384, -7.55675819999999],
			['Orense', 42.3357829, -7.863931399999956],
			['Pontevedra', 42.4298846, -8.644620199999963]
			];
		}
		if(seleccionado == "Madrid, Comunidad de"){
			$("#nombreComunidad").html("Comunidad de Madrid");
			marcadores =[
			['Madrid', 40.4167754, -3.7037901999999576]
			];
		}if(seleccionado == "Murcia, Región de"){
			$("#nombreComunidad").html("Región de Murcia");
			marcadores =[
			['Murcia', 37.9922399, -1.1306544000000258]
			];
		}
		if(seleccionado == "Navarra, Comunidad Foral de"){
			$("#nombreComunidad").html("Comunidad Foral de Navarra");
			marcadores =[
			['Navarra', 42.6953909, -1.6760690999999497]
			];
		}if(seleccionado == "País Vasco"){
			$("#nombreComunidad").html("País Vasco");
			marcadores =[
			['Vizcaya', 43.2204286, -2.69838679999998],
			['Gipúzcoa', 43.0756299, -2.223666699999967],
			['Alava', 42.9099989, -2.69838679999998]
			];
		}if(seleccionado == "Rioja, La"){
			$("#nombreComunidad").html("La Rioja");
			marcadores =[
			['La Rioja', 42.2870733, -2.5396029999999428]
			];

		}if(seleccionado == "Ceuta"){
			$("#nombreComunidad").html("Ceuta");
			marcadores =[
			['Ceuta', 35.8893874, -5.321345500000007]
			];
		}if(seleccionado == "Melilla"){
			$("#nombreComunidad").html("Melilla");
			marcadores =[
			['Melilla', 35.2922775, -2.9380972999999813]
			];
		}
		cargaMapa(marcadores);
	});
	/* Creación del mapa */
	function cargaMapa(marcadores) {
		var marcadores = marcadores;
      var map = new google.maps.Map(document.getElementById('mapa'), {
        zoom: 7,
        center: new google.maps.LatLng(marcadores[0][1], marcadores[0][2]),
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });
      var infowindow = new google.maps.InfoWindow();
      var marker, i;
      for (i = 0; i < marcadores.length; i++) {  
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(marcadores[i][1], marcadores[i][2]),
          map: map
        });
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
            infowindow.setContent(marcadores[i][0]);
            infowindow.open(map, marker);
          }
        })(marker, i));
      }
    }
	</script>
</body>
</html>