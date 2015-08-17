<?php
/**
 * landx functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 */

//Define variable
define('THEMENAME', 'landx' );
define('THEMEVERSION', '1.3.2' );
define('THEMEURI', trailingslashit( get_template_directory_uri() ) );
define('THEMEDIR', trailingslashit( get_template_directory() ) );

if ( ! function_exists( 'landx_setup' ) ) :
/**
 * landx setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 */
function landx_setup() {

	/*
	 * Make Twenty Fourteen available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Fourteen, use a find and
	 * replace to change THEMESNAME to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( THEMENAME, THEMEDIR . '/languages' );

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'editor-style.css') );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 926, 443, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'header-menu'   => __( 'Header menu', THEMENAME )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );

	add_theme_support( 'woocommerce' );
}
endif; // landx_setup
add_action( 'after_setup_theme', 'landx_setup' );

 /**
 * Required: set 'ot_theme_mode' filter to true.bread
 */
 add_filter( 'ot_theme_mode', '__return_true' );


/**
 * Show Settings Pages
 */
add_filter( 'ot_show_pages', '__return_false' );

/**
 * Show Theme Options UI Builder
 */
add_filter( 'ot_show_options_ui', '__return_true' );

/**
 * Show Settings Import
 */
add_filter( 'ot_show_settings_import', '__return_true' );

/**
 * Show Settings Export
 */
add_filter( 'ot_show_settings_export', '__return_true' );

/**
 * Show New Layout
 */
add_filter( 'ot_show_new_layout', '__return_true' );

/**
 * Show Documentation
 */
add_filter( 'ot_show_docs', '__return_true' );

/**
 * Custom Theme Option page
 */
add_filter( 'ot_use_theme_options', '__return_true' );

/**
 * Meta Boxes
 */
add_filter( 'ot_meta_boxes', '__return_true' );

/**
 * Allow Unfiltered HTML in textareas options
 */
add_filter( 'ot_allow_unfiltered_html', '__return_false' );

/**
 * Loads the meta boxes for post formats
 */
add_filter( 'ot_post_formats', '__return_true' );

/**
 * OptionTree in Theme Mode
 */
require( trailingslashit( THEMEDIR ) . 'option-tree/ot-loader.php' );

/**
 * Theme Options
 */
require( trailingslashit( THEMEDIR ) . 'admin/theme-options.php' );


/**
 * Function for the back end.
 *
 */
require THEMEDIR . 'admin/functions.php';

require THEMEDIR . 'admin/widgets.php';

/**
 * Enqueue scripts and styles for the front end.
 *
 */
require THEMEDIR . 'inc/scripts.php';
/**
 * Add caps megamenu.
 *
 */
 
 /*
 * tgm plugins
 *
 */
 require THEMEDIR . 'lib/landx-plugins.php';


/**
 * Function for the front end.
 *
 */
require THEMEDIR . 'inc/landx-image-resize.php';
require THEMEDIR . 'inc/functions.php';


add_filter( 'embed_defaults', 'bigger_embed_size' );

function bigger_embed_size(){ 
  return array( 'width' => 1160, 'height' => 600 );
}


?>