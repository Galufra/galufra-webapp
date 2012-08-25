<?php
/**
 * @package Galufra
 */


/**
 * Entità Evento
 */
class EEvento {

    public $id_evento = null;
    public $nome = null;
    public $descrizione = null;
    public $data = null;
    public $n_visite = 0;
    public $n_iscritti = 0;
    public $annuncio = null;
    //public $locale = null;
    public $lat = null;
    public $lon = null;
    public $id_gestore = null;

    /**
     *@access public
     * @return int
     *
     */
    public function getIdEvento() {
        return $this->id_evento;
    }

    /**
     *@access public
     * @param int $idEvento
     *
     */
    public function setIdEvento($idEvento) {
        $this->id_evento = $idEvento;
    }

    /**
     * @access public
     * @return String
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * @access public
     * @param string $nome
     */
    public function setNome($nome) {
        $this->nome = $nome;
    }

    /**
     * @access public
     * @return String
     */
    public function getDescrizione() {
        return $this->descrizione;
    }

    /**
     * @access public
     * @param string $descrizione
     */
    public function setDescrizione($descrizione) {
        $this->descrizione = $descrizione;
    }

    /**
     * @access public
     * @return String
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @access public
     * @param string $annuncio
     */
    public function setAnnuncio($annuncio){
        $this->annuncio = $annuncio;
    }

    /**
     * @access public
     * @return String
     */
    public function getAnnuncio(){
        return $this->annuncio;
    }

    /**
     * @access public
     * @param string $data
     */
    public function setData($data) {
        $this->data = $data;
    }

    /**
     * @access public
     * @return int
     */
    public function getNVisite() {
        return $this->n_visite;
    }

    /**
     * @access public
     * @param int $nVisite
     */
    public function setNVisite($nVisite) {
        $this->n_visite = $nVisite;
    }

    /**
     * @access public
     * @return int
     */
    public function getNIscritti() {
        return $this->n_iscritti;
    }

    /**
     * @access public
     * @param int $nIscritti
     */
    public function setNIscritti($nIscritti) {
        $this->n_iscritti = $nIscritti;
    }

    /**
     * @access public
     * @return int
     */
    public function getGestore() {
        return $this->id_gestore;
    }

    /**
     * @access public
     * @param int $gestore
     */
    public function setGestore($gestore) {
        $this->id_gestore = $gestore;
    }

    /* public function getLocale() {
      return $this->locale;
      } */

    /*
      public function setLocale($locale) {
      $this->locale = $locale;
      } */

    /**
     * @access public
     * @return int
     */
    public function getLat() {
        return $this->lat;
    }

    /**
     * @access public
     * @param int $lat
     */
    public function setLat($lat) {
        $this->lat = $lat;
    }

    /**
     * @access public
     * @return  int
     */
    public function getLon() {
        return $this->lon;
    }

    /**
     * @access public
     * @param int $lon
     */
    public function setLon($lon) {
        $this->lon = $lon;
    }

}

?>
