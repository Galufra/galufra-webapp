<?php /* Smarty version Smarty-3.1.10, created on 2012-08-02 18:26:03
         compiled from "../templates/template1/template/crea.tpl" */ ?>
<?php /*%%SmartyHeaderCode:997560866501a4aa0651dd1-87780936%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '222659ed5dae255d0a3e62f71542fb50f0a32e17' => 
    array (
      0 => '../templates/template1/template/crea.tpl',
      1 => 1343924682,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '997560866501a4aa0651dd1-87780936',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.10',
  'unifunc' => 'content_501a4aa068bca2_93812619',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_501a4aa068bca2_93812619')) {function content_501a4aa068bca2_93812619($_smarty_tpl) {?><form id='creaEvento' >
            <table>
            <tr>
                <td><label>Nome:</label></td>
                <td><input type='text' id='nome' name='nome' /></td>
            </tr>
            <tr>
                 <td><label>Data:</label></td>
                 <td><input type='text' id='data' name='data' /></td>
            </tr>
            <tr>
                 <td><label>Ora:</label></td>
                 <td><input type='text' id='ora' name='ora' /></td>
            </tr>
            <tr>
                 <td><label>Indirizzo:</label></td>
                 <td><input type='text' id='indirizzo' name='indirizzo' /></td>
            </tr>
            <tr>
                <td><label>Descrizione:</label></td>
                <td><textarea id='descrizione' rows=4
                name='descrizione'></textarea></td>
            </tr>
            <tr>
                <td><button id='submit' class = "button">Invia</button></td>
            </tr>
        </table>
        </form>
<div id='map_canvas' style='height: 300px'></div>
<?php }} ?>