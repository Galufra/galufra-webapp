<?php

/**
 * @package Galufra
 */
require_once '../Foundation/FUtente.php';
require_once('../Foundation/FEvento.php');
require_once('../Foundation/Utility/USession.php');
require_once('../Entity/EUtente.php');
require_once('../Entity/EEvento.php');
require_once '../View/VHome.php';
require_once 'CRegistrazione.php';

/**
 * Controller della home page. Gestisce tutte le funzionalità più
 * importanti dell'applicazione
 *
 */
class CHome {

    private $utente = null;

    /**
     * @access public
     *
     * Smista le operazioni più importanti dell' applicazione attraverso uno switch che prende come
     * parametro un dato passato via get.
     */
    public function __construct() {

        session_start();

        /* Caricamento dell'utente.
         */
        $u = new Futente();
        $u->connect();
        //elimino gli utenti non confermati
        $u->cleanExpired();

        if (isset($_SESSION["username"])) {
            $user = $_SESSION["username"];
            $this->utente = $u->load($user);

            //carico il num di eventi. la funzione blocca automaticamente l'utente se si accorge che gli eventi sono troppi
            if ($this->utente)
                $this->utente->setNumEventi($this->utente->isAdmin(), $this->utente->isSuperuser());
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
            case('getMaxConsigliati'):
                $this->getMaxConsigliati();
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
            /* Forniamo eventi preferiti e consigliati */
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
            /* facciamo il login */
            case('login'):

                if (!$this->utente && isset($_POST['username']) && isset($_POST["password"])) {
                    session_destroy();
                    $uname = mysql_real_escape_string(htmlspecialchars(($_POST['username'])));
                    $pwd = mysql_real_escape_string(htmlspecialchars(($_POST['password'])));
                    $login = new CRegistrazione($uname, $pwd);
                    $login->logIn();
                    if ($login->isLogged()) {
                        $this->utente = $u->load($uname);
                        //carico il numero di eventi dell'utente
                        $this->utente->setNumEventi();
                    }
                }
                //stampo la home
                if ($this->utente) {
                    $view->isAutenticato(true);
                    $view->showUser($this->utente->getUsername());
                    //blocco il messaggio di conferma registrazione e il link "diventa superuser"
                    if ($this->utente->isConfirmed())
                        $view->regConfermata();
                    if ($this->utente->isSuperuser())
                        $view->isSuperuser();
                }else {
                    //Errore di login
                    $view->isAutenticato(false);
                    $view->regConfermata();
                    $view->errorLogin();
                }


                $view->mostraPagina();

                break;

            case('logout'):
                session_unset();
                session_destroy();
                $view->isAutenticato(false);
                $view->regConfermata();
                $view->mostraPagina();
                break;

            case('getUtente'):
                $this->getUtente();
                break;

            case('recupera'):
                $this->recuperaPwd();
                break;

            case('uniqueUname'):
                $this->isUniqueUname();
                break;

            case('uniqueEmail'):
                $this->isUniqueEmail();
                break;

            case('reg'):
                //Gestisco la registrazione
                if (!$this->utente
                        && (isset($_POST["username"]) && $_POST["username"] != null)
                        && isset($_POST["password"]) && isset($_POST["password1"])
                        && (isset($_POST["citta"]) && $_POST["citta"] != null)
                        && (isset($_POST["mail"]) && $_POST["mail"] != null)) {

                    $uname = mysql_real_escape_string(htmlspecialchars($_POST['username']));
                    //è unico l'username?
                    if ($u->isUnique($uname)) {


                        $pwd = mysql_real_escape_string(htmlspecialchars($_POST['password']));
                        $pwd1 = mysql_real_escape_string(htmlspecialchars($_POST['password1']));
                        $citta = mysql_real_escape_string(htmlspecialchars($_POST['citta']));
                        $mail = mysql_real_escape_string(htmlspecialchars($_POST['mail']));
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
                }
                //stampo come prima home con o senza messaggio di errore
                if ($this->utente) {
                    $view->isAutenticato(true);
                    $view->showUser($this->utente->getUsername());
                    if ($this->utente->isConfirmed()) {
                        $view->regConfermata();
                    }
                    if ($this->utente->isSuperuser())
                        $view->isSuperuser();
                } else {
                    $view->isAutenticato(false);
                    $view->regConfermata();
                    $view->errorRegistrazione();
                }

                $view->mostraPagina();


                break;


            default:
                //il comportamento di default è la home page
                if ($this->utente) {
                    $view->isAutenticato(true);
                    $view->showUser($this->utente->getUsername());
                    if (!$this->utente->isSbloccato())
                        $view->blocca();
                    if ($this->utente->isConfirmed()) {
                        $view->regConfermata();
                    }
                    if ($this->utente->isSuperuser())
                        $view->isSuperuser();
                } else {

                    $view->isAutenticato(false);
                    $view->regConfermata();
                }

                $view->mostraPagina();
                break;
        }
    }

    /**
     * @access public
     *
     * Fornisce un Json con i dati dell'utente
     */
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

    /**
     *
     * @access public
     *
     *  Crea un JSON contenente gli eventi restituiti da
     * FEvento::searchEventiMappa() utilizzando le coordinate della mappa
     *
     * @param int $neLat
     * @param int $neLon
     * @param int $swLat
     * @param int $swLon
     *
     */
    public function getEventiMappa($neLat, $neLon, $swLat, $swLon) {
        $ev = new FEvento();
        $ev->connect();
        $ev_array = $ev->searchEventiMappa($neLat, $neLon, $swLat, $swLon);
        echo json_encode($ev_array);
        exit;
    }

    /**
     *
     * @Crea un JSON contenente gli eventi restituiti da
     * FEvento::getEventiConsigliati() utilizzando le coordinate della mappa.
     *
     * @access public
     * @param int $neLat
     * @param int $neLon
     * @param int $swLat
     * @param int $swLon
     *
     *
     */
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

    /**
     * Crea un JSON contenente gli eventi restituiti da
     * FEvento::getAllConsigliati() utilizzando le coordinate della mappa.
     *
     * @access public
     *
     */
    public function getMaxConsigliati() {

        $ev = new FEvento();
        $ev->connect();
        $ev_array = $ev->getAllConsigliati($this->utente->getId(), false);
        $out = array(
            'total' => count($ev_array),
            'eventi' => $ev_array
        );
        echo json_encode($out);
        exit;
    }

    /**
     *
     * Crea un JSON contenente gli eventi restituiti da
     * FEvento::getEventiPreferiti() utilizzando le coordinate della mappa
     *
     * @access public
     * @param Boolean $fornisciTutti
     *
     * 
     */
    public function getEventiPreferiti($fornisciTutti=false) {
        $ev = new FEvento();
        $ev->connect();
        $ev_array = $ev->getEventiPreferiti($this->utente->getId());
        $out = array(
            'total' => ($fornisciTutti) ? count($ev_array) : '3',
            'eventi' => $ev_array
        );
        echo json_encode($out);
        exit;
    }

    /**
     * Crea un JSON contenente gli eventi personali dell'utente
     *
     * @access public
     * @param EEvento $eventi
     *
     *
     */
    public function inviaEventiPersonali($eventi) {

        $out = array(
            'total' => count($eventi),
            'eventi' => $eventi
        );
        echo json_encode($out);
        exit;
    }

    /**
     * invia una nuova password all'utente. La funzione mail verrà
     * decommentata una volta che facciamo il deploy dell'applicazione
     *
     * @access public
     *
     *
     */
    public function recuperaPwd() {
        $status = false;
        if (!$this->utente && (isset($_GET['username']) && $_GET['username'] != null)) {
            $pwd = CRegistrazione::getUniqueId();
            $u = new FUtente();
            $u->connect();
            $user = $u->load($_GET['username']);
            if ($user != null) {
                //$user->setPassword($pwd);
                /* $status = mail($user->getEmail(), "Recupero password Galufra",
                  "Ciao ".$user->getUsername()."!!. La tua nuova password è $pwd .
                  Fai di nuovo il login e cambiala secondo le tue preferenze!","From: galufra@galufra.com");
                  if($status)
                  $u->update($user); */
                $status = true;
            }
        }
        $out = array(
            'inviata' => "$status"
        );
        echo json_encode($out);
        exit;
    }

    /**
     * Controlla se l'username è unico. Utilizzato lato client per controlli via javascript
     * Utilizza il metodo FUtente::isUnique($user)
     * 
     * @access public
     */
    public function isUniqueUname() {
        $result = true;
        if (isset($_GET['uname']) && $_GET['uname'] != null) {
            $u = new FUtente();
            $u->connect();
            $result = $u->isUnique(mysql_real_escape_string($_GET['uname']));
        }
        $out = array(
            'unique' => "$result"
        );
        echo json_encode($out);
        exit;
    }

    /**
     * Controlla se l'email è unica. Utilizzato lato client per controlli via javascript
     * Utilizza il metodo FUtente::isEmailUnique($email)
     *
     * @access public
     */
    public function isUniqueEmail() {
        $result = true;
        if (isset($_GET['email']) && $_GET['email'] != null) {
            $u = new FUtente();
            $u->connect();
            $result = $u->isEmailUnique(mysql_real_escape_string($_GET['email']));
        }
        $out = array(
            'unique' => "$result"
        );
        echo json_encode($out);
        exit;
    }
}

$home = new CHome();
?>
