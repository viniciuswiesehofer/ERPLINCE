<?php

/**
 * Register sidebars.
 *
 * Registers our main widget area and the front page widget areas.
 *
 * @since landx 1.0
 */
function landx_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', THEMENAME ),
		'id' => 'sidebar-1',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', THEMENAME ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	if( function_exists( 'ot_get_option' ) ):
		$sidebarArr = ot_get_option( 'create_sidebar', array() );
		if( !empty( $sidebarArr ) ){
			$i = 4;
			foreach ($sidebarArr as $sidebar) {

				register_sidebar( array(
					'name' => $sidebar['title'],
					'id' => 'sidebar-'.$i,
					'description' => $sidebar['desc'],
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<h3 class="widget-title">',
					'after_title' => '</h3>',
				) );

				$i++;
			}
		}
	endif;	//if( function_exists( 'ot_get_option' ) ):

	
}
add_action( 'widgets_init', 'landx_widgets_init' );
?>