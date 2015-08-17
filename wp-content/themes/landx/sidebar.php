<?php
/**
 * The sidebar containing the main widget area
 *
 * If no active widgets are in the sidebar, hide it completely.
 *
 * @package WordPress
 * @subpackage themecap
 * @since landx 1.0
 */
?>
<?php
if(is_page()){
		$sidebar = get_post_meta( get_the_ID(), 'sidebar', true );		
		if($sidebar == '') $sidebar = 'sidebar-1';
}
elseif(is_single())
	$sidebar = (function_exists('ot_get_option'))? ot_get_option( 'blog_single_sidebar', 'sidebar-1' ) : 'sidebar-1';
else
	$sidebar = (function_exists('ot_get_option'))? ot_get_option( 'blog_sidebar', 'sidebar-1' ) : 'sidebar-1';
?>
	

<div class="widget-area sidebar" role="complementary">
	<?php if ( is_active_sidebar( $sidebar ) ) : ?>
		<?php dynamic_sidebar( $sidebar ); ?>
	<?php else: ?>
		<?php $args = 'before_widget = <div class="widget">&after_widget=</div>&before_title=<h3 class="title"><span>&after_title=</span></h3>'; ?>
		<?php the_widget( 'WP_Widget_Archives', '', $args ); ?> 
		<?php the_widget( 'WP_Widget_Pages', '', $args ); ?> 
	<?php endif; ?>
</div><!-- .sidebar -->
