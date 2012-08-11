<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License
-->
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Galufra_WebApp 1.0</title>
        <meta name="Keywords" content="" />
        <meta name="Description" content="" />
        <link href="../templates/template1/template/default.css" rel="stylesheet" type="text/css" />
        <link href="../js/anytime.c.css" rel="stylesheet" type="text/css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAO2zXC0wh-S8SjMgPRZfoTUGZMGHBIzZ0&sensor=false"></script>
        <script type="text/javascript" src='../js/functions.js'></script>
{foreach $scripts as $s}
        <script type="text/javascript" src='../js/{$s}'></script>
{/foreach}

    </head>
    <body>
        <div id="header">
            <ul id="menu">
                <li><a href="CHome.php" accesskey="1" title="">Home</a></li>
                <li><a href="profilo.html" accesskey="2" title="">Profilo</a></li>
                <li><a href="#" accesskey="3" title="">Crea Evento</a></li>
                <li id='messagebox'></li>
            </ul>

            <form id="search" method="get" action="">
                <fieldset>
                    <input name="input1" type="text" id="input1" />
                    <input name="input2" type="submit" id="input2" value="Search" />
                </fieldset>
            </form>
        </div>

        <div id="content">
            <div id="colOne">
                <div id="logo">

                    <form action="CHome.php?action=login" method="post" >

                        <table cellpadding="1">

                            <tr><h1>login</h1></tr>

                            <tr>
                                <td>    <label class="label">username:</label> </td>
                                <td class="right">    <input type="text" name="username" class="input4" size="20"/></td>
                            </tr>

                            <tr>
                                <td>	<label class="label">password:</label> </td>
                                <td>    <input type="password" name="password"class="input4" size="20" /> </td>
                            </tr>

                            <tr>
                                <td>    <button id="loginbutton" class="button">Login</button> </td>
                            </tr>

                        </table>
                    </form>

                    <div align=center><a id="areg" href=""><b>Registrati!</b></a></div>

                </div>
                <div id="logo2">

                    <form action="CHome.php?action=reg" method="post" >
                        <table>

                            <tr><h1>Registrazione</h1></tr>

                            <tr>
                                <td><label class="label">username:</label></td>
                                <td><input type="text" name="username" class="input4 " size="20"/></td>
                            </tr>
                            <tr>
                                <td><label class="label">password:</label></td>
                                <td><input type="password" name="password" class="input4 " size="20" /></td>
                            </tr>
                            <tr>
                                <td><label class="label">ripeti password:</label></td>
                                <td><input type="password" name="password1" class="input4 " size="20" /></td>
                            </tr>
                            <tr>
                                <td><label class="label">città:</label></td>
                                <td><input type="text" name="citta" class="input4 " size="20" /></td>
                            </tr>->
                            <tr>
                                <td><label class="label">e-mail:</label></td>
                                <td><input type="text" name="mail" class="input4 " size="20" /></td>
                            </tr>
                            <tr>

                                <td colspan="2"><button id="regbutton" class="button">ok</button></td>
                            </tr>
                        </table>
                    </form>

                </div>
                <div id="logo3">
                    {if $name != null}
                    <h2>Ciao {$name}</h2>
                    {/if}
                    <div>
                        <h3><a href="CHome.php?action=logout">Logout</a></h3>
                    </div>
                    <div id="crea">
                        <h3>
                            {if $sbloccato}
                            <a href="CCrea.php?action=">
                            {else}
                                <a href="CHome.php?action=">
                                    <script>
                                        showMessage("Limite eventi superato. Diventa SUPERUSER!");
                                    </script>
                             {/if}
                                    Crea Evento
                                </a>
                        </h3>
                    </div>
                    <div>
                        <h3><a href="CProfilo.php" class="profilo">Profilo</a></h3>
                    </div>
                </div>



                <div class="box" id="boxPersonali">
                    <h3><a href="CListaEventi.php?action=personali">Tuoi Eventi</a></h3>
                    <ul class="bottom" id='ulPersonali'></ul>
                </div>
                <div class="box" id="boxPreferiti">
                    <h3><a href="CListaEventi.php?action=preferiti">Eventi Preferiti</a></h3>
                    <ul class="bottom" id='ulPreferiti'>
                    </ul>
                </div>
                <div class="box" id="boxConsigliati">
                    <h3><a href="CListaEventi.php?action=consigliati">Eventi Consigliati</a></h3>
                    <ul class="bottom" id='ulConsigliati'>
                    </ul>
                </div>
            </div>

            <div  class="colTwo">
        {include $content}
            </div>

            <script>
        $("#logo2").hide();
        $("#logo3").hide();
            </script>

            {if $autenticato}
            <script>
                 $("#logo").hide("slow");
                 $("#logo3").show("slow");
            </script>
            {/if}

            <script>
                $("#areg").click(function ( event ) {
                  event.preventDefault();
                  $("#logo").hide("slow");
                      $("#logo2").show("slow");
                });
            </script>



        </div>
        <div id="footer">
            <p>Copyright (c) 2006 Sitename.com. All rights reserved. Design by <a href="http://freecsstemplates.org/">Free CSS Templates</a>.</p>
        </div>
    </body>
</html>
