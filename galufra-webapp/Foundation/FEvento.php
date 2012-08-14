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

    public function searchEventiMappa($neLat, $neLon, $swLat, $swLon) {
        return $this->search(array(
            array('lat', 'BETWEEN', "$swLat' AND '$neLat"),
            array('lon', 'BETWEEN', "$swLon' AND '$neLon"),
            array('data', '>=', date('Y-m-d'))
        ));
    }

    public function getEventiPreferiti($idUtente) {
        $this->makeQuery("
                SELECT * FROM evento as e
                WHERE e.data >= NOW()
                AND e.id_evento IN (
                    SELECT evento FROM preferisce as p, evento as e1
                    WHERE p.utente =  $idUtente
                    AND p.evento = e1.id_evento )
                ORDER BY data"
        );
        return $this->getObjectArray();
    }

    public function storePreferiti($idUtente, $idEvento) {
        $this->makeQuery("
            INSERT INTO preferisce
            VALUES ($idUtente, $idEvento)");
    }

    public function removePreferiti($idUtente, $idEvento) {
        $this->makeQuery("
            DELETE FROM preferisce
            WHERE utente = '$idUtente'
            AND evento = '$idEvento'");
    }

    //(non utilizzato) scrive sulla tabella gestisce chi ha creato un particolare evento
    public function storeGestione($idUtente, $idEvento) {

        $this->makeQuery("INSERT INTO gestisce VALUES ($idUtente, $idEvento)");
    }

    //Pone/rimuove un evento come Consigliato
    public function storeConsigliati($idUtente, $idEvento, $lat, $lon) {
        //La prima query potrà essere utile per una ricerca più fine

        $this->makeQuery("INSERT INTO consiglia VALUES ($idUtente, $idEvento,$lat,$lon)");
        //$this->makeQuery("UPDATE $this->_table SET consigliato = 1 WHERE id_evento = $idEvento");
    }

    public function removeConsigliati($idUtente, $idEvento) {
        $this->makeQuery("
            DELETE FROM consiglia
            WHERE utente = '$idUtente'
            AND evento = '$idEvento'");
    }

    //Fornisco gli eventi che hanno il campo consigliato settato a 1, in futuro si potrebbe
    //utilizzare la tabella "consiglia" per una ricerca più precisa
    public function getEventiConsigliati($idUtente, $neLat, $neLon, $swLat, $swLon) {

        $this->makeQuery("SELECT * FROM evento WHERE data >= NOW() AND id_evento IN (
                SELECT evento FROM consiglia as c
                WHERE c.lat BETWEEN $swLat AND $neLat AND
                c.lon BETWEEN $swLon AND $neLon AND
                c.utente != $idUtente
                GROUP BY evento ORDER BY COUNT(*) DESC) LIMIT 3"
        );
        return $this->getObjectArray();
    }

    //Mi fornisce tutti gli eventi consigliati
    public function getAllConsigliati($idUtente, $dellUtente) {
        $query = (
                "SELECT * FROM evento
                WHERE data >= NOW()
                AND id_evento IN (
                    SELECT evento FROM consiglia as c
                    WHERE c.utente " . (($dellUtente) ? "=" : "!=") . " $idUtente
                    GROUP BY evento ORDER BY COUNT(*) DESC) " . (($dellUtente) ? "" : "LIMIT 15") . ""
                );
        $this->makeQuery($query);
        return $this->getObjectArray();
    }

    //conta il numero degli eventi
    public function userEventCounter($id) {
        $result = $this->makeQuery("SELECT COUNT(*) FROM $this->_table WHERE id_gestore = $id");
        if ($result[0]) {
            $result = $this->getResult();
            return $result[1];
        }
        else
            return false;
    }

    //blocca un utente che ha superato il limite degli eventi da creare
    public function bloccaUtente($id) {
        $result = $this->makeQuery("UPDATE utente SET sbloccato = 0 WHERE id_utente = $id");
        return $result[0];
    }

    //fornisce un array di eventi creati dall' utente con quel particolare "id"
    public function getUserEventi($id) {

        $result = $this->makeQuery("SELECT * FROM $this->_table WHERE id_gestore = $id");
        if ($result[0]) {
            $eventi = $this->getObjectArray();
            return $eventi;
        }
        return false;
    }

    public function guestCounter($id) {
        $number = 0;
        $result = $this->makeQuery("SELECT COUNT(*) FROM preferisce WHERE evento = $id");
        if ($result[0]) {
            $res = $this->getResult();
            return $res[1]["COUNT(*)"];
        }else
            return $nummber;
    }

}

?>
