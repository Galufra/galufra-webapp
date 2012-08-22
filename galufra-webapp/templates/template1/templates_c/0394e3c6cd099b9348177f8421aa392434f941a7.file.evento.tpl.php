<?php /* Smarty version Smarty-3.1.10, created on 2012-08-22 17:10:00
         compiled from "../templates/template1/template/evento.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1916286972501a4f30a78117-37999457%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0394e3c6cd099b9348177f8421aa392434f941a7' => 
    array (
      0 => '../templates/template1/template/evento.tpl',
      1 => 1345562741,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1916286972501a4f30a78117-37999457',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.10',
  'unifunc' => 'content_501a4f30ab7d13_97860150',
  'variables' => 
  array (
    'evento' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_501a4f30ab7d13_97860150')) {function content_501a4f30ab7d13_97860150($_smarty_tpl) {?><script type='text/javascript'>
id_evento = <?php echo $_smarty_tpl->tpl_vars['evento']->value->id_evento;?>

lat= <?php echo $_smarty_tpl->tpl_vars['evento']->value->lat;?>

lon= <?php echo $_smarty_tpl->tpl_vars['evento']->value->lon;?>

</script>

<h1 id='nome'><?php echo $_smarty_tpl->tpl_vars['evento']->value->nome;?>
</h1>
<h2 id='data'></h2>

<div id='descrizione'>
<p><?php echo $_smarty_tpl->tpl_vars['evento']->value->descrizione;?>
</p>
</div>

<div id='map_canvas' style='height: 300px'></div>
<?php }} ?>