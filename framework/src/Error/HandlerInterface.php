<?php

namespace Ufo\Error;

/**
 *
 * @author gb-michel
 *        
 */
interface HandlerInterface
{
    /**
     * 
     * @param unknown $errno
     * @param unknown $errstr
     * @param unknown $errfile
     * @param unknown $errline
     */
    static public function devel($errno, $errstr, $errfile, $errline);
    
    
    /**
     * 
     * @param unknown $errno
     * @param unknown $errstr
     * @param unknown $errfile
     * @param unknown $errline
     */
    static public function prod($errno, $errstr, $errfile, $errline);
}

?>