<?php
require_once('FMysql.php');

class FEvento extends FMysql {

    public function __construct() {
        parent::__construct();
        $this->_table = 'evento';
        $this->_key = 'id_evento';
        $this->_class = 'EEvento';
    }
    
    public function searchEventi($neLat, $neLon, $swLat, $swLon){
		return $this->search(array(
			array('lat', 'BETWEEN', "$swLat' AND '$neLat"),
			array('lon', 'BETWEEN', "$swLon' AND '$neLon"),
			array('data', '>=', date('Y-m-d'))
			));
		
	}

}

?>
