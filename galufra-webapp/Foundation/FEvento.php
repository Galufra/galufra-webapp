<?php
require_once('FMysql.php');

class FEvento extends FMysql {

    public function __construct() {
        parent::__construct();
        $this->_table = 'evento';
        $this->_key = 'id_evento';
        $this->_class = 'EEvento';
    }
    /* 
     * Restituisce un array di eventi futuri (data >= oggi)
     * con coordinate comprese nel rettangolo ne-sw.
     */
    public function searchEventiMappa($neLat, $neLon, $swLat, $swLon){
		return $this->search(array(
			array('lat', 'BETWEEN', "$swLat' AND '$neLat"),
			array('lon', 'BETWEEN', "$swLon' AND '$neLon"),
			array('data', '>=', date('Y-m-d'))
			));
		
	}
    public function getEventiPreferiti($idUtente){
            $this->makeQuery("
                SELECT * FROM evento as e
                WHERE e.data >= NOW()
                AND e.id_evento IN (
                    SELECT evento FROM preferisce as p, evento as e1
                    WHERE p.utente =  $idUtente
                    AND p.evento = e1.id_evento )"
            );
            return $this->getObjectArray();
        }

    public function storePreferiti($idUtente, $idEvento){
        $this->makeQuery("
            INSERT INTO preferisce
            VALUES ($idUtente, $idEvento)");
    }
    public function removePreferiti($idUtente, $idEvento){
        $this->makeQuery("
            DELETE FROM preferisce
            WHERE utente = '$idUtente'
            AND evento = '$idEvento'");
    }
}

?>
