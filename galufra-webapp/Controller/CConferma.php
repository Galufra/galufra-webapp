<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Foundation/FUtente.php';
require_once '../Foundation/FEvento.php';
require_once '../Entity/EUtente.php';
require_once '../View/VConferma.php';
require_once '../View/VHome.php';

class CConferma {

    private $utente = null;

    public function __construct() {

        $u = new FUtente();
        $u->connect();

        if (isset($_SESSION['username'])) {
            $this->utente = $u->load($_SESSION['username']);
            //carico il numero dell' utente
            $this->utente->setNumEventi($this->utente->isAdmin(), $this->utente->isSuperuser());
        }

        if (!isset($_GET['action']))
            $_GET['action'] = null;

        switch ($_GET['action']) {

            case ('conferma'):
                if ($this->confermaReg()) {
                    $view = new VConferma ();
                    $view->regConfermata();
                    if ($this->utente) {
                        $view->isAutenticato(true);
                        $view->showUser($this->utente->getUsername());
                        if ($this->utente->isConfirmed())
                            $view->regConfermata();
                        if ($this->utente->isSuperuser())
                            $view->isSuperuser();
                    }
                    $view->mostraPagina();
                } else {
                    $view = new VHome();
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
                break;

            default:
                $view = new VHome();
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

    public function confermaReg() {

        if (isset($_GET['id'])) {
            $u = new FUtente();
            $u->connect();
            $result = $u->userConfirmation(mysql_escape_string($_GET['id']));
            return $result[0];
        } else {
            return false;
        }
    }

}

session_start();
$conferma = new CConferma();
?>
