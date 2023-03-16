<?php

    /*
        * Plugin Name: WooSales
    */


/*Require all action functions */
$files = glob( __DIR__ . '/functions/actions/*.php');
foreach ($files as $file) {
    require_once($file);   
}

//Requires
require_once("classes/tables/SalesTable.php");
require_once("const.php");
