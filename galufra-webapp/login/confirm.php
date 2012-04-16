<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('controller/regController.php');

$reg = new regController();

if (isset($_GET['id']) AND strlen($_GET['id']) == 32) {
    
    $reg->cleanExpired();
    $result = $reg->Confirm($_GET['id']);


    switch ($status) {

        case REG_SUCCESS:
            echo "Thank you! Your registration has been confirmed!";
            break;
        case REG_FAILED:
            echo "Attention! Your registration has been expired!";
            break;
    }
}else

    echo "Error! Maybe your link is corrupted!"
?>
