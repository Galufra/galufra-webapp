<?php
/**
 * @package Galufra
 */


require_once 'View.php';
require_once '../Entity/EUtente.php';
/**
 * View per la gestione della pagina della bacheca evento
 */

class VCerca extends View {

    public $content = 'cerca.tpl';
    public $eventi;
    public $utente;
    public $scripts = array();

    /**
     * @access public
     * @param array $ev_array
     * @param EUtente $ut
     */
    public function __construct($ut, $ev_array = null) {
        $this->eventi = $ev_array;
        $this->utente = $ut;
        $this->assignByRef("eventi", $this->eventi);
        $this->assignByRef("utente", $this->utente);
        parent::__construct();
    }

}

?>
