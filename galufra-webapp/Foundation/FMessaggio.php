<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class FMessaggio extends Fmysql {

    public function __construct() {
        parent::__construct();
        $this->_table = 'messaggio';
        $this->_key = 'id_mess';
        $this->_return_class = 'EMessaggio';
    }

    public function loadMessages($idEvento) {
        $query = 'SELECT * ' .
                'FROM `' . $this->_table . '` ' .
                'WHERE evento = `'.$idEvento.'` ORDER BY data';
        $r = $this->makeQuery($query);
        if($r[0])
            return $this->getArrayObject();
        else
            return array(false,"loadMessages()");
    }

}

?>
