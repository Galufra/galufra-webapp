<?php

require_once '../View/VProfilo.php';
require_once '../View/VHome.php';
require_once '../Foundation/FUtente.php';
require_once '../Foundation/FEvento.php';
require_once '../Entity/EUtente.php';
require_once '../Entity/EEvento.php';
require_once '../Controller/CRegistrazione.php';

class CProfilo {

    private $utente = null;
    private $utenteDaVis = null;
    private $action = "";

    public function __construct($name) {

        $u = new FUtente();
        $u->connect();
        if (isset($_SESSION['username'])) {

            $this->utente = $u->load($_SESSION['username']);

            if ($name && $this->utente->getUsername() == $name) {
                $this->action = "modifica_profilo";
                $_SESSION['enable'] = true;
            } else if ($name && $this->utente->getUsername() != $name) {
                $this->action = "visualizza_profilo";
                $_SESSION['enable'] = false;
            } else if (!$name && $this->utente) {
                $this->action = "modifica_profilo";
                $_SESSION['enable'] = true;
            } else
                $this->action = null;


            if (isset($_POST["action"]) && $_POST["action"] == "update" && isset($_SESSION['enable']) && $_SESSION['enable']) {
                $this->updateUtente();
                $this->action = null;
            }
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
                $this->utenteDaVis = $u->load($name);
                if ($this->utenteDaVis) {
                    $view = new VProfilo($this->utenteDaVis, true);
                    if ($this->utente) {
                        $view->isAutenticato(true);
                        $view->showUser($this->utente->getUsername());
                    }
                } else {
                    $view = new VHome();
                    if ($this->utente) {
                        $view->isAutenticato(true);
                        $view->showUser($this->utente->getUsername());
                    }
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

    public function updateUtente() {

        /* if (isset($_POST["password"]) || isset($_POST['password1'])
          || isset($_POST["nome"]) || isset($_POST["cognome"]) || isset($_POST["citta"]) || isset($_POST["email"])) { */
        $pwd = null;
        $pwd1 = null;
        if (isset($_POST['password']) && isset($_POST['password1'])) {
            $pwd = $_POST['password'];
            $pwd1 = $_POST['password1'];
        }
        $this->utente->setCitta(mysql_real_escape_string(isset($_POST['citta']) ? $_POST['citta'] : $this->utente->getCitta()));
        $this->utente->setNome(mysql_real_escape_string(isset($_POST['nome']) ? $_POST['nome'] : $this->utente->getNome()));
        $this->utente->setCognome(mysql_real_escape_string(isset($_POST['cognome']) ? $_POST['cognome'] : $this->utente->getCognome()));
        if ($this->utente->setEmail(
                        (isset($_POST['email']) ? mysql_real_escape_string($_POST['email']) : $this->utente->getEmail()))
                &&
                $pwd == $pwd1
        ) {
            //$registra = new CRegistrazione($this->utente->getUsername(), $pwd, $citta, $mail, $nome, $cognome);
            //$result = $registra->updateProfilo();
            if ($pwd != null && $pwd1 != null && md5($pwd) != $this->utente->getPassword())
                $this->utente->setPassword($pwd);
            $db = new FUtente();
            $db->connect();
            $result = $db->update($this->utente);
            if ($result[0]) {
                $out = array(
                    'message' => 'Modifiche avvenute con successo!'
                );
                echo json_encode($out);
                exit;
            } else {
                $out = array(
                    'message' => "Errore...Riprova"
                );
                echo json_encode($out);
                exit;
            }
        } else {
            $out = array(
                'message' => "Le password non coincidono"
            );
            echo json_encode($out);
            exit;
        }
        // }
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

if (!isset($_GET["name"]))
    $_GET["name"] = "";

$profilo = new CProfilo(htmlspecialchars($_GET["name"]));
?>