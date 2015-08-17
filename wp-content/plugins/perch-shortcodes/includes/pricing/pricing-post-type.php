<?php
if ( ! function_exists('landx_pricing_post_type') ) {

// Register Custom Post Type
function landx_pricing_post_type() {

	$labels = array(
		'name'                => _x( 'Pricing tables', 'Post Type General Name', 'landx' ),
		'singular_name'       => _x( 'Pricing table', 'Post Type Singular Name', 'landx' ),
		'menu_name'           => __( 'Pricing table', 'landx' ),
		'parent_item_colon'   => __( 'Parent Item:', 'landx' ),
		'all_items'           => __( 'All Items', 'landx' ),
		'view_item'           => __( 'View Item', 'landx' ),
		'add_new_item'        => __( 'Add New Item', 'landx' ),
		'add_new'             => __( 'Add New', 'landx' ),
		'edit_item'           => __( 'Edit Item', 'landx' ),
		'update_item'         => __( 'Update Item', 'landx' ),
		'search_items'        => __( 'Search Item', 'landx' ),
		'not_found'           => __( 'Not found', 'landx' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'landx' ),
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'revisions', 'page-attributes', ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'pricing', $args );

}

// Hook into the 'init' action
add_action( 'init', 'landx_pricing_post_type', 0 );

}

add_filter('manage_edit-pricing_columns', 'perch_pricings_columns', 10);
add_action('manage_pricing_posts_custom_column', 'perch_pricings_custom_columns', 10, 2);
function perch_pricings_columns($defaults){
    $defaults['perch_pricing_thumbs'] = __('Shotcodes', THEMENAME);
    return $defaults;
}
function perch_pricings_custom_columns($column_name, $post_id){
	 switch ( $column_name ) {
		case 'perch_pricing_thumbs':
        echo '[pricing_table id="'.$post_id.'"]';
    	break;
    }
}

?>