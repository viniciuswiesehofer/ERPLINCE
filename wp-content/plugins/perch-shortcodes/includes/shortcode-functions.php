<?php
/*
 * Allow shortcodes in widgets
 * @since v1.0
 */
add_filter('widget_text', 'do_shortcode');



/*
 * Fix Shortcodes
 * @since v1.0
 */
if( !function_exists('perch_fix_shortcodes') ) {
	function perch_fix_shortcodes($content){
		$array = array (
			'<p>['		=> '[', 
			']</p>'		=> ']', 
			']<br />'	=> ']'
		);
		$content = strtr($content, $array);
		return $content;
	}
}
add_filter('the_content', 'perch_fix_shortcodes');


/*
 * Clear Floats
 * @since v1.0
 */
if( !function_exists('perch_clear_floats_shortcode') ) {
	function perch_clear_floats_shortcode() {
		return '<div class="perch-clear-floats"></div>';
	}
}
add_shortcode( 'perch_clear_floats', 'perch_clear_floats_shortcode' );


/*
 * Callout
 * @since v1.4
 */
if( !function_exists('perch_callout_shortcode') ) {
	function perch_callout_shortcode( $atts, $content = NULL ) {
		extract( shortcode_atts( array(
			'caption'				=> '',
			'button_text'			=> '',
			'button_color'			=> 'blue',
			'button_url'			=> 'http://themeperch.com',
			'button_rel'			=> 'nofollow',
			'button_target'			=> 'blank',
			'button_border_radius'	=> '',
			'button_size'			=> '',
			'class'					=> '',
			'button_icon_left'		=> '',
			'button_icon_right'		=> '',
			'visibility'			=> 'all',
			'fade_in'				=> '',
		), $atts ) );
		$fade_in_class = NULL;
		if ( $fade_in == 'true' ) {
			wp_enqueue_script('perch_scroll_fade');
			$fade_in_class = 'perch-fadein';
		}
		$icon_left = str_replace("|"," ",$button_icon_left) ;
		$icon_right = str_replace("|"," ",$button_icon_right) ;


		$border_radius_style = ( $button_border_radius ) ? 'style="border-radius:'. intval($button_border_radius) .'px; background-color: '.$button_color.';"' : NULL;

		$output = '<div class="perch-callout perch-clearfix '. $class .' perch-'. $visibility .' '. $fade_in_class .'">';
		if ( $button_text !== '' ) {
			$output .= '<div class="perch-callout-button">';
				$output .='<a href="'. esc_url($button_url) .'" title="'. $button_text .'" target="_'. $button_target .'" class="perch-button '. $button_size .' " '. $border_radius_style .'><span class="perch-button-inner" '. $border_radius_style .'>';
				if ( $icon_left !== '' && $icon_left !== 'none' ) {
					$output .= '<i class="perch-callout-icon-left '. $icon_left .'"></i>';
				}
				$output .= $button_text;
				if ( $icon_right !== '' && $icon_right !== 'none' ) {
					$output .= '<i class="perch-callout-icon-right '. $icon_right .'"></i>';
				}
			$output .='</span></a>';
			$output .='</div>';
		}
		$output .= '<div class="perch-callout-caption">';

			$output .= do_shortcode ( $content );
		$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
}
add_shortcode( 'perch_callout', 'perch_callout_shortcode' );


/*
 * Skillbars
 * @since v1.3
 */
if( !function_exists('perch_skillbar_shortcode') ) {
	function perch_skillbar_shortcode( $atts  ) {
		extract( shortcode_atts( array(
			'title'			=> '',
			'percentage'	=> '100',
			'color'			=> '#6adcfa',
			'class'			=> '',
			'show_percent'	=> 'true',
			'visibility'	=> 'all',
		), $atts ) );
		
		// Enque scripts
		wp_enqueue_script('perch_skillbar');
		
		// Display the accordion	';
		$output = '<div class="perch-skillbar perch-clearfix '. $class .' perch-'. $visibility .'" data-percent="'. intval( $percentage ) .'%">';
			if ( $title !== '' ) $output .= '<div class="perch-skillbar-title" style="background: '. $color .';"><span>'. $title .'</span></div>';
			$output .= '<div class="perch-skillbar-bar" style="background: '. $color .';"></div>';
			if ( $show_percent == 'true' ) {
				$output .= '<div class="perch-skill-bar-percent">'.$percentage.'%</div>';
			}
		$output .= '</div>';
		
		return $output;
	}
}
add_shortcode( 'perch_skillbar', 'perch_skillbar_shortcode' );

/*
 * Spacing
 * @since v1.0
 */
if( !function_exists('perch_spacing_shortcode') ) {
	function perch_spacing_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'size'	=> '20',
			'class'	=> '',
		),
		$atts ) );
	 return '<hr class="perch-spacing '. $class .'" style="height: '. intval($size) .'px" />';
	}
}
add_shortcode( 'perch_spacing', 'perch_spacing_shortcode' );

