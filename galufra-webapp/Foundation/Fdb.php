<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

interface Fdb {

    public function connect();
    public function makeQuery($query);
    public function close();

}


?>
