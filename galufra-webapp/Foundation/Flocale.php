<?php

class Flocale extends Fmysql {

    public function __construct() {
        parent::__construct();
        $this->_table = 'locale';
        $this->_key = 'id';
        $this->_return_class = 'Elocale';
    }

}

?>
