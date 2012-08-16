<?php

require_once 'View.php';

class VProfilo extends View {

    public $scripts = null;
    public $content = null;

    /**
     * @access public
     * @param EUtente $utente
     * @param EUtente $utenteV
     * @param boolean $reader
     * @param FILE $tpl
     * @param FILE $scripts
     *
     * Assegna le variabili per mostrare il profilo. Le variabili diverse dal solito sono:
     *
     *  -$reader: indica se l' utente è solo un lettore del profilo o ne è anche il possessore
     *  -$utenteV: indica l'utente che si vuole visionare senza poterlo modificare
     */
    public function __construct($utente = null,$utenteV=null,$reader = true,$tpl = 'profilo.tpl',$scripts = array ('anytime.c.js','CProfilo.js')) {
        $this->content = $tpl;
        $this->scripts = $scripts;
        $this->assignByRef("utente", $utente);
        $this->assignByRef("utenteV",$utenteV);
        $this->assign("reader",$reader);
        parent::__construct();

    }
    
	
}
?>