<?php

class EMessaggio {

    public $id_mess = null;
    public $testo = null;
    public $data = null;
    public $evento = null;
    public $utente = null;

    /**
     * @access public
     * @return int
     */
    public function getId() {
        return $this->id_mess;
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
     * @return String
     */
    public function getTesto() {
        return $this->testo;
    }

    /**
     * @access public
     * @return EEvento
     */
    public function getEvento() {
        return $this->evento;
    }

    /**
     * @access public
     * @return EUtente
     */
    public function getUtente() {
        return $this->utente;
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
     * @param String $testo
     */
    public function setTesto($testo) {
        $this->testo = $testo;
    }

    /**
     * @access public
     * @param EEvento $evento
     */
    public function setEvento($evento){
        $this->evento = $evento;
    }

    /**
     * @access public
     * @param EUtente $user
     */
    public function setUtente($user) {
        $this->utente = $user;
    }

}

?>
