<?php


const BECHO_RAW = 1;
const BECHO_CLI = 2;

const BECHO_ESC_HTML = 10;
const BECHO_ESC_ATTR = 11;
const BECHO_ESC_URL = 12;
const BECHO_ESC_JS = 13;


const BECHO_RED = 31;
const BECHO_GREEN = 32;
const BECHO_YELLOW = 33;

/**
 * If you want to include this lib in a package without composer
 * such as your own plugin/module this will require the classes 
 * you need
 */
function ensureBechoClasses() 
{
    if (!class_exists("\\Becho\\Becho")) {
        require 'Becho/Echoer.php';
        require 'Becho/StandardEchoer.php';
        require 'Becho/Becho.php';
    }
}

/**
 * It is easier to override functions this way
 */ 
if (!function_exists('becho')) {
    
    // Ensure our classes are loaded
    ensureBechoClasses();
    
    /**
     * A better echo?
     */ 
    function becho($text, $ctx=\BECHO_RAW, $options=[])
    {
        $becho = \Becho\Becho::getInstance();
        return call_user_func_array([$becho, 'echo'], func_get_args());
    }
}
