<?php
/**
 * Iconize WordPress Plugin.
 *
 * @package   Iconize_WP
 * @author    Mladen Ivančević <ivancevic.mladen@gmail.com>
 * @license   http://codecanyon.net/licenses
 * @link      http://codecanyon.net/user/mladen16/
 * @copyright 2014 Mladen Ivančević
 *
 * @wordpress-plugin
 * Plugin Name: Iconize WordPress
 * Plugin URI:  http://codecanyon.net/item/iconize-wordpress-plugin/6481628
 * Description: Visually add vector icons to posts, pages, menu items, widget titles, categories, tags and custom taxonomies using modal dialog.
 * Version:     1.1.4
 * Author:      Mladen Ivančević
 * Author URI:  http://codecanyon.net/user/mladen16/
 * Text Domain: iconize
 * License:     http://codecanyon.net/licenses
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	
	die;
}

// Load classes.

// Main plugin class.
require_once( plugin_dir_path( __FILE__ ) . 'class-iconize-wp.php' );

// Custom Walker classes for nav menu system.
require_once( plugin_dir_path( __FILE__ ) . 'includes/menu-walkers/class-iconize-walker-nav-menu-edit.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/menu-walkers/class-iconize-walker-nav-menu.php' );

// Custom Walker classes for taxonomy lists.
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-iconize-walker-category.php' );

// Custom Widgets.
require_once( plugin_dir_path( __FILE__ ) . 'includes/widgets/class-iconize-widget-taxonomies.php' );

// Load files with functions for retriving icons.
require_once( plugin_dir_path( __FILE__ ) . 'includes/icon-functions.php' );

// Load update notifier.
require_once( plugin_dir_path( __FILE__ ) . 'includes/update-notifier.php' );

add_action( 'plugins_loaded', array( 'Iconize_WP', 'get_instance' ) );