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
define('DB_NAME', 'teardown-tattler');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'Q9Q0V/eMY.gJ-mswD+.Awv)@wmi4=-Un/Fw}gj}HHN*Gp?/bEb/Jek*uZe9{)_;5');
define('SECURE_AUTH_KEY',  'QXxH%VFS85fItM_{!% -N3Chc>sFSWqlx?+v>jqQKtDD4)GUV7|~DSyC_p+%9wnz');
define('LOGGED_IN_KEY',    '|s#^iT7)T|9#;oaKXg]Z</$3g$~0Z^UL%3)/tNV-MGRhnn;n,`6AJFDBm0@_^6y0');
define('NONCE_KEY',        '?iY]m9UG)X3r{-n0Z =Z2DxV=nB]Hc7D~KX fV_P+9kIl=GgdV2fc!UZP1z*bZnE');
define('AUTH_SALT',        '8=~a5gO|X-!g=I<h@ilB7))SGja/yy`n+`%Sly1:&-)2K+h@8(9AgeoFR;~-99`h');
define('SECURE_AUTH_SALT', '?C,{s8c3|c7q9_W[fl}QVxL=i}N)9uC[AAiU2u.6.4~irl+Q8?Agm]~w#uO 4jD4');
define('LOGGED_IN_SALT',   '90N,n>#?|0`)0^|0?S?#s4Pp}|SI-u[5+}#UVCQW!i)@-v/8W;@<K0gB:I]5.U}G');
define('NONCE_SALT',       'Q?E-?Mh#p^PF1S_&Pp-+>~4%c:A+63GsoO{z/@~7$1`FQ-;%4X1Jb<p0t$![,es-');

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
define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
//require_once(ABSPATH . 'wp-settings.php');
