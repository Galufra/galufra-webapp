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

    public function __construct() {
        parent::__construct();
        global $config;
        $this->template_dir = $config['smarty']['template_dir'];
        $this->compile_dir = $config['smarty']['compile_dir'];
        $this->config_dir = $config['smarty']['config_dir'];
        $this->cache_dir = $config['smarty']['cache_dir'];
        $this->caching = false;
    }

    public function showUser($n="anonimo") {

        $this->user = $n;
    }

    public function errorLogin() {

        $this->errore_loggato = true;
    }

    public function errorRegistrazione(){
        
        $this->errore_registrazione = true;
    }

    public function regConfermata() {

        $this->confirmed = true;
    }

    public function isSuperuser(){
        $this->superuser = true;
    }

    public function isAutenticato($b) {

        $this->autenticato = $b;
    }

    public function blocca() {

        $this->sbloccato = false;
    }

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
