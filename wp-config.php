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
define( 'DB_NAME', 'new_record_studio' );

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
define( 'AUTH_KEY',         'kywY2+i-Q3F`!{EU6Qk[3VKyo.BpFo[]p!`+*BGnVi JrB=-Ee_X,Y&b iG9}2@J' );
define( 'SECURE_AUTH_KEY',  'Bt.BwG*cpg#uhtd$4*ueQ>n%HhEeHzTb*C2FHmSPkg7-7T1<?E_+wpeAKslZ<ceq' );
define( 'LOGGED_IN_KEY',    ';0YW0+@rD!dp:%eG>+xtSUmSxZ[y>Kx^K3e9N&4m}4_V]D$r4CuW1TSjM$W( -:m' );
define( 'NONCE_KEY',        ')AZJV]oX4MHey@lfN;^I.7ayF!ER$|=M:J~mp<Ono$xHLY_-?gdcj7+>=}4)PHo+' );
define( 'AUTH_SALT',        'Gu@O7`q~wRxHrZCtA]]k8 ENeHWDbn_H>@w%Z|}pw[Az2G6UG?Jc #w8z{o@l?%;' );
define( 'SECURE_AUTH_SALT', 'vCzl[z!#lu`uPpDP#3cq ^H)_G}%yBH~xVWo9dtcJxb[at1: HKxsm5O(N>@`iDP' );
define( 'LOGGED_IN_SALT',   'vVH&GLI>/v`]I] sfE>6G{~:WTT[6/iVL(z1B};EK]T[{dU*Sv4_8,J9Sfu*P^Gg' );
define( 'NONCE_SALT',       'R3,:8i_W6u`_Fy]!5@PydftPOn`K<W(ciFyU%@:XqWL]uthzR.F:3.+YQ&,$c5oo' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'nrs_';

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