/**
* Social Icons
* @since 1.0
*/
if( !function_exists('perch_social_shortcode') ) {
	function perch_social_shortcode( $atts ){   
		extract( shortcode_atts( array(
			'icon'				=> 'dashicons|dashicons-facebook-alt',
			'url'				=> 'http://www.twitter.com/themeperch',
			'title'				=> 'Follow Us',
			'target'			=> 'self',
			'rel'				=> '',
			'border_radius'		=> '',
			'class'				=> '',
		), $atts ) );
		$icon_class = str_replace("|"," ",$icon) ;
		$border_radius_style = ( $border_radius ) ? ' style="border-radius:'. intval($border_radius) .'px;" ' : NULL;

		return '<a href="' . esc_url($url) . '" class="perch-social-icon '. $class .'" target="_'.$target.'" title="'. $title .'" rel="'. $rel .'"
'.$border_radius_style.'><i class="'.$icon_class.'"></i></a>';
	}
}
add_shortcode('perch_social', 'perch_social_shortcode');

/**
* Highlights
* @since 1.0
*/
if ( !function_exists( 'perch_highlight_shortcode' ) ) {
	function perch_highlight_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'color'			=> 'yellow',
			'class'			=> '',
			'visibility'	=> 'all',
		),
		$atts ) );
		$style = ( $color ) ? ' style="background-color:'. $color .';" ' : NULL;
		return '<span class="perch-highlight '. $class .' perch-'. $visibility .'"'.$style.'>' . do_shortcode( $content ) . '</span>';
	
	}
}
add_shortcode('perch_highlight', 'perch_highlight_shortcode');


/*
 * Buttons
 * @since v1.0
 */
if( !function_exists('perch_button_shortcode') ) {
	function perch_button_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'color'				=> 'blue',
			'url'				=> 'http://www.themeperch.com',
			'title'				=> 'Visit Site',
			'target'			=> 'self',
			'size'				=> '',
			'rel'				=> '',
			'border_radius'		=> '',
			'class'				=> '',
			'icon_left'			=> '',
			'icon_right'		=> '',
			'visibility'		=> 'all',
		), $atts ) );
		
		
		$border_radius_style = ( $border_radius ) ? 'style="border-radius:'. intval($border_radius) .'px; background-color: '.$color.';"' : NULL;
		$rel = ( $rel ) ? 'rel="'.$rel.'"' : NULL;

		$icon_left = str_replace("|"," ",$icon_left) ;
		$icon_right = str_replace("|"," ",$icon_right) ;
		
		$button = NULL;
		$button .= '<a href="' . $url . '" class="perch-button '. $size .' '. $class .' perch-'. $visibility .'" target="_'.$target.'" title="'. $title .'" '. $border_radius_style .' '. $rel .'>';
			$button .= '<span class="perch-button-inner" '.$border_radius_style.'>';
				if ( $icon_left !== '' ) {
					$button .= '<i class="perch-callout-icon-left '. $icon_left .'"></i>';
				}
				$button .= $title;
				if ( $icon_right !== '' ) {
					$button .= '<i class="perch-callout-icon-right '. $icon_right .'"></i>';
				}
			$button .= '</span>';
		$button .= '</a>';
		return $button;
	}
}
add_shortcode('perch_button', 'perch_button_shortcode');



