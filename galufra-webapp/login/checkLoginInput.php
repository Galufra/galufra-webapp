<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include ("controller/mysqlController.php");

 $db = new mysqlController();

 $result = $db->connect();
 if($result[0]==false){

     echo ("Error in ".$result[1]);
     /*$mex = urlencode('wrong user or password!');
       header("location: $_SERVER[PHP_SELF]?msg=$mex");*/
     exit;
 }

 $uname = trim($_POST['username']);
 $pwd = trim($_POST['password']);

 if (get_magic_quotes_gpc ()){

     $uname = stripslashes($uname);
     $pwd = stripslashes($pwd);

 }

 $uname = mysql_real_escape_string($uname);
 $pwd = mysql_real_escape_string($pwd);

 $query = $db->makeQuery("SELECT id FROM utenti WHERE user='$uname' AND password=MD5('$pwd')");

 if( !$query[0] ){

     echo ("Error in ".$query[1]);
     /*$mex = urlencode('wrong user or password!');
       header("location: $_SERVER[PHP_SELF]?msg=$mex");*/
     exit;
 }

 $result = mysql_fetch_array($query[1]);

 /*session start ...*/

?>
