<?php
/**
 * In dieser Datei werden die Grundeinstellungen für WordPress vorgenommen.
 *
 * Zu diesen Einstellungen gehören: MySQL-Zugangsdaten, Tabellenpräfix,
 * Secret-Keys, Sprache und ABSPATH. Mehr Informationen zur wp-config.php gibt es
 * auf der {@link http://codex.wordpress.org/Editing_wp-config.php wp-config.php editieren}
 * Seite im Codex. Die Informationen für die MySQL-Datenbank bekommst du von deinem Webhoster.
 *
 * Diese Datei wird von der wp-config.php-Erzeugungsroutine verwendet. Sie wird ausgeführt,
 * wenn noch keine wp-config.php (aber eine wp-config-sample.php) vorhanden ist,
 * und die Installationsroutine (/wp-admin/install.php) aufgerufen wird.
 * Man kann aber auch direkt in dieser Datei alle Eingaben vornehmen und sie von
 * wp-config-sample.php in wp-config.php umbenennen und die Installation starten.
 *
 * @package WordPress
 */

/**  MySQL Einstellungen - diese Angaben bekommst du von deinem Webhoster. */
/**  Ersetze database_name_here mit dem Namen der Datenbank, die du verwenden möchtest. */
define('DB_NAME', 'wordpress');

/** Ersetze username_here mit deinem MySQL-Datenbank-Benutzernamen */
define('DB_USER', 'wp');

/** Ersetze password_here mit deinem MySQL-Passwort */
define('DB_PASSWORD', 'wordpress');

/** Ersetze localhost mit der MySQL-Serveradresse */
define('DB_HOST', '127.0.0.1');

/** Der Datenbankzeichensatz der beim Erstellen der Datenbanktabellen verwendet werden soll */
define('DB_CHARSET', 'utf8');

/** Der collate type sollte nicht geändert werden */
define('DB_COLLATE', '');

/**#@+
 * Sicherheitsschlüssel
 *
 * Ändere jeden KEY in eine beliebige, möglichst einzigartige Phrase.
 * Auf der Seite {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * kannst du dir alle KEYS generieren lassen.
 * Bitte trage für jeden KEY eine eigene Phrase ein. Du kannst die Schlüssel jederzeit wieder ändern,
 * alle angemeldeten Benutzer müssen sich danach erneut anmelden.
 *
 * @seit 2.6.0
 */
define('AUTH_KEY',         ')Svt|qO;hkS-yyJcfWEVAn|*ATR48$=OtfS&)E%6_+X68di8(qcL6<D*uG><4kvV');
define('SECURE_AUTH_KEY',  'N*DsW|?Zddi9]tKm!i/2g_|ruqT/I&J_DoUMDKau&9Qj|O5?i&IGfwNc?pBq}mQz');
define('LOGGED_IN_KEY',    'N:>RUt4w-5`lMoVwvHO~ag^~`jIVCV?hd-t-X{Ab+6_lgE)Pkw(No&_-_f{7<Xw@');
define('NONCE_KEY',        'lTGkG=U$9RZ>L8pP6&gm4g3P7?Uj-jqu8@t1k#<YC+-tRsE}Q6b6iKR4utVk!G80');
define('AUTH_SALT',        '-DkV}h/:{N9cBWeL >ZFQP8n}.^^1Y4oG5T*kgB_Hwi|?Jq_~KniE;?}Xr_oSR@K');
define('SECURE_AUTH_SALT', 'TDY:QVjxukfSmBM)xn|L.C8<aHqv08*F)ah8vgGk#{g<jO|BBFO*9ux-nhf}3-mo');
define('LOGGED_IN_SALT',   'af-`xXTo!JamDy}+h6 P_b+QqSAoX;KoL-|}ep#NR} L0OZ&KK<Ta1Hay<sU+_t{');
define('NONCE_SALT',       '^.[!-l7>[G%cBF6$oi<ajR=+-=aIzb@jh_*5-%U/G9@Nq9;baipGPqvnKn2Q|Q7D');

/**#@-*/

/**
 * WordPress Datenbanktabellen-Präfix
 *
 *  Wenn du verschiedene Präfixe benutzt, kannst du innerhalb einer Datenbank
 *  verschiedene WordPress-Installationen betreiben. Nur Zahlen, Buchstaben und Unterstriche bitte!
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

define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'localhost');
define('PATH_CURRENT_SITE', '/~nessie/wordpress/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
