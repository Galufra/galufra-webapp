<?php

require_once('../Foundation/FUtente.php');
require_once('../Foundation/FEvento.php');
require_once('../Foundation/Utility/USession.php');
require_once('../Entity/EUtente.php');
require_once('../Entity/EEvento.php');
require_once '../View/VHome.php';
require_once 'CRegistrazione.php';

class CHome {

    private $utente = null;

    public function __construct() {
        /* Caricamento dell'utente.
         */
        $u = new Futente();
        $u->connect();

        if (isset($_SESSION["username"])) {
            $user = $_SESSION["username"];
            $this->utente = $u->load($user);
            //carico il num di eventi. la funzione blocca automaticamente l'utente se si accorge che gli eventi sono troppi
            $this->utente->setNumEventi();
        }
        $view = new VHome();


        /* Se "action" non è impostato, eseguiremo il comportamento
         * di default nello switch successivo.
         */
        if (!isset($_GET['action']))
            $_GET['action'] = '';

        switch ($_GET['action']) {

            case('getEventiMappa'):
                $this->getEventiMappa(
                        mysql_real_escape_string($_GET['neLat']),
                        mysql_real_escape_string($_GET['neLon']),
                        mysql_real_escape_string($_GET['swLat']),
                        mysql_real_escape_string($_GET['swLon'])
                );
                break;
            case('getEventiPreferiti'):
                $this->getEventiPreferiti();
                break;
            /*
             * Aggiunta/rimozione di un evento nell'elenco dei preferiti
             */
            case('addPreferiti'):
                try {
                    $this->utente->addPreferiti($_GET['id_evento']);
                    echo "L'evento è stato aggiunto ai tuoi preferiti.";
                } catch (dbException $e) {
                    // 1062 = esiste già una tupla con gli stessi id
                    if ($e->getMessage() == '1062')
                        echo "L'evento fa già parte dei tuoi preferiti!";
                    else
                        echo "C'è stato un errore. Riprova :)";
                }
                break;

            case('removePreferiti'):
                try {
                    $this->utente->removePreferiti($_GET['id_evento']);
                    echo "L'evento è stato rimosso dai tuoi preferiti.";
                } catch (dbException $e) {
                    echo "C'è stato un errore. Riprova :)";
                }
                break;

            case( 'getEventiPersonali'):
                try {
                    $eventi = $this->utente->getEventi($this->utente->getId());
                    $this->inviaEventiPersonali($eventi);
                } catch (dbException $e) {
                    echo "C'è stato un errore. Riprova :)";
                }
                break;

            case('getEventiConsigliati'):
                $this->getEventiConsigliatiMappa(
                        mysql_real_escape_string($_GET['neLat']),
                        mysql_real_escape_string($_GET['neLon']),
                        mysql_real_escape_string($_GET['swLat']),
                        mysql_real_escape_string($_GET['swLon'])
                );
                break;

            case('login'):
                if (!$this->utente && isset($_POST['username']) && isset($_POST["password"])) {
                    session_destroy();
                    $uname = mysql_real_escape_string($_POST['username']);
                    $pwd = mysql_real_escape_string($_POST['password']);
                    $login = new CRegistrazione($uname, $pwd);
                    $login->logIn();
                    if ($login->isLogged()) {
                        $this->utente = $u->load($uname);
                        $this->utente->setNumEventi();
                    }
                }
                if ($this->utente) {
                    $view->isAutenticato(true);
                    $view->showUser($this->utente->getUsername());
                    if (!$this->utente->isSbloccato())
                        $view->blocca();
                }else
                    $view->isAutenticato(false);


                $view->mostraPagina();

                break;

            case('logout'):
                session_unset();
                session_destroy();
                $view->isAutenticato(false);
                $view->mostraPagina();
                break;

            case('getUtente'):
                $this->getUtente();
                break;

            case('reg'):
                if (!$this->utente && isset($_POST['username']) && isset($_POST["password"]) && isset($_POST['password1'])
                        && isset($_POST["citta"]) && isset($_POST["mail"])) {
                    $uname = mysql_real_escape_string($_POST['username']);
                    $pwd = mysql_real_escape_string($_POST['password']);
                    $pwd1 = mysql_real_escape_string($_POST['password1']);
                    $citta = mysql_real_escape_string($_POST['citta']);
                    $mail = mysql_real_escape_string($_POST['mail']);
                    if ($pwd == $pwd1) {
                        $registra = new CRegistrazione($uname, $pwd, $citta, $mail);
                        session_destroy();
                        $result = $registra->regUtente();
                        if ($result[0]) {
                            $this->utente = $result[1];
                            //$this->utente->setNumEventi();
                        }
                    }
                }
                if ($this->utente) {
                    $view->isAutenticato(true);
                    $view->showUser($this->utente->getUsername());
                    if (!$this->utente->isSbloccato())
                    //cambia il link a home.php
                        $view->blocca();
                }
                else
                    $view->isAutenticato(false);

                $view->mostraPagina();


                break;

            case('confirm'):
                if (isset($_GET['id'])) {
                    if ($this->confirmReg($_GET['id]'])) {
                        //tpl di conferma
                    } else {
                        //tpl di errore
                    }
                    $view->mostraPagina();
                }

            default:
                if ($this->utente) {
                    $view->isAutenticato(true);
                    $view->showUser($this->utente->getUsername());
                    if (!$this->utente->isSbloccato())
                        $view->blocca();
                }else
                    $view->isAutenticato(false);

                $view->mostraPagina();
                break;
        }
    }

    public function getUtente() {
        $out = array('logged' => false);
        if ($this->utente) {
            $out['logged'] = true;
            $out['username'] = $this->utente->getUsername();
            $out['nome'] = $this->utente->getNome();
            $out['cognome'] = $this->utente->getCognome();
            $out['citta'] = $this->utente->getCitta();
        }
        echo json_encode($out);
    }

    /*
     * Crea un JSON contenente gli eventi restituiti da
     * FEvento::searchEventiMappa().
     */

    public function getEventiMappa($neLat, $neLon, $swLat, $swLon) {
        $ev = new FEvento();
        $ev->connect();
        $ev_array = $ev->searchEventiMappa($neLat, $neLon, $swLat, $swLon);
        echo json_encode($ev_array);
        exit;
    }

    public function getEventiConsigliatiMappa($neLat, $neLon, $swLat, $swLon) {
        $ev = new FEvento();
        $ev->connect();
        $ev_array = $ev->getEventiConsigliati($this->utente->getId(), $neLat, $neLon, $swLat, $swLon);
        $out = array(
        'total' => count($ev_array),
        'eventi' => $ev_array
        );
        echo json_encode($out);
        exit;
    }

    public function getEventiPreferiti($fornisciTutti=false) {
        $ev = new FEvento();
        $ev->connect();
        $ev_array = $ev->getEventiPreferiti($this->utente->getId());
        $out = array(
            'total' => ($fornisciTutti)? count($ev_array) : '3' ,
            'eventi' =>  $ev_array
        );
        echo json_encode($out);
        exit;
    }

    public function confirmReg($uid) {

        $u = new FUtente();
        $u->connect();
        $result = $u->userConfirmation($uid);
        return $result[0];
    }

    public function inviaEventiPersonali($eventi) {

        $out = array(
            'total' => count($eventi),
            'eventi' => $eventi
        );
        echo json_encode($out);
        exit;
    }

}

session_start();
$home = new CHome();
?>
