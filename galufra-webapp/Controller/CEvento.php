<?php
/**
 * @package Galufra
 */


include '../Foundation/FEvento.php';
include '../Foundation/FUtente.php';
include '../Entity/EEvento.php';
include '../Entity/EUtente.php';
include '../View/VEvento.php';
include '../View/VHome.php';

/**
 * Controller per la gestione degli eventi
 */
class CEvento {

    private $evento;
    private $utente;

    /**
     * @access public
     *
     *
     * Una volta caricati i dati di sessione attraverso uno
     * switch gestiscele varie operazioni da svolgere sull' evento nella mappa.
     * Si utilizza in alcuni casi json per ritornare dati al client

     * @param int $id
     */
    public function __construct($id = null) {

        $u = new Futente();
        $u->connect();
        if (isset($_SESSION['username'])) {
            $this->utente = $u->load($_SESSION['username']);
            //carico il numero di eventi dell' utente
            $this->utente->setNumEventi($this->utente->isAdmin(), $this->utente->isSuperuser());
        }

        $ev = new FEvento();
        $ev->connect();
        //elimino gli eventi scaduti
        $ev->cleanExpiredEvent();
        if ($id)
            $this->evento = $ev->load($id);

        // Id non fornito o non valido: homepage
        if (!$id || !$this->evento) {
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
            exit;
        } else {
            //se non sono loggato va al comportamento di default
            if (!isset($_GET['action']) || !$this->utente)
                $_GET['action'] = '';
            switch ($_GET['action']) {
                case('getEvento'):
                    echo json_encode($this->evento);
                    break;
                case('isPreferito'):
                    $out = false;
                    $ev = new FEvento();
                    $ev->connect();
                    $ev_array = $ev->getEventiPreferiti($this->utente->getId());
                    if (is_array($ev_array))
                        foreach ($ev_array as $i) {
                            if ($i->id_evento == $this->evento->id_evento) {
                                $out = true;
                                break;
                            }
                        }
                    echo json_encode($out);
                    break;
                case('isConsigliato'):
                    $out = false;
                    $ev = new FEvento();
                    $ev->connect();
                    $ev_array = $ev->getAllConsigliati($this->utente->getId(), true);
                    if (is_array($ev_array))
                        foreach ($ev_array as $i) {
                            if ($i->id_evento == $this->evento->id_evento) {
                                $out = true;
                                break;
                            }
                        }
                    echo json_encode($out);
                    break;

                case('addPreferiti'):
                    try {
                        $this->utente->addPreferiti($this->evento->id_evento);
                        echo "evento aggiunto ai tuoi preferiti.";
                    } catch (dbException $e) {
                        // 1062 = esiste già una tupla con gli stessi id
                        if ($e->getMessage() == '1062')
                            echo "evento già tra i tuoi preferiti!";
                        else
                            echo "C'è stato un errore. Riprova :)";
                    }
                    break;
                case('removePreferiti'):
                    try {
                        $this->utente->removePreferiti($this->evento->id_evento);
                        echo "evento rimosso dai preferiti.";
                    } catch (dbException $e) {
                        echo "C'è stato un errore. Riprova :)";
                    }
                    break;
                case('addConsigliati'):
                    try {
                        $this->utente->addConsigliati($this->evento->id_evento);
                        echo "Hai consigliato l' evento agli utenti";
                    } catch (dbException $e) {
                        echo "C'è stato un errore. Riprova :)";
                    }
                    break;
                case('removeConsigliati'):
                    try {
                        $this->utente->removeConsigliati($this->evento->id_evento);
                        echo "Hai tolto il tuo consiglio!";
                    } catch (dbException $e) {
                        echo "C'è stato un errore. Riprova :)";
                    }
                    break;
                default:
                    $view = new VEvento($this->evento);
                    $view->regConfermata();
                    $view->mostraPagina();
                    break;
            }
        }
    }

}

if (!isset($_GET['id']))
    $_GET['id'] = null;

session_start();
$CEvento = new CEvento(htmlspecialchars($_GET['id']));
?>
