<?php /* Smarty version Smarty-3.1.10, created on 2012-06-29 18:59:23
         compiled from "../templates/template1/template/home.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2905953674feddeeb8dfbb2-66939864%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2d256592c9b7f12c67f1e6607af61a7f2ab676a5' => 
    array (
      0 => '../templates/template1/template/home.tpl',
      1 => 1340988472,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2905953674feddeeb8dfbb2-66939864',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.10',
  'unifunc' => 'content_4feddeeb90b354_64636808',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4feddeeb90b354_64636808')) {function content_4feddeeb90b354_64636808($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAO2zXC0wh-S8SjMgPRZfoTUGZMGHBIzZ0&sensor=false"></script>
    <script type="text/javascript" src='../js/CHome.js'></script>
</head>
<body>
<div id="header">
	<ul id="menu">
		<li><a href="login.html" accesskey="1" title="">Home</a></li>
		<li><a href="profilo.html" accesskey="2" title="">Profilo</a></li>
		<li><a href="#" accesskey="3" title="">Crea Evento</a></li>
		
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
				
			   <form action="checkLoginInput.php" method="post" >
				
				<table cellpadding="1">
				
				<tr><h1>login</h1></tr>
				
				<tr>
                <td>    <label class="label">username:</label> </td>
                <td class="right">    <input type="text" name="username" class="input4" size="20"/></td>
				</tr>	
				
				<tr>
				<td>	<label class="label">password:</label> </td>
                <td>    <input type="text" name="password"class="input4" size="20" /> </td>
				</tr>	
				  
				<tr>	
				<td>	<a id="areg" href="">Registrati!</a></td>
                <td>    <button id="loginbutton" class="button">Login</button> </td>
			    </tr>
				<tr>
				
				</tr>
				
				</table>		
				</form>
	            
		</div>
		<div id="logo2">	
				
				<form action="checkLoginInput.php" method="post" >
				<table>
				
				<tr><h1>Registrazione</h1></tr>
			
				<tr>
				<td><label class="label">username:</label></td>
				<td><input type="text" name="username" class="input4 " size="20"/></td>
				</tr>
				<tr>
				<td><label class="label">password:</label></td>
				<td><input type="text" name="password" class="input4 " size="20" /></td>
				</tr>
				<tr>
				<td><label class="label">nome:</label></td>
				<td><input type="text" name="nome" class="input4 " size="20" /></td>
				</tr>
				<tr>
				<td><label class="label">cognome:</label></td>
				<td><input type="text" name="cognome" class="input4 " size="20" /></td>
				</tr>
				<tr>
				<td><label class="label">sesso:</label></td>
				<td><select name="sesso" class="">
					<option value="0" ></option>
                    <option value="M" > M</option>
                    <option value="F" > F </option>
					</select></td>
				</tr>
				<tr>
				<td><label class="label">città:</label></td>
				<td><input type="text" name="citta" class="input4 " size="20" /></td>
				</tr>
				<tr>
				<td><label class="label">e-mail:</label></td>
				<td><input type="text" name="citta" class="input4 " size="20" /></td>
				</tr>
				<tr>
				
				<td colspan="2"><button id="regbutton" class="button">Submit</button></td>
			    </tr>
				</table>
	</form>	
 
	</div>
		
		
		
		<div class="box">
			<h3>Prossimi Eventi</h3>
			<ul class="bottom">
			</ul>
		</div>
		<div class="box">
			<h3>Eventi Preferiti</h3>
			<ul class="bottom">
			</ul>
		</div>
		<div class="box">
			<h3>Eventi Consigliati</h3>
			<ul class="bottom">

			</ul>
		</div>
	</div>
	
	<!-- questo è il div che dovra contenere la mappa -->
	<div  class="colTwo">
        <div id="map_canvas" style='height: 600px'></div>
	</div>
	
	<script>
    $("#logo2").hide();
	</script>
	
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