<?php
define( 'WP_CACHE', true );

define( 'WP_CACHE', false ); // Added by WP Rocket

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
define( 'DB_NAME', "sql_kyunkyun_net" );

/** MySQL database username */
define( 'DB_USER', "sql_kyunkyun_net" );

/** MySQL database password */
define( 'DB_PASSWORD', "jnSxL6YNejsW3KD8" );

/** MySQL hostname */
define( 'DB_HOST', "localhost" );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'xn(h*I[8Z3CG!dRaY8qiBiUw&z/KFj3;?h~733gpE)VMFi, Y+;;G?D6JBCO=/|%' );
define( 'SECURE_AUTH_KEY',   'EZU+{srs]_.!PV[IZ/M/Sr,$s}c86w~(#=]N:Lm=tD*]k!6)O2=vA=(>:W_@?vy*' );
define( 'LOGGED_IN_KEY',     '#/&4V]L=cAO{Ix8qnY{y;eJ)ORT=5cDqrV,[rMC|L:6XYh.fr{it$<7F7kx[epUI' );
define( 'NONCE_KEY',         'p[kCxl-$RRRf]30H8}Qrp!f!S7#jA1l8xM+IG-SwrATPls65yT1 qNJpWU32TK]:' );
define( 'AUTH_SALT',         'dQstb%W+g/PjkM*qnBpg/gMZ/=Fm%y!%&_Hz+2F|%xOInbiH<vhUNfxywB]b[i%d' );
define( 'SECURE_AUTH_SALT',  'e29AcNBQ.E}!u>LZ k%%<ldmGoWXlKXKG.C*osuLNy%g6MNU=qshz(WY7YB(C*|5' );
define( 'LOGGED_IN_SALT',    'NW@LF:i;cotu}?BkXSsuSo7$E|w6[S-X8nqX#o3`?wi(Z}>!UnDv9UYP/?{&d3AE' );
define( 'NONCE_SALT',        'VNi|1yK^FHxgspq3e[8$+XqR4~6*@z:ok9,A#Ph`s.>H7,?v(ARE5|;AHkhMYH85' );
define( 'WP_CACHE_KEY_SALT', 'Eq-iyc ?Zy/YqG0y<!(r}(3qBNa`]p83.^+Ax[<d.es}kCA_Hm:p9Kg2Odc7#w<6' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
