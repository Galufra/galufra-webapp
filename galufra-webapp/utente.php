<?php
require_once 'login/controller/mysqlController.php';

class utente {
	private $id;
	
	function __construct($i){
		$this->id = $i;
	}
	
	/* Query($attr)
	 * cerca il valore del campo $attr
	 * nel record con id_utente pari a quello
	 * dell'oggetto ($this->id). Per farlo crea
	 * un oggetto mysqlController.
	 * Una query fallita restituisce false.
	 */
	private function Query($attr){
		$db = new mysqlController();
		$db->connect();
		$attr = mysql_real_escape_string($attr);
		$query = "SELECT ". $attr ." FROM utente
				  WHERE utente.id_utente =". $this->id.";";
		$result = $db->makeQuery($query);
		$db->close();
		/* Query riuscita: restituzione
		 * del valore di $attr
		 */
		if($result[0]){
			$record = mysql_fetch_array($result[1]);
			return $record[$attr];
		}
		/* Query fallita: restituisce false
		 */
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
