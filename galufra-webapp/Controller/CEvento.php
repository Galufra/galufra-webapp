<?php

include '../Foundation/FEvento.php';
include '../Foundation/FUtente.php';
include '../Entity/EEvento.php';
include '../Entity/EUtente.php';
include '../View/VEvento.php';

class CEvento {

    private $evento;
    private $utente;

    /**
     * @access public
     *
     *
     * @param int $id
     *
     * Una volta caricati i dati di sessione attraverso uno
     * switch gestiscele varie operazioni da svolgere sull' evento nella mappa.
     * Si utilizza in alcuni casi json per ritornare dati al client
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
        if ($id)
            $this->evento = $ev->load($id);
        // Id non fornito o non valido: messaggio di errore
        if (!$id || !$this->evento)
            echo 'Errore...';
        else {
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
                        $this->utente->removePreferiti($this->evento->id_evento);
                        echo "L'evento è stato rimosso dai tuoi preferiti.";
                    } catch (dbException $e) {
                        echo "C'è stato un errore. Riprova :)";
                    }
                    break;
                case('addConsigliati'):
                    try {
                        $this->utente->addConsigliati($this->evento->id_evento, $this->evento->getLat(), $this->evento->getLon());
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
