<?php
/**
 *
 * @package Galufra
 *
 */

require_once '../Foundation/FUtente.php';
require_once '../Entity/EUtente.php';
require_once '../Foundation/FEvento.php';
require_once '../Entity/EEvento.php';
require_once '../View/VCerca.php';
require_once '../View/VHome.php';


/**
 * Controller per la ricerca degli eventi
 */
class CCerca {

    private $utente = null;
    private $view = null;

    public function __construct() {
        session_start();
        if (isset($_SESSION['username']) && $_SESSION['username'] != null) {
            $user = new FUtente();
            $user->connect();
            $this->utente = $user->load($_SESSION['username']);
            //carico il numero di eventi
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


        /* Se non vengono passati i dati, visualizza la schermata di ricerca
         */
        if(!isset($_GET['action'])){
            if(!isset($_GET['nome']))
                $_GET['action'] = '';
            else
                $_GET['action'] = 'cerca';
        }

        /*
         * Gestisco le action
         */
        switch($_GET['action']){
            default:
                 $this->view = new VCerca($this->utente);
                 if ($this->utente) {
                    $this->view->isAutenticato(true);
                    $this->view->showUser($this->utente->getUsername());
                    if (!$this->utente->isSbloccato())
                        $this->view->blocca();
                    //blocco il messaggio di conferma registrazione
                    if ($this->utente->isConfirmed())
                        $this->view->regConfermata();
                    //tolgo il link "diventa supersuser"
                    if ($this->utente->isSuperuser())
                        $this->view->isSuperuser();
                }else {
                    //blocco il messaggio di conferma registrazione
                    $this->view->regConfermata();
                }
                $this->view->mostraPagina();
            break;
            /* Autocompletamento
             */
            case 'suggest':
                $suggestions = array();
                $e = new FEvento();
                $e->connect();
                $ev_array = $e->searchEventiNome($_GET['query'], false);
                foreach ($ev_array as $i)
                    $suggestions[] = $i->nome;
                echo json_encode(array(
                'suggestions' => $suggestions,
                'query' => $_GET['query']
                ));
            break;
            /* Risultati di ricerca
             */
            case 'cerca':
                $e = new FEvento();
                $e->connect();
                $eventi = $e->searchEventiNome($_GET['nome']);
                $this->view = new VCerca($this->utente, $eventi);
                if ($this->utente) {
                    $this->view->isAutenticato(true);
                    $this->view->showUser($this->utente->getUsername());
                    if (!$this->utente->isSbloccato())
                        $this->view->blocca();
                    //blocco il messaggio di conferma registrazione
                    if ($this->utente->isConfirmed())
                        $this->view->regConfermata();
                    //tolgo il link "diventa supersuser"
                    if ($this->utente->isSuperuser())
                        $this->view->isSuperuser();
                }else {
                    //blocco il messaggio di conferma registrazione
                    $this->view->regConfermata();
                }
                if (!$eventi)
                    $this->view->assign('noresult', true);
                $this->view->mostraPagina();
            break;
        }
    }

}

$c = new CCerca();
?>
