<?php

require_once '../View/VCrea.php';
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
        if (isset($_SESSION['username']))
            $this->utente = $u->load($_SESSION['username']);
        /* Se "action" non è impostato, eseguiremo il comportamento
         * di default nello switch successivo.
         */
        if (!isset($_GET['action']) || !$this->utente)
            $_GET['action'] = '';
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
                else{
                    $response = array(
                        'status' => 'OK',
                        'message' => "L'evento è stato creato correttamente."
                    );
                }
                echo json_encode($response);

                break;

            default:

                $view = new VCrea();
                if ($this->utente) {
                    $view->isAutenticato(true);
                    $view->showUser($this->utente->getUsername());
                }
                $view->mostraPagina();

                break;
        }
    }

}

session_start();
$crea = new CCrea();
?>
