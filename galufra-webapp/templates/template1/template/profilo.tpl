<div id="profilo">
    <h2>Profilo</h2>

    <img src="" alt="" width="109" height="109" class="image" />
    <div class="indent">


{if !$reader }
        <div id='modificaProfilo'  >
            <table>

                <tr><h1>{$utente->getUsername()}: i tuoi dati</h1></tr>


                <tr>
                    <a href="#" class="modificaPwd">modifica password</a>
                </tr>
                <tr class = 'password'>
                    <td><label class="label1">password:</label></td>
                    <td>
                        <input type="password"  name="password" id="password" class="input3" />
                    </td>
                </tr>
                <tr class = 'password'>
                <td><label class="label1">ripeti password:</label></td>
                    <td><input type="password" name="password1" id="password1" class="input3"/>
                </tr>
                <tr>
                    <td><label class="label1">nome:</label></td>
                    <td><input type="text" name="nome" id='nome' class="input3" value={$utente->getNome()} /></td>
                </tr>
                <tr>
                    <td><label class="label1">cognome:</label></td>
                    <td><input type="text" name="cognome" id='cognome' class="input3" value={$utente->getCognome()} /></td>
                </tr>

                <tr>
                    <td><label class="label1">città:</label></td>
                    <td><input type="text" name="citta" id='citta' class="input3 " value={$utente->getCitta()} /></td>
                </tr>
                <tr>
                    <td><label class="label1">e-mail:</label></td>
                    <td><input type="text" name="email" id='email' class="input3 " value={$utente->getEmail()} /></td>
                </tr>
                <tr>

                    <td colspan="2"><button id="updateButton" class="button">Salva</button></td>
                </tr>
            </table>
        </div>
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
                <td><label class="box">Città: {$utente->getCitta()}</label></td>
            </tr>
            <tr>
                <td><label class="box">E-Mail: {$utente->getEmail()}</label></td>
            </tr>
        </table>
        {/if}
    </div>
</div>