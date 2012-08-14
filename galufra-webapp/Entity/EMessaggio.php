<?php

class EMessaggio {

    public $id_mess = null;
    public $testo = null;
    public $data = null;
    public $evento = null;
    public $utente = null;

    public function getId() {
        return $this->id_mess;
    }

    public function getData() {
        return $this->data;
    }

    public function getTesto() {
        return $this->testo;
    }

    public function getEvento() {
        return $this->evento;
    }

    public function getUtente() {
        return $this->utente;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setTesto($testo) {
        $this->testo = $testo;
    }

    public function setEvento($evento){
        $this->evento = $evento;
    }

    public function setUtente($user) {
        $this->utente = $user;
    }

}

?>
