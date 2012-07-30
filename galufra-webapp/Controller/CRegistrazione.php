<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class CRegistrazione {

    private $username = null;
    private $password = null;
    private $citta = null;
    private $mail = null;
    private $autenticato = false;
    private $errore = null;

    public function __construct($uname, $pwd, $citta=null, $mail=null) {

        $this->username = $uname;
        $this->password = md5($pwd);
        $this->citta = $citta;
        $this->mail = $mail;
    }

    public function logIn() {

        $u = new FUtente();
        $u->connect();
        $utente = $u->load($this->username);
        if ($utente != FALSE) {

            if ($utente->getPassword() == $this->password) {

                $this->autenticato = TRUE;
                $this->initSession();
                $u->close();
                return true;
            } else {
                $this->errore = "Password non valida";
                $u->close();
                return false;
            }
        }

        $this->errore = "Username non valido";
        return false;
    }

    public function initSession() {

        $session = new USession();
        $session->imposta_valore('username', $this->username);
        $this->errore = "Login riuscito";
    }

    public function isLogged() {
        return $this->autenticato;
    }

    public function regUtente() {

        $db = new FUtente();
        $db->connect();
        $uid = $this->getUniqueId();
        $newUtente = new EUtente();
        $newUtente->setUsername($this->username);
        $newUtente->setPassword($this->password);
        $newUtente->setCitta($this->citta);
        $newUtente->setNome("fabio");
        $newUtente->setCognome("fabio");
        if ($newUtente->setEmail($this->mail)) {
            $result = $db->store($newUtente);
            if ($result[0])
                $result = $db->makeQuery("UPDATE utente SET confirm_id = '" . $uid . "' WHERE username = '".$newUtente->getUsername()."'");
        }
        if ($result[0]) {
            if ($this->sendConfirmationMail($this->mail, "fra.miscia@gmail.com", $uid)) {
                $this->errore = "Registrazione avvenuta con successo";
                $this->autenticato = true;
                $this->initSession();
                return array(true,$newUtente);
            }
            else {
                $this->errore = "Registrazione fallita";
                return array(false,null);
            }
        }
    }

    public function getUniqueId() {

        list($usec, $sec) = explode(' ', microtime());
        mt_srand((float) $sec + ((float) $usec * 100000));
        return md5(uniqid(mt_rand(), true));
    }

    public function sendConfirmationMail($to, $from, $id) {

        $msg = "Hello! To confirm your galufra registration click here:
	http://localhost/galufra/galufra-webapp/Controller/CHome.php?action=confirm&id=" . $id . "";
        //$status = mail($to, "Conferma la registrazione", $msg, "From: " . $from) ? true : false;

        return true;
    }

}

?>
