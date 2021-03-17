<?php
/*
Plugin Name: tarteaucitron.js - Cookies legislation & GDPR
Plugin URI: https://tarteaucitron.io/
Description: Comply with the Cookies and GDPR legislation.
Version: 1.5.0
Text Domain: tarteaucitronjs
Domain Path: /languages/
Author: tarteaucitron.io
Author URI: https://tarteaucitron.io/
Licence: GPLv2
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'TARTEAUCITRON_FILE'            	, __FILE__ );
define( 'TARTEAUCITRON_PATH'       		, realpath( plugin_dir_path( TARTEAUCITRON_FILE ) ) . '/' );


add_action( 'plugins_loaded', 'tarteaucitron_load_textdomain' );
function tarteaucitron_load_textdomain() {
    load_plugin_textdomain( 'tarteaucitronjs', false, TARTEAUCITRON_PATH . '/languages' ); 
}

require(TARTEAUCITRON_PATH . '/Admin.php');
require(TARTEAUCITRON_PATH . '/Sidebars.php');
require(TARTEAUCITRON_PATH . '/Widgets.php');

function tarteaucitron_post($query, $needLogin = 1) {
    $query .= '&langWP='.substr(get_locale(), 0, 2);
    if ($needLogin == 1) {
        $query .= '&uuid='.get_option('tarteaucitronUUID').'&token='.get_option('tarteaucitronToken').'&website='.$_SERVER['SERVER_NAME'];
    }

	parse_str($query, $query_array);

	$response = wp_remote_post( 'https://tarteaucitron.io/pro/wordpress/token.php', array(
		'method' => 'POST',
		'timeout' => 45,
		'redirection' => 5,
		'body' => $query_array,
		'blocking' => true,
		'sslverify' => false,
    	)
	);

	//print_r($query_array);

	if ( !is_wp_error( $response ) ) {
		//print_r($response['body']);
		return $response['body'];
	}

	return "0";
}

add_action('wp_enqueue_scripts', 'tarteaucitron_user_css_js', 1);
function tarteaucitron_user_css_js() {
	
	wp_register_style('tarteaucitronjs', plugins_url('tarteaucitronjs/css/user.css'));

    wp_enqueue_style('tarteaucitronjs');
}

add_action('wp_head', 'tarteaucitronForceLocale', 1);
function tarteaucitronForceLocale() {

    $domain = $_SERVER['SERVER_NAME'];
    
	$allowed 	= array('bg','cn','cs','da','de','el','en','es','fi','fr','hu','it','ja','nl','pl','pt','ro','ru','se','sk','tr','vi','lv','no','ca','sv','zh');
	$locale 	= substr(get_locale(), 0, 2);

	if (in_array($locale, $allowed)) {

		echo '<script>
		var tarteaucitronForceLanguage = "'.$locale.'";
		</script>';
	}
                      
    $loc = "";
    if (in_array($locale, $allowed)) {
        $loc = 'locale='.$locale.'&';
    }
    
    echo '<script type="text/javascript" src="https://tarteaucitron.io/load.js?'.$loc.'iswordpress=true&domain='.$domain.'&uuid='.get_option('tarteaucitronUUID').'"></script>';
}

add_action( 'admin_bar_menu', 'tarteaucitron_toolbar', PHP_INT_MAX );
function tarteaucitron_toolbar( $wp_admin_bar ) {
	$wp_admin_bar->add_menu( array(
		'id'    => 'tarteaucitronjs',
		'title' => '<span class="ab-icon"></span> tarteaucitron.js',
		'href'  => admin_url('options-general.php?page=tarteaucitronjs'),
	) );
}

add_action( 'admin_print_styles', '_tarteaucitron_admin_bar_css', 100 );
add_action( 'wp_print_styles', '_tarteaucitron_admin_bar_css', 100 );
function _tarteaucitron_admin_bar_css() {

	if (current_user_can( 'manage_options' )) {
		wp_register_style(
			'tarteaucitronjs-admin-bar',
			plugins_url('tarteaucitronjs/css/admin-bar.min.css'),
			array(),
			'1'
		);

		wp_enqueue_style( 'tarteaucitronjs-admin-bar' );
	}
}
    
    add_filter( 'embed_oembed_html', 'tarteaucitronjs_oembed_dataparse', PHP_INT_MAX, 4 );
    function tarteaucitronjs_oembed_dataparse($cache, $url, $attr, $post_ID) {
        
        if (is_admin()) {return;}

        if (strpos($url, "youtube.com")) {
            parse_str( parse_url( $url, PHP_URL_QUERY ), $youtube_args );

            if ($youtube_args['v'] != "") {
                return "<script>jQuery(function() {(tarteaucitron.job = tarteaucitron.job || []).push('youtube');});</script><div class=\"youtube_player\" videoID=\"".$youtube_args['v']."\" width=\"100%\" height=\"100%\" style=\"height:50vw\" theme=\"light\" rel=\"0\" controls=\"1\" showinfo=\"1\" autoplay=\"0\"></div>";
            }
        }

        if (strpos($url, "vimeo.com")) {
            $id = substr(parse_url($url, PHP_URL_PATH), 1);

            if ($id != "") {
                return "<script>jQuery(function() {(tarteaucitron.job = tarteaucitron.job || []).push('vimeo');});</script><div class=\"vimeo_player\" videoID=\"".$id."\" width=\"100%\" height=\"100%\" style=\"height:50vw\"></div>";
            }
        }

        if (strpos($url, "dailymotion.com")) {
            $id = end(explode("/", $url));

            if ($id != "") {
                return "<script>jQuery(function() {(tarteaucitron.job = tarteaucitron.job || []).push('dailymotion');});</script><div class=\"dailymotion_player\" videoID=\"".$id."\" width=\"100%\" height=\"100%\" style=\"height:50vw\" showinfo=\"1\" autoplay=\"0\"></div>";
            }
        }

        return $cache;
    }
    
/*
    add_filter( 'oembed_ttl', function($ttl) {
          $GLOBALS['wp_embed']->usecache = 0;
                $ttl = 0;
                // House-cleanoing
                do_action( 'tarteaucitron_do_cleanup' );
        return $ttl;
    });
    
    add_filter( 'embed_oembed_discover', function( $discover )
    {
        if( 1 === did_action( 'tarteaucitron_do_cleanup' ) )
            $GLOBALS['wp_embed']->usecache = 1;
        return $discover;
    } );
    
    add_filter( 'oembed_dataparse', 'tarteaucitron_oembed', 100, 3 );
    function tarteaucitron_oembed($return, $data, $url) {

        if($data->type === 'video') {
            $width = $data->width ? $data->width : '100%';
            $height = $data->height ? $data->height : '100%';

            if (strpos($url, "youtube.com")) {
              parse_str( parse_url( $url, PHP_URL_QUERY ), $youtube_args );

              if ($youtube_args['v'] != "") {
                return "<script>jQuery(function() {(tarteaucitron.job = tarteaucitron.job || []).push('youtube');});</script><div class=\"youtube_player\" videoID=\"".$youtube_args['v']."\" width=\"". $width ."\" height=\"". $height ."\" theme=\"light\" rel=\"0\" controls=\"1\" showinfo=\"1\" autoplay=\"0\"></div>";
              }
            }

            if (strpos($url, "vimeo.com")) {
              $id = substr(parse_url($url, PHP_URL_PATH), 1);
          
              if ($id != "") {
                return "<script>jQuery(function() {(tarteaucitron.job = tarteaucitron.job || []).push('vimeo');});</script><div class=\"vimeo_player\" videoID=\"".$id."\" width=\"". $width ."\" height=\"". $height ."\"></div>";
              }
            }

            if (strpos($url, "dailymotion.com")) {
              $id = end(explode("/", $url));
          
              if ($id != "") {
                return "<script>jQuery(function() {(tarteaucitron.job = tarteaucitron.job || []).push('dailymotion');});</script><div class=\"dailymotion_player\" videoID=\"".$id."\" width=\"". $width ."\" height=\"". $height ."\" showinfo=\"1\" autoplay=\"0\"></div>";
              }
            }
        }

        return $return;
    }
*/
