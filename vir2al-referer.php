<?php
/*
Plugin Name: vir2al Referer
Plugin URI: https://sayhello.ch
Description: Adds a modal if user comes from vir2al.ch
Author: Nico Martin
Version: 0.0.1
Author URI: https://nicomartin.ch
Text Domain: vtlref
Domain Path: /languages
 */

if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) || version_compare( PHP_VERSION, '5.3', '<' ) ) {
	function vtlref_compatability_warning() {

		// translators: Dependency waring
		$dependency_text = sprintf( __( '“%1$s” requires PHP %2$s (or newer) and WordPress %3$s (or newer) to function properly. Your site is using PHP %4$s and WordPress %5$s. Please upgrade. The plugin has been automatically deactivated.', 'vtlref' ), 'vir2al Referer', '5.3', '4.7', PHP_VERSION, $GLOBALS['wp_version'] );
		echo "<div class='error'><p>$dependency_text</p></div>";

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
	}

	add_action( 'admin_notices', 'vtlref_compatability_warning' );

	function vtlref_deactivate_self() {
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}

	add_action( 'admin_init', 'vtlref_deactivate_self' );

	return;
} else {

	require_once 'Classes/class-plugin.php';

	function vtlref_get_instance() {
		return nicomartin\vir2alreferer\Plugin::get_instance( __FILE__ );
	}

	vtlref_get_instance();

	require_once 'Classes/class-init.php';
	vtlref_get_instance()->Init = new nicomartin\vir2alreferer\Init();
	vtlref_get_instance()->Init->run();

	/**
	 * Test Hooks
	 */

	function vtlref_update_test( $old_version = 'none', $new_version = 'none' ) {

		add_action( 'admin_notices', function () use ( $old_version, $new_version ) {

			echo '<div class="notice notice-success is-dismissible">';
			echo '<p>vtlref_on_update: ' . $old_version . ' --> ' . $new_version . '</p>';
			echo '</div>';
		} );
	}

	add_action( 'vtlref_on_update', 'vtlref_update_test', 10, 2 );

	function vtlref_activate_test() {

		add_action( 'admin_notices', function () {
			echo '<div class="notice notice-success is-dismissible">';
			echo '<p>vtlref_on_activate</p>';
			echo '</div>';
		} );
	}

	add_action( 'vtlref_on_activate', 'vtlref_activate_test' );
}
