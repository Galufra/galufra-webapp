<?php
/**
 * @package Galufra
 */

require_once 'View.php';

/**
 * View che gestisce la home page. Vedi View.php per analizzare
 * la maggior parte di variabili smarty
 */
class VHome extends View {
    
    public $content = 'home.tpl';
    public $scripts = array('CHome.js');

        public function __construct() {

        $this->pulsante_cerca = true;
        parent::__construct();
    }


}

?>
