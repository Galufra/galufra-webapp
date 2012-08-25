<?php
/**
 * @package Galufra
 *
 */


require_once 'View.php';

/**
 * View per la gestione degli eventi
 */
class VEvento extends View {
    public $content = 'evento.tpl';
    public $scripts = array('CEvento.js');

    /**
     * @access public
     * @param EEvento $ev
     */
    public function __construct($ev){
        parent::__construct();
        $this->assign('evento',$ev);
        $data = 'aaa';
        $this->assign('data', $data);
    }
}

?>
