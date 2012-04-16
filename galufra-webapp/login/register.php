<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'controller/regController.php';

if(isset($_POST['action']) AND $_POST['action']=='send'){

    $reg = new regController();

    $uname = trim($_POST['uname']);
    $pwd = trim($_POST['pwd']);
    $name = trim($_POST['name']);
    $surname = trim($_POST['sname']);
    $city = trim($_POST['city']);
    if( $reg->validateEmail($_POST['email']) )
        $email=$_POST['email'];
    else die("Invalid email!");

    if (get_magic_quotes_gpc ()) {

        $uname = stripslashes($uname);
        $pwd = stripslashes($pwd);
        $name = stripslashes($name);
        $surname = stripslashes($surname);
        $city = stripslashes($city);
    }

    $uname = mysql_real_escape_string($uname);
    $pwd = mysql_real_escape_string($pwd);
    $name = mysql_real_escape_string($name);
    $surname = mysql_real_escape_string($surname);
    $city = mysql_real_escape_string($city);

    $status = $reg->register($_POST);

    switch ($status) {

        case REG_FAILED:
            die("Registration Failed. Please try again!");
            break;
        case REG_SUCCESS:
            echo("Registration Completed!\n An email has been sent to you for account validation\n");
            break;


    }

}else die ("error");



?>
