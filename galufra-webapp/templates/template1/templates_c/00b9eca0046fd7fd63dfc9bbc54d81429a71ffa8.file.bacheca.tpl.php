<?php /* Smarty version Smarty-3.1.10, created on 2012-08-23 11:20:21
         compiled from "../templates/template1/template/bacheca.tpl" */ ?>
<?php /*%%SmartyHeaderCode:143893498150351b4c44a934-76211985%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '00b9eca0046fd7fd63dfc9bbc54d81429a71ffa8' => 
    array (
      0 => '../templates/template1/template/bacheca.tpl',
      1 => 1345713531,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '143893498150351b4c44a934-76211985',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.10',
  'unifunc' => 'content_50351b4c489ff5_46748695',
  'variables' => 
  array (
    'evento' => 0,
    'utente' => 0,
    'data' => 0,
    'partecipanti' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50351b4c489ff5_46748695')) {function content_50351b4c489ff5_46748695($_smarty_tpl) {?><script type='text/javascript'>
lat = <?php echo $_smarty_tpl->tpl_vars['evento']->value->getLat();?>
;
lon = <?php echo $_smarty_tpl->tpl_vars['evento']->value->getLon();?>
;
</script>

<div id = 'bacheca' >

    <div>
        <?php if ($_smarty_tpl->tpl_vars['utente']->value->isAdmin()){?>
        <h4><a href="#" id='eliminaEvento'>(Elimina Evento)</a></h4>
        <?php }?>
        <h1 align=center><?php echo $_smarty_tpl->tpl_vars['evento']->value->getNome();?>
</h1>
    </div>
    <h3>Data: <?php echo $_smarty_tpl->tpl_vars['data']->value;?>
</h3>

    <h4>Partecipanti: <?php echo $_smarty_tpl->tpl_vars['partecipanti']->value;?>
</h4>

    <p id='descrizione'><?php echo $_smarty_tpl->tpl_vars['evento']->value->getDescrizione();?>
</p>


    <div id='map_canvas' style='height: 300px'></div>

    <div id='annuncioGestore'>


    </div>

    <?php if ($_smarty_tpl->tpl_vars['utente']->value->getId()==$_smarty_tpl->tpl_vars['evento']->value->getGestore()||$_smarty_tpl->tpl_vars['utente']->value->isAdmin()){?>
    <div id='creaAnnuncio' >
        <table>
            <tr>
                <td><label>Annuncio:</label></td>
                <td><textarea id='annuncio' rows=4></textarea></td>
            </tr>
            <tr>
                <td><button id='inserisciAnnuncio' class = "button">Annuncia!</button></td>
            </tr>
        </table>
    </div>
    <?php }?>

    <div id='messaggiBacheca'>
        <br><h2>Bacheca Messaggi:</h2>
    </div>

    <div id='creaMessaggio' >
        <table>
            <tr>
                <td><label>Messaggio:</label></td>
                <td><textarea id='messaggio' rows=4></textarea></td>
            </tr>
            <tr>
                <td><button id='inserisciMessaggio' class = "button">Scrivi!</button></td>
            </tr>
        </table>
    </div>



</div>
<div id='map_canvas' style='height: 300px'></div>
<?php }} ?>