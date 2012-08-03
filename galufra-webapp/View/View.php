<?php

require_once '../libs/Smarty.class.php';
require_once '../includes/config.inc.php';

abstract class View extends Smarty {

    public $content = null;
    public $scripts = null;
    public $autenticato = false;
    public $user = null;
    public $sbloccato = true;

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

    public function isAutenticato($b) {

        $this->autenticato = $b;
    }

    public function blocca() {

        $this->sbloccato=false;

    }
    
    public function mostraPagina() {
        if (!is_array($this->scripts) || is_null($this->content))
            throw new Exception('parametri non definiti');
        if (!$this->autenticato) {
            $this->assign('name', "anonimo");
            $this->assign('autenticato', false);
            $this->assign('sbloccato',$this->sbloccato);
        } else {

            $this->assign('name', $this->user);
            $this->assign('autenticato', $this->autenticato);
            $this->assign('sbloccato',  $this->sbloccato);
        }
        $this->assign('scripts', $this->scripts);
        $this->assign('content', $this->content);
        $this->display('default.tpl');
    }

}

?>
