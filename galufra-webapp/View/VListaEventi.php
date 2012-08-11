<?php
require_once 'View.php';

class VListaEventi extends View {

    public $scripts = null;
    public $content = 'listaEventi.tpl';

    //permetto di cambiare il tpl per reindirizzare la pagina alla home page una volta costruito l'evento
    public function __construct($scripts) {
       
        $this->scripts = $scripts;
        parent::__construct();
    }

}
?>
