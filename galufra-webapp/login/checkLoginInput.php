<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include ("controller/mysqlController.php");

 $db = new mysqlController();

 $result = $db->connect();
 if($result[0]==false)
     echo ("Error in ".$result[1]);

 /*querying ...*/

?>
