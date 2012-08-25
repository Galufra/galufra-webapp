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
            VALUES ('" . $u->getUsername() . "','" . $u->getPassword() . "','" . $u->getEmail() . "','" . $u->getCitta() . "','" . time() . "','" . $uid . "', ". $u->isConfirmed().")";
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
        $this->connect();
        $query = "UPDATE $this->_table SET confirmed = 1 WHERE confirm_id = '" . $uid . "'";

        $result = $this->makeQuery($query);
        if ($result[0])
            return array(true, "Utente confermato");
        else
            return array(false, "Utente non confermato");
    }

}

?>
