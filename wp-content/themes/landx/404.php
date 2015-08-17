<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Land_X
 * @since Land X 1.0
 */

get_header(); ?>
<section class="blog-posts">
<div class="container">
		<div id="post-0" class="row">
        	<div class="col-md-10 col-md-offset-1">
            	<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'landx' ); ?></p>
				<?php get_search_form(); ?>
            </div>
        </div>
    
</div>
</section>
<?php get_footer(); ?>