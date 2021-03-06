<?php

/**
 * @package Galufra
 */
require_once '../View/VCrea.php';
require_once '../View/VHome.php';
require_once '../Foundation/FUtente.php';
require_once '../Foundation/FEvento.php';
require_once '../Entity/EUtente.php';
require_once '../Entity/EEvento.php';

/**
 * Controller per la creazione di un nuovo evento. 
 */
class CCrea {

    private $utente = null;

    /**
     * @access public
     * Una volta controllati i dati di sessione,
     * gestisce la creazione dell' evento da parte dell'utente
     * */
    public function __construct() {

        session_start();

        $u = new Futente();
        $u->connect();
        if (isset($_SESSION['username']) && $_SESSION['username'] != null) {

            $this->utente = $u->load($_SESSION['username']);
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

        /* Se "action" non è impostato, o l'utente non esiste oppure ha esaurito il num di eventi, eseguiremo il comportamento
         * di default nello switch successivo, ignorando anche i dati mandati via get.
         */
        if (!isset($_POST['action']) || !$this->utente || !$this->utente->isSbloccato()) {
            $_POST['action'] = '';
        }

        switch ($_POST['action']) {
            case('creaEvento'):
                //creo un entity Evento e salvo in database
                $ev = new EEvento();
                //filtro con mysql escape string o html special chars?
                $ev->setNome(utf8_decode(htmlspecialchars(mysql_real_escape_string($_POST['nome']))));
                $ev->setDescrizione(utf8_decode(htmlspecialchars(mysql_real_escape_string($_POST['descrizione']))));
                // Conversione della data in formato MySql
                $unixdate = strtotime(mysql_real_escape_string($_POST['timestamp']));
                $ev->setData(date('Y-m-d H:i:s', $unixdate));
                $ev->setGestore($this->utente->getId());
                $ev->setLat(mysql_real_escape_string($_POST['lat']));
                $ev->setLon(mysql_real_escape_string($_POST['lon']));
                $Foundation = new FEvento();
                $Foundation->connect();
                $result = $Foundation->store($ev);
                if (!$result[0])
                    $response = array(
                        'status' => 'ERR',
                        'message' => 'Si è verificato un errore'
                    );
                else {
                    $response = array(
                        'status' => 'OK',
                        'message' => "L'evento è stato creato correttamente."
                    );
                    $this->utente->incrementaNumEventi();
                }
                echo json_encode($response);
                break;

            default:
                //stampo la home se ho esaurito il numero di eventi che
                //si possono creare
                if ($this->utente && !$this->utente->isSbloccato()) {
                    //cambio il tpl di CCrea per evitare hack in html visto che il metodo blocca modifica solo il link
                    //di crea evento
                    $view = new VCrea('home.tpl', array('CHome.js'));
                    $view->isAutenticato(true);
                    $view->showUser($this->utente->getUsername());
                    if (!$this->utente->isSbloccato())
                        $view->blocca();
                    if ($this->utente->isConfirmed())
                        $view->regConfermata();
                    if ($this->utente->isSuperuser())
                        $view->isSuperuser();

                    $view->pulsante_cerca = true;
                    $view->mostraPagina();
                   
                }
                //altrimenti stampo la pagina di creazione evento
                else if ($this->utente) {
                    $view = new VCrea();
                    $view->isAutenticato(true);
                    $view->showUser($this->utente->getUsername());
                    if (!$this->utente->isSbloccato())
                        $view->blocca();
                    if ($this->utente->isConfirmed())
                        $view->regConfermata();
                    if ($this->utente->isSuperuser())
                        $view->isSuperuser();
                    $view->mostraPagina();
                }else {
                    $view = new VCrea();
                    $view->regConfermata();
                    $view->mostraPagina();
                }

                break;
        }
    }

}


$crea = new CCrea();
?>
