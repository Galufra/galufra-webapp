<?php
/**
 *
 * @package Galufra
 *
 */


require_once '../Foundation/FUtente.php';
require_once '../Foundation/FEvento.php';
require_once '../Entity/EUtente.php';
require_once '../Entity/EMessaggio.php';
require_once '../Foundation/FMessaggio.php';
require_once '../Entity/EEvento.php';
require_once '../View/VBacheca.php';
require_once '../View/VHome.php';

/**
 * Controller per la gestione della bacheca messaggi dell'evento
 */
class Cbacheca {

    private $utente;
    private $evento;
    private $message = array();
    private $numPartecipanti = 0;

    /**
     * @access public
     * 
     * 
     *Smista attraverso uno switch le richieste del client una
     *volta caricati i dati di sessione
     *
     * @param int id_evento
     * */
    public function __construct($id) {

        session_start();

        $u = new Futente();
        $u->connect();

        if ($id) {
            $ev = new FEvento();
            $ev->connect();
            $this->evento = $ev->load($id);
            if ($this->evento) {
                //carico il numero di partecipanti dell'evento
                $this->numPartecipanti = $ev->guestCounter($this->evento->getIdEvento());
                $_SESSION['evento'] = $id;
            }
        }

        if (isset($_SESSION['username'])) {
            $this->utente = $u->load($_SESSION['username']);
            //carico il numero dell' utente
            $this->utente->setNumEventi($this->utente->isAdmin(), $this->utente->isSuperuser());
        }
        //Se non è impostato l'id carico l' evento dai dati di sessione
        if (!$id && isset($_SESSION['evento'])) {
            $ev = new FEvento();
            $ev->connect();
            $this->evento = $ev->load($_SESSION['evento']);
            $this->numPartecipanti = $ev->guestCounter($this->evento->getIdEvento());

        }


        if (!isset($_GET['action']))
            $_GET['action'] = "";

        switch ($_GET['action']) {

            case ('creaMessaggio'):
                $message = mysql_real_escape_string(utf8_decode($_GET['messaggio']));
                $this->insertMessage($message);
                break;

            case ('creaAnnuncio'):
                $message = htmlentities(utf8_decode($_GET['annuncio']));
                $this->insertAnnuncio($message);
                break;

            case ('getMessaggi'):
                $this->getMessages();
                break;

            case ('eliminaMessaggio'):
                $this->deleteMessage();
                break;

            case ('getPartecipanti'):
                $this->getPartecipanti();
                break;

            case('eliminaEvento'):
                $this->eliminaEvento();
                break;


            default:
                //Se sono loggato e un evento esiste visualizzo la bacheca
                if ($this->evento && $this->utente) {
                    $view = new VBacheca($this->evento, $this->utente, $this->numPartecipanti);
                    if ($this->utente->isConfirmed())
                        $view->regConfermata();
                    if ($this->utente->isSuperuser())
                        $view->isSuperuser();
                }
                else
                    //altrimenti visualizzo la home
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

                break;
        }
    }

    /**
     * @access public
     * 
     * fornisce tutti i messaggi di un determinato evento e ci dice inoltre se l' utente è
     * amministratore o gestore dell' evento.Fornisce inoltre un json di risposta
     *
     * @return Json
     */
    public function getMessages() {

        $mex = new FMessaggio();
        $mex->connect();
        $isGestore = false;
        $isAdmin = false;
        $messaggi = $mex->loadMessages($this->evento->getIdEvento());
        if ($this->utente->getId() == $this->evento->getGestore())
            $isGestore = true;
        if ($this->utente->isAdmin())
            $isAdmin = true;
        $out = array(
            'total' => count($messaggi),
            'messaggi' => $messaggi,
            'isGestore' => $isGestore,
            'isAdmin' => $isAdmin,
            'annuncio' => $this->evento->getAnnuncio()
        );
        echo json_encode($out);
    }

    /**
     * @access public
     * 
     *
     * inserisce un messaggio in bacheca e fornisce un json di risposta
     */
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
    /**
     * @access public
     *
     *
     * inserisce un annuncio da parte del gestore dell'evento. Fornisce un json di risposta
     *
     * @param string $mess
     */
    public function insertAnnuncio($mess) {
        $response = false;
        if ($this->evento) {
            $ev = new FEvento();
            $ev->connect();
            $this->evento->setAnnuncio($mess);
            $result = $ev->update($this->evento);
            if (!$result[0])
                $response = array(
                    'message' => 'Si è verificato un errore'
                );
            else {
                $response = array(
                    'message' => "Annuncio Inserito!"
                );
            }
            
        }
        echo json_encode($response);
    }
    /**
     * @access public
     *
     * elimina un messaggio dalla bacheca
     *
     * @return Json
     */
    public function deleteMessage() {
        $m = new FMessaggio();
        $m->connect();
        if (isset($_GET['idMex'])) {
            $mex = mysql_real_escape_string($_GET['idMex']);
            $messaggio = $m->load($mex);
            if ($messaggio && ($this->utente->isAdmin() || ($this->utente->getId() == $this->evento->getGestore()))) {
                //if ($messaggio->getUtente()->getId() == $utente->getId()) {
                $m->delete($messaggio);
                $out = array(
                    'message' => "Messaggio eliminato con successo"
                );
                //}
            } else {
                $out = array(
                    'message' => "Non hai i permessi per questa azione"
                );
            }
        } else {
            $out = array(
                'message' => "Nessun messaggio valido selezionato"
            );
        }

        echo json_encode($out);
    }
    /**
     * @access public
     * 
     * Se siamo amministratori, elimina l'evento
     *
     * @return Json
     */
    public function eliminaEvento() {

        if ($this->evento && $this->utente->isAdmin()) {
            $ev = new FEvento();
            $ev->connect();
            $result = $ev->delete($this->evento);
            if ($result[0]) {
                $response = array(
                    'message' => 'Evento Eliminato'
                );
                $_SESSION['evento'] = '';
            }
            else
                $response = array(
                    'message' => 'Si è verificato un errore'
                );
        }else
            $response = array(
                'message' => 'Non hai i permessi per questa azione'
            );

        echo json_encode($response);
    }

    /**
     * Fornisce i partecipanti ad un evento (l'id è preso dalla sessione).
     * Utilizza FUtente::getPartecipanti($id)
     *
     * @access public
     * @return Json
     */
    public function getPartecipanti(){
        $response = array('utenti' => null, 'count' => 0);
        if($this->evento && $this->utente){
            $u = new FUtente();
            $u->connect();
            $result = $u->getPartecipanti($this->evento->getIdEvento());
            if($result){
                $response = array (
                       'utenti' => $result,
                       'count' => $this->numPartecipanti
                        );
            }
        }

        echo json_encode($response);
    }

}



if (!isset($_GET['id']))
    $_GET['id'] = null;

$bacheca = new CBacheca($_GET['id']);
?>
