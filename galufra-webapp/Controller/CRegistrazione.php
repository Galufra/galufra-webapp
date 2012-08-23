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
    private $nome = null;
    private $cognome = null;
    private $autenticato = false;
    private $errore = null;

     /**
     * @access public
     * @param  uname 
     * @param  pwd 
     * @param  mail 
     * @param nome 
     * @param  cognome 
     * @param  uid 
     * */
    public function __construct($uname, $pwd, $citta=null, $mail=null, $nome=null, $cognome=null, $uid=null) {

        $this->username = $uname;
        $this->password = $pwd;
        $this->citta = $citta;
        $this->mail = $mail;
        $this->nome = $nome;
        $this->cognome = $cognome;
    }

    /**
     * @access public
     * @return Boolean
     *
     * esegue il login e inizia una sessione utente
     */
    public function logIn() {

        $u = new FUtente();
        $u->connect();
        $utente = $u->load($this->username);

        if ($utente != FALSE) {

            if ($utente->getPassword() == md5($this->password)) {

                $this->autenticato = TRUE;
                $this->initSession();
                //$u->close();
                return true;
            } else {
                $this->errore = "Password non valida";
                //$u->close();
                return false;
            }
        }

        $this->errore = "Username non valido";
        return false;
    }

    /**
     * @access public
     *
     * Fa partire la sessione utilizzando la classe USession
     */
    public function initSession() {

        $session = new USession();
        $session->imposta_valore('username', $this->username);
        $this->errore = "Login riuscito";
    }
    /**
     * @access public
     * @return Boolean
     * 
     * 
     */

    public function isLogged() {
        return $this->autenticato;
    }

    /**
     * @access public
     * @return array(2){Boolean,String}
     */
    public function regUtente() {

        $result=array(false,"errore");
        $db = new FUtente();
        $db->connect();
        $uid = $this->getUniqueId();
        $newUtente = new EUtente();
        $newUtente->setUsername($this->username);
        $newUtente->setPassword($this->password);
        $newUtente->setCitta($this->citta);
        if ($newUtente->setEmail($this->mail))
            $result = $db->storeUtente($newUtente, $uid);
        if ($result[0]) {
            if ($this->sendConfirmationMail($this->mail, "galufra@galufra.com", $uid)) {
                $this->errore = "Registrazione avvenuta con successo";
                $this->autenticato = true;
                $this->initSession();
                return array(true, $newUtente);
            } else {
                $this->errore = "Registrazione fallita";
                return array(false, null);
            }
        }else return array(false,"errore");
    }

    /**
     * @access public
     * @return String
     *
     * Fornisce un id univoco utilizzando l' orario. Prende i secondi
     * e i microsecondi e li usa come chiave per generare un numero random
     * di cui viene fatto l'md5
     */
    public static function getUniqueId() {

        list($usec, $sec) = explode(' ', microtime());
        mt_srand((float) $sec + ((float) $usec * 100000));
        return md5(uniqid(mt_rand(), true));
    }

    /**
     * @access public
     * @param string $to
     * @param string $from
     * @param int $id
     * @return boolean
     *
     * invia l' email di conferma
     */
    public function sendConfirmationMail($to, $from, $id) {

        $msg = "Ciao! Per confermare la tua registrazione clicca qui:
	http://localhost/galufra-webapp/Controller/CConferma.php?action=conferma&id=" . $id . "";
        //$status = mail($to, "Conferma la registrazione", $msg, "From: " . $from) ? true : false;
        $status=true;
        return $status;
    }

    /**
     * @access public
     * @return array(2){boolean,EUtente}
     *
     * Esegue l'update di un utente
     */
    public function updateProfilo() {
        $db = new FUtente();
        $db->connect();
        $newUtente = new EUtente();
        //$newUtente->setUsername($this->username);
        $newUtente->setPassword($this->password);
        $newUtente->setCitta($this->citta);
        $newUtente->setNome($this->nome);
        $newUtente->setCognome($this->cognome);
        if ($newUtente->setEmail($this->mail))
            $result = $db->update ($newUtente);
        if ($result[0]) {
            return array(true,$newUtente);
        }else{
            return array(false,null);
        }
    }

}

?>
