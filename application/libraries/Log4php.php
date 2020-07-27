<?php
/*
* Created on 16/05/2010
*
* To change the template for this generated file go to
* Window - Preferences - PHPeclipse - PHP - Code Templates
*/


include_once('apache-log4php-2.0.0-incubating/src/main/php/Logger.php');
Logger::configure('log4php.properties');


class Log4php {

    function Log4php(){
        
        $logger = Logger::getLogger("Log4php");
        //$logger->info("llamado a Log4php");        
        
    }
} 


?>;
