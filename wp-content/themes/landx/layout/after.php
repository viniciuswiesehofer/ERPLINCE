<?php
	if(is_page())
		$layout = get_post_meta( get_the_ID(), 'page_layout', true );
	elseif(is_single())
		$layout = (function_exists('ot_get_option'))? ot_get_option( 'single_layout', 'rs' ) : 'rs';
	else
		$layout = (function_exists('ot_get_option'))? ot_get_option( 'blog_layout', 'rs' ) : 'rs';
	

?>		
			</div>
			<?php if( $layout != 'full' ): ?>
			<div class="col-lg-4 col-md-4">
				<?php get_sidebar(); ?>			
			</div>
			<?php endif; // end $blog_layout != 'full' check ?>  
	</div>
</section>