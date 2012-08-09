<div id="profilo">
    <h2>Profilo</h2>

    <img src="" alt="" width="109" height="109" class="image" />
    <div class="indent">


{if !$reader }
        <form action="" method="post" >
            <table>

                <tr><h1>I tuoi dati</h1></tr>


                <tr>
                    <td><label class="label1">username:</label></td>
                    <td><input type="text" disabled="dis" name="username" class="input3"  value={$utente->getUsername()} /></td>
                </tr>
                <tr>
                    <td><label class="label1">password:</label></td>
                    <td><input type="password" disabled="dis" name="password" class="input3" value={$utente->getPassword()} /><a href="#">modifica</a></td>
                </tr>
                <tr>
                    <td><label class="label1">nome:</label></td>
                    <td><input type="text" name="nome" class="input3" value={$utente->getNome()} /></td>
                </tr>
                <tr>
                    <td><label class="label1">cognome:</label></td>
                    <td><input type="text" name="cognome" class="input3" value={$utente->getCognome()} /></td>
                </tr>

                <tr>

                    <td><label class="label1">data di nascita:</label></td>
                    <td><input type="date" name="data" class="input3"  id="testButton" value={$utente->getData()}/></td>

                </tr>

                <tr>
                    <td><label class="label1">città:</label></td>
                    <td><input type="text" name="citta" class="input3 " value={$utente->getCitta()}/></td>
                </tr>
                <tr>
                    <td><label class="label1">e-mail:</label></td>
                    <td><input type="text" name="email" class="input3 " value={$utente->getEmail()} /></td>
                </tr>
                <tr>

                    <td colspan="2"><button id="regbutton" class="button">Salva</button></td>
                </tr>
            </table>
        </form>
        {else}
        <table>

            <tr><h1>Profilo Utente</h1></tr>


            <tr>
                <td><label class="box">Username: {$utente->getUsername()}</label></td>
            </tr>
            <tr>
                <td><label class="box">Nome: {$utente->getNome()}</label></td>
            </tr>
            <tr>
                <td><label class="box">Cognome: {$utente->getCognome()}</label></td>
            </tr>
            <tr>
                <td><label class="box">Data di Nascita: {$utente->getDate()}</label></td>
            </tr><tr>
                <td><label class="box">Città: {$utente->getCitta()}</label></td>
            </tr><tr>
                <td><label class="box">E-Mail: {$utente->getEmail()}</label></td>
            </tr>
        </table>
        {/if}
    </div>
</div>