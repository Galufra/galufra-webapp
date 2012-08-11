<?php

require_once '../Foundation/FUtente.php';
require_once '../Foundation/FEvento.php';
require_once '../Entity/EUtente.php';
require_once '../Entity/EMessaggio.php';
require_once '../Foundation/FMessaggio.php';
require_once '../Entity/EEvento.php';
require_once '../View/VBacheca.php';
require_once '../View/VHome.php';


class Cbacheca {

    private $utente;
    private $evento;
    private $message = array();

    public function __construct($id) {

        $u = new Futente();
        $u->connect();

        if ($id) {
            $ev = new FEvento();
            $ev->connect();
            $this->evento = $ev->load($id);
            $_SESSION['evento'] = $id;
        }

        if (isset($_SESSION['username'])) {
            $this->utente = $u->load($_SESSION['username']);
            //carico il numero dell' utente
            $this->utente->setNumEventi();
        }
        if (!$id && isset($_SESSION['evento'])) {
            $ev = new FEvento();
            $ev->connect();
            $this->evento = $ev->load($_SESSION['evento']);
        }


        if (!isset($_GET['action']))
            $_GET['action'] = "";

        switch ($_GET['action']) {

            case ('creaMessaggio'):
                $message = mysql_escape_string(htmlspecialchars(utf8_decode($_GET['messaggio'])));
                $this->insertMessage($message);
                break;

            case ('getMessaggi'):
                $this->getMessages();
                break;

            default:
                if ($this->evento) 
                    $view = new VBacheca($this->evento);
                else $view = new VHome ();
                    if ($this->utente) {
                        $view->isAutenticato(true);
                        $view->showUser($this->utente->getUsername());
                        if (!$this->utente->isSbloccato())
                            $view->blocca();
                    }
                    $view->mostraPagina();
                
                break;
        }
    }

    public function getMessages() {

        $mex = new FMessaggio();
        $mex->connect();
        $messaggi = $mex->loadMessages($this->evento->getIdEvento());
        $out = array(
            'total' => count($messaggi),
            'messaggi' => $messaggi
        );
        echo json_encode($out);
    }

    public function insertMessage($mess) {

        $mex = new EMessaggio();
        $mex->setTesto($mess);
        $mex->setData(date('Y-m-d H:i:s'));
        $mex->setUtente($this->utente->getUsername());
        $mex->setEvento($this->evento->getIdEvento());
        $Foundation = new FMessaggio();
        $Foundation->connect();
        $result = $Foundation->storeMessaggio($mex);
        if (!$result[0])
            $response = array(
                'status' => 'ERR',
                'message' => 'Si è verificato un errore'
            );
        else {
            $response = array(
                'status' => 'OK',
                'message' => "Messaggio Inserito!"
            );
        }
        echo json_encode($response);
    }

    public function deleteMessage($messaggio) {


        $m = new FMessage();
        $m->connect();
        if ($messaggio->getUtente()->getId() == $utente->getId())
            $m->delete($messaggio);
        else
            return false;
    }

}

session_start();

if (!isset($_GET['id']))
    $_GET['id'] = null;

$bacheca = new CBacheca($_GET['id']);
?>
