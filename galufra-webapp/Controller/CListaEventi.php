<?php

require_once '../Foundation/FUtente.php';
require_once '../Foundation/FEvento.php';
require_once '../Entity/EUtente.php';
require_once '../Entity/EEvento.php';
require_once '../View/VListaEventi.php';
require_once '../View/VHome.php';

class CListaEventi {

    private $utente;

    public function __construct() {

        $u = new Futente();
        $u->connect();

        if (isset($_SESSION['username'])) {

            $this->utente = $u->load($_SESSION['username']);
        }

        if (!isset($_GET['action']))
            $_GET['action'] = "";

        switch ($_GET['action']) {

            case ('preferiti'):
                $lista = new VListaEventi(array("listaEventiPreferiti.js"));
                if ($this->utente) {
                    $lista->isAutenticato(true);
                    $lista->showUser($this->utente->getUsername());
                }
                $lista->mostraPagina();
                break;

            case ('personali'):
                $lista = new VListaEventi(array("listaEventiPersonali.js"));
                if ($this->utente) {
                    $lista->isAutenticato(true);
                    $lista->showUser($this->utente->getUsername());
                }
                $lista->mostraPagina();
                break;

            case ('consigliati'):
                $lista = new VListaEventi(array("listaEventiConsigliati.js"));
                if ($this->utente) {
                    $lista->isAutenticato(true);
                    $lista->showUser($this->utente->getUsername());
                }
                $lista->mostraPagina();
                break;

            default:

                $view = new VHome ();
                if ($this->utente) {
                    $view->isAutenticato(true);
                    $view->showUser($this->utente->getUsername());
                }
                $view->mostraPagina();

                break;
        }
    }

    public function getPreferiti() {
        $ev = new FEvento();
        $ev->connect();
        $ev_array = $ev->getEventiPreferiti($this->utente->getId());
        $out = array(
            'total' => count($ev_array),
            'eventi' => $ev_array
        );
        json_encode($out);
        exit;
    }

    public function getConsigliati() {
        $ev = new FEvento();
        $ev->connect();
        $ev_array = $ev->getAllConsigliati($this->utente->getId(), false);
        $out = array(
            'total' => count($ev_array),
            'eventi' => $ev_array
        );
        json_encode($out);
        exit;
    }

    public function getPersonali() {
        $ev = new FEvento();
        $ev->connect();
        $eventi = $ev->getUserEventi($this->utente->getId());
        $out = array(
            'total' => count($eventi),
            'eventi' => $eventi
        );
        json_encode($out);
        exit;
    }

}

session_start();

$listaEventi = new CListaEventi();
?>

