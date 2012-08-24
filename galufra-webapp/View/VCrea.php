<?php

require_once 'View.php';

class VCrea extends View {

    public $scripts = null;
    public $content = null;
    
    /**
     * @access public
     *
     * permetto di cambiare il tpl per reindirizzare la pagina alla home page una volta costruito l'evento
     *
     * @param FILE $tpl
     * @param FILE $scripts
     *
     */
    public function __construct($tpl = 'crea.tpl',$scripts = array ('anytime.c.js', 'CCrea.js')) {
        $this->content = $tpl;
        $this->scripts = $scripts;
        parent::__construct();
    }

}

?>
