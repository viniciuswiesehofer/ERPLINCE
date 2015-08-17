<?php
function landx_blog_options( $options = array() ){
	$options = array(
        array(
        'id'          => 'blog_title',
        'label'       => __( 'Blog header title', THEMENAME ),
        'desc'        => '',
        'std'         => 'Blog',
        'type'        => 'text',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
    array(
        'id'          => 'blog_subtitle',
        'label'       => __( 'Blog header subtitle', THEMENAME ),
        'desc'        => '',
        'std'         => 'Read our latest update and news',
        'type'        => 'text',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
    array(
        'id'          => 'blog_header_bg',
        'label'       => __( 'Custom Blog header BAckground image', THEMENAME ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
    array(
        'id'          => 'excerpt_length',
        'label'       => __( 'Excerpt length', THEMENAME ),
        'desc'        => '',
        'std'         => '55',
        'type'        => 'numeric-slider',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '10,150,5',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
    array(
        'id'          => 'readmore_text',
        'label'       => __( 'Read more text', THEMENAME ),
        'desc'        => '',
        'std'         => 'Read more &raquo;',
        'type'        => 'text',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
		array(
        'id'          => 'blog_layout',
        'label'       => __( 'Blog layout', THEMENAME ),
        'desc'        => '',
        'std'         => 'rs',
        'type'        => 'radio-image',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'full',
            'label'       => __( 'Full width', THEMENAME ),
            'src'         => OT_URL . '/assets/images/layout/full-width.png'
          ),
          array(
            'value'       => 'ls',
            'label'       => __( 'Left sidebar', THEMENAME ),
            'src'         => OT_URL . '/assets/images/layout/left-sidebar.png'
          ),
          array(
            'value'       => 'rs',
            'label'       => __( 'Right sidebar', THEMENAME ),
            'src'         => OT_URL . '/assets/images/layout/right-sidebar.png'
          )
        )
      ),
      array(
        'id'          => 'blog_sidebar',
        'label'       => __( 'Blog Sidebar', THEMENAME ),
        'desc'        => '',
        'std'         => 'sidebar-1',
        'type'        => 'sidebar-select',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'blog_layout:not(full)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'single_layout',
        'label'       => __( 'Blog single post layout', THEMENAME ),
        'desc'        => '',
        'std'         => 'rs',
        'type'        => 'radio-image',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'full',
            'label'       => __( 'Full width', THEMENAME ),
            'src'         => OT_URL . '/assets/images/layout/full-width.png'
          ),
          array(
            'value'       => 'ls',
            'label'       => __( 'Left sidebar', THEMENAME ),
            'src'         => OT_URL . '/assets/images/layout/left-sidebar.png'
          ),
          array(
            'value'       => 'rs',
            'label'       => __( 'Right sidebar', THEMENAME ),
            'src'         => OT_URL . '/assets/images/layout/right-sidebar.png'
          )
        )
      ),
    array(
        'id'          => 'blog_single_sidebar',
        'label'       => __( 'Single post Sidebar', THEMENAME ),
        'desc'        => '',
        'std'         => 'sidebar-1',
        'type'        => 'sidebar-select',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'single_layout:not(full)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'sticky_post_text',
        'label'       => __( 'Sticky post text', THEMENAME ),
        'desc'        => '',
        'std'         => 'Featured post',
        'type'        => 'text',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
    );

	return apply_filters( 'landx_blog_options', $options );
}  
?>