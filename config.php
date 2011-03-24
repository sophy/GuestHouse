<?php
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for Shopping Cart */
define('DB_NAME', 'guest_house');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');



/** Base URL **/
define('BASE_URL', 'http://local.gh');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

//echo ABSPATH;

/** Sets up project vars and included files. */
require_once(ABSPATH . 'setting.php');

?>
