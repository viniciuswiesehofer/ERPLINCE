<?php
	$subtitle = '';
	if( is_single() || is_home() ){
		$title = ot_get_option('blog_title');
		$subtitle = ot_get_option('blog_subtitle');
	}elseif ( is_category() ){
		$title = __( 'Category Archives: ', 'landx' ).single_cat_title( '', false );
		if ( category_description() ) :
		$subtitle = category_description();
		endif;
	}elseif ( is_author() ){
		$title = __( 'Author Archives: ', 'landx' ).'<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a>';
		if ( category_description() ) :
		$subtitle = category_description();
		endif;
	} 
	elseif( is_tag() ) {
		$title = __( 'Tag Archives: ', 'landx' ).single_tag_title( '', false );
		if ( tag_description() ) :
		$subtitle = tag_description();
		endif;
	}elseif ( is_archive() ){
		 if ( is_day() ) :
				$title =  __( 'Daily Archives: ', 'landx' ).'<span>' . get_the_date() . '</span>';
			elseif ( is_month() ) :
				$title = __( 'Monthly Archives: ', 'landx' ). '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'landx' ) ) . '</span>' ;
			elseif ( is_year() ) :
				$title = __( 'Yearly Archives: ', 'landx' ).'<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'landx' ) ) . '</span>' ;
			else :
				$title = __( 'Archives', 'landx' );
			endif;
	} elseif(is_404()){
		$title = 'Page not found!';
		$subtitle = __( 'This is somewhat embarrassing.', THEMENAME);
	} elseif( is_page() ){
		$title = get_the_title();
		$subtitle = tag_description();
	}else {
		$title = get_the_title();
	}

	$custom_title = get_post_meta( get_the_ID(), 'custom_title', true );
	if( $custom_title == 'on' ){
		$alt_title = get_post_meta( get_the_ID(), 'title', true );
		$title = ( $alt_title != '' )? $alt_title : $title;

		$subtitle = get_post_meta( get_the_ID(), 'subtitle', true );
		$subtitle = ( $subtitle != '' )? '<div class="blog-description">'.esc_attr($subtitle).'</div>' : '';
	}


?>
<?php 
$header_bg = get_post_meta( get_the_ID(), 'header_bg', true );
$custom__header_bg_type = get_post_meta( get_the_ID(), 'custom__header_bg_type', true );
$custom__header_slider = get_post_meta( get_the_ID(), 'custom__header_slider', true );
if($header_bg == 'on' && $custom__header_bg_type == 'slider' && $custom__header_slider != ''){ ?>
<div class="slider-wrapper">	
<?php	echo do_shortcode($custom__header_slider); ?>
</div>
<?php } else { ?>
<div class="color-overlay">
	<div class="blog-intro">
		<div class="container">
			<h1 class="blog-title intro white-text"><?php echo esc_attr($title); ?></h1>		
			<?php echo $subtitle; ?>		
			<?php  
				$show_breadcrumbs = (function_exists('ot_get_option'))? ot_get_option('show_breadcrumbs', 'off') : 'off';
  				if( $show_breadcrumbs != 'off' )landx_breadcrumbs(); 
  			?>
		</div>
	</div>
</div>
<?php } ?>

