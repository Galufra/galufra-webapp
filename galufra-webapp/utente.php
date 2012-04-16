<?php
require_once 'login/controller/dbController.php';

class utente {
	private $id;
	
	function __construct($i){
		$this->id = $i;
	}
	
	private function Query($attr){
		$query = "SELECT ". $attr ." FROM utente
				  WHERE utente.id_utente =". $this->id.";"
		if($result[0]){
			$record = mysql_fetch_array($result[1]);
			return $record[$attr];
		}
		else 
			return false;
	}
	
	function getCitta(){
		if ($result = $this->Query('citta'))
			return $result;
		else return false;
	}
	
	function getNome(){
		if ($result = $this->Query('nome'))
			return $result;
		else return false;
	}
}

?>
