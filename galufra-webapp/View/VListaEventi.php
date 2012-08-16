<?php
require_once 'View.php';

class VListaEventi extends View {

    public $scripts = null;
    public $content = 'listaEventi.tpl';

    /**
     * @access public
     * @param FILE $script
     *
     * Assegna lo script che si occupa della particolare lista di eventi
     * che vogliamo mostrare: preferiti,consigliati,personali
     */
    public function __construct($scripts) {
       
        $this->scripts = $scripts;
        parent::__construct();
    }

}
?>
