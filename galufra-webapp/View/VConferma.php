<?php

require_once 'View.php';

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