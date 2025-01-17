<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'lingesh_task' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '(`$d7[9AFym4Y&7^criK(cM?p/<Fkm[c{/T}Ve01gaS(C|ht3ihlH{zDu&_xERzg' );
define( 'SECURE_AUTH_KEY',  'GI46Q!#W;,$%*mZ?8iX|~[&z<]sT1YH0YPUmNw61tHw*/h0Fmq]<cy>U(E)}bfmb' );
define( 'LOGGED_IN_KEY',    '5S}#QQ7u|4zpcS#:it!NUE*&<XWkF.d0Wo~A}igBr.rgn]o_`#[rGYj$/bEXqzwZ' );
define( 'NONCE_KEY',        '.6w_-T8 !,MW~a/z?_u)s):Ca8sUqRw`Qj#-TGFH#.+#Go07ZJS}w)m T6DlKKuC' );
define( 'AUTH_SALT',        'Sa/c?7=&%r|2m59dRuZ R3+{y]]h&cwaDSC-Vp-)(Gh9!k=,`Ttrm>yylA+ZD&C4' );
define( 'SECURE_AUTH_SALT', '1x6g0D+]q=Rtm$M&s^_n$s^Pm<ln0XPzGT|]7&a3bc|Kby0fAq/iOlno)2?:1:b%' );
define( 'LOGGED_IN_SALT',   'mpw!,|Dc]EX<:0flW>kM;kb69/ONypZQd8hAMuBqF/a9Y6X9CSY5[-v|)pfeEdPe' );
define( 'NONCE_SALT',       '&ZZ[p/<16I|v`sg%yH-FIslY9pz}EdqMr&u5#zlp ?35f-F/{2BJtP*@a^o8%GNz' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
