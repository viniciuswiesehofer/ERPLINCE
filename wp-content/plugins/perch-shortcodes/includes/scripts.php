<?php
/**
 * This file loads the CSS and JS necessary for your shortcodes display
 *
 */

if( !function_exists ('perch_shortcodes_scripts') ) {
	function perch_shortcodes_scripts() {

		$scripts_dir = TPSC_PLUGIN_URL.'assets/';

		// Make sure jquery is loaded
		wp_enqueue_script( 'jquery' );

		// Register scripts
		wp_register_script( 'perch_tabs', $scripts_dir . 'js/perch_tabs.js', array ( 'jquery', 'jquery-ui-tabs'), '1.0', true );
		wp_register_script( 'perch_toggle', $scripts_dir . 'js/perch_toggle.js', 'jquery', '1.0', true );
		wp_register_script( 'perch_accordion', $scripts_dir . 'js/perch_accordion.js', array ( 'jquery', 'jquery-ui-accordion'), '1.0', true );
		wp_register_script( 'perch_googlemap',  $scripts_dir . 'js/perch_googlemap.js', array('jquery'), '1.0', true );
		wp_register_script( 'perch_googlemap_api', 'https://maps.googleapis.com/maps/api/js?sensor=false', array('jquery'), '1.0', true );
		wp_register_script( 'perch_skillbar', $scripts_dir . 'js/perch_skillbar.js', array ( 'jquery' ), '1.0', true );
		wp_register_script( 'perch_scroll_fade', $scripts_dir . 'js/perch_scroll_fade.js', array ( 'jquery' ), '1.0', true );

		// Enqueue CSS
		wp_enqueue_style( 'perch_shortcode_styles', $scripts_dir . 'css/perch_shortcodes_styles.css' );
		wp_enqueue_style( 'perch_shortcodes_font_awesome', $scripts_dir . 'css/font-awesome.min.css.css' );
		
	}
}
add_action('wp_enqueue_scripts', 'perch_shortcodes_scripts');