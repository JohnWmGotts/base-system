<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */

		$http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https' : 'http'; 
		define('SITE_URL',$http.'://crowdedrocket.com/');
		define('DB_NAME', 'crowdedrockwp');
		define('DB_USER', 'crowdedrockwp');
		define('DB_PASSWORD', 'A1nDj2Jj3!');
		define('DB_HOST', 'crowdedrockwp.db.9407803.hostedresource.com'); 	// was localhost at chumly.biz. tbd at aws.
		//define('DIR_FS',$_SERVER['DOCUMENT_ROOT'].'/');
		define('DIR_FS',$_SERVER['DOCUMENT_ROOT'].'/crowdedrocket/');	
		define('DIR_INC',DIR_FS.'includes/');
		define('DIR_FUN',DIR_INC.'functions/');		
		define('SITE_DB_HOST', "crowdedrocket.db.9407803.hostedresource.com");
		define('SITE_DB_NAME', "crowdedrocket");		
		define('SITE_DB_USER', "crowdedrocket");
		define('SITE_DB_PASS', "A1nDj2Jj3!");

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');


define('SITE_MOD',SITE_URL.'modules/');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ',ww?K%38N|4[^92pfz! QdkL$~kG,&#)ut.jz}7Qyl4LP-1kbEUX-|@4SJp5{+02');
define('SECURE_AUTH_KEY',  '~)N9^ftoB|pO%{u*l>?3B2XL>eG!%^9Fq[0~2JVn|xI4rK?9.mB]|CJxyfQi+]~J');
define('LOGGED_IN_KEY',    '9qLSJ?I^cJ$B2dE/R*6h,jd8Cg^v$NLS;NAlA4tgm|!:m5ZlmVnG|aT:2J?;pO97');
define('NONCE_KEY',        ']-qfh*Nn~Hzn>5kvDf|[Q{K]oesdrayq-q 75-q8x+p%wal}V5 2%a+;J`;hY@#E');
define('AUTH_SALT',        '3w,H|44%|Lv:aeno?*(GiY_^(X*${A hf:~y{lSJ/|5|@>dl2IwUU#+SHxlW!=N`');
define('SECURE_AUTH_SALT', '|nuR?&fp{OL3`Gd%|nQ[KiKs=wE.t/P<$|<<fB%NQ;AM7&#X_?ZMOB-Dp^3yDXzd');
define('LOGGED_IN_SALT',   '2SFg-+c#h|xQG!Qrt0W0[Ei(vDypsZY++fGU}&r*=&w]gm-aE?HNx,-|dB;v8#6i');
define('NONCE_SALT',       'Sm#>t~}sH5+AYX}EwJXQ==n4$pY:2`/Opc^ 0=JpR9@!5:KsDcf8Gmk~iN[8e|Zt');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
