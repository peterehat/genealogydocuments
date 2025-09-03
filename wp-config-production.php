<?php
/**
 * The base configuration for WordPress
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'defaultdb' );

/** MySQL database username */
define( 'DB_USER', 'doadmin' );

/** MySQL database password */
define( 'DB_PASSWORD', 'YOUR_DB_PASSWORD_HERE' );

/** MySQL hostname */
define( 'DB_HOST', 'genealogydocuments-db-do-user-25354054-0.l.db.ondigitalocean.com:25060' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '|PE{<4W*E7uSd5}HGpAd]JE-pS+Go#>@p7Tp)4:/g0;/g8(]  bKney$Q:{U2 g{' );
define( 'SECURE_AUTH_KEY',  's+Q)Rk2OPy{[.}.zv.t=;lq6Wg~wFou_=>FN@THVr(*]-`nXZZgWu~5Q%yB7Rmqc' );
define( 'LOGGED_IN_KEY',    '.<`DOU;Q/MbqZU^[$3Ra.htv~r5<O->)A>:35=uTBxDW#;XppN]YP+ce;wXXOSL+' );
define( 'NONCE_KEY',        '1X-r=DnAU55_fxGXEunJRC`:c<v@fKW#K=}e/`` 2)&4reLY@l9W.^rRm||R@bc*' );
define( 'AUTH_SALT',        '!/>z=7N>-Wl=wp>Oe)C-Zdza-R1x`8X9Uvn|n/*Z>_pS@u76}Fp?+anLP_t!ca^x' );
define( 'SECURE_AUTH_SALT', '~NLaBA<T(z*VmAy):n0mUX@{ti@L0y=&c`&a7Bk|ufJ~@hrPWz?6<>1zijn7,(2M' );
define( 'LOGGED_IN_SALT',   'Q_Et.K$px(Q(l=(JTQ8Bn9A$NTyGA?SyoWeBs*7hV9QH1]Yu!7,{m#bUc.@Pt.(/' );
define( 'NONCE_SALT',       'N2#Y*y%1D&+E,X<|H1t`2[L,hW/`rXUN{|`fQHSLrO%N7hx)?_-TwN_HEqr&I@;`' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';