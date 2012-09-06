<?php
/**
 * @package Galufra
 */


require_once '../Foundation/FUtente.php';
require_once '../Foundation/FEvento.php';
require_once '../Entity/EUtente.php';
require_once '../Entity/EEvento.php';
require_once '../View/VListaEventi.php';
require_once '../View/VHome.php';

/**
 * Controller che gestisce 3 tipi di liste generali:
 * -lista eventi preferiti
 * -lista eventi personali
 * -lista eventi consigliati
 */
class CListaEventi {

    private $utente;

    /**
     * @access public
     *
     * una volta controllati i dati di sessione fornisce attraverso uno switch che prende come
     * parametro un dato passato via get la lista completa dobbiamo stampare:
     * preferiti
     * consigliati
     * personali
     */
    public function __construct() {


        session_start();

        $u = new Futente();
        $u->connect();

        if (isset($_SESSION['username'])) {

            $this->utente = $u->load($_SESSION['username']);
            $this->utente->setNumEventi();
        }

        if (!isset($_GET['action']))
            $_GET['action'] = "";

        //stampiamo le liste fornendo sempre i dati per la view, ovvero i parametri
        //dell'utente
        switch ($_GET['action']) {

            case ('preferiti'):

                $lista = new VListaEventi(array("listaEventiPreferiti.js"));
                if ($this->utente) {
                    $lista->isAutenticato(true);
                    $lista->showUser($this->utente->getUsername());
                    if ($this->utente->isConfirmed())
                        $lista->regConfermata();
                    if ($this->utente->isSuperuser())
                        $lista->isSuperuser();
                }else {
                    $lista->regConfermata();
                }
                $lista->mostraPagina();
                break;

            case ('personali'):
                $lista = new VListaEventi(array("listaEventiPersonali.js"));
                if ($this->utente) {
                    $lista->isAutenticato(true);
                    $lista->showUser($this->utente->getUsername());
                    if ($this->utente->isConfirmed())
                        $lista->regConfermata();
                    if ($this->utente->isSuperuser())
                        $lista->isSuperuser();
                }else {
                    $lista->regConfermata();
                }
                $lista->mostraPagina();
                break;

            case ('consigliati'):
                $lista = new VListaEventi(array("listaEventiConsigliati.js"));
                if ($this->utente) {
                    $lista->isAutenticato(true);
                    $lista->showUser($this->utente->getUsername());
                    if ($this->utente->isConfirmed())
                        $lista->regConfermata();
                    if ($this->utente->isSuperuser())
                        $lista->isSuperuser();
                }else {
                    $lista->regConfermata();
                }
                $lista->mostraPagina();
                break;

            default:
                //nessun action impostato: visualizzo la home
                $view = new VHome ();
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

                break;
        }
    }

    /**
     * @access public
     *
     * fornisce un Json con gli eventi preferiti.
     *
     */
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

    /**
     * @access public
     *
     * fornisce un Json con gli eventi consigliati.
     *
     */
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

    /**
     * @access public
     *
     * fornisce un Json con gli eventi personali.
     *
     */
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


$listaEventi = new CListaEventi();
?>

