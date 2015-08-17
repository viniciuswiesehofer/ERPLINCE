<?php
/**
 * Template Name: Squeeze Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in landx consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage themecap
 * @since landx 1.0
 */

 ?>
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

if( function_exists('ot_get_option') ){
	$menu_logo = ot_get_option( 'main_logo' );
	}else{
		$menu_logo = THEMEURI. 'images/logo-dark.png';
	}
	$squzee_header_logo_display = get_post_meta( get_the_ID(), 'squzee_header_logo_display', true );
	$squzee_header_logo = get_post_meta( get_the_ID(), 'squzee_header_logo', true );
	$squzee_social_button_display = get_post_meta( get_the_ID(), 'squzee_social_button_display', true );
?>
<?php $bg_style = get_post_meta( get_the_ID(), 'bg_style', true ); ?>
<header id="home" class="<?php echo $bg_style; ?>">
	<div id="section<?php echo get_the_ID(); ?>">
	<!-- COLOR OVER IMAGE -->
		<div class="color-overlay">	
			<div class="navbar non-sticky">			
		<div class="container">
			<?php if($squzee_header_logo_display == 'on'): ?>
			<div class="navbar-header">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo $squzee_header_logo; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
			</div>
			<?php endif; ?>
			<?php
				$social_array = array(
				            array(
				              'title' => 'Facebook',
				              'link'  => '#',
				              'icon'  => 'social_facebook_circle'
				              ),
				            array(
				              'title' => 'Twitter',
				              'link'  => '#',
				              'icon'  => 'social_twitter_circle'
				              ),
				            array(
				              'title' => 'Linkdin',
				              'link'  => '#',
				              'icon'  => 'social_linkedin_circle'
				              ),
				            );
				if( function_exists('ot_get_option') ){
					$social_array = ot_get_option( 'header_social_icons', array() );
				}
				?>
			<?php if( !empty($social_array) && ($squzee_social_button_display == 'on') ): ?>
			<ul class="nav navbar-nav navbar-right social-navigation hidden-xs">
				<?php foreach ($social_array as $key => $value) {
					echo '<li><a href="'.$value['link'].'" title="'.$value['title'].'"><i class="'.$value['icon'].'"></i></a></li>';
				} ?>
			
			</ul>
			<?php endif; ?>
		</div><!-- /END CONTAINER -->			
	</div>
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
									</div>	
								</div>																			
							</div><!--.row-->
							<?php else: ?>
								<?php the_content(); ?>
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
	

<?php
global $wpdb;
$pages = get_post_meta( get_the_ID(), 'pages', true );
if( !empty($pages) ):
	$i = 0;
	foreach ($pages as $key => $value):
		$alt = ( ($i % 2) == 1 )? ' bgcolor-2' : '';
		if( ($value['page_id'] != '') && ( $value['link_type'] == 'internal' ) ):
			
			$pageid = get_the_ID();
			$the_query = new WP_Query( array('p' =>$value['page_id'], 'post_type' => 'page' ) );
			while ( $the_query->have_posts() ) : $the_query->the_post(); 
			?>
			<?php
			$bg_style = get_post_meta( get_the_ID(), 'bg_style', true );
			?>
			<section id="section<?php echo $value['page_id']; ?>" class="onepage-<?php echo $pageid; ?> section<?php echo $value['page_id'].$alt; ?> <?php echo ( $bg_style == 'dark' )? 'cta-section' : '';  ?>">
				<?php echo ( $bg_style == 'dark' )? '<div class="color-overlay">' : '';  ?>
					<div class="container">		
 					<?php get_template_part( 'content', 'onepage' ); ?>	
 					</div><!--.container-->
				<?php echo ( $bg_style == 'dark' )? '</div>' : '';  ?>
			</section><!--#section<?php echo $value['page_id']; ?>-->
 			<?php endwhile; // end of the loop. ?>	
			<?php wp_reset_postdata(); ?>
			<?php
			$i++;
		endif; //if( $value['page_id'] != ''):
	endforeach;	
endif; //if( !empty($pages) )	
?>

<?php get_footer(); ?>