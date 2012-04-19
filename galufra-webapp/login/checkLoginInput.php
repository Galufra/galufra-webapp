<?php

/*
 * 
 * 
 */
require_once ("controller/authController.php");

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
        if (!is_null($user)) {

            list($status, $uid) = $auth->registerSession($user);
        }
    }
}

switch ($status) {
    case AUTH_LOGGED:
        echo '<div align="center">Sei gia connesso ... </div>';
        break;
    case AUTH_INVALID_PARAMS:
        echo '<div align="center">Hai inserito dati non corretti ... </div>';
        break;
    case AUTH_LOGEDD_IN:
        switch ($auth->getOption("TRANSICTION METHOD")) {
            case AUTH_USE_LINK:

                break;
            case AUTH_USE_COOKIE:
                setcookie('uid', $uid, time() + 3600 * 365);
                break;
            case AUTH_USE_SESSION:

                break;
        }
        echo '<div align="center">Ciao ' . $user['nome'] . ' ...</div>';
        break;
    case AUTH_FAILED:
        echo '<div align="center">Fallimento durante il tentativo di connessione</div>';
        break;
}
?>
