<?php

// Error Reporting Konfigurieren
define( 'ERROR_LEVEL', E_ALL ^ E_NOTICE);
error_reporting(ERROR_LEVEL);

@ini_set( 'display_errors', 1 );
@ini_set( 'register_globals', 'off' );

function errorExceptionHandler($errno, $errstr, $errfile, $errline) {
	if( $errno & ERROR_LEVEL )
		throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}

set_error_handler('errorExceptionHandler');

define('ROOT', __DIR__.'/..' );
header( 'Content-Type: text/html; charset=UTF-8' );

require ROOT.'/vendor/autoload.php';
