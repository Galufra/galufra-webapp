<?php
require_once('../Foundation/FUtente.php');
require_once('../Foundation/FEvento.php');
require_once('../Entity/EUtente.php');
require_once('../Entity/EEvento.php');
require_once '../View/VHome.php';

class CHome{
private $utente;

public function __construct(){
    /* Caricamento dell'utente.
     */
    $u = new Futente();
    $u->connect();
    $this->utente = $u->load('luca');
    /* Se "action" non è impostato, eseguiremo il comportamento
     * di default nello switch successivo.
     */
    if(!isset($_GET['action']))
        $_GET['action'] = '';
    switch($_GET['action']){
        case('getEventiMappa'):
            $this->getEventiMappa(
				mysql_real_escape_string($_GET['neLat']),
                mysql_real_escape_string($_GET['neLon']),
				mysql_real_escape_string($_GET['swLat']),
                mysql_real_escape_string( $_GET['swLon'])
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
        case('getUtente'):
            $this->getUtente();
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
        $out = array('logged' => false);
        if($this->utente){
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
    public function getEventiMappa($neLat, $neLon, $swLat, $swLon){
        $ev = new FEvento();
        $ev->connect();
        $ev_array = $ev->searchEventiMappa($neLat, $neLon, $swLat, $swLon);
        echo json_encode($ev_array);
        exit;
    }
    public function getEventiPreferiti(){
        $ev = new FEvento();
        $ev->connect();
        $ev_array = $ev->getEventiPreferiti($this->utente->getId());
        $out = array(
                'total' => count($ev_array),
                'eventi' => $ev_array
        );
        echo json_encode($out);
        exit;
    }
}

$home= new CHome();
?>
