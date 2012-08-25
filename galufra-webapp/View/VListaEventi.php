<?php
/**
 * @package Galufra
 */

require_once 'View.php';

/**
 * View che gestisce le liste di eventi consigliati,preferiti e personali
 */
class VListaEventi extends View {

    public $scripts = null;
    public $content = 'listaEventi.tpl';

    /**
     * @access public
     *
     * Assegna lo script che si occupa della particolare lista di eventi
     * che vogliamo mostrare: preferiti,consigliati,personali
     *
     * @param FILE $script
     */
    public function __construct($scripts) {
       
        $this->scripts = $scripts;
        parent::__construct();
    }

}
?>
