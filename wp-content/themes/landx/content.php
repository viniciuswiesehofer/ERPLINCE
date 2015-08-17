	<!-- SINGLE POST STARTS -->
	<div id="post-<?php the_ID(); ?>">
			
            <?php if( !is_single()):?>
            <div <?php post_class('post'); ?>>
            <?php else: ?>
            <article <?php post_class('single-post'); ?>> 
            <?php endif; ?>
				<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
					<div class="post-meta"><div class="sticky-post"><?php echo ot_get_option('sticky_post_text', 'Featured post'); ?></div></div>
				<?php endif; ?>	
				<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
                <div class="featured-image">
					<?php the_post_thumbnail( 'post-thumbnails' ); ?>
				</div>
                <?php endif; ?>
				
				<div class="post-contents">
					
					<?php if( !is_single() ):?>
                    	<a href="<?php the_permalink(); ?>" rel="bookmark"><h2 class="post-title"><?php the_title(); ?></h2></a>
					<?php else: ?>
                    	<h2><?php the_title(); ?></h2>
					<?php endif; ?>					
					<div class="colored-line"></div>
					
                    
                    <?php if( !is_single() ): ?>
	                    <div class="post-description">                   
		                    <?php the_excerpt(); ?>
	                    </div>
					<?php endif; ?>
					
					
					<div class="post-meta">
						<div class="meta-author">
							<span class="colored-text ion-android-social-user"></span><?php the_author_posts_link(); ?>
						</div>
						<div class="meta-date">
							<span class="colored-text icon_clock"></span><?php echo get_the_date( 'F d, Y' ); ?>
						</div>
						<?php 
							$format = get_post_format();
							echo ($format != '')? '<div class="meta-date"><span class="colored-text genericon genericon-'.$format.'"></span>'.get_post_format_string( $format ). '</div>' : ''; 
						?>
						<?php
                        $categories = get_the_category();
						$output = '';
						if($categories){
							$count_cat = count($categories);
							$j = 1;
						?>
                        <div class="meta-category">
							<span class="colored-text ion-folder"></span>
                            <?php foreach($categories as $category) {
                            $output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", 'landx' ), $category->name ) ) . '">'.$category->cat_name.'</a>';
							if($j != $count_cat ){
								$output .= ', ';
							}
							
							$j++;
							}
							echo trim($output);
							?>
						</div>
                        <?php } ?>
					</div>
                    
                    <?php if( is_single() ): ?>
	                    <div class="post-description">
							<?php the_content(); ?>
	                    </div>
	                    <?php
	                    $posttags = get_the_tags();
						if ( $posttags ):
							$count = count($posttags);
							$i = 1;
							?>
		                    <div class="tags">
								<span class="strong"><?php echo __( 'Tags: ', 'landx' ); ?></span>
				                    <?php foreach( $posttags as $tag ): ?>
					                    <a href="<?php echo get_tag_link($tag->term_id); ?>"><?php echo $tag->name; ?></a>
					                    <?php if($i != $count ): ?>
					                    	<?php echo _e( ', ', 'landx' ); ?>
					                    <?php endif; ?>
					                    
				                    	<?php $i++; ?>
									<?php endforeach; ?>
								
						    </div>
					    <?php endif; ?>
					<?php endif; ?>
                    
                    
                    
                    <?php if( is_single()):?>
					<?php comments_template( '', true ); ?>
                    <?php endif; ?>
				</div>
				
			<?php if( !is_single()):?>
            </div>
            <?php else: ?>
            </article>
            <?php endif; ?>

          <!--   <div class="pager-buttons">
		    	<?php //wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'landx' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
		    </div> -->


		    	<?php wp_link_pages( array( 'before' => '<div class="pager-buttons"><div class="page-links">' . __( 'Pages:', 'landx' ) , 'after' => '</div></div>', 'link_before' => '<span class="page-links-title">', 'link_after' => '</span>' ) ); ?>
		    
	</div>
	<!-- /END SINGLE POST STARTS -->
    
   
        
	