<?php if( (has_post_thumbnail()) && (! post_password_required()) ): ?>
	<div class="featured-image">
	<?php the_post_thumbnail( 'blog-thumbnails' ); ?>
	</div>
	<?php endif; ?>

<div class="post-contents">
	<?php the_content(); ?>
    <?php comments_template( '', true ); ?>
</div>