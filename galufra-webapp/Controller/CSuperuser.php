<?php

require_once '../Foundation/FUtente.php';
require_once '../View/VSuperuser.php';
require_once '../Entity/EUtente.php';
require_once '../Foundation/FEvento.php';

class CSuperuser {

    private $utente = null;

    public function __construct() {

        $u = new FUtente();
        $u->connect();

        if (isset($_SESSION['username'])) {
            $this->utente = $u->load($_SESSION['username']);
            //carico il numero dell' utente
            $this->utente->setNumEventi($this->utente->isAdmin(), $this->utente->isSuperuser());
        }

        $view = new VSuperuser();
        if ($this->utente) {
            $view->isAutenticato(true);
            $view->showUser($this->utente->getUsername());
            if ($this->utente->isConfirmed())
                $view->regConfermata();
            if ($this->utente->isSuperuser())
                $view->isSuperuser();
        }else {
            $view->regConfermata();
        }
        $view->mostraPagina();
    }

}

session_start();
$conferma = new CSuperuser();
?>
