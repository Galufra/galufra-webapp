<?php
require_once('FMysql.php');

class FEvento extends FMysql {

    public function __construct() {
        parent::__construct();
        $this->_table = 'evento';
        $this->_key = 'id_evento';
        $this->_class = 'EEvento';
    }
    
    public function searchEventi(){
		return $this->search(array(
			array('lat', '>', 0),
			array('lon', '>', 0) 
			));
		
	}

}

?>
