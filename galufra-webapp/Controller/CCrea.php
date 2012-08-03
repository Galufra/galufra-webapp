<?php

require_once '../View/VCrea.php';
require_once '../View/VHome.php';
require_once '../Foundation/FUtente.php';
require_once '../Foundation/FEvento.php';
require_once '../Entity/EUtente.php';
require_once '../Entity/EEvento.php';

class CCrea {

    private $utente = null;

    public function __construct() {
        /* In futuro dovremo controllare che l'utente sia loggato
         * e sia un Gestore. Per ora carico il mio utente
         */
        $u = new Futente();
        $u->connect();
        if (isset($_SESSION['username'])) {

            $this->utente = $u->load($_SESSION['username']);
            //carico il numero di eventi
            $this->utente->setNumEventi();
        }

        /* Se "action" non è impostato, o l' utente non esiste oppure ha esaurito il num di eventi, eseguiremo il comportamento
         * di default nello switch successivo, ignorando anche i dati mandati via get.
         */
        if (!isset($_GET['action']) || !$this->utente || !$this->utente->isSbloccato()) {
            $_GET['action'] = '';
        }

        switch ($_GET['action']) {
            case('creaEvento'):
                $ev = new EEvento();
                $ev->setNome(utf8_decode($_GET['nome']));
                $ev->setDescrizione(utf8_decode($_GET['descrizione']));
                // Conversione della data in formato MySql
                $unixdate = strtotime($_GET['timestamp']);
                $ev->setData(date('Y-m-d H:i:s', $unixdate));
                $ev->setGestore($this->utente->getId());
                $ev->setLat($_GET['lat']);
                $ev->setLon($_GET['lon']);
                var_dump($ev);
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
                //echo json_encode($response);
                break;

            default:
                if ($this->utente && !$this->utente->isSbloccato()) {
                    //cambio il tpl di ccrea per evitare hack in html visto che il metodo blocca modifica solo il link
                    //di crea evento
                    $view = new VCrea('home.tpl',array ('CHome.js'));
                    $view->isAutenticato(true);
                    $view->showUser($this->utente->getUsername());
                    if (!$this->utente->isSbloccato())
                        $view->blocca();
                    $view->mostraPagina();
                }
                else if ($this->utente) {
                    $view = new VCrea();
                    $view->isAutenticato(true);
                    $view->showUser($this->utente->getUsername());
                    if (!$this->utente->isSbloccato())
                        $view->blocca();
                    $view->mostraPagina();
                }else {
                    $view = new VCrea();
                    $view->mostraPagina();
                }

                break;
        }
    }


}

session_start();
$crea = new CCrea();
?>
