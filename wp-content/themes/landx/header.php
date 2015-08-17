<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
if( function_exists('ot_get_option') )
   echo (ot_get_option('fabicon') != '')? '<link rel="shortcut icon" href="'.ot_get_option('fabicon').'">' : '';
?>
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class('landx-multipage'); ?>>
<?php $bg_style = get_post_meta( get_the_ID(), 'bg_style', true );
 	  $bg_style = ( $bg_style != '' )? $bg_style : 'dark'; ?>
	<header class="<?php echo $bg_style; ?>  header-<?php echo ot_get_option('sticky_navigation', 'on'); ?>">
	<?php get_template_part( 'header/topbar' ); ?>
	<?php get_template_part( 'header/landx', 'title' ); ?>
	</header>