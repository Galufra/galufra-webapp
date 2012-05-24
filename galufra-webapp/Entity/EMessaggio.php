<?php

class EMessaggio {

    private $id_mess = null;
    private $data = null;
    private $testo = null;
    private $titolo = null;
    private $descrizione = null;
    private $evento = null;
    private $utente = null;
    

    public function getId() {
        return $this->id_mess;
    }

    public function getData() {
        return $this->data;
    }

    public function getTesto() {
        return $this->testo;
    }

    public function getTitolo() {
        return $this->titolo;
    }
    
    public function getDescrizione(){
        return $this->descrizione;
    }
    
    public function getEvento(){
        return $this->evento;
    }
    
    public function getUtente(){
        return $this->utente;
    }

    public function setData($data){
        $this->data = $data;
    }

    public function setTesto($testo){
        $this->testo = $testo;
    }

    public function setTitolo($titolo){
        $this->titolo = $titolo;
    }

    public function setDescrizione($descr){
        $this->descrizione = $descr;
    }

}

?>
