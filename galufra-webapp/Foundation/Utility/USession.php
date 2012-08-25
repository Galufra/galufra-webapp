<?php
/**
 * @package Galufra
 */

/**
 * Classe che gestisce le sessioni. Viene utilizzata solo nel login e nella
 * registrazione, negli altri casi vengono utilizzate le funzioni fornite di
 * base dal php
 */
class USession {
    public function __construct() {
        session_start();
       
    }
    function imposta_valore($chiave,$valore) {
        $_SESSION[$chiave]=$valore;
    }
    function cancella_valore($chiave) {
        unset($_SESSION[$chiave]);
    }
    function leggi_valore($chiave) {
        if (isset($_SESSION[$chiave]))
            return $_SESSION[$chiave];
        else
            return false;
    }
}

?>
