<?php

require_once('FMysql.php');
require_once '../Entity/EMessaggio.php';

class FMessaggio extends FMysql {

    /**
     * @access public
     */
    public function __construct() {
        parent::__construct();
        $this->_table = 'messaggio';
        $this->_key = 'id_mess';
        $this->_class = 'EMessaggio';
    }

    /**
     * @access public
     *
     * Carica tutti i messaggi. Non uso la load per accelerare i tempi
     *
     * @param int $idEvento
     * @return array
     *
     * 
     */
    public function loadMessages($idEvento) {
        $query = "SELECT * FROM $this->_table
                  WHERE evento = $idEvento ORDER BY data";
        $r = $this->makeQuery($query);
        if ($r[0])
            return $this->getObjectArray();
        else
            return array(false, "loadMessages()");
    }

     /**
     * @access public
      *
      * Salva un messaggio. Non uso la store per accelerare i tempi
      *
     * @param EMessaggio $messaggio
     * @return array
     *
     * 
     */
    public function storeMessaggio($messaggio) {
        $m = new EMessaggio();
        $m = $messaggio;
        $query =
                "INSERT INTO " . $this->_table . " (testo,data,evento,utente)
            VALUES ('" . $m->getTesto() . "','" . $m->getData() . "','" . $m->getEvento() . "','" . $m->getUtente() . "')";
        $this->connect();
        $result = $this->makeQuery($query);
        return $result;
    }

}

?>
