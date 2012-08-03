<?php

require_once 'View.php';

class VCrea extends View {

    public $scripts = null;
    public $content = null;

    public function __construct($tpl = 'crea.tpl',$scripts = array ('anytime.c.js', 'CCrea.js')) {
        $this->content = $tpl;
        $this->scripts = $scripts;
        parent::__construct();
    }

}

?>
