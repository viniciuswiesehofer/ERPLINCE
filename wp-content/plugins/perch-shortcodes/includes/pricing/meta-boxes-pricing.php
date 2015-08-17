<?php
/**
 * Initialize the meta boxes. 
 */
add_action( 'admin_init', 'pricing_meta_boxes' );

function pricing_meta_boxes(){
  global $wpdb, $post;
  if( function_exists( 'ot_get_option' ) ):
  $my_meta_boxx = array(
    'id'        => 'my_meta_box',
    'title'     => 'Package Information',
    'desc'      => '',
    'pages'     => array( 'pricing' ),
    'context'   => 'normal',
    'priority'  => 'high',
    'fields'    => array(   
    array(
        'id'          => 'featured',
        'label'       => __( 'Featured', 'landx' ),
        'desc'        => '',
        'std'         => 'off',
        'type'        => 'on-off',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),   
      array(
        'id'          => 'feature_info',
        'label'       => __( 'Feature info', 'landx' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'list-item',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'type:is(text)',
        'condition'   => '',
        'operator'    => 'and',
        'settings'    => array( 
          array(
            'id'          => 'type',
            'label'       => __( 'Type', 'landx' ),
            'desc'        => '',
            'std'         => 'text',
            'type'        => 'select',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and',
            'choices'     => array( 
              array(
                'value'       => 'text',
                'label'       => __( 'Text', 'landx' ),
                'src'         => ''
              ),
              array(
                'value'       => 'yn',
                'label'       => __( 'Availibility', 'landx' ),
                'src'         => ''
              )
            )
          ),
          array(
            'id'          => 'lavel_info',
            'label'       => __( 'Lavel info', 'landx' ),
            'desc'        => '',
            'std'         => '',
            'type'        => 'textarea',
            'rows'        => '1',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => '',
            'condition'   => 'type:is(text)',
            'operator'    => 'and'
          ),
          array(
            'id'          => 'availibility',
            'label'       => __( 'Feature availibility', 'landx' ),
            'desc'        => '',
            'std'         => 'on',
            'type'        => 'on-off',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => '',
            'condition'   => 'type:is(yn)',
            'operator'    => 'and'
          )
        )
      ), 
      array(
        'id'          => 'sign_up_text',
        'label'       => __( 'Sign up lavel Text', 'landx' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'textarea',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ), 
      array(
        'id'          => 'button_link',
        'label'       => __( 'Button link', 'landx' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ), 
      array(
        'id'          => 'button_text',
        'label'       => __( 'Button text', 'landx' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
         
    )
  );
  
  ot_register_meta_box( $my_meta_boxx );
  endif;  //if( function_exists( 'ot_get_option' ) ):
}
?>