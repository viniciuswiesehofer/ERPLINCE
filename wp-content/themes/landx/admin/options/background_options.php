<?php
function landx_background_options( $options = array() ){
	$options = array(
		array(
        'id'          => 'container_width',
        'label'       => __( 'Container width', THEMENAME ),
        'desc'        => '',
        'std'         => array(1170, 'px'),
        'type'        => 'measurement',
        'section'     => 'background_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'action'      =>array(
                array(
                    'selector' => '.container',
                    'property' => 'max-width'
                    )
            )
      ),
      array(
        'id'          => 'body_background',
        'label'       => __( 'Body background', THEMENAME ),
        'desc'        => '',
        'std'         => array(),
        'type'        => 'background',
        'section'     => 'background_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'action'   => array(
                array(
                    'selector' => 'body'
                    )
            )
      ),
      array(
        'id'          => 'main_container_background',
        'label'       => __( 'Main container background', THEMENAME ),
        'desc'        => '',
        'std'         => array(),
        'type'        => 'background',
        'section'     => 'background_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'action'   => array(
                array(
                    'selector' => 'section .container'
                    )
            )
      ),
      array(
        'id'          => 'main_container_alt_background',
        'label'       => __( 'Main container Alter background', THEMENAME ),
        'desc'        => '',
        'std'         => array( 'background-image' => '', 'background-color' => '#f7f8fa' ),
        'type'        => 'background',
        'section'     => 'background_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'action'   => array(
                array(
                    'selector' => '.bgcolor-2'
                    )
            )
      ),
      array(
        'id'          => 'header_navigation_background',
        'label'       => __( 'Header navigation background', THEMENAME ),
        'desc'        => '',
        'std'         => array('background-image' => '', 'background-color' => '#fff'),
        'type'        => 'background',
        'section'     => 'background_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'action'   => array(
                array(
                    'selector' => '.sticky-navigation'
                    )
            )
      ),
    array(
        'id'          => 'sidebar_background',
        'label'       => __( 'Sidebar background', THEMENAME ),
        'desc'        => '',
        'std'         => array('background-image' => '', 'background-color' => '#fff'),
        'type'        => 'background',
        'section'     => 'background_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'action'   => array(
                array(
                    'selector' => '.sidebar'
                    )
            )
      ),
      array(
        'id'          => 'footer_background',
        'label'       => __( 'Footer background', THEMENAME ),
        'desc'        => '',
        'std'         => array('background-image' => '', 'background-color' => '#f7f8fa'),
        'type'        => 'background',
        'section'     => 'background_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'action'   => array(
                array(
                    'selector' => 'footer.bgcolor-2'
                    )
            )
      ),
     
    );

	return apply_filters( 'landx_background_options', $options );
}  
?>