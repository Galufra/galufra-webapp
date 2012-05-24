<?php

class FUtente extends Fmysql {

    public function __construct() {
        parent::__construct();
        $this->_table = 'utente';
        $this->_key = 'username';
        $this->_class = 'EUtente';
    }

}

?>
