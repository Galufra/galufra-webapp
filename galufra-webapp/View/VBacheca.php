<?php
/**
 * @package Galufra
 */


require_once 'View.php';
require_once '../Entity/EEvento.php';

/**
 * View per la gestione della pagina della bacheca evento
 */

class VBacheca extends View {

    public $content = 'bacheca.tpl';
    public $scripts = array('CBacheca.js');
    public $evento;
    public $utente;

    /**
     * @access public
     * @param EEvento $ev
     * @param EUtente $ut
     * @param int $partecipanti
     */
    public function __construct($ev,$ut,$partecipanti) {
        $this->evento = $ev;
        $this->utente = $ut;
        $this->assignByRef("evento", $this->evento);
        $this->assignByRef("utente", $this->utente);
        $data = new DateTime($this->evento->getData());
        $this->assign("data",$data->format('d-m-Y H:i'));
        $this->assign("partecipanti",$partecipanti);
        parent::__construct();
    }

}

?>
