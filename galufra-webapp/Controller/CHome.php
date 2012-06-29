<?php
require_once('../Foundation/FUtente.php');
require_once('../Foundation/FEvento.php');
require_once('../Entity/EUtente.php');
require_once('../Entity/EEvento.php');
require_once('../View/VEventiXML.php');
require_once '../View/VHome.php';

class CHome{
private $utente;

public function __construct(){
    /* Caricamento dell'utente.
     */
    $u = new Futente();
    $u->connect();
    $l = $u->load('luca');
    $this->utente = $l[1][1];
    /* Se "action" non è impostato, eseguiremo il comportamento
     * di default nello switch successivo.
     */
    if(!isset($_GET['action']))
        $_GET['action'] = '';
    switch($_GET['action']){
        case('getEventiMappa'):
            $this->getEventiMappa(
				$_GET['neLat'], $_GET['neLon'],
				$_GET['swLat'], $_GET['swLon']
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
                if ($e->getMessage() == '1062')
                    echo "L'evento fa già parte dei tuoi preferiti!";
                else echo "C'è stato un errore. Riprova :)";
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
        case('getCitta'):
            echo $this->utente->getCitta();
            break;
        /* default: stampa la pagina
         */
        default: 
            $view = new VHome();
            $view->mostraPagina();
            break;
        }
    }
    public function getUtente(){
        return $this->utente;
    }
    /* 
     * Crea un XML contenente gli eventi restituiti da 
     * FEvento::searchEventi().
     */
    public function getEventiMappa($neLat, $neLon, $swLat, $swLon){
        $ev = new FEvento();
        $ev->connect();
        $ev_array = $ev->searchEventiMappa($neLat, $neLon, $swLat, $swLon);
        $View = new VEventiXML($ev_array[1][1]);
        exit;
    }
    public function getEventiPreferiti(){
        $ev = new FEvento();
        $ev->connect();
        $ev_array = $ev->getEventiPreferiti($this->utente->getId());
        $View = new VEventiXML($ev_array[1]);
        exit;
    }
}

$home= new CHome();
?>
