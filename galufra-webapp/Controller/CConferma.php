<?php


require_once '../Foundation/FUtente.php';
require_once '../Foundation/FEvento.php';
require_once '../Entity/EUtente.php';
require_once '../View/VConferma.php';
require_once '../View/VHome.php';


class CConferma {

    private $utente = null;
	
	/** 
	 * @access public
	 *
	 *
	 * una volta controllati i dati di sessione attraverso uno switch,
	 * smista le azioni del controller, in questo caso una sola:
	 * la conferma della registrazione
	 */
    public function __construct() {

        $u = new FUtente();
        $u->connect();

        if (isset($_SESSION['username'])) {
            $this->utente = $u->load($_SESSION['username']);
            //carico il numero dell' utente
            $this->utente->setNumEventi($this->utente->isAdmin(), $this->utente->isSuperuser());
        }

        if (!isset($_GET['action']))
            $_GET['action'] = null;

        switch ($_GET['action']) {

            case ('conferma'):
                if ($this->confermaReg()) {
                    //stampo la pagina di conferma registrazione avvenuta
                    $view = new VConferma ();
                    $view->regConfermata();
                    if ($this->utente) {
                        $view->isAutenticato(true);
                        $view->showUser($this->utente->getUsername());
                        if ($this->utente->isConfirmed())
                            $view->regConfermata();
                        if ($this->utente->isSuperuser())
                            $view->isSuperuser();
                    }
                    $view->mostraPagina();
                } else {
                    //altrimenti stampo la home page
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
                break;

            default:
                //se non c'è un action stampo la home
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
     * conferma la registrazione dell' utente
     *
     * @return boolean
     **/
    public function confermaReg() {

        if (isset($_GET['id'])) {
            $u = new FUtente();
            $u->connect();
            $result = $u->userConfirmation(mysql_escape_string($_GET['id']));
            return $result[0];
        } else {
            return false;
        }
    }

}

session_start();
$conferma = new CConferma();
?>
