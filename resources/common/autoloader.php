<?php

/*
This function loads classes automatically so they don't have to be included on every page.
The filename of the classes must be named the same as the classes themselves otherwise the autoloader will fail.
*/

spl_autoload_register('autoLoadClasses');

function autoLoadClasses($className) {
    $path = $_SERVER["DOCUMENT_ROOT"] .'/classes/';
    $extension = '.class.php';
    $fullPath = $path . $className . $extension;

    if(!file_exists($fullPath)) {
        return false;
    }

    include_once $fullPath;
}