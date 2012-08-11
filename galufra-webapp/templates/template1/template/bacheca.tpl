
<div id = 'bacheca' >

    <h1 align=center>{$evento->getNome()}</h1>
    <h3>{$evento->getData()}</h3>

    <h2>{$evento->getDescrizione()}</h2>

    <div id='messaggiBacheca'>

    </div>

    <div id='creaMessaggio' >
        <table>
            <tr>
                <td><label>Messaggio:</label></td>
                <td><textarea id='messaggio' rows=4></textarea></td>
            </tr>
            <tr>
                <td><button id='inserisciMessaggio' class = "button">Scrivilo!</button></td>
            </tr>
        </table>
    </div>



</div>
<div id='map_canvas' style='height: 300px'></div>
