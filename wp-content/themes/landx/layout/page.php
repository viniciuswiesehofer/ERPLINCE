<?php
	$page_layout = get_post_meta( get_the_ID(), 'page_layout', true );
	$page_layout = ( $page_layout == '' )? 'rs' : $page_layout;
	if( $page_layout != 'full' ){
		$sidebar = get_post_meta( get_the_ID(), 'sidebar', true );
		if( $page_layout != 'ds' ){
			$container_class = 'col-lg-8 col-md-8';
			$sidebar_class = 'col-lg-4 col-md-4';
			$container_class .= ( $page_layout == 'ls' )? $container_class.' pull-right' : '';
		}
	}

$args = 'before_widget = <div class="widget">&after_widget=</div>&before_title=<h3 class="widget-title">&after_title=</h3>'; 
?>
<?php if( $page_layout == 'full' ): ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'content', 'page' ); ?>
	<?php endwhile; // end of the loop. ?>
<?php else: ?>
	<div class="row">
		<div class="<?php echo $container_class; ?>">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
			<?php endwhile; // end of the loop. ?>
		</div>


		<div class="<?php echo $sidebar_class; ?>">
			<div id="secondary" class="widget-area sidebar" role="complementary">
				<?php 
				if ( is_active_sidebar( $sidebar ) ) : 				
					dynamic_sidebar( $sidebar );			
				else: 
					the_widget( 'WP_Widget_Archives', '', $args );
					the_widget( 'WP_Widget_Pages', '', $args );  
				endif; 
				?>
			</div><!-- #secondary -->
		</div>
	</div>
<?php endif; ?>	


