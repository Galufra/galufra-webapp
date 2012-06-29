<?php
require_once('FMysql.php');

class Flocale extends FMysql {

    public function __construct() {
        parent::__construct();
        $this->_table = 'locale';
        $this->_key = 'id_locale';
        $this->_return_class = 'Elocale';
    }

}

?>
