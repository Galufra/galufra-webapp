<?php

class Fevento extends Fmysql {

    public function __construct() {
        parent::__construct();
        $this->_table = 'evento';
        $this->_key = 'id';
        $this->_return_class = 'Eevento';
    }

}

?>
