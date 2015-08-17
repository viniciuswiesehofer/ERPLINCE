<style>
<?php

landx_dynamic_css();

?>


<?php
if ( is_page_template( 'page-templates/one-page.php' ) ) {

	if( get_post_meta( get_the_ID(), 'onepage_preloader', true ) != THEMEURI . 'admin/assets/images/loading.gif'){
		echo '.preloader{ background-image: url('.esc_url(get_post_meta( get_the_ID(), 'onepage_preloader', true )).') }';
		echo '.status {background-image: none;}';
	} else {
	echo '.preloader{ background-image: url('.esc_url(get_post_meta( get_the_ID(), 'onepage_preloader', true )).') }
	';
	}
	echo '.landx-onepage header{ background-image: url('.esc_url(get_post_meta( get_the_ID(), 'background', true )).') }';
	

	$pages = get_post_meta( get_the_ID(), 'pages', true );
	if( !empty($pages) ):
		foreach ($pages as $p):
			$bg_style = get_post_meta( $p['page_id'], 'bg_style', true );
			if( isset($p['page_id']) && ($bg_style == 'dark') ):

				$background = get_post_meta( $p['page_id'], 'background', true );
				if( $background != '' ){
					echo '.onepage-'.get_the_ID().'.section'.$p['page_id'].'{ ';
					echo 'background-image: url('.esc_url($background).');';
				 	echo ' }';
				}
				
			

			endif; //if( isset($value['page_id']) ):
		endforeach;

	endif; //if( !empty($pages) )
	echo '';
}else{
	$header_bg = get_post_meta( get_the_ID(), 'header_bg', true );
	$custom__header_bg = get_post_meta( get_the_ID(), 'custom__header_bg', true );
	
	if(($header_bg == 'on') && ($custom__header_bg != '') ){	
			echo ( $custom__header_bg != '' )? '.page header{ background-image: url('.esc_url($custom__header_bg).') }' : '';
	}

	$header_bg = ot_get_option('blog_header_bg');
	echo ( $header_bg != '' )? 'header{ background-image: url('.esc_url($header_bg).') }' : '';
}

if ( is_page_template( 'page-templates/squeeze-page.php' ) ) {
	echo '.landx-onepage header{ background-image: url('.esc_url(get_post_meta( get_the_ID(), 'background', true )).') }';
}
?>

</style>