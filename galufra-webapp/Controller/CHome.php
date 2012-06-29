<?php
require_once('../Foundation/FUtente.php');
require_once('../Foundation/FEvento.php');
require_once('../Entity/EUtente.php');
require_once('../Entity/EEvento.php');
require_once('../View/VEventiXML.php');
require_once '../View/VHome.php';

class CHome{
private $utente;

/*
 * Scartabellando un po' in rete ho notato che il pattern Singleton 
 * è spesso sconsigliato per una serie di ragioni... Nel dubbio lascio
 * la classe nel suo stato precedente (non che faccia molta differenza,
 * allo stato attuale :) )
 */
//~ private static $_instance = null;
//~ public static function getInstance(){
    //~ if(self::$_instance == null){   
        //~ $c = __CLASS__;
        //~ self::$_instance = new $c;
    //~ }
    //~ return self::$_instance;
//~ }

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
            exit;
            break;
        case('addPreferiti'):
            try {
                $this->utente->addPreferiti($_GET['id_evento']);
                echo "L'evento è stato aggiunto ai tuoi preferiti.";
            } catch (dbException $e) {
                if ($e->getMessage() == '1062')
                    echo "L'evento fa già parte dei tuoi preferiti!";
                else echo "C'è stato un errore. Riprova :)";
            }
            exit;
            break;
        case('removePreferiti'):
            try {
                    $this->utente->removePreferiti($_GET['id_evento']);
                    echo "L'evento è stato rimosso dai tuoi preferiti.";
                } catch (dbException $e) {
                    echo "C'è stato un errore. Riprova :)";
                }
                exit;
            break;
        case('getCitta'):
            echo $this->utente->getCitta();
            exit;
            break;
        /* default: in futuro stamperà la pagina con una classe view VMap
         * Per ora un semplice break; ci porta fuori dallo switch
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

//~ $home= CHome::getInstance();

$home= new CHome();

/*
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="login.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAO2zXC0wh-S8SjMgPRZfoTUGZMGHBIzZ0&sensor=false"></script>
        <script type="text/javascript" src='../js/CHome.js'></script>

</script>
	</head>
	<body>
        <div id="box">
            <div id="boxl">
                <input type="text" class="ricerca" value="Cerca..." />
            </div>
            <div id="boxr">
                <button class="button" id="options">Username</button>
            </div>
        </div>
		<div id="map_canvas" style='height: 600px'></div>
	</body>
</html>
*/
?>
