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
define('DB_NAME', 'naggroup');

/** MySQL database username */
define('DB_USER', 'naggroup');

/** MySQL database password */
define('DB_PASSWORD', 'ngrpngrp2019');

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
define('AUTH_KEY',         ':*u`J#bb1FkL}H[:~K-r}LCb<}mS/$g]ZBQ4)j=lj>BNH/$>f;;:m^}f3qudx9>&');
define('SECURE_AUTH_KEY',  'kJANVCcI(x54cO$!Eyn:Gr@1|;&cHF3}c6+/w1_uIh78BR^yH:_m]Y/gwMvcP/8_');
define('LOGGED_IN_KEY',    'l2*.v#YP(8xu9Ph%<#m50e/vnw|/)B8>PP@:#|h>h1Yw1NrtX/F#J-pbot_V]<p.');
define('NONCE_KEY',        'ipyj^ -v9K*!aRg?.o76S;hJ-?.LYGTn.<T6o*66W_9hIJjX|cOpE*k&;%=TE+_1');
define('AUTH_SALT',        'ZP1b0uL%/I9e1lUCVKBYCE9MZ@u. LCi2v.hY>Ujnt5RWG*#Er2}:ZL$gI u7Ex[');
define('SECURE_AUTH_SALT', '}Or_ xY-%7{)A#f+hDFOb385@S7j-GI^u>Fw[N%W>_82S]Wj+s77&g~JPt%}1-;~');
define('LOGGED_IN_SALT',   'D3omXvkqh7<iY_x^|Do>@WlKS}DO$>`g:21B@QIfZVrWI8$L!$cER|J-b!|Fh:k#');
define('NONCE_SALT',       'pk:n.t8 xc%if]c>W&=NTIRk{t{Y9MY/]q~(@mF<OD5nbY]v3H(KXw3Y9DQz}9Xb');

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
