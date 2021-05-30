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
define('DB_NAME', 'local');

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

// Enable WP_DEBUG mode
define('WP_DEBUG', true);

// Enable Debug logging to the /wp-content/debug.log file
define('WP_DEBUG_LOG', true);

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'mSle0K7dHpKvoiuV1p9kK0ghxSp6IjscEv69/xzRl6zqD9lAoIze6/Ba+n174hHRlZWs2lSTqG6Mrf7sctvkdQ==');
define('SECURE_AUTH_KEY',  '1OYU3s2kpXZGttaP6vMfWCZzHjKfIwu0akbMPhH3px2Mebn4JMJSYi8uutqUqCI3xrth4AtPS2SGNWNA619I0w==');
define('LOGGED_IN_KEY',    'F8emtGufpoBklu5lyipEUfKqzup1wPcPn5Mgow6VSbIerW0ItiQHLZVrpxyR074gK60UThXGcDG/qnjfw5aZyQ==');
define('NONCE_KEY',        'ijKY4dBb9gThN22KBm3cZVsCwVEol09cmdIXsvwTiTVHk038KhCfoAgxmr1tThPvDIxb+KYAKKVqg+fjdrEFFQ==');
define('AUTH_SALT',        'XJPDe4gFbrgn36fiGkttcAzEtyJ0CgxELsjMWO44sVjD8Qx+LYDutgMaGmhKL808bALX720QuGYtUfoeoM8msA==');
define('SECURE_AUTH_SALT', 'iBCady70cBFJxQdvbfchwvY0CAdhFGRmages5HuIJcs/KzUpX4NX/KUd7SGuZUAjT3Z19jM+Mn00KRUXknFJfQ==');
define('LOGGED_IN_SALT',   'z5CYCqxip3ph0YTer4udnimax1h61ohxrvpVFexgRB46NG/xNWimUhbk1O0OR/wgXrnt3/ArgCqXat6KNiqI8w==');
define('NONCE_SALT',       '+f2MRgmeEJ7SOmZ2/NLFiiJLIy1HF2OjtsvtzgeTft6HFX725Yf+iyKJj7dadDPfVFKwFy3tOIrYDotLFsOE0w==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
