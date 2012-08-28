<?php
/**
 * @package Galufra
 */


require_once('FMysql.php');


/**
 * Foundation per leggere/scrivere eventi sul DB. 
 * 
 */
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
     *
     * Restituisce un array di eventi compresi tra oggi e il prossimo mese
     * con coordinate comprese nel rettangolo ne-sw.
     *
     * @param int $neLat
     * @param int $neLon
     * @param int $swLat
     * @param int $swLon

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
    
    public function searchEventiNome($nome) {
        return $this->search(array(
            array('nome', 'LIKE', "%$nome%")
        ));
    }

    /**
     * @access public
     *
     * ritorna il numero di eventi preferiti
     *
     * @param int $idUtente
     * @return int
     *
     * 
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
     *
     * salva un evento preferito da un utente
     *
     * @param int $idUtente
     * @param int $idEvento
     *
     * 
     */
    public function storePreferiti($idUtente, $idEvento) {
        $this->makeQuery("
            INSERT INTO preferisce
            VALUES ($idUtente, $idEvento)");
    }

    /**
     * @access public
     *
     * rimuove evento preferito da un utente
     *
     * @param int $idUtente
     * @param int $idEvento
     *
     * 
     */
    public function removePreferiti($idUtente, $idEvento) {
        $this->makeQuery("
            DELETE FROM preferisce
            WHERE utente = '$idUtente'
            AND evento = '$idEvento'");
    }

    /**
     *
     * @access public
     *
     * Pone un evento come Consigliato
     *
     * @param int $idUtente
     * @param int $idEvento
     *
     *
     */
    public function storeConsigliati($idUtente, $idEvento) {


        $this->makeQuery("INSERT INTO consiglia VALUES ($idUtente, $idEvento)");
        
    }

    /**
     * @access public
     *
     * Rimuove un evento tra i consigliati
     *
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
     *
     * Fornisco gli eventi che sono stati più consigliati
     * nel frangente di mappa
     *
     * @param int $idUtente
     * @param int $neLat
     * @param int $neLon
     * @param int $swLat
     * @param int $swLon
     * @return array(EEvento)
     *
     *
     */
    public function getEventiConsigliati($idUtente, $neLat, $neLon, $swLat, $swLon) {

        $this->makeQuery("SELECT * FROM evento WHERE data >= NOW() AND id_evento IN (

                SELECT evento FROM consiglia as c INNER JOIN evento as e ON c.evento = e.id_evento
                WHERE e.lat BETWEEN $swLat AND $neLat AND
                e.lon BETWEEN $swLon AND $neLon AND
                c.utente != $idUtente
                GROUP BY evento ORDER BY COUNT(*) DESC) LIMIT 3"
        );
        return $this->getObjectArray();
    }

    /**
     * @access public
     *
     * Mi fornisce tutti gli eventi consigliati
     *
     * @param int $idUtente
     * @param int $dellUtente
     * @return array(EEvento)
     *
     * 
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
     * @access public
     *
     * conta il numero degli eventi
     *
     * @param int $id
     * @return int
     *
     * 
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
     *
     * blocca un utente che ha superato il limite degli eventi da creare
     *
     * @param int $id
     * @return boolean
     *
     */
    public function bloccaUtente($id) {
        $result = $this->makeQuery("UPDATE utente SET sbloccato = 0 WHERE id_utente = $id");
        return $result[0];
    }

    /**
     * @access public
     *
     * fornisce un array di eventi creati dall' utente con quel particolare "id".
     * Ritorna false in caso di errore
     *
     * @param int $id
     * @return array(EEvento)
     *
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
     *
     * Conta i partecipanti di un particolare evento
     *
     * @param int $id
     * @return int
     *
     * 
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
     * Elimino gli eventi scaduti
     **/
    public function cleanExpiredEvent() {
        $query = "DELETE FROM $this->_table WHERE  data <= '".date("Y-m-d H:m:s")."'";
        $this->makeQuery($query);
    }

}

?>
