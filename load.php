<?php

/** Define ABSPATH as this files directory */
define( 'ABSPATH', dirname(__FILE__) . '/' );

// begin the session
session_start();
/*
if ( defined('E_RECOVERABLE_ERROR') )
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR);
else
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING);
*/
error_reporting(E_ALL);
ini_set('display_errors', '1');


if ( file_exists( ABSPATH . 'config.php') ) {

	/** The config file resides in ABSPATH */
	require_once( ABSPATH . 'config.php' );
}






?>
