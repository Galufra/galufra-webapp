{if isset($eventi)}
<h3>Risultati della ricerca</h3>
<div class="cons">
{foreach from=$eventi item=evento}
    <div class="box">
        <a href="CBacheca.php?id={$evento->id_evento}"><li>{$evento->nome}</li></a>
        <ul>{$evento->data}</ul>
        <ul>{$evento->descrizione}</ul>
    </div>
{/foreach}
</div>
{else}
    {if !isset($noresult)}
        <h3>Ricerca</h3>
        <form action='CCerca.php' method='GET'>
            Nome dell'evento: <input type='text' name='nome'>
        </form>
    {else}
        <h3>Risultati della ricerca</h3>
        <p>Nessun evento corrisponde ai dati di ricerca :(</p>
    {/if}
{/if}
