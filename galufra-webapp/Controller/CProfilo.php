<?php

/**
 * @package Galufra
 */
require_once '../View/VProfilo.php';
require_once '../View/VHome.php';
require_once '../Foundation/FUtente.php';
require_once '../Foundation/FEvento.php';
require_once '../Entity/EUtente.php';
require_once '../Entity/EEvento.php';
require_once '../Controller/CRegistrazione.php';

/**
 * Controller della pagina del profilo.
 */
class CProfilo {

    private $utente = null;
    private $utenteDaVis = null;
    private $action = "";

    /**
     * @access public
     *
     *
     * Una volta controllati i dati di sessione controlla se un utente sta visualizzando il proprio
     * profilo, e quindi modificarlo, altrimenti potrà solo leggerlo
     * Permette inoltre di aggiornare,eliminare,rendere superuser o admin un particolare utente
     *
     * @param string $name
     * */
    public function __construct($name) {

        session_start();

        $u = new FUtente();
        $u->connect();
        if (isset($_SESSION['username'])) {

            $this->utente = $u->load($_SESSION['username']);
            $this->utente->setNumEventi();

            if (isset($_GET['action']) && $_GET['action'] == 'suggest') {
                $this->suggest($_GET['query']);
                exit;
            }
            if ($name && $this->utente->getUsername() == $name) {
                $this->action = "modifica_profilo";
            } else if ($name && $this->utente->getUsername() != $name) {
                $this->action = "visualizza_profilo";
            } else if (!$name && $this->utente) {
                $this->action = "modifica_profilo";
            } else
                $this->action = null;


            if (isset($_POST["action"]) && $_POST["action"] == "update") {
                $this->updateUtente();
                $this->action = null;
            }
            if (isset($_POST["action"]) && $_POST["action"] == "eliminaUtente") {
                $this->deleteUtente();
                $this->action = null;
            }

            if (isset($_POST["action"]) && $_POST["action"] == "addSuperuser") {
                $this->addSuperuser();
                $this->action = null;
            }

            if (isset($_POST["action"]) && $_POST["action"] == "addAdmin") {
                $this->addAdmin();
                $this->action = null;
            }
        }
        //stampo la pagina da modificare o solo da leggere
        switch ($this->action) {
            case('modifica_profilo'):
                $view = new VProfilo($this->utente, null, false);
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
            case('visualizza_profilo'):
                $this->utenteDaVis = $u->load($name);
                if ($this->utenteDaVis) {
                    $view = new VProfilo($this->utente, $this->utenteDaVis, true);
                    if ($this->utente) {
                        $view->isAutenticato(true);
                        $view->showUser($this->utente->getUsername());
                        if ($this->utente->isConfirmed())
                            $view->regConfermata();
                        if ($this->utente->isSuperuser())
                            $view->isSuperuser();
                    }
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
                }
                $view->mostraPagina();
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

    /**
     * @access public
     *
     * ritorna un json che ci dice se l'update è andato a buon fine.
     * Faccio inoltre tutti i controlli necessari per evitare errori indesiderati
     * 
     */
    public function updateUtente() {

        $pwd = '';
        $pwd1 = '';
        if ((isset($_POST['password']) && $_POST['password'] != null) && (isset($_POST['password1']) && $_POST['password'] != null )) {
            $pwd = $_POST['password'];
            $pwd1 = $_POST['password1'];
        }
        $this->utente->setCitta((isset($_POST['citta']) ? (htmlentities($_POST['citta'])) : $this->utente->getCitta()));
        $this->utente->setNome((isset($_POST['nome']) ? (htmlentities($_POST['nome'])) : $this->utente->getNome()));
        $this->utente->setCognome((isset($_POST['cognome']) ? (htmlentities($_POST['cognome'])) : $this->utente->getCognome()));

        if ($this->utente->setEmail
                        (
                        (isset($_POST['email']) ? (htmlentities($_POST['email'])) : $this->utente->getEmail())
                )
                &&
                $pwd == $pwd1
        ) {
            if ($pwd != '' && $pwd1 != '' && md5($pwd) != $this->utente->getPassword())
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
    }

    /**
     * @access public
     *
     * ritorna un json che ci dice se l'eliminazione dell'utente è andata a buon fine.
     * Faccio inoltre tutti i controlli necessari per evitare errori indesiderati
     *
     */
    public function deleteUtente() {
        $out = null;
        if (isset($_POST['name']) && $this->utente->isAdmin()) {
            $name = mysql_escape_string($_POST['name']);
            $u = new FUtente();
            $u->connect();
            $result = $u->delete($u->load($name));
            if (!$result[0]) {
                $out = array('message' => "errore...");
            }
        }else
            $out = array('message' => "utente non valido, o permessi insufficienti");
    }

    /**
     * @access public
     *
     * ritorna un json che ci dice se l'update dei permessi è andato a buon fine.
     * Faccio inoltre tutti i controlli necessari per evitare errori indesiderati
     *
     */
    public function addSuperuser() {
        $out = null;
        if ((isset($_POST['user']) && $_POST['user'] != null) && $this->utente->isAdmin()) {

            $name = mysql_escape_string($_POST['user']);
            $u = new FUtente();
            $u->connect();
            $user = $u->load($name);
            $result = array(false, "errore");

            if ($user) {
                $user->setSuperuser();
                $result = $u->update($user);
            }
            if ($result[0]) {
                $out = array(
                    'result' => "1",
                    'message' => "Operazione Eseguita"
                );
            }
        }else
            $out = array(
                'result' => "0",
                'message' => "Impossibile eseguire l'operazione"
            );

        echo json_encode($out);
        exit;
    }

    /**
     * @access public
     *
     * ritorna un json che ci dice se l'update dei permessi è andato a buon fine.
     * Faccio inoltre tutti i controlli necessari per evitare errori indesiderati
     */
    public function addAdmin() {
        $out = null;

        if ((isset($_POST['user']) && $_POST['user'] != null) && $this->utente->isAdmin()) {

            $name = mysql_escape_string($_POST['user']);
            $u = new FUtente();
            $u->connect();
            $user = $u->load($name);
            $result = array(false, "errore");

            if ($user) {
                $user->administrate();
                $user->setSuperuser();
                $result = $u->update($user);
            }

            if ($result[0]) {
                $out = array(
                    'result' => "1",
                    'message' => "Operazione Eseguita");
            }
        }else
            $out = array(
                'result' => "0",
                'message' => "Impossibile eseguire l'operazione"
            );

        echo json_encode($out);
        exit;
    }
    /**
     * Restituisce un array di utenti il cui nome inizia con $query.
     * @access public
     * @param String $query
     * 
     */
    public function suggest($query) {
        if ($this->utente->isAdmin()) {
            $suggestions = array();
            $u = new FUtente();
            $u->connect();
            $user_array = $u->searchUtentiNome($query, false);
            foreach ($user_array as $i)
                $suggestions[] = $i->username;
            echo json_encode(array(
                'suggestions' => $suggestions,
                'query' => $_GET['query']
            ));
        }
        else
            echo json_encode(array());
    }

}

if (!isset($_GET["name"]))
    $_GET["name"] = "";

$profilo = new CProfilo(htmlspecialchars($_GET["name"]));
?>
