<?php

require_once('FMysql.php');

class FEvento extends FMysql {

    /**
     * @access public
     */
    public function __construct() {
        parent::__construct();
        $this->_table = 'evento';
        $this->_key = 'id_evento';
        $this->_class = 'EEvento';
    }

    /**
     * @access public
     * @param int $neLat
     * @param int $neLon
     * @param int $swLat
     * @param int $swLon
     *
     * Restituisce un array di eventi futuri (data >= oggi)
     * con coordinate comprese nel rettangolo ne-sw.
     */
    public function searchEventiMappa($neLat, $neLon, $swLat, $swLon) {
        $prossimomese = new DateTime();
        $prossimomese->modify('+1 month');
        return $this->search(array(
            array('lat', 'BETWEEN', "$swLat' AND '$neLat"),
            array('lon', 'BETWEEN', "$swLon' AND '$neLon"),
            array('data', '>=', date("Y-m-d")),
            array('data', '<=', $prossimomese->format("Y-m-d"))
        ));
    }

    /**
     * @access public
     * @param int $idUtente
     * @return int
     *
     * ritorna il numero di eventi preferiti
     */
    public function getEventiPreferiti($idUtente) {
        $this->makeQuery("
                SELECT * FROM evento as e
                WHERE e.data >= NOW()
                AND e.id_evento IN (
                    SELECT evento FROM preferisce as p, evento as e1
                    WHERE p.utente =  $idUtente
                    AND p.evento = e1.id_evento )
                ORDER BY DATE_FORMAT(data, '%y-%m-%d %H:%i')"
        );
        return $this->getObjectArray();
    }

    /**
     * @access public
     * @param int $idUtente
     * @param int $idEvento
     *
     * salva un evento preferito da un utente
     */
    public function storePreferiti($idUtente, $idEvento) {
        $this->makeQuery("
            INSERT INTO preferisce
            VALUES ($idUtente, $idEvento)");
    }

    /**
     * @access public
     * @param int $idUtente
     * @param int $idEvento
     *
     * rimuove evento preferito da un utente
     */
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

    /**
     *
     * @access public
     * @param int $idUtente
     * @param int $idEvento
     * @param int $lat
     * @param $lon
     *
     * Pone/rimuove un evento come Consigliato
     *
     */
    public function storeConsigliati($idUtente, $idEvento, $lat, $lon) {


        $this->makeQuery("INSERT INTO consiglia VALUES ($idUtente, $idEvento,$lat,$lon)");
        //$this->makeQuery("UPDATE $this->_table SET consigliato = 1 WHERE id_evento = $idEvento");
    }

    /**
     * @access public
     * @param in $idUtente
     * @param int $idEvento
     */
    public function removeConsigliati($idUtente, $idEvento) {
        $this->makeQuery("
            DELETE FROM consiglia
            WHERE utente = '$idUtente'
            AND evento = '$idEvento'");
    }

    /**
     *
     * @access public
     * @param int $idUtente
     * @param int $neLat
     * @param int $neLon
     * @param int $swLat
     * @param int $swLon
     * @return array(EEvento)
     *
     * Fornisco gli eventi che sono stati più consigliati
     * nel frangente di mappa
     *
     *
     */
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

    /**
     * @access public
     * @param int $idUtente
     * @param int $dellUtente
     * @return array(EEvento)
     *
     * Mi fornisce tutti gli eventi consigliati
     */
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

    /**
     * @acess public
     * @param int $id
     * @return int
     *
     * conta il numero degli eventi
     */
    public function userEventCounter($id) {
        $result = $this->makeQuery("SELECT COUNT(*) FROM $this->_table WHERE id_gestore = $id");
        if ($result[0]) {
            $result = $this->getResult();
            return $result[1];
        }
        else
            return false;
    }

    /**
     * @access public
     * @param int $id
     * @return boolean
     *
     * blocca un utente che ha superato il limite degli eventi da creare
     */
    public function bloccaUtente($id) {
        $result = $this->makeQuery("UPDATE utente SET sbloccato = 0 WHERE id_utente = $id");
        return $result[0];
    }

    /**
     * @access public
     * @param int $id
     * @return array(EEvento)
     *
     *
     * fornisce un array di eventi creati dall' utente con quel particolare "id".
     * Ritorna false in caso di errore
     */
    public function getUserEventi($id) {

        $result = $this->makeQuery("SELECT * FROM $this->_table WHERE id_gestore = $id ORDER BY DATE_FORMAT(data, '%y-%m%d %H:%i')");
        if ($result[0]) {
            $eventi = $this->getObjectArray();
            return $eventi;
        }
        return false;
    }

    /**
     * @access public
     * @param int $id
     * @return int
     *
     * Conta i partecipanti di un particolare evento
     */
    public function guestCounter($id) {
        $number = 0;
        $result = $this->makeQuery("SELECT COUNT(*) FROM preferisce WHERE evento = $id");
        if ($result[0]) {
            $res = $this->getResult();
            return $res[1]["COUNT(*)"];
        }else
            return $number;
    }

    /**
     * @access public
     *
     * Eliminto gli eventi scaduti
     *
    public function cleanExpiredEvent() {
        $query = "DELETE FROM $this->_table WHERE  data <= DATE_FORMAT(" .date("Y-m-d H:i"). ",'%y-%m-%d %H:%i')";
        $this->makeQuery($query);
    }*/

}

?>
