<div id="profilo">

{if !$reader }

    <h2>Profilo</h2>

   
    <div class="indent">


        <div id='modificaProfilo'  >
            <table>

                <tr><h1>{$utente->getUsername()}: i tuoi dati</h1></tr>


                <tr>
                <a href="#" class="modificaPwd">modifica password</a>
                </tr>
                <tr class = 'password'>
                    <td><label class="label1">password:</label></td>
                    <td>
                        <input type="password"  name="password" id="codice" class="input3" />
                    </td>
                </tr>
                <tr class = 'password'>
                    <td><label class="label1">ripeti password:</label></td>
                    <td><input type="password" name="password1" id="codice1" class="input3" />
                </tr>
                <tr>
                    <td><label class="label1">nome:</label></td>
                    <td><input type="text" name="nome" id='nome' class="input3" value="{$utente->getNome()}" /></td>
                </tr>
                <tr>
                    <td><label class="label1">cognome:</label></td>
                    <td><input type="text" name="cognome" id='cognome' class="input3" value="{$utente->getCognome()}" /></td>
                </tr>
                <tr>
                    <td><label class="label1">città:</label></td>
                    <td><input type="text" name="citta" id='city' class="input3" value="{$utente->getCitta()}" /></td>
                </tr>
                <tr>
                    <td><label class="label1">e-mail:</label></td>
                    <td><input type="text" name="email" id='email' class="input3" value="{$utente->getEmail()}" /></td>
                </tr>
                <tr>
                    <td colspan="2"><button id="updateButton" class="button">Salva</button></td>
                </tr>

                {if $utente->isAdmin()}
                <tr>
                    <td><label class="label1">Nuovo Admin:</label></td>
                    <td><input type="text" name="admin" id='admin' class="input3" /></td>
                    <td colspan="2"><button id="adminButton" class="button">add</button></td>
                </tr>
                <tr>
                    <td><label class="label1">Nuovo SuperUser:</label></td>
                    <td><input type="text" name="superuser" id='superuser' class="input3 " /></td>
                    <td colspan="2"><button id="superuserButton" class="button">add</button></td>
                </tr>
            </table>
             {/if}
            <table>

                {if $utente->isAdmin()}
                <tr>
                    <td><h3>Sei Amministratore di Galufra web-app</h3></td>
                </tr>
                {/if}

                {if $utente->isSuperuser()}
                <tr>
                    <td><h3>Sei Superuser di Galufra web-app</h3></td>
                </tr>
                {/if}
            </table>

        </div>
        {else}
        <table>

            <tr><h1>Profilo Utente</h1></tr>

            {if $utente->isAdmin()}
            <h4><a href="#" id='eliminaUtente' value="{$utenteV->getUsername()}">(Elimina Utente)</a></h4>
            {/if}
            <tr>
                <td><label class="box">Username: {$utenteV->getUsername()}</label></td>
            </tr>
            <tr>
                <td><label class="box">Nome: {$utenteV->getNome()}</label></td>
            </tr>
            <tr>
                <td><label class="box">Cognome: {$utenteV->getCognome()}</label></td>
            </tr>
            <tr>
                <td><label class="box">Città: {$utenteV->getCitta()}</label></td>
            </tr>
            <tr>
                <td><label class="box">E-Mail: {$utenteV->getEmail()}</label></td>
            </tr>
            {if $utenteV->isSuperuser()}
            <tr>
                <td>È un Superuser di Galufra web-app</td>
            </tr>
            {/if}
        </table>
        {/if}
    </div>
</div>
