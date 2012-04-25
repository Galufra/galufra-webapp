<?php

/*
 * 
 * 
 */
require_once ("controller/authController.php");
require_once ("controller/permissionController.php");

$auth = new Authorization();
list($status, $user) = $auth->getStatus();

if ($status == AUTH_NOT_LOGGED) {
    $uname = trim($_POST['username']);
    $pwd = trim($_POST['password']);
    if (get_magic_quotes_gpc ()) {

        $uname = stripslashes($uname);
        $pwd = stripslashes($pwd);
    }

    $uname = mysql_real_escape_string($uname);
    $pwd = mysql_real_escape_string($pwd);

    if ($uname == "" or $pwd == "") {

        $status = AUTH_INVALID_PARAMS;

    } else {

        list($status, $user) = $auth->Login($uname, $pwd);
        
    }
}

$perm = new permissionController();
$permission = $perm->getUserPermission($_SESSION['user_id']);

switch ($status) {
    case AUTH_LOGGED:
        echo '<div align="center">'.$user['nome'].' sei gia connesso ... </div>';
        echo '<div align="center">Sei un '.$permission['descrizione'].'</div>';
        break;
    case AUTH_INVALID_PARAMS:
        echo '<div align="center">Hai inserito dati non corretti ... </div>';
        break;
    case AUTH_LOGEDD_IN:
        echo '<div align="center">Ciao ' . $user['nome'] . ' ...</div>';
        echo '<div align="center">Sei '.$permission['descrizione'].'</div>';
        break;
    case AUTH_FAILED:
        echo '<div align="center">Fallimento durante il tentativo di connessione</div>';
        break;
}
?>
