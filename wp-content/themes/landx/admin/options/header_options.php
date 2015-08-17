<?php
function landx_header_options( $options = array() ){
	$options = array(
		array(
        'id'          => 'logo',
        'label'       => __( 'Logo', THEMENAME ),
        'desc'        => 'Appear in Menu bar',
        'std'         => THEMEURI.'/images/logo2.png',
        'type'        => 'upload',
        'section'     => 'header_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
    
    
    );

	return apply_filters( 'landx_header_options', $options );
} 
?>