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
<body <?php body_class('landx-onepage'); ?>>
<!-- =========================
     PRE LOADER       
============================== -->
<div class="preloader">
  <div class="status">&nbsp;</div>
</div>

<!-- =========================
     HEADER   
============================== -->
<?php
if( function_exists('ot_get_option') ){
	$logo = ot_get_option( 'main_logo' );
}else{
	$logo = THEMEURI. 'images/logo-dark.png';
}
?>
<?php 
$bg_style = get_post_meta( get_the_ID(), 'bg_style', true );
$onepage_header_style = get_post_meta( get_the_ID(), 'onepage_header_style', true ); 
?>
<header id="home" class="<?php echo esc_attr($bg_style.' '.$onepage_header_style); ?>">

	<?php
		$slider_class = ''; 		
		

		$custom_header_slider_option = get_post_meta( get_the_ID(), 'custom_header_slider_option', true );
		$custom_header_slider = get_post_meta( get_the_ID(), 'onepage_header_slider', true );
		if(($onepage_header_style == 'shortcode') && ($custom_header_slider != '')){ 
		$slider_class .= 'custom-slider';
		?>
		<div class="slider-wrapper">	
		<?php	echo do_shortcode($custom_header_slider); ?>
		</div>
		<?php } ?>
    <div id="section<?php echo get_the_ID(); ?>" class="<?php echo $slider_class; ?>">

    	<?php if($onepage_header_style == 'video'): ?>
	    	<video autoplay  poster="<?php echo esc_url(get_post_meta( get_the_ID(), 'background', true )) ?>" id="bgvid" loop>
				<source src="<?php echo esc_url(get_post_meta( get_the_ID(), 'webm_video_url', true )) ?>" type="video/webm">
				<source src="<?php echo esc_url(get_post_meta( get_the_ID(), 'mp4_video_url', true )) ?>" type="video/mp4">
			</video>
		<?php endif; ?>

    	<!-- COLOR OVER IMAGE -->
		<div class="color-overlay">	
			<?php get_template_part('header/onepage', 'nav'); ?>	
			<!-- HEADING, FEATURES AND REGISTRATION FORM CONTAINER -->
			<div class="container">
				<div class="intro-section">
					<?php
						$form_display = get_post_meta( get_the_ID(), 'form_display', true );
						$form_position = get_post_meta( get_the_ID(), 'form_position', true );
						$container_class = ( ($form_display == 'on') && (  $form_position == 'right' ) )? 'col-md-7 col-sm-7': 'col-md-12 col-lg-12';
						$form_container_class = ( ($form_display == 'on') && (  $form_position == 'right' ) )? 'col-md-5 col-sm-5': 'col-md-6 col-md-offset-3';
						$container_class .= ' text-'.get_post_meta( get_the_ID(), 'content_alignment', true );
					?>
					<div class="row">
						
						<!-- LEFT - HEADING AND TEXTS -->
						<div class="<?php echo $container_class ?>">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php
								if( has_post_thumbnail() ):
									$fullsize = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'full');
									$url = $fullsize[0];
									$image_position = get_post_meta( get_the_ID(), 'image_position', true );	
									$image_class = ( $image_position == 'left' )? 'pull-left' : ' pull-right';		
							?>
							<div class="row">
								<div class="col-md-6 col-lg-6 <?php echo $image_class; ?>">
									<div class="side-screenshot pull-left"><img class="featured-image" src="<?php echo $url ?>" alt="<?php the_title() ?>"></div>
								</div>	
								<div class="col-md-6">
									<div class="<?php echo $class ;?>">
										<?php the_content(); ?>
										<?php get_template_part( 'inc/jump', 'button' ); ?>	
									</div>	
								</div>																			
							</div><!--.row-->
							<?php else: ?>
								<?php the_content(); ?>
								<?php get_template_part( 'inc/jump', 'button' ); ?>	
							<?php endif; ?>	
							<?php endwhile; ?>					
						</div>				
						<!-- RIGHT - REGISTRATION FORM -->
						
						<div class="<?php echo $form_container_class ?>">
						<?php get_template_part( 'inc/subcription', 'form' ); ?>				
						</div>
						<!-- /END - REGISTRATION FORM -->
					</div>
				</div>		
			</div>
			<!-- /END HEADING, FEATURES AND REGISTRATION FORM CONTAINER -->
			
		</div>
	</div>
</header>

	