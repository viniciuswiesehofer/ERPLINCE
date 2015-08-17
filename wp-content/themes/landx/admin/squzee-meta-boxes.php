<?php
/**
 * Initialize the meta boxes. 
 */
add_action( 'admin_init', 'landx_squzee_meta_boxes' );

function landx_squzee_meta_boxes() {

  if( function_exists( 'ot_get_option' ) ): 

  $my_meta_box = array(
    'id'        => 'landx_squzee_meta_box',
    'title'     => 'Landx Squzee Template Settings',
    'desc'      => 'This option only applicable when you select Squzee Template',
    'pages'     => array( 'page' ),
    'context'   => 'normal',
    'priority'  => 'high',
    'fields'    => array(  
      array(
        'id'          => 'squzee_header_logo_display',
        'label'       => __( 'Header logo display', THEMENAME ),
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        
      ), 
      array(
        'id'          => 'squzee_header_logo',
        'label'       => __( 'Header logo', THEMENAME ),
        'desc'        => '',
        'std'         => THEMEURI. '/images/logo.png',
        'type'        => 'upload',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'squzee_header_logo_display:is(on)',
        'operator'    => 'and',
        
      ),
      array(
        'id'          => 'squzee_social_button_display',
        'label'       => __( 'Social link display', THEMENAME ),
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        
      ), 
    )
  );


  
  ot_register_meta_box( $my_meta_box );
  endif;  //if( function_exists( 'ot_get_option' ) ):

}
?>