<?php
require_once 'View.php';
class VHome extends View {
    public function mostraPagina(){
        $this->display('home.tpl');
    }
}

?>
