<?php
require_once('FMysql.php');

class FUtente extends FMysql {

    public function __construct() {
        parent::__construct();
        $this->_table = 'utente';
        $this->_key = 'username';
        $this->_class = 'EUtente';
    }

}

?>
