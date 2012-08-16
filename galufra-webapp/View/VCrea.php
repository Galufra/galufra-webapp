<?php

require_once 'View.php';

class VCrea extends View {

    public $scripts = null;
    public $content = null;
    
    /**
     * @access public
     * @param FILE $tpl
     * @param FILE $scripts
     *
     * permetto di cambiare il tpl per reindirizzare la pagina alla home page una volta costruito l'evento
     *
     */
    public function __construct($tpl = 'crea.tpl',$scripts = array ('anytime.c.js', 'CCrea.js')) {
        $this->content = $tpl;
        $this->scripts = $scripts;
        parent::__construct();
    }

}

?>
