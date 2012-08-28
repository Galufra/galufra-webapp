<?php

/**
 * @package Galufra
 */
/**
 * Effettuo il redirect a CHome.php
 */
if (file_exists("installer.class.php"))
    header("location: installer.class.php");
else
    header("location: Controller/CHome.php");
?>
