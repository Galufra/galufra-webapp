<?php
/**
 * @package Galufra
 */

require_once '../Foundation/FUtente.php';
require_once '../View/VSuperuser.php';
require_once '../Entity/EUtente.php';
require_once '../Foundation/FEvento.php';
require_once '../View/VHome.php';

/**
 *
 * Controller per la gestione di un superuser. Per ora è minimale,
 * gestisce solo una semplice pagina
 *
 */
class CSuperuser {

    private $utente = null;

    /**
     * @access public
     *
     * una volta caricati i dati di sessione
     * esegue la stampa della pagina per diventare superuser utilizzando
     * la view apposita
     */
    public function __construct() {

        session_start();

        $u = new FUtente();
        $u->connect();

        if (isset($_SESSION['username']) && $_SESSION['username'] != null) {
            $this->utente = $u->load($_SESSION['username']);
            //carico il numero dell' utente
            $this->utente->setNumEventi($this->utente->isAdmin(), $this->utente->isSuperuser());
        } else {
            //stampo la home se non sono loggato
            $view = new VHome ();
            if ($this->utente) {
                $view->isAutenticato(true);
                $view->showUser($this->utente->getUsername());
                if (!$this->utente->isSbloccato())
                    $view->blocca();
                //blocco il messaggio di conferma registrazione
                if ($this->utente->isConfirmed())
                    $view->regConfermata();
                //tolgo il link "diventa supersuser"
                if ($this->utente->isSuperuser())
                    $view->isSuperuser();
            }else {
                //blocco il messaggio di conferma registrazione
                $view->regConfermata();
            }
            $view->mostraPagina();
            exit;
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

$conferma = new CSuperuser();
?>
