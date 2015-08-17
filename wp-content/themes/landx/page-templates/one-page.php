<?php
/**
 * Template Name: One page Template
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

get_header('onepage'); ?>
<div id="sections-container">
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
			<section id="<?php echo get_the_slug($value['page_id']); ?>" class="onepage-<?php echo $pageid; ?> section<?php echo $value['page_id'].$alt; ?> <?php echo ( $bg_style == 'dark' )? 'cta-section' : '';  ?>">
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
</div>
<?php get_footer(); ?>