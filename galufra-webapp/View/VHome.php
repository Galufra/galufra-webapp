<?php
require_once 'View.php';
class VHome extends View {
    
    public $content = 'home.tpl';
    public $scripts = array('CHome.js');

        public function __construct() {

        $this->pulsante_cerca = true;
        parent::__construct();
    }


}

?>
