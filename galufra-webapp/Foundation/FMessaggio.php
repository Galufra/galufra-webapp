<?php

require_once('FMysql.php');
require_once '../Entity/EMessaggio.php';

class FMessaggio extends FMysql {

    public function __construct() {
        parent::__construct();
        $this->_table = 'messaggio';
        $this->_key = 'id_mess';
        $this->_class = 'EMessaggio';
    }

    public function loadMessages($idEvento) {
        $query = "SELECT * FROM $this->_table
                  WHERE evento = $idEvento ORDER BY data";
        $r = $this->makeQuery($query);
        if ($r[0])
            return $this->getObjectArray();
        else
            return array(false, "loadMessages()");
    }

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
