<?php
$bg_style = get_post_meta( get_the_ID(), 'bg_style', true );
$title = get_the_title();
$subtitle = '';

$custom_title = get_post_meta( get_the_ID(), 'custom_title', true );
if( $custom_title == 'on' ){
	$alt_title = get_post_meta( get_the_ID(), 'title', true );
	$title = ( $alt_title != '' )? $alt_title : $title;

	$subtitle = get_post_meta( get_the_ID(), 'subtitle', true );
	$subtitle = ( $subtitle != '' )? '<div class="sub-heading">'.esc_attr($subtitle).'</div>' : '';
}

$display_page_title = get_post_meta( get_the_ID(), 'display_page_title', true );


$content_alignment = get_post_meta( get_the_ID(), 'content_alignment', true );
$class = ( $content_alignment == 'left' )? ' text-left' : 'text-center';
$line_class = ( $content_alignment == 'left' )? ' pull-left' : '';


//mailclimp form settings
$form_display = get_post_meta( get_the_ID(), 'form_display', true );
$form_position = get_post_meta( get_the_ID(), 'form_position', true );
$container_class = ( ($form_display == 'on') && (  $form_position == 'right' ) )? 'col-md-7 col-sm-7': 'col-md-12 col-sm-12';
$form_container_class = ( ($form_display == 'on') && (  $form_position == 'right' ) )? 'col-md-5 col-sm-5': 'col-md-12 col-sm-12';
?>
			

<?php
//animation
$title_animation = get_post_meta( get_the_ID(), 'title_animation', true );
$content_animation = get_post_meta( get_the_ID(), 'content_animation', true );
$featured_image_animation = get_post_meta( get_the_ID(), 'featured_image_animation', true );
$form_animation = get_post_meta( get_the_ID(), 'form_animation', true );
?>
<div class="row">							
	<div class="<?php echo $container_class ?>"><!-- LEFT - HEADING AND TEXTS -->
		<?php
			if( has_post_thumbnail() ):
				$fullsize = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'full');
				$url = $fullsize[0];
				$image_position = get_post_meta( get_the_ID(), 'image_position', true );	
				$image_class = ( $image_position == 'left' )? 'pull-left' : ' pull-right';		
			?>
			<div class="row">
				<div class="col-md-6 col-lg-6 <?php echo $image_class; ?>">
					<div class="side-screenshot pull-left<?php echo $featured_image_animation ?>"><img class="featured-image" src="<?php echo $url ?>" alt="<?php the_title() ?>"></div>
				</div>	
				<div class="col-md-6">
					<div class="content-wrap <?php echo $class ;?>">

						<?php if($display_page_title == 'on'): ?>
							<div class="onepage-title<?php echo $title_animation ?>">
								<h2><?php echo esc_attr($title); ?></h2>		
								<div class="colored-line<?php echo $line_class; ?>"></div>
								<?php echo $subtitle; ?>
							</div>
						<?php endif; ?>	

						<div class="content<?php echo $content_animation ?>">
							<?php the_content(); ?>
						</div><!--.content-->
					</div>	
				</div>																			
			</div><!--.row-->
		<?php else: ?>		
			<div class="content-wrap <?php echo $class ;?>">		
				<?php if($display_page_title == 'on'): ?>
					<div class="onepage-title<?php echo $title_animation ?>">
						<h2><?php echo esc_attr($title); ?></h2>		
						<div class="colored-line<?php echo $line_class; ?>"></div>
						<?php echo $subtitle; ?>
					</div>
				<?php endif; ?>		

				<div class="content<?php echo $content_animation ?>">										
					<?php the_content(); ?>
				</div><!--.content-->
			</div><!--.content-wrap-->
		<?php endif; //if( has_post_thumbnail() ):?>
		<?php get_template_part( 'inc/jump', 'button' ); ?>
	</div>			
	<div class="<?php echo $form_container_class.$form_animation ?>"><!-- RIGHT - REGISTRATION FORM -->
		<?php get_template_part( 'inc/subcription', 'form' ); ?>
	</div>	
</div><!--.row-->