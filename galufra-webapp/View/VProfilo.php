<?php

require_once 'View.php';

class VProfilo extends View {

    public $scripts = null;
    public $content = null;

    public function __construct($utente = null,$reader = true,$tpl = 'profilo.tpl',$scripts = array ('anytime.c.js','CProfilo.js')) {
        $this->content = $tpl;
        $this->scripts = $scripts;
        $this->assignByRef("utente", $utente);
        $this->assign("reader",$reader);
        parent::__construct();

    }
    
	
}
