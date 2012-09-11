<?php

/**
 * @package Galufra
 */
require_once('FMysql.php');

/**
 * Foundation per la gestione di un utente sul db
 */
class FUtente extends FMysql {

    /**
     * @access public
     */
    public function __construct() {
        parent::__construct();
        $this->_table = 'utente';
        $this->_key = 'username';
        $this->_class = 'EUtente';
    }

    /**
     * @access public
     *
     * Esegue la registrazione sul db di un utente. Non uso la store per accelerare
     * i tempi.
     *
     * @param EUtente $user
     * @param int $uid
     * @return array
     *
     */
    public function storeUtente($user, $uid) {
        $u = new EUtente();
        $u = $user;
        $query =
                "INSERT INTO " . $this->_table . " (username,password,email,citta,date,confirm_id, confirmed)
            VALUES ('" . $u->getUsername() . "','" . $u->getPassword() . "','" . $u->getEmail() . "','" . $u->getCitta() . "','" . time() . "','" . $uid . "', " . $u->isConfirmed() . ")";
        $this->connect();
        $result = $this->makeQuery($query);
        return $result;
    }

    /**
     * @access public
     *
     * Eliminto gli utenti che non hanno confermato la registrazione entro 24h
     */
    public function cleanExpired() {

        $query = "DELETE FROM $this->_table WHERE  (date + 24*60*60) <= " . time() . " and confirmed = 0";
        $this->makeQuery($query);
    }

    /**
     * @access public
     *
     * Confermo sul db un utente
     *
     * @param int $uid
     * @return array
     *
     */
    public function userConfirmation($uid) {

        $query = "UPDATE $this->_table SET confirmed = 1 WHERE confirm_id = '" . $uid . "'";

        $result = $this->makeQuery($query);
        if ($result[0])
            return array(true, "Utente confermato");
        else
            return array(false, "Utente non confermato");
    }

    /**
     * Indica se un dato username è gia utilizzato oppure no.
     * @access public
     * @param String $user
     * @return Boolean
     */
    public function isUnique($user) {
        $query = "SELECT COUNT(*) FROM $this->_table WHERE username = '" . $user . "'";
        $result = $this->makeQuery($query);
        if ($result[0]) {
            $result = $this->getResult();
            if ($result[1]["COUNT(*)"] == 0)
                return true;
        }

        return false;
    }

    /**
     * Indica se una data email è gia utilizzata oppure no.
     * @access public
     * @param String $email
     * @return Boolean
     */
    public function isEmailUnique($email) {
        $query = "SELECT COUNT(*) FROM $this->_table WHERE email = '" . $email . "'";
        $result = $this->makeQuery($query);
        if ($result[0]) {
            $result = $this->getResult();
            if ($result[1]["COUNT(*)"] == 0)
                return true;
        }

        return false;
    }

    /**
     * Restituisce gli utenti il cui nome inizia con $nome. Utilizzato per
     * l'autocompletamento.
     * @access public
     * @param String $nome
     * @return array 
     */
    public function searchUtentiNome($nome) {
        $nome = mysql_real_escape_string($nome);
        $val = "$nome%";
        return $this->search(array(
            array('username', 'LIKE', $val)
        ));
    }
    /**
     * Fornisce i partecipanti ad un evento. Ritorna in caso di successo
     * un array di oggetti EUtente caricati solo con username e id_utente
     * 
     * @param int $id_evento
     * @return array
     */
    public function getPartecipanti($id_evento) {
        $query = "SELECT username,id_utente FROM $this->_table WHERE id_utente IN (
            SELECT utente FROM preferisce WHERE evento = $id_evento)";
        $return = $this->makeQuery($query);
        if ($return[0]) {
            $result = $this->getObjectArray();
            return $result;
        }
        else
            return false;
    }

}

?>
