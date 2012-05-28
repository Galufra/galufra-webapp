<?php
require_once('FMysql.php');

class Fevento extends FMysql {

    public function __construct() {
        parent::__construct();
        $this->_table = 'evento';
        $this->_key = 'id_evento';
        $this->_return_class = 'EEvento';
    }

}

?>
