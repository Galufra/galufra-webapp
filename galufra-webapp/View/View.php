<?php

require_once '../libs/Smarty.class.php';
require_once '../includes/config.inc.php';

abstract class View extends Smarty {

    public $content = null;
    public $scripts = null;
    public $autenticato = false;
    public $user = null;
    public $sbloccato = true;
    public $confirmed = false;
    public $errore_loggato = false;
    public $errore_registrazione = false;
    public $superuser = false;

    /**
     * @access public
     * @global array $config
     */
    public function __construct() {
        parent::__construct();
        global $config;
        $this->template_dir = $config['smarty']['template_dir'];
        $this->compile_dir = $config['smarty']['compile_dir'];
        $this->config_dir = $config['smarty']['config_dir'];
        $this->cache_dir = $config['smarty']['cache_dir'];
        $this->caching = false;
    }

    /**
     * @access public
     * @param string $n
     *
     * Assegna il nome utente
     */
    public function showUser($n="anonimo") {

        $this->user = $n;
    }

    /**
     * @access public
     *
     * Farà mostrare un messaggio di errore di login
     */
    public function errorLogin() {

        $this->errore_loggato = true;
    }

    /**
     * @access public
     *
     * Farà mostrare un messaggio di errore di registrazione
     */
    public function errorRegistrazione(){
        
        $this->errore_registrazione = true;
    }

    /**
     * @access public
     *
     * Se non viene chiamato, farà mostrare il messaggio che richiede la conferma
     * della registrazione
     */
    public function regConfermata() {

        $this->confirmed = true;
    }

    /**
     * @access public
     *
     * Se non viene chiamato apparirà un link all'utente "Diventa Superuser"
     *
     */
    public function isSuperuser(){
        $this->superuser = true;
    }

    /**
     * @access public
     * @param boolean $b
     *
     * Dice al tpl che l'utente in questione è autenticato
     */
    public function isAutenticato($b) {

        $this->autenticato = $b;
    }

    /**
     * @access public
     *
     * Mostra il messaggio che indica il superamento del numero di eventi personali
     * massimi concessi dal sistema
     */
    public function blocca() {

        $this->sbloccato = false;
    }

    /**
     * @access public
     *
     * Mostra la pagina assegnando tutte le variabili
     *
     */
    public function mostraPagina() {
        if (!is_array($this->scripts) || is_null($this->content))
            throw new Exception('parametri non definiti');
        if (!$this->autenticato) {
            $this->assign('name', "anonimo");
            $this->assign('autenticato', false);
            $this->assign('sbloccato', $this->sbloccato);
            $this->assign('regConfirmed', $this->confirmed);
            $this->assign('errore_loggato', $this->errore_loggato);
            $this->assign('errore_registrazione',$this->errore_registrazione);
            $this->assign('superuser',$this->superuser);
        } else {
            $this->assign('errore_registrazione',$this->errore_registrazione);
            $this->assign('errore_loggato', $this->errore_loggato);
            $this->assign('name', $this->user);
            $this->assign('autenticato', $this->autenticato);
            $this->assign('sbloccato', $this->sbloccato);
            $this->assign('regConfirmed', $this->confirmed);
            $this->assign('superuser',$this->superuser);
        }
        $this->assign('scripts', $this->scripts);
        $this->assign('content', $this->content);
        $this->display('default.tpl');
    }

}

?>
