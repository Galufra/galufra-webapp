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

    /**
     * @access public
     *
     * @param string $name
     *
     * Una volta controllati i dati di sessione controlla se un utente sta visualizzando il proprio
     * profilo, e quindi può modificarlo, altrimenti può solo leggerlo
     * La variabile di sessione 'enable' permette di tornare al nostro profilo se non inseriamo un
     * username come parametro del costruttore.
     * Permette inoltre di aggiornare,eliminare,rendere superuser o admin un particolare utente
     * */
    public function __construct($name) {

        $u = new FUtente();
        $u->connect();
        if (isset($_SESSION['username'])) {

            $this->utente = $u->load($_SESSION['username']);
            $this->utente->setNumEventi();

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
     * ritorna un json che ci dice se l' update è andato a buon fine.
     * Faccio inoltre tutti i controlli necessari per evitare errori indesiderati
     *
     *
     * */
    public function updateUtente() {

        $pwd = '';
        $pwd1 = '';
        if ((isset($_POST['password']) && $_POST['password']!=null) && (isset($_POST['password1']) && $_POST['password']!=null )) {
            $pwd = $_POST['password'];
            $pwd1 = $_POST['password1'];
        }
        $this->utente->setCitta((isset($_POST['citta']) ? mysql_real_escape_string(htmlspecialchars($_POST['citta'])) : $this->utente->getCitta()));
        $this->utente->setNome((isset($_POST['nome']) ? mysql_real_escape_string(htmlspecialchars($_POST['nome'])) : $this->utente->getNome()));
        $this->utente->setCognome((isset($_POST['cognome']) ? mysql_real_escape_string(htmlspecialchars($_POST['cognome'])) : $this->utente->getCognome()));

        if ($this->utente->setEmail
                        (
                        (isset($_POST['email']) ? mysql_real_escape_string(htmlspecialchars($_POST['email'])) : $this->utente->getEmail())
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
     * ritorna un json che ci dice se l' eliminazione dell'utente è andata a buon fine.
     * Faccio inoltre tutti i controlli necessari per evitare errori indesiderati
     *
     *
     * */
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
     * ritorna un json che ci dice se l' update dei permessi è andato a buon fine.
     * Faccio inoltre tutti i controlli necessari per evitare errori indesiderati
     *
     *
     * */
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
     * ritorna un json che ci dice se l' update dei permessi è andato a buon fine.
     * Faccio inoltre tutti i controlli necessari per evitare errori indesiderati
     *
     *
     * */
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

}

session_start();

if (!isset($_GET["name"]))
    $_GET["name"] = "";

$profilo = new CProfilo(htmlspecialchars($_GET["name"]));
?>