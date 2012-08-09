<?php

require_once 'View.php';
require_once '../Entity/EEvento.php';

class VBacheca extends View {

    public $content = 'bacheca.tpl';
    public $scripts = array('CBacheca.js');
    public $evento;

    public function __construct($ev) {
        $this->evento = $ev;
        $this->assignByRef("evento", $this->evento);
        parent::__construct();
    }

}

?>
