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
define('DB_NAME', 'aok');

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
define('AUTH_KEY',         '/`KVwQdQ329o4+>,_EU3ER~S&szgvFi?l[J.c?%+T]p0A1h2EO-9p@KHe8EP@|qa');
define('SECURE_AUTH_KEY',  '{I(>hH#qNx:-H60jCG4m75Mnc>.UT(Ho?|BlaQ!GClf&+|{!@?(3qGw3Rrz?4=Y ');
define('LOGGED_IN_KEY',    'FZ{|N*4X2}a:rquOE|9|]G54$[&Dc!E>-~N-6UsR$2su4+n84-C-cWai>@M.+z~&');
define('NONCE_KEY',        'o+{w[W&u,!Y>|/SZ#~ap3x2MoQ&.lZ1Twf2Qwc0L+$s3qD&lcfK$9x/^Fo=#,;0K');
define('AUTH_SALT',        'dB}uak}bbE.h<X=}|.irM{!igOkog$Xu:JTtgIxJ1xcDaS7MWq(;_g|Q95xFQn|[');
define('SECURE_AUTH_SALT', 'aD2lNl&j[$^+=LKg=M6tyZ=,-ge,nv+2jA(2[pi~ZSUxpt=qfpZm*TRIUw,fWL&q');
define('LOGGED_IN_SALT',   'A`dKbn|rfiX1jb}:{q/lf5.dB@+(5k`ETPjj8F<^HU-e|?%N&+@ (!QQbsbj>q]a');
define('NONCE_SALT',       'BbcKUJ[=~*t7){1/v_Vz(e<oP>o-VZ-Bg+:W<~^M>i?APZy`M+c4K;!zRz z.~]y');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
