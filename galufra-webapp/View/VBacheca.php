<?php

require_once 'View.php';
require_once '../Entity/EEvento.php';

class VBacheca extends View {

    public $content = 'bacheca.tpl';
    public $scripts = array('CBacheca.js');
    public $evento;
    public $utente;

    public function __construct($ev,$ut,$partecipanti) {
        $this->evento = $ev;
        $this->utente = $ut;
        $this->assignByRef("evento", $this->evento);
        $this->assignByRef("utente", $this->utente);
        $this->assign("partecipanti",$partecipanti);
        parent::__construct();
    }

}

?>
