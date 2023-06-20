<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://oswaldocavalcante.com
 * @since             1.0.0
 * @package           Classebiblica
 *
 * @wordpress-plugin
 * Plugin Name:     Classe Bíblica
 * Plugin URI:     	https://github.com/oswaldocavalcante/classebiblica-plugin
 * Update URI:		https://github.com/oswaldocavalcante/classebiblica-plugin
 * Description:     Plugin que adiciona funcionalidades para a plataforma classebiblica.org
 * Version:         2.1.3
 * Author:          Oswaldo Cavalcante
 * Author URI:      https://oswaldocavalcante.com
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     classebiblica
 * Domain Path:     /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CLASSEBIBLICA_VERSION', '2.1.3' );

// /**
//  * For updating
//  */
// if( ! function_exists( 'my_plugin_check_for_updates' ) ){
    
//     function my_plugin_check_for_updates( $update, $plugin_data, $plugin_file ){
        
//         static $response = false;
        
//         if( empty( $plugin_data['UpdateURI'] ) || ! empty( $update ) )
//             return $update;
        
//         if( $response === false )
//             $response = wp_remote_get( $plugin_data['UpdateURI'] );
        
//         if( empty( $response['body'] ) )
//             return $update;
        
//         $custom_plugins_data = json_decode( $response['body'], true );
        
//         if( ! empty( $custom_plugins_data[ $plugin_file ] ) )
//             return $custom_plugins_data[ $plugin_file ];
//         else
//             return $update;
        
//     }
    
//     add_filter('update_plugins_classebiblica.org', 'my_plugin_check_for_updates', 10, 3);
// }

// Include Updater file
if( ! class_exists( 'Classebiblica_Updater' ) ){
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-classebiblica-updater.php';
}

$updater = new Classebiblica_Updater( __FILE__ ); // instantiate our class
$updater->set_username( 'oswaldocavalcante' ); // set username
$updater->set_repository( 'classebiblica-plugin' ); // set repository
$updater->initialize(); // initialize the updater

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-classebiblica-activator.php
 */
function activate_classebiblica() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-classebiblica-activator.php';
	Classebiblica_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-classebiblica-deactivator.php
 */
function deactivate_classebiblica() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-classebiblica-deactivator.php';
	Classebiblica_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_classebiblica' );
register_deactivation_hook( __FILE__, 'deactivate_classebiblica' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-classebiblica.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_classebiblica() {

	$plugin = new Classebiblica();
	$plugin->run();

}
run_classebiblica();
