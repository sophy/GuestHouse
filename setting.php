<?php
require_once(ABSPATH.'includes/functions.php');

require_once(ABSPATH .'includes/ez/shared/ez_sql_core.php'); //import ez_sql_core.php for sql library
require_once(ABSPATH .'includes/ez/ez_sql_mysql.php'); //import ez_sql_mysql.php for mysql library

$dbgh = new ezSQL_mysql(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST); // create $db object of ezSQL_mysql and connect to database
$dbgh->query('SET NAMES '. DB_CHARSET);

/** Pagination Class **/
require_once(ABSPATH .'includes/paginator.class.php');
//create paginator object and generate pagination
$pages = new Paginator; //create paginator object

?>
