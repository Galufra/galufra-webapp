<?php

require_once('../Foundation/FUtente.php');
require_once('../Entity/EUtente.php');
require_once('../Foundation/FMessaggio.php');
require_once('../Entity/EEvento.php');

class Cbacheca {

    private $utente;
    private $evento;
    private $message = array();

    public function __construct($user, $event) {

        $this->utente = new EUtente();
        $this->evento = new EEvento();
        $this->utente = $user->__clone();
        $this->evento = $event->__clone();
        $m = new FMessaggio();
        $m->connect();
        $this->message = $m->loadMessages($this->evento->getId());
    }

    public function getMessages() {

        return $this->message;
    }

    public function insertMessage($messaggio) {

        $m = new FMessage();
        $m->connect();
        $id_mex = $m->store($messaggio);
        $mex = $m->load($id_mex);
        array_push($this->message, $mex);
        return $mex;
    }

    public function deleteMessage($messaggio) {


        $m = new FMessage();
        $m->connect();
        if ($messaggio->getUtente()->getId() == $utente->getId())
            $m->delete($messaggio);
        else
            return false;

        $this->message = $m->loadMessages($this->evento->getId());
        return $this->getMessages();
    }

}

?>
