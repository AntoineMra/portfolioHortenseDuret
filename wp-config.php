<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les
 * valeurs.
 *
 * Ce fichier contient les réglages de configuration suivants :
 *
 * Réglages MySQL
 * Préfixe de table
 * Clés secrètes
 * Langue utilisée
 * ABSPATH
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'portfolio' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '%+NR47w$]2u.bCXOtWmPX^m%mB-[h3 &Su@*6|H1<W69{/TE?;SF&:k_-tTTg:uR' );
define( 'SECURE_AUTH_KEY',  '1cM(:{RcBOz8mHw [FVf]P>%m![-XrAc$eXL</u;S+s)zm/mI:wHa:(W{@s~fm.C' );
define( 'LOGGED_IN_KEY',    'c:g[c9n3gK>-tOOx>(nw0Bn}+MjT~~PY1[-QCdT>F?,uJxfsLlH/|5@(z+sG~_Ow' );
define( 'NONCE_KEY',        'l9KlBf9SK4oV$[nI@.paaPq^_WRy5UWE#p_#pj[ww:&p:&RysHZu[>C4|pvOKGmo' );
define( 'AUTH_SALT',        '^~JIs0$$Y74j+lOE)aMX4(&VX%RAMmtEhidA}!B`=}P >K^A7B&ra<af7|DdmqI~' );
define( 'SECURE_AUTH_SALT', 'Q`0k,IE-aKv|/m=[BcO!pMU[KWw80L.lKWGAgC_&r/t|).N-sliBRKim*%J4t?k^' );
define( 'LOGGED_IN_SALT',   'ntd}%!L=b&URM-?$_K%44ZX0p<Fza4c(1^>`&m+j]Jq5~RH%,*o%#rmjsT=<_B,R' );
define( 'NONCE_SALT',       '],;HV-Sv)^[2xwR[[AZ!{$Ocb{Tn&-GEz|N72dqW^ -]j[;pwcCw{,8_p|Yqs[P-' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( ! defined( 'ABSPATH' ) )
  define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once( ABSPATH . 'wp-settings.php' );
