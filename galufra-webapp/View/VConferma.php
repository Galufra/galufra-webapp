<?php
/**
 * @package galufra
 */


require_once 'View.php';


/**
 * View per la gestione della pagina di conferma della registrazione
 */
class VConferma extends View {

    public $content = 'confermaRegistrazione.tpl';
    public $scripts = array('CConferma.js');

    /**
     * @access public
     */
    public function __construct() {
        parent::__construct();
    }

}

?>
