<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'kevinqiu_wrdp6');


/** MySQL database username */
define('DB_USER', 'kevinqiu_wrdp6');


/** MySQL database password */
define('DB_PASSWORD', 'FHXB6Jc76z8p9qVq');


/** MySQL hostname */
define('DB_HOST', 'localhost');


/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');


/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '=A_C=i6VBA_svi{-<Htk$tkJ4D6g_tU>W]SM[p(nnsJ_n[]]F h*N)+s}=$>{nBm');

define('SECURE_AUTH_KEY',  '+6XSK _=2!F[s&1^58n~G?*V[]@q-pnd^^^ZZd~Sb2lDlEN*KLgQ>bJGt?[up.{&');

define('LOGGED_IN_KEY',    'rmojKMCZOmCI-;$zN]mss4+1g=K6Lx&bO0ZPlMj(rx/6t;+-.+_[mUi^Y5|blLB>');

define('NONCE_KEY',        'a4@X-sIYm(PF|]REK5pw^?x!+pF4/^>Z(s`qlT*w%-MO8.ov=~d<&w5x)ID6)m#^');

define('AUTH_SALT',        'ZrPDL+>Xe~V)i{)lva#4W?H0LmQK.UjoV|m:u5H-|hbN>VeC}NssWh|F]%q 3R>+');

define('SECURE_AUTH_SALT', '(*W@@|nl2[1<:Y?/Iz+Onk&}Ty^N`Kw|An4QbT-}C.OV6F-^~Lgi8T_om.&]W^|*');

define('LOGGED_IN_SALT',   'V.;K|_)O}}a}yZax[6(EN37.$y,l-R-LEglDS>6Pp+UdX4tx;=isJDf?>CA`1eR`');

define('NONCE_SALT',       'R( PxI@{t7YV5*4vypUh4_1^A.[I`e{^a[,p/:e]hCcg AYfu[6}YOS$XHK4ZvPp');


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';


/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
