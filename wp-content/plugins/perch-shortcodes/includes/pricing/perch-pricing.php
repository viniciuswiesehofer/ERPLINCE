<?php
include 'pricing-post-type.php';
include 'meta-boxes-pricing.php';

function get_landx_pricing_table( $post_id = '' ){
	global $wpdb, $post;

	$output = '';
	// WP_Query arguments
	$args = array (
		'p'                      => $post_id,
		'post_type'              => 'pricing',
	);

	// The Query
	$query = new WP_Query( $args );

	// The Loop
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$featured = get_post_meta( get_the_ID(), 'featured', true );
			$featured_class = ( $featured == 'off' )? ' dark-bg' : ' color-bg';

			$output .= '<div class="package  bgcolor-white"><div class="header' .$featured_class. '">';
			$output .= '<h3>' .get_the_title(). '</h3>';
			$output .= '<div class="sub-heading">' .get_the_content(). '</div></div>';

			$output .= 	'<!-- PACKAGE FEATURES --><div class="package-features">';
			$feature_info = get_post_meta( get_the_ID(), 'feature_info', true );
			if( !empty($feature_info) ){
				$output .= '<ul>';
				foreach( $feature_info as $value ){
					$output .= '<li><div class="column-9p">' .$value['title']. '</div>';
					if( $value['type'] == 'text' ){
						$output .= '<div class="column-1p">' .$value['lavel_info']. '</div>';
					}else{
						$output .= ( $value['availibility'] == 'on' )? '<div class="column-1p"><span class="icon_check"></span></div>': '<div class="column-1p"><span class="icon_close"></span></div>';
					}
					$output .= '</li>';
				}
				$output .= '</ul>';
			}else{

			}
			$output .= '<div class="bottom-row">';
			$sign_up_text = get_post_meta( get_the_ID(), 'sign_up_text', true );
			$output .= ( $sign_up_text != '' )? '<div class="column-7p"><h6>'.$sign_up_text.'</h6></div>' : '';
			$button_link = get_post_meta( get_the_ID(), 'button_link', true );
			$button_text = get_post_meta( get_the_ID(), 'button_text', true );
			$button_text = ($button_text != '' )? $button_text : 'Sign up';
			if( $button_link != '' ){
				$button_class = ( $featured == 'off' )? ' secondary-button' : ' standard-button';
				$output .= '<div class="column-3p">
								<div class="cta-1">
									<a class="btn '.$button_class.'" href="' .$button_link. '">' .$button_text. '</a>
								</div>
							</div>';
			}
			

			$output .= '</div>';

			$output .= '</div>';	

			$output .= '</div><!-- package ' .get_the_title(). ' -->';
		}
	} 
	// Restore original Post Data
	//wp_reset_postdata();

	return $output;
}

function get_landx_pricing_table_callback( $atts ) {
		extract( shortcode_atts( array(
			'id'			=> ''
		), $atts ) );

		return get_landx_pricing_table($id);
}

add_shortcode( 'pricing_table' , 'get_landx_pricing_table_callback' );

function get_landx_pricing_tables(){
	global $wpdb, $post;

	$output = '';
	// WP_Query arguments
	$args = array (
		'post_type'              => 'pricing',
	);

	// The Query
	$query = new WP_Query( $args );
	// The Loop
	$output .= '<div class="pricing-table"><div class="row">';
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$output .= '<div class="col-md-4">'.get_landx_pricing_table( get_the_ID() ).'</div>';
		}
	} 
	$output .= '</div></div>';
	// Restore original Post Data
	//wp_reset_postdata();

	return $output;		
}

add_shortcode( 'pricing_tables' , 'get_landx_pricing_tables' );
?>