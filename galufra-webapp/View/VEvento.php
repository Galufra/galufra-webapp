<?php
require_once 'View.php';
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
    }
}

?>
