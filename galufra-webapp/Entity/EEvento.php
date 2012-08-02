<?php

class EEvento {

    public $id_evento = null;
    public $nome = null;
    public $descrizione = null;
    public $data = null;
    public $n_visite = 0;
    public $n_iscritti = 0;
    //public $locale = null;
    public $lat = null;
    public $lon = null;
    public $id_gestore = null;

    public function getIdEvento() {
        return $this->id_evento;
    }

    public function setIdEvento($idEvento) {
        $this->id_evento = $idEvento;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getDescrizione() {
        return $this->descrizione;
    }

    public function setDescrizione($descrizione) {
        $this->descrizione = $descrizione;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getNVisite() {
        return $this->n_visite;
    }

    public function setNVisite($nVisite) {
        $this->n_visite = $nVisite;
    }

    public function getNIscritti() {
        return $this->n_iscritti;
    }

    public function setNIscritti($nIscritti) {
        $this->n_iscritti = $nIscritti;
    }

    public function getGestore() {
        return $this->id_gestore;
    }

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

    public function getLat() {
        return $this->lat;
    }

    public function setLat($lat) {
        $this->lat = $lat;
    }

    public function getLon() {
        return $this->lon;
    }

    public function setLon($lon) {
        $this->lon = $lon;
    }

}

?>
