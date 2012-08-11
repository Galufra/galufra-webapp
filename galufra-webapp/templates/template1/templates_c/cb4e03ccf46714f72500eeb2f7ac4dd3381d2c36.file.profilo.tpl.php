<?php /* Smarty version Smarty-3.1.10, created on 2012-08-11 09:24:28
         compiled from "../templates/template1/template/profilo.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10810680105024dad4f22ba7-58075765%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cb4e03ccf46714f72500eeb2f7ac4dd3381d2c36' => 
    array (
      0 => '../templates/template1/template/profilo.tpl',
      1 => 1344669854,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10810680105024dad4f22ba7-58075765',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.10',
  'unifunc' => 'content_5024dad5043415_59513653',
  'variables' => 
  array (
    'reader' => 0,
    'utente' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5024dad5043415_59513653')) {function content_5024dad5043415_59513653($_smarty_tpl) {?><div id="profilo">
    <h2>Profilo</h2>

    <img src="" alt="" width="109" height="109" class="image" />
    <div class="indent">


<?php if (!$_smarty_tpl->tpl_vars['reader']->value){?>
        <div id='modificaProfilo'  >
            <table>

                <tr><h1><?php echo $_smarty_tpl->tpl_vars['utente']->value->getUsername();?>
: i tuoi dati</h1></tr>


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
                    <td><input type="text" name="nome" id='nome' class="input3" value=<?php echo $_smarty_tpl->tpl_vars['utente']->value->getNome();?>
 /></td>
                </tr>
                <tr>
                    <td><label class="label1">cognome:</label></td>
                    <td><input type="text" name="cognome" id='cognome' class="input3" value=<?php echo $_smarty_tpl->tpl_vars['utente']->value->getCognome();?>
 /></td>
                </tr>

                <tr>
                    <td><label class="label1">città:</label></td>
                    <td><input type="text" name="citta" id='citta' class="input3 " value=<?php echo $_smarty_tpl->tpl_vars['utente']->value->getCitta();?>
 /></td>
                </tr>
                <tr>
                    <td><label class="label1">e-mail:</label></td>
                    <td><input type="text" name="email" id='email' class="input3 " value=<?php echo $_smarty_tpl->tpl_vars['utente']->value->getEmail();?>
 /></td>
                </tr>
                <tr>

                    <td colspan="2"><button id="updateButton" class="button">Salva</button></td>
                </tr>
            </table>
        </div>
        <?php }else{ ?>
        <table>

            <tr><h1>Profilo Utente</h1></tr>


            <tr>
                <td><label class="box">Username: <?php echo $_smarty_tpl->tpl_vars['utente']->value->getUsername();?>
</label></td>
            </tr>
            <tr>
                <td><label class="box">Nome: <?php echo $_smarty_tpl->tpl_vars['utente']->value->getNome();?>
</label></td>
            </tr>
            <tr>
                <td><label class="box">Cognome: <?php echo $_smarty_tpl->tpl_vars['utente']->value->getCognome();?>
</label></td>
            </tr>
            <tr>
                <td><label class="box">Città: <?php echo $_smarty_tpl->tpl_vars['utente']->value->getCitta();?>
</label></td>
            </tr>
            <tr>
                <td><label class="box">E-Mail: <?php echo $_smarty_tpl->tpl_vars['utente']->value->getEmail();?>
</label></td>
            </tr>
        </table>
        <?php }?>
    </div>
</div><?php }} ?>