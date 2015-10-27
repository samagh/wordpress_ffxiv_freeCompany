<?php
/*
Plugin Name: FFXIV Modulo para wordpress
Plugin URI: None
Description: Modulo para gestionar la freeCompany del FFXIV
Author: Seinah
Version: 1.2
Author URI: http://twitter.com/jorpeivi
*/

/*
 *	Comprobamos si ya existe
 */

/* Cargamos el plugin insert_php */
include('insert_php.php');

/* Cargamos librerias nuetras */
include('pages.php');

/* Librerias con las funciones para el Cron */
include('cron.php');

/* */
include('virtual_page.php');

/*
 * CARGAMOS LA CONFIGURACION INICIAL
 */
include('start.php');
register_activation_hook(__FILE__,'ffxiv_install'); 
register_deactivation_hook( __FILE__, 'ffxiv_remove' );

function modify_contact_methods($profile_fields) {
	// Add new fields
	$profile_fields['XIVPlayer'] = 'Player XIV Name';
	return $profile_fields;
}

function ffxiv_init()
{
    add_filter('user_contactmethods', 'modify_contact_methods');
}

add_action( 'wp_enqueue_scripts', 'my_js_include_function' );
// add_action("plugins_loaded","seinah_init"); // Una vez Cargados los Plugins
// add_action("init","seinah_init");           // Para capturar $_GET y $_POST
add_action("init","ffxiv_init");
//add_action("wp_loaded","seinah_init");

function my_js_include_function() {
	//wp_enqueue_style( 'style-name', get_stylesheet_uri() );
	wp_enqueue_script( 'tooltip', plugins_url() . '/ffxiv/js/tooltips.js', array() );
}
