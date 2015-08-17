<?php
// Register Style
function landx_admin_styles() {

	wp_enqueue_style( 'wp-jquery-ui-dialog' );
	wp_register_style( 'landx-style', THEMEURI. '/admin/assets/css/style.css', false, '1.0.0', 'all' );
	wp_enqueue_style( 'landx-style' );

}

// Hook into the 'admin_enqueue_scripts' action
add_action( 'admin_enqueue_scripts', 'landx_admin_styles' );


// Register Script
function landx_admin_scripts() {

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-dialog' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox'); 
    wp_enqueue_script('media-upload');
	wp_register_script( 'landx-scripts', THEMEURI. '/admin/assets/js/scripts.js', array( 'jquery', 'wp-color-picker' ), false, true );
	wp_enqueue_script( 'landx-scripts' );

}

// Hook into the 'admin_enqueue_scripts' action
add_action( 'admin_enqueue_scripts', 'landx_admin_scripts' );
?>