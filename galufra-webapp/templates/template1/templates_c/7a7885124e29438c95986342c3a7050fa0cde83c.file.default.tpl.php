<?php /* Smarty version Smarty-3.1.10, created on 2012-08-05 13:55:58
         compiled from "../templates/template1/template/default.tpl" */ ?>
<?php /*%%SmartyHeaderCode:116381495150127392e30ec1-13862966%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7a7885124e29438c95986342c3a7050fa0cde83c' => 
    array (
      0 => '../templates/template1/template/default.tpl',
      1 => 1344167752,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '116381495150127392e30ec1-13862966',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.10',
  'unifunc' => 'content_50127392ea25b1_78331766',
  'variables' => 
  array (
    'scripts' => 0,
    's' => 0,
    'name' => 0,
    'sbloccato' => 0,
    'content' => 0,
    'autenticato' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50127392ea25b1_78331766')) {function content_50127392ea25b1_78331766($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
<?php  $_smarty_tpl->tpl_vars['s'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['s']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['scripts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['s']->key => $_smarty_tpl->tpl_vars['s']->value){
$_smarty_tpl->tpl_vars['s']->_loop = true;
?>
        <script type="text/javascript" src='../js/<?php echo $_smarty_tpl->tpl_vars['s']->value;?>
'></script>
<?php } ?>

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
                    <?php if ($_smarty_tpl->tpl_vars['name']->value!=null){?>
                    <h2>Ciao <?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</h2>
                    <?php }?>
                    <div>
                        <h3><a href="CHome.php?action=logout">Logout</a></h3>
                    </div>
                    <div id="crea">
                        <h3>
                            <?php if ($_smarty_tpl->tpl_vars['sbloccato']->value){?>
                            <a href="CCrea.php?action=">
                            <?php }else{ ?>
                                <a href="CHome.php?action=">
                                    <script>
                                        showMessage("Limite eventi superato. Diventa SUPERUSER!");
                                    </script>
                             <?php }?>
                                    Crea Evento
                                </a>
                        </h3>
                    </div>
                </div>



                <div class="box" id="boxPersonali">
                    <h3>Tuoi Eventi</h3>
                    <ul class="bottom" id='ulPersonali'></ul>
                </div>
                <div class="box" id="boxPreferiti">
                    <h3>Eventi Preferiti</h3>
                    <ul class="bottom" id='ulPreferiti'>
                    </ul>
                </div>
                <div class="box" id="boxConsigliati">
                    <h3>Eventi Consigliati</h3>
                    <ul class="bottom" id='ulConsigliati'>
                    </ul>
                </div>
            </div>

            <div  class="colTwo">
        <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['content']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

            </div>

            <script>
        $("#logo2").hide();
        $("#logo3").hide();
            </script>

            <?php if ($_smarty_tpl->tpl_vars['autenticato']->value){?>
            <script>
                 $("#logo").hide("slow");
                 $("#logo3").show("slow");
            </script>
            <?php }?>

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
<?php }} ?>