<?php
/**
 * @package Galufra
 */



/*
 * pattern per creare foundation a seconda della tecnologia
 * che si vuole utilizzare
 *
 */

interface FDb {

    public function connect();
    public function makeQuery($query);
    public function close();

}


?>