/*
 * Boxes
 * @since v1.0
 *
 */
if( !function_exists('perch_box_shortcode') ) { 
	function perch_box_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'color'				=> 'gray',
			'float'				=> 'center',
			'text_align'		=> 'left',
			'width'				=> '100',
			'margin_top'		=> '',
			'margin_bottom'		=> '',
			'class'				=> '',
			'visibility'		=> 'all',
			'fade_in'			=> 'false',
		), $atts ) );
		$fade_in_class = NULL;
		if ( $fade_in == 'true' ) {
			wp_enqueue_script('perch_scroll_fade');
			$fade_in_class = 'perch-fadein';
		}
		$style_attr = '';
		if( $margin_bottom ) {
			$style_attr .= 'margin-bottom: '. $margin_bottom .'px;';
		}
		if ( $margin_top ) {
			$style_attr .= 'margin-top: '. $margin_top .'px;';
		}
		$style_attr .= ( $color ) ? 'background-color:'. $color .';' : NULL;

		$alert_content = '';
		$alert_content .= '<div class="perch-box '. $fade_in_class .'  ' . $color . ' '.$float.' '. $class .' perch-'. $visibility .'" style="text-align:'. $text_align .'; width:'. $width .'%;'. $style_attr .'">';
		$alert_content .= ' '. do_shortcode($content) .'</div>';
		return $alert_content;
	}
}
add_shortcode( 'perch_box', 'perch_box_shortcode' );



/*
 * Testimonial
 * @since v1.0
 *
 */

function testimonial_landx_group( $atts, $content = NULL) {
	extract( shortcode_atts( array(
			'class'			=> '',
		), $atts ) );
	$html = '<div class="row testimonials">
		<div id="feedbacks" class="owl-carousel owl-theme">';
	$html .=do_shortcode ( $content );
	$html .='</div>
	</div>';
	return $html;
}

add_shortcode('perch-testimonials-group', 'testimonial_landx_group');

function landx_testimonial_single ($atts, $content = NULL) {
	extract( shortcode_atts( array(
			'name'				=> '',
			'title'			=> '',
			'website'			=> '',
			'image'			=> '',
		), $atts ) );

	if( $image > 0 ){
		$arr = explode(',', $image);
		//print_r($arr);
		$image_attributes = wp_get_attachment_image_src( intval($arr[0]), 'full' );
		$image_url = $image_attributes[0];
	}else{
		$image_url = '';
	}
	

	$html = '<div class="single-feedback">
				<div class="client-pic">';
				if($image_url !=''){				
					$resize_image_url = landx_image_resize($image_url, 71, 71, true, '', false);
					$html .= '<img src="'.$resize_image_url.'" alt="client image">';
				} else {
					$html .= '<img src=" http://placehold.it/71x71" alt="client image">';
				}
				$html .= '</div>
				<div class="box">
					<p class="message">'.$content.'</p>
				</div>
				<div class="client-info">
					<div class="client-name colored-text strong">'.$name.'</div>
					<div class="company">'.$title.'</div>
				</div>
			</div>';
	return $html;
}

add_shortcode('perch-testimonial','landx_testimonial_single');

// screenshot shortcode



function perch_carousel_callback( $atts=array() ){
	extract( shortcode_atts( array(
		'images' => '',
		'thumb_width' => 400,
		'thumb_height' => 272,
		), $atts ) );
	$output = '';

	if($images != ''){
		$output = '<div class="row screenshots"><div id="screenshots" class="owl-carousel owl-theme">';
		
		if( $images != '' ){
			$arr = explode(',', $images);
			foreach ($arr as $key => $value) {
				if( $value > 0 ):
					$image_attributes = wp_get_attachment_image_src( $value, 'full' );
					$url = $image_attributes[0];
					$resize_image_url = perch_image_resize($url, $thumb_width, $thumb_height, true, '', false);

						$output .= '<div class="shot">
						<a href="'.$url.'" data-lightbox-gallery="screenshots-gallery"><img src="'.$resize_image_url.'" alt="image"></a>
					</div>';
				endif;
			}
			
			
		}else{
			$image_url = '';
		}
		
		$output .= '</div></div>';
	}
	return $output;
}
add_shortcode( 'perch-carousel', 'perch_carousel_callback' );


function perch_clients_logo_callback( $atts=array() ){
	extract( shortcode_atts( array(
		'images' => ''
		), $atts ) );
	$output = '';

	if($images != ''){
		$output = '<ul class="client-logos">';
		
		if( $images != '' ){
			$arr = explode(',', $images);
			foreach ($arr as $key => $value) {
				if( $value > 0 ):
					$image_attributes = wp_get_attachment_image_src( $value, 'full' );
					$url = $image_attributes[0];
					if( $url != '' )				
					$output .= '<li><a href="'.$url.'"><img src="'.$url.'" alt="image"></a></li>';
				endif;
			}
			
			
		}else{
			$image_url = '';
		}
		
		$output .= '</ul>';
	}
	return $output;
}

add_shortcode( 'perch-clients-logo', 'perch_clients_logo_callback' );

/*
 * Columns
 * @since v1.0
 *
 */
if( !function_exists('perch_column_shortcode') ) {
	function perch_column_shortcode( $atts, $content = null ){
		extract( shortcode_atts( array(
			'size'			=> 'one-third',
			'position'		=>'first',
			'class'			=> '',
			'visibility'	=> 'all',
			'fade_in'		=> 'false',
		), $atts ) );
		$fade_in_class = '';
		if ( $fade_in == 'true' ) {
			wp_enqueue_script('perch_scroll_fade');
			$fade_in_class = 'perch-fadein';
		}
		return '<div class="perch-column perch-' . $size . ' perch-column-'.$position.' '. $class .' '. $fade_in_class .' perch-'. $visibility .'">' . do_shortcode($content) . '</div>';
	}
}
add_shortcode('perch_column', 'perch_column_shortcode');



/*
 * Toggle
 * @since v1.0
 */
if( !function_exists('perch_toggle_shortcode') ) {
	function perch_toggle_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title'			=> 'Toggle Title',
			'class'			=> '',
			'visibility'	=> 'all',
			'state'       => ''
		), $atts ) );
		
		// Enque scripts
		wp_enqueue_script('perch_toggle');
		
		// Display the Toggle
		return '<div class="perch-toggle '. $class .' perch-'. $visibility .' '.$state.'"><h3 class="perch-toggle-trigger">'. $title .'</h3><div class="perch-toggle-container">' . do_shortcode($content) . '</div></div>';
	}
}
add_shortcode('perch_toggle', 'perch_toggle_shortcode');


/*
 * Accordion
 * @since v1.0
 *
 */

// Main
if( !function_exists('perch_accordion_main_shortcode') ) {
	function perch_accordion_main_shortcode( $atts, $content = null  ) {
		
		extract( shortcode_atts( array(
			'class'			=> '',
			'visibility'	=> 'all',
		), $atts ) );
		
		// Enque scripts
		wp_enqueue_script('jquery-ui-accordion');
		wp_enqueue_script('perch_accordion');
		
		// Display the accordion	
		return '<div class="perch-accordion '. $class .' perch-'. $visibility .'">' . do_shortcode($content) . '</div>';
	}
}
add_shortcode( 'perch_accordion', 'perch_accordion_main_shortcode' );


// Section
if( !function_exists('perch_accordion_section_shortcode') ) {
	function perch_accordion_section_shortcode( $atts, $content = null  ) {
		extract( shortcode_atts( array(
			'title'	=> 'Title',
			'class'	=> '',
		), $atts ) );
		return '<h3 class="perch-accordion-trigger '. $class .'"><a href="#">'. esc_attr($title) .'</a></h3><div>' . do_shortcode($content) . '</div>';
	}
}
add_shortcode( 'perch_accordion_section', 'perch_accordion_section_shortcode' );


/*
 * Tabs
 * @since v1.0
 *
 */
if (!function_exists('perch_tabgroup_shortcode')) {
	function perch_tabgroup_shortcode( $atts, $content = null ) {
		
		//Enque scripts
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('perch_tabs');
		
		// Display Tabs
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );
		preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
		$tab_titles = array();
		if( isset($matches[1]) ){ $tab_titles = $matches[1]; }
		$output = '';
		if( count($tab_titles) ){
			$output .= '<div id="perch-tab-'. rand(1, 100) .'" class="perch-tabs">';
			$output .= '<ul class="ui-tabs-nav perch-clearfix">';
			foreach( $tab_titles as $tab ){
				$output .= '<li><a href="#perch-tab-'. sanitize_title( $tab[0] ) .'">' . esc_attr($tab[0]) . '</a></li>';
			}
			$output .= '</ul>';
			$output .= do_shortcode( $content );
			$output .= '</div>';
		} else {
			$output .= do_shortcode( $content );
		}
		return $output;
	}
}
add_shortcode( 'perch_tabgroup', 'perch_tabgroup_shortcode' );

if (!function_exists('perch_tab_shortcode')) {
	function perch_tab_shortcode( $atts, $content = null ) {
		$defaults = array(
			'title'			=> 'Tab',
			'class'			=> '',
			'visibility'	=> 'all',
		);
		extract( shortcode_atts( $defaults, $atts ) );
		return '<div id="perch-tab-'. sanitize_title( $title ) .'" class="tab-content '. $class .' perch-'. $visibility .'">'. do_shortcode( $content ) .'</div>';
	}
}
add_shortcode( 'perch_tab', 'perch_tab_shortcode' );




/*
 * Pricing Table
 * @since v1.0
 *
 */
 
/*main*/
if( !function_exists('perch_pricing_table_shortcode') ) {
	function perch_pricing_table_shortcode( $atts, $content = null  ) {
		extract( shortcode_atts( array(
			'class'			=> '',
			'visibility'	=> 'all',
		), $atts ) );
		return '<div class="perch-pricing-table '. $class .' perch-'. $visibility .'">' . do_shortcode($content) . '</div><div class="perch-clear-floats"></div>';
	}
}
add_shortcode( 'perch_pricing_table', 'perch_pricing_table_shortcode' );

/*
 * Heading
 * @since v1.1
 */
if( !function_exists('perch_heading_shortcode') ) {
	function perch_heading_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'title'			=> __('Sample Heading', 'perch'),
			'type'			=> 'h2',
			'style'			=> 'double-line',
			'margin_top'	=> 10,
			'margin_bottom'	=> 10,
			'text_align'	=> '',
			'font_size'		=> 14,
			'color'			=> '#323232',
			'class'			=> '',
			'heading_icon_left'		=> '',
			'heading_icon_right'	=> ''
		),
		$atts ) );

		

		$style_attr = '';
		if ( $font_size ) {
			$style_attr .= 'font-size: '. $font_size .'px;';
		}
		if ( $color ) {
			$style_attr .= 'color: '. $color .';';
		}
		if( $margin_bottom ) {
			$style_attr .= 'margin-bottom: '. intval($margin_bottom) .'px;';
		}
		if ( $margin_top ) {
			$style_attr .= 'margin-top: '. intval($margin_top) .'px;';
		}
		
		if ( $text_align ) {
			$text_align = 'text-align-'. $text_align;
		} else {
			$text_align = 'text-align-left';
		}

		$heading_icon_left = str_replace("|"," ",$heading_icon_left) ;
		$heading_icon_right = str_replace("|"," ",$heading_icon_right) ;
		
	 	$output = '<'.$type.' class="perch-heading perch-heading-'. $style .' '. $text_align .' '. $class .'" style="'.$style_attr.'"><span>';
		if ( $heading_icon_left !== '' && $heading_icon_left !== 'none' ) $output .= '<i class="perch-heading-icon-left '. $heading_icon_left .'"></i>';
			$output .= $title;
		if ( $heading_icon_right !== '' && $heading_icon_right !== 'none' ) $output .= '<i class="perch-heading-icon-right '. $heading_icon_right .'"></i>';
		$output .= '</'.$type.'></span>';
		
		return $output;
	}
}
add_shortcode( 'perch_heading', 'perch_heading_shortcode' );


/*
 * Google Maps
 * @since v1.1
 */
if (! function_exists( 'perch_shortcode_googlemaps' ) ) {
	function perch_shortcode_googlemaps($atts, $content = null) {
		
		extract(shortcode_atts(array(
				'title'			=> '',
				'location'		=> '',
				'width'			=> '',
				'height'		=> '300',
				'zoom'			=> 8,
				'align'			=> '',
				'class'			=> '',
				'visibility'	=> 'all',
		), $atts));
		
		// load scripts
		wp_enqueue_script('perch_googlemap');
		wp_enqueue_script('perch_googlemap_api');
		
		
		$output = '<div id="map_canvas_'.rand(1, 100).'" class="googlemap '. $class .' perch-'. $visibility .'" style="height:'.$height.'px;width:'.$width.'%;">';
			$output .= ( !empty( $title ) ) ? '<input class="title" type="hidden" value="'. $title .'" />' : '';
			$output .= '<input class="location" type="hidden" value="'.$location.'" />';
			$output .= '<input class="zoom" type="hidden" value="'.$zoom.'" />';
			$output .= '<div class="map_canvas"></div>';
		$output .= '</div>';
		
		return $output;
	}
}
add_shortcode("perch_googlemap", "perch_shortcode_googlemaps");


/*
 * Divider
 * @since v1.1
 */
if( !function_exists('perch_divider_shortcode') ) {
	function perch_divider_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'style'				=> 'fadeout',
			'margin_top'		=> '20px',
			'margin_bottom'		=> '20px',
			'class'				=> '',
			'visibility'		=> 'all',
		),
		$atts ) );
		$style_attr = '';
		if ( $margin_top && $margin_bottom ) {  
			$style_attr = 'style="margin-top: '. intval($margin_top) .'px;margin-bottom: '. intval($margin_bottom) .'px;"';
		} elseif( $margin_bottom ) {
			$style_attr = 'style="margin-bottom: '. intval($margin_bottom) .'px;"';
		} elseif ( $margin_top ) {
			$style_attr = 'style="margin-top: '. intval($margin_top) .'px;"';
		} else {
			$style_attr = NULL;
		}
	 return '<hr class="perch-divider '. $style .' '. $class .' perch-'. $visibility .'" '.$style_attr.' />';
	}
}
add_shortcode( 'perch_divider', 'perch_divider_shortcode' );

if( !function_exists('perch_posts_blog_shortcode') ) {
	function perch_posts_blog_shortcode($atts) {
		extract( shortcode_atts( array(
			'column'				=> 3,
			'posts_per_page'		=> 4,
			'orderby' 				=> 'title',
			'order' 				=> 'DESC',
			'see_all_posts_text'	=> ''			
		),
		$atts ) );
		$col = 12/$column;
	?>
	<div class="posts-blog-page">
	<?php
	query_posts( array( 'posts_per_page' => $posts_per_page, 'orderby' => $orderby, 'order' => $order ) );
	// Posts are found
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
	?>
	<div id="blog-post-<?php the_ID(); ?>" class="col-lg-<?php echo $col;?> col-md-<?php echo $col;?> col-sm-<?php echo $col;?> col-xs-12">
    <?php if( has_post_thumbnail() ){
		$fullsize = wp_get_attachment_image_src(get_post_thumbnail_id( get_the_ID() ), 'full');
		$url = $fullsize[0];
		?>
       <div class="blog-post-thumb">
        <?php $image_resize = perch_image_resize( $url, 400, 300 ); ?>
        <a href="<?php the_permalink(); ?>"><img src="<?php echo $image_resize; ?>" alt="<?php the_title(); ?>" /></a>
        </div>
   <?php } ?>
    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </div>
	<?php
		}
	}
	// Posts not found
	else {
	?>
	<div><?php _e( 'Posts not found', 'tp' ) ?></div>
	<?php
	}
	?>
	</div>
    <?php if($see_all_posts_text != '' ){ ?>
    <div class="view-all-posts"><a href="<?php echo get_permalink( get_option( 'page_for_posts' ) );?>"><?php echo $see_all_posts_text; ?></a></div>
    <?php } ?>
	<?php
	}
}
add_shortcode( 'perch_blog_posts', 'perch_posts_blog_shortcode' );
?>