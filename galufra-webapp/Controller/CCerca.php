<?php
require_once '../Foundation/FUtente.php';
require_once '../Entity/EUtente.php';
require_once '../Foundation/FEvento.php';
require_once '../Entity/EEvento.php';
require_once '../View/VCerca.php';


class CCerca{
    private $utente = null;
    private $view = null;
    
    public function __construct(){
        session_start();
        if(isset($_SESSION['username'])) {
            $user = new FUtente();
            $user->connect();
            $this->utente = $user->load($_SESSION['username']);
            /* Se non vengono passati i dati, visualizza la schermata di ricerca
             */
            if(!isset($_GET['nome'])){
                $this->view = new VCerca($this->utente);
                $this->view->mostraPagina();
            }
            /* Risultati di ricerca
             */
            else {
                $e = new FEvento();
                $e->connect();
                $eventi = $e->searchEventiNome($_GET['nome']);
                $this->view = new VCerca($this->utente, $eventi);
                if (!$eventi)
                    $this->view->assign('noresult', true);
                $this->view->mostraPagina();
            }
        }
        else{
            header('location: CHome.php');
        }
    }
    
}

$c = new CCerca();

?>
