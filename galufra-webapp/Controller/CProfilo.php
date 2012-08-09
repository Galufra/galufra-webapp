<?php

require_once '../View/VCrea.php';
require_once '../View/VHome.php';
require_once '../Foundation/FUtente.php';
require_once '../Foundation/FEvento.php';
require_once '../Entity/EUtente.php';
require_once '../Entity/EEvento.php';

class CPofilo {

    private $utente = null;
    private $action = "";

    public function __construct($id) {

        $u = new FUtente();
        $u->connect();
        if (isset($_SESSION['username'])) {

            $this->utente = $u->load($_SESSION['username']);
            if ($this->utente->getId() == $id) {
                $this->action = "modifica_profilo";
            }else
                $this->action = "visualizza_profilo";
        }

        switch ($this->action) {
            case('modifica_profilo'):
                $view = new VProfilo($this->utente, false);
                if ($this->utente) {
                    $view->isAutenticato(true);
                    $view->showUser($this->utente->getUsername());
                }
                $view->mostraPagina();
                break;
            case('visualizza_profilo'):
                $view = new VProfilo($this->utente, true);
                if ($this->utente) {
                    $view->isAutenticato(true);
                    $view->showUser($this->utente->getUsername());
                }
                $view->mostraPagina();
                break;
            default:
                $view = new VHome();
                if ($this->utente) {
                    $view->isAutenticato(true);
                    $view->showUser($this->utente->getUsername());
                }
                $view->mostraPagina();
            }
    }
}

            /*                if (!$this->utente && isset($_POST['username']) && isset($_POST["password"]) && isset($_POST['nome']) && isset($_POST['cognome'])
              && isset($_POST["citta"]) && isset($_POST["mail"])) {
              $eu = new EUtente();
              $eu->setUsername($_POST['username']);
              $eu->setPassword($_POST['password']));
              $eu->setNome($_POST['nome']));
              $eu->setCognome($_POST['cognome']));
              // Conversione della data in formato MySql
              $unixdate = strtotime($_GET['timestamp']);
              $eu->setData(date('Y-m-d H:i:s', $unixdate));
              $eu->setEmail($_POST['mail']));
              $eu->setCitta($_POST['citta']));
              $Foundation = new FUtente();
              $Foundation->connect();
              $result = $Foundation->update($eu);
              if (!$result[0])
              $response = array(
              'status' => 'ERR',
              'message' => 'Si � verificato un errore'
              );
              else {
              $response = array(
              'status' => 'OK',
              'message' => "Il profilo � stato aggiornato correttamente."
              );
              }
              }
              break;
             */




session_start();

if (!isset($_GET("id")))
$_GET["id"] = "";

$profilo = new CProfilo($_GET["id"]);
?>