<?php /* Smarty version Smarty-3.1.10, created on 2012-08-08 21:15:26
         compiled from "../templates/template1/template/bacheca.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1427448665020ebd368acc9-39753850%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '00b9eca0046fd7fd63dfc9bbc54d81429a71ffa8' => 
    array (
      0 => '../templates/template1/template/bacheca.tpl',
      1 => 1344453275,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1427448665020ebd368acc9-39753850',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.10',
  'unifunc' => 'content_5020ebd36e3778_64057303',
  'variables' => 
  array (
    'evento' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5020ebd36e3778_64057303')) {function content_5020ebd36e3778_64057303($_smarty_tpl) {?>
<div id = 'bacheca' >

    <h1 align=center><?php echo $_smarty_tpl->tpl_vars['evento']->value->getNome();?>
</h1>
    <h3><?php echo $_smarty_tpl->tpl_vars['evento']->value->getData();?>
</h3>

    <h2><?php echo $_smarty_tpl->tpl_vars['evento']->value->getDescrizione();?>
</h2>

    <div id='messaggiBacheca'>

    </div>

    <div id='creaMessaggio' >
        <table>
            <tr>
                <td><label>Descrizione:</label></td>
                <td><textarea id='messaggio' rows=4></textarea></td>
            </tr>
            <tr>
                <td><button id='inserisciMessaggio' class = "button">Scrivilo!</button></td>
            </tr>
        </table>
    </div>



</div>
<div id='map_canvas' style='height: 300px'></div>
<?php }} ?>