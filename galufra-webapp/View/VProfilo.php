<?php
/**
 * @package Galufra
 */

require_once 'View.php';

/**
 * View che gestisce la pagina di profilo
 */
class VProfilo extends View {

    public $scripts = null;
    public $content = null;

    /**
     * @access public
     *
     * Assegna le variabili per mostrare il profilo. Le variabili diverse dal solito sono:
     *
     *  -$reader: indica se l' utente è solo un lettore del profilo o ne è anche il possessore
     *  -$utenteV: indica l'utente che si vuole visionare senza poterlo modificare
     *
     * @param EUtente $utente
     * @param EUtente $utenteV
     * @param boolean $reader
     * @param FILE $tpl
     * @param FILE $scripts
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
