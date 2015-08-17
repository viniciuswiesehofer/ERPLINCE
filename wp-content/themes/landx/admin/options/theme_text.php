<?php
function landx_theme_text( $options = array() ){
	$options = array(
		array(
        'id'          => 'category_archive_title',
        'label'       => __( 'Category archive title', THEMENAME ),
        'desc'        => '',
        'std'         => 'Showin posts for -',
        'type'        => 'text',
        'section'     => 'theme_text',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
    );

	return apply_filters( 'landx_theme_text', $options );
}   
?>