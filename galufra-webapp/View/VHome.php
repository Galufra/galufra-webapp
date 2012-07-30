<?php
require_once 'View.php';
class VHome extends View {
    public $content = 'home.tpl';
    public $scripts = array('CHome.js');
    //public $autenticato = false;


    public function showUser($n){
        
        $this->assign("name",$n);
    }

    public function isAutenticato($b){

        $this->assign("autenticato",$b);
    }

}

?>
