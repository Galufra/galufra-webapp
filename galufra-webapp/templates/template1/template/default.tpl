<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License
-->
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Galufra_WebApp</title>
        <meta name="Keywords" content="" />
        <meta name="Description" content="" />
        <link rel="shortcut icon" href="../templates/template1/template/images/logo-galufra-favicon.ico" >
            <link href="../templates/template1/template/default.css" rel="stylesheet" type="text/css" />
            <link href="../js/anytime.c.css" rel="stylesheet" type="text/css" />
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
            <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAO2zXC0wh-S8SjMgPRZfoTUGZMGHBIzZ0&sensor=false"></script>
            <script src="http://maps.google.com/maps/api/js?libraries=places&region=uk&language=en&sensor=false"></script>
            <script type="text/javascript" src='../js/functions.js'></script>
{foreach $scripts as $s}
            <script type="text/javascript" src='../js/{$s}'></script>
{/foreach}

    </head>
    <body>
        <div id="header">
            <ul id="menu">
                <li><a href="CHome.php" accesskey="1" title=""><img alt=""  src="../templates/template1/template/images/logo-galufra.png"></img></a></li>
                {if $autenticato}
                <li><a href="CProfilo.php" accesskey="2" title="">Profilo</a></li>
                <li><a href="CHome.php?action=logout">Logout</a></li>
                {/if}
                <li id='messagebox'></li>
            </ul>
            {if $cerca}
            <div id="search">
                <fieldset>
                    <input id="cercaInputBox" name="input1" type="text"/>
                    <button class="button" id="cerca">Centra</button>
                </fieldset>
            </div>
            {/if}
        </div>
        <div id="content">
            <div id="colOne">
                <div id="logo">

                    <form action="CHome.php?action=login" method="post" >

                        <table cellpadding="1">

                            <tr><h1>login</h1></tr>

                            <tr>
                                <td>    <label class="label">username:</label> </td>
                                <td class="right">
                                    <input type="text" id="username" name="username" class="input4" size="13"/>
                                </td>
                            </tr>

                            <tr>
                                <td>	<label class="label">password:</label> </td>
                                <td>
                                    <input type="password" id="pass" name="password"class="input4" size="13" />
                                </td>
                            </tr>

                            <tr>
                                <td>    <button id="loginbutton" class="button">Login</button> </td>
                            </tr>

                        </table>
                    </form>

                    <div align=center><a id="areg" href=""><b>Registrati!</b></a></div>
                    <div align=center><a id="forgetpwd" href=""><b>password dimenticata </b></a></div>

                </div>
                <div id="logo2">

                    <form action="CHome.php?action=reg" method="post" >
                        <table>

                            <tr><h1>Registrazione</h1></tr>

                            <tr>
                                <td><label class="label">username:</label></td>
                                <td><input type="text" id="user" name="username" class="input4 " size="13"/></td>
                            </tr>
                            <tr>
                                <td><label class="label">password:</label></td>
                                <td><input type="password" id="password" name="password" class="input4 " size="13" /></td>
                            </tr>
                            <tr>
                                <td><label class="label">ripeti password:</label></td>
                                <td><input type="password" id="password1" name="password1" class="input4 " size="13" /></td>
                            </tr>
                            <tr>
                                <td><label class="label">città:</label></td>
                                <td><input type="text" id="citta" name="citta" class="input4 " size="13" /></td>
                            </tr>
                            <tr>
                                <td><label class="label">e-mail:</label></td>
                                <td><input type="text" id="email" name="mail" class="input4 " size="13" /></td>
                            </tr>
                            <tr>
                                <td colspan="1"><a href="#" id="backHome"><b>indietro</b></a></td>
                                <td colspan="2"><button id="regbutton" class="button">ok</button></td>
                            </tr>
                        </table>
                    </form>

                </div>

                <div id="recuperoPwd">
                    <div>
                        <table>
                            <tr>
                                <td><label class="label">username:</label></td>
                                <td><input type="text" id="userRec" name="username" class="input4 " size="13"/></td>
                            </tr>
                            <tr>
                                <td colspan="1"><a href="#" id="backHome"><b>indietro</b></a></td>
                                <td colspan="2"><button id="recbutton" class="button">ok</button></td>
                            </tr>
                        </table>
                        <div align=center><b>Ti verrà inviata una e-mail all' indirizzo di registrazione con una nuova password che potrai</div>
                        <div align=center>modificare
                            successivamente dal tuo profilo</b></div>
                    </div>
                </div>

                <div id="logo3">
                    {if $name != null}
                    <h3>
                        <div align=left>

                            Benvenuto {$name}!
                        </div>

                    </h3>
                    {/if}
                    <div id="crea" class="profilo">
                        <h4>
                            {if $sbloccato}
                            <a href="CCrea.php?action=">
                            {else}
                                <a href="CHome.php?action=">
                                    <script>
                                        showMessage("Diventa SUPERUSER per creare eventi!");
                                    </script>
                             {/if}
                                    Crea Evento
                                </a>
                        </h4>
                    </div>
                    <div class="profilo">
                        <h4><a href="CProfilo.php">Profilo</a></h4>
                    </div>
                    <div class='profilo'>
                        <h4><a href="CCerca.php">Ricerca Eventi</a></h4>
                    </div>
                    {if $autenticato && !$superuser}
                    <div class="profilo">
                        <h4><a href="CSuperuser.php">Diventa Superuser</a></h4>
                    </div>
                    {else}
                    <div class="profilo">
                        <h4><a href="CHome.php?action=logout">Logout</a></h4>
                    </div>
                    {/if}
                </div>


                {if $autenticato}
                <div class="box" id="boxPersonali">
                    <h3><a href="CListaEventi.php?action=personali">Tuoi Eventi</a></h3>
                    <ul class="bottom" id='ulPersonali'></ul>
                </div>
                <div class="box" id="boxPreferiti">
                    <h3><a href="CListaEventi.php?action=preferiti">Dove Sarò</a></h3>
                    <ul class="bottom" id='ulPreferiti'>
                    </ul>
                </div>
                <div class="box" id="boxConsigliati">
                    <h3><a href="CListaEventi.php?action=consigliati">Eventi Consigliati</a></h3>
                    <ul class="bottom" id='ulConsigliati'>
                    </ul>
                </div>
                {else}
                <div class="box">
                    <p id="benvenuto">Benvenuto in Galufra WebApp. L'applicazione si pone
                        come obiettivo quello di proporre un nuovo modo di valorizzare
                        il territorio utilizzando una mappa come punto di accesso ad ogni luogo.
                        Adesso puoi consultarla liberamente, ma per avere accesso a tutte le
                        funzionalità è necessaria la <a href="#" class="goToReg">registrazione ;)</a></p>
                    <p id="benvenuto">
                        Francesco, Luca e Gabriele
                    </p>
                </div>
               {/if}

            </div>
            <div  class="colTwo">
        {include $content}
            </div>

            <script>
        $("#logo2").hide();
        $("#logo3").hide();
        $("#recuperoPwd").hide();
            </script>

            {if $autenticato}
            <script>
                 $("#logo").hide("slow");
                 $("#logo3").show("slow");
            </script>
            {/if}

            {if !$regConfirmed}
            <script>
            showMessage("Conferma la registrazione in 1 giorno!");
            </script>
            {/if}

            {if $errore_loggato}
            <script>showMessage("Login Fallito");</script>
            {/if}

            {if $errore_registrazione}
            <script>showMessage("Registrazione fallita...Riprova");</script>
            {/if}

            <script>
                $("#areg").click(function ( event ) {
                  event.preventDefault();
                  $("#logo").hide("slow");
                  $("#logo2").show("slow");
                });

               $("#forgetpwd").click(function ( event ) {
                  event.preventDefault();
                  $("#logo").hide("slow");
                  $("#recuperoPwd").show("slow");
                });

            </script>


        </div>
        <div id="footer">
            <p>Copyright (c) 2012 Galufra web-app. All rights reserved. Design by <a href="http://freecsstemplates.org/">Free CSS Templates</a>.</p>
        </div>
    </body>
</html>
