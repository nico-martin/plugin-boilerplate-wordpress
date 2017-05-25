<?php
/*
Plugin Name: PLUGIN_NAME
Plugin URI: PLUGIN_URI
Description: PLUGIN_DESCRIPTION
Author: PLUGIN_AUTHOR (AUTHOR_EMAIL)
Version: 0.0.1
Author URI: AUTHOR_URI
Text Domain: TEXT_DOMAIN
Domain Path: /languages
 */

if ( version_compare( $wp_version, '4.7', '<' ) || version_compare( PHP_VERSION, '5.3', '<' ) ) {
	function PLUGIN_PREFIX_compatability_warning(){
		echo '<div class="error"><p>' . sprintf(
			// translators: Dependency waring
			__( '“%1$s” requires PHP %2$s (or newer) and WordPress %3$s (or newer) to function properly. Your site is using PHP %4$s and WordPress %5$s. Please upgrade. The plugin has been automatically deactivated.', 'TEXT_DOMAIN' ),
			'PLUGIN NAME',
			'5.3',
			'4.7',
			PHP_VERSION,
			$GLOBALS['wp_version']
		) . '</p></div>';
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
	}
	add_action( 'admin_notices', 'PLUGIN_PREFIX_compatability_warning' );

	function PLUGIN_PREFIX_deactivate_self() {
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}
	add_action( 'admin_init', 'PLUGIN_PREFIX_deactivate_self' );

	return;
} else {

	require_once 'Classes/class-plugin.php';

	function PLUGIN_PREFIX_get_instance() {
		return AUTHOR_NAMESPACE\PLUGIN_NAMESPACE\Plugin::get_instance( __FILE__ );
	}
	PLUGIN_PREFIX_get_instance();


	/**
	 * Test Hooks
	 */

	function PLUGIN_PREFIX_update_test( $old_version = 'none', $new_version = 'none' ) {

		add_action( 'admin_notices', function() use ( $old_version, $new_version ) {

			echo '<div class="notice notice-success is-dismissible">';
			echo 	'<p>PLUGIN_PREFIX_on_update: ' . $old_version . ' --> ' . $new_version . '</p>';
			echo '</div>';
		});
	}
	add_action( 'PLUGIN_PREFIX_on_update', 'PLUGIN_PREFIX_update_test', 10, 2 );

	function PLUGIN_PREFIX_activate_test() {

		add_action( 'admin_notices', function() {
			echo '<div class="notice notice-success is-dismissible">';
			echo 	'<p>PLUGIN_PREFIX_on_activate</p>';
			echo '</div>';
		});
	}
	add_action( 'PLUGIN_PREFIX_on_activate', 'PLUGIN_PREFIX_activate_test' );
}
