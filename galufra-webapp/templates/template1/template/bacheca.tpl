<script type='text/javascript'>
lat = {$evento->getLat()};
lon = {$evento->getLon()};
</script>

<div id = 'bacheca' >

    <div>
        {if $utente->isAdmin()}
        <h4><a href="#" id='eliminaEvento'>(Elimina Evento)</a></h4>
        {/if}
        <h1 align=center>{$evento->getNome()}</h1>
    </div>
    <h3>Data: {$data}</h3>

    <a href="#"><h4 id='partecipanti'>Partecipanti: {$partecipanti}</h4></a>

    <div id="elenco_part" >
        <a href="#" id="nascondi_elenco"><h4>nascondi</h4></a>
    </div>

    <p id='descrizione'>{$evento->getDescrizione()}</p>

    <div id='map_canvas' style='height: 300px'></div>

    <div id='annuncioGestore'>


    </div>

    {if $utente->getId() == $evento->getGestore() || $utente->isAdmin()}
    <div id='creaAnnuncio' >
        <table>
            <tr>
                <td><label>Annuncio:</label></td>
                <td><textarea id='annuncio' rows=4></textarea></td>
            </tr>
            <tr>
                <td><button id='inserisciAnnuncio' class = "button">Annuncia!</button></td>
            </tr>
        </table>
    </div>
    {/if}

    <div id='messaggiBacheca'>
        <br><h2>Bacheca Messaggi:</h2>
    </div>

    <div id='creaMessaggio' >
        <table>
            <tr>
                <td><label>Messaggio:</label></td>
                <td><textarea id='messaggio' rows=4></textarea></td>
            </tr>
            <tr>
                <td><button id='inserisciMessaggio' class = "button">Scrivi!</button></td>
            </tr>
        </table>
    </div>



</div>
<div id='map_canvas' style='height: 300px'></div>
