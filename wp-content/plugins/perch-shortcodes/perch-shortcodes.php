<?php
/**
 * Plugin Name: Perch Shortcodes
 * Plugin URI: http://themeforest.net/user/themeperch/portfolio?ref=themeperch
 * Description: A simple shortcode generator. Add buttons, columns, tabs, toggles and alerts to your theme.
 * Version: 1.0.
 * Author: Themeperch
 * Author URI: http://themeforest.net/user/themeperch/portfolio?ref=themeperch
 */

class PerchShortcodes {

    function __construct()
    {
    	define( 'TPSC_VERSION', '2.0' );

    	// Plugin folder path
    	if ( ! defined( 'TPSC_PLUGIN_DIR' ) ) {
    		define( 'TPSC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
    	}

    	// Plugin folder URL
    	if ( ! defined( 'TPSC_PLUGIN_URL' ) ) {
    		define( 'TPSC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    	}
    	require_once( TPSC_PLUGIN_DIR .'includes/icon-picker/icon-picker.php' );
    	require_once( TPSC_PLUGIN_DIR .'includes/pricing/perch-pricing.php' );    
    	require_once( TPSC_PLUGIN_DIR .'includes/scripts.php' );	
    	require_once( TPSC_PLUGIN_DIR .'includes/shortcode-functions.php' );
		require_once( TPSC_PLUGIN_DIR .'includes/perch-image-resize.php' );

        add_action( 'init', array(&$this, 'init') );
        add_action( 'admin_init', array(&$this, 'admin_init') );
		
	}

	/**
	 * Enqueue front end scripts and styles
	 *
	 * @return	void
	 */
	function init()
	{
		if( ! is_admin() )
		{
			wp_enqueue_style( 'perch-shortcodes', TPSC_PLUGIN_URL . 'assets/css/shortcodes.css' );
		}
	}

	/**
	 * Enqueue Scripts and Styles
	 *
	 * @return	void
	 */
	function admin_init()
	{
		include_once( TPSC_PLUGIN_DIR . 'includes/tpsc-from-build.php' );
		include_once( TPSC_PLUGIN_DIR . 'includes/class-tpsc-admin-insert.php' );

		// css
		wp_enqueue_style( 'perch-popup', TPSC_PLUGIN_URL . 'assets/css/admin.css', false, '1.0', 'all' );

		// js
		wp_register_script( 'perch-scripts', TPSC_PLUGIN_URL .'assets/js/scripts.js', array('jquery','media-upload','thickbox') );
		wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');
 		wp_enqueue_script('plupload-all');
        wp_enqueue_script('media-upload');
        wp_enqueue_script('perch-scripts');
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'perch-uploader', TPSC_PLUGIN_URL .'assets/js/admin.js', array('jquery','media-upload','thickbox') );
		wp_localize_script( 'jquery', 'PerchShortcodes', array('plugin_folder' => WP_PLUGIN_URL .'/perch-shortcodes', 'ajaxurl' => admin_url( 'admin-ajax.php' )) );
		
	}
}
new PerchShortcodes();

include_once( TPSC_PLUGIN_DIR . 'includes/class-tpsc-admin-insert-widget.php' );
?>