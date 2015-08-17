<?php
/**
 * Enqueue scripts and styles for the front end.
 *
 */
function landx_scripts() {
	// Add Lato font, used in the main stylesheet.
	$font_url = landx_get_font_url();
	if ( ! empty( $font_url ) )
	wp_enqueue_style( 'landx-fonts', esc_url_raw( $font_url ), array(), null );
	wp_enqueue_style( 'bootstrap-min', THEMEURI . 'css/bootstrap.min.css', array(), null );
	wp_enqueue_style( 'ionicons', THEMEURI . 'assets/ionicons/css/ionicons.css', array(), null );
	wp_enqueue_style( 'elegant-icon-style', THEMEURI . 'assets/elegant-icons/style.css', array(), null );
	wp_enqueue_style( 'landx-blue', THEMEURI . 'css/colors/blue.css', array(), null );
	

	
	wp_enqueue_style( 'landx-styles', THEMEURI . 'css/styles.css', array(), null );
	wp_enqueue_style( 'landx-blog', THEMEURI . 'css/blog.css', array(), null );
	wp_enqueue_style( 'landx-owl-theme', THEMEURI . 'css/owl.theme.css', array(), null );
	wp_enqueue_style( 'landx-carousel-owl', THEMEURI . 'css/owl.carousel.css', array(), null );
	wp_enqueue_style( 'landx-nivo-lightbox', THEMEURI . 'css/nivo-lightbox.css', array(), null );
	wp_enqueue_style( 'landx-default', THEMEURI . 'css/nivo_themes/default/default.css', array(), null );
	wp_enqueue_style( 'landx-animate', THEMEURI . 'css/animate.css', array(), null );
	
	wp_enqueue_style( 'landx-woocommerce', THEMEURI . 'css/woocommerce.css', array(), null );
	
	

	// Load our main stylesheet.
	wp_enqueue_style( 'landx-style', get_stylesheet_uri() );
	wp_enqueue_style( 'landx-responsive', THEMEURI . 'css/responsive.css', array( 'landx-style' ), null );


	//scripts
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	wp_enqueue_script( 'jquery' );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	wp_register_script( 'landx-ajaxchimp', THEMEURI . 'js/jquery.ajaxchimp.min.js', array( 'jquery' ), '', true );
	wp_register_script( 'landx-ajaxchimplangs', THEMEURI . 'js/jquery.ajaxchimp.langs.min.js', array( 'jquery' ), '', true );
	wp_localize_script( 'landx-ajaxchimp', 'landx', array('mailchimp_post_url' => esc_url(ot_get_option('mailchimp_post_url')), 'themeuri' => THEMEURI, 'ajax_url' => admin_url( 'admin-ajax.php' )) );
	wp_enqueue_script('landx-ajaxchimp');

	// Adds JavaScript.
	wp_enqueue_script( 'landx-bootstrap', THEMEURI . 'js/bootstrap.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'landx-smoothscroll', THEMEURI . 'js/smoothscroll.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'landx-scrollTo', THEMEURI . 'js/jquery.scrollTo.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'landx-localScroll', THEMEURI . 'js/jquery.localScroll.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'landx-carousel', THEMEURI . 'js/owl.carousel.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'landx-nivo-lightbox', THEMEURI . 'js/nivo-lightbox.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'landx-simple-expand', THEMEURI . 'js/simple-expand.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'landx-jquery.nav', THEMEURI . 'js/jquery.nav.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'landx-fitvids', THEMEURI . 'js/jquery.fitvids.js', array( 'jquery' ), '', true );
	
	wp_enqueue_script( 'landx-visible', THEMEURI . 'js/jquery.visible.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'landx-custom', THEMEURI . 'js/custom.js', array( 'jquery' ), '', true );

	
	
}
add_action( 'wp_enqueue_scripts', 'landx_scripts' );

function landx_dynamic_style_load_to_header(){	
	if( function_exists('ot_get_option') ){
		load_template( THEMEDIR . '/inc/style.php' );
		echo ot_get_option('google_analytic_code');
		echo '<style>'.ot_get_option('custom_css').'</style>';
		
	}	

	
}
add_action( 'wp_head', 'landx_dynamic_style_load_to_header' );

function landx_dynamic_style_load_to_footer(){	
	if( function_exists('ot_get_option') ){
		echo ot_get_option( 'footer_scripts' );
	}	

	//wp_enqueue_script( 'landx-retina', THEMEURI . 'js/retina-1.1.0.min.js', array( 'jquery' ), '3.1.5', true );
	
}
add_action( 'wp_footer', 'landx_dynamic_style_load_to_footer' );

function print_landx_inline_script() {
	$background_type = get_post_meta(get_the_ID(), 'onepage_header_style', true);
	if( $background_type == 'image_slider' ){
                  
    	$attachments = get_post_meta(get_the_ID(), 'onepage_image_slider', true);
    	$arr = explode(',', $attachments);
    	if( !empty($arr) ):
    		wp_enqueue_style( 'landx-vegas', THEMEURI . 'css/vegas.css', array(), null );
    		wp_enqueue_script( 'landx-vegas', THEMEURI . '/js/vegas.min.js', array( 'jquery' ), '1.0', true );
  			?>
			<script type="text/javascript">
				jQuery( function() {
					jQuery('header, body').vegas({
     
						slides:[
							<?php 
								foreach( $arr as $id ){
									$image_attributes = wp_get_attachment_image_src( $id, 'full' ); 
									echo ($image_attributes[0] != '')? "{ src:'".$image_attributes[0]."', fade:1500 }," : "";
								}
							 ?>							
						],
						loading:false
					})
				});
			</script>
			<style>.landx-onepage header{background-image:none; position: relative; z-index: 9999;}</style>
			<?php 
		endif;
  	}
}
add_action( 'wp_footer', 'print_landx_inline_script' );
?>