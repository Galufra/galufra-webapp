<script type='text/javascript'>
id_evento = {$evento->id_evento}
lat= {$evento->lat}
lon= {$evento->lon}
</script>

<h1 id='nome'>{$evento->nome}</h1>
<h2 id='data'></h2>

<div id='descrizione'>
<p>{$evento->descrizione}</p>
</div>

<div id='map_canvas' style='height: 300px'></div>
