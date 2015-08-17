<?php
function landx_footer_options( $options = array() ){

    $choice= array( 
          array(
            'value'       => 'social_facebook_square',
            'label'       => 'Facebook',
            'src'         => ''
          ),
          array(
            'value'       => 'social_twitter_square',
            'label'       => 'Twitter',
            'src'         => ''
          ),
          array(
            'value'       => 'social_pinterest_square',
            'label'       => 'Pinterest',
            'src'         => ''
          ),
          array(
            'value'       => 'social_googleplus_square',
            'label'       => 'Google+',
            'src'         => ''
          ),
          array(
            'value'       => 'social_instagram_square',
            'label'       => 'Instagram',
            'src'         => ''
          ),
          array(
            'value'       => 'social_linkedin_square',
            'label'       => 'LinkdIn',
            'src'         => ''
          ),
		  array(
            'value'       => 'social_youtube_square',
            'label'       => 'Youtube',
            'src'         => ''
          ),
		  array(
            'value'       => 'fa fa-vk',
            'label'       => 'VK',
            'src'         => ''
          ),
        );

	$options = array(
	array(
        'id'          => 'footer_logo',
        'label'       => __( 'Footer logo', 'landx' ),
        'desc'        => '',
        'std'         => THEMEURI. 'images/logo-dark.png',
        'type'        => 'upload',
        'section'     => 'footer_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      
      array(
        'id'          => 'copyright_text',
        'label'       => __( 'Copyright Text', 'landx' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'footer_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
	  array(
        'id'          => 'social_icon_display',
        'label'       => 'Footer Social Icon Display',
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
		'section'     => 'footer_options',
        'class'       => '',
        'choices'     => array(),
        'condition'	  => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'footer_social_icons',
        'label'       => 'Footer Social Icons',
        'desc'        => '',
        'std'         => array(
                            array(
                              'title' => 'Facebook',
                              'link'  => '#',
                              'icon'  => 'social_facebook_square'
                              ),
                            array(
                              'title' => 'Twitter',
                              'link'  => '#',
                              'icon'  => 'social_twitter_square'
                              ),
                            array(
                              'title' => 'Pinterest',
                              'link'  => '#',
                              'icon'  => 'social_pinterest_square'
                              ),
                            array(
                              'title' => 'Google+',
                              'link'  => '#',
                              'icon'  => 'social_googleplus_square'
                              ),
                            array(
                              'title' => 'Instragram',
                              'link'  => '#',
                              'icon'  => 'social_instagram_square'
                              ),
                            array(
                              'title' => 'Linkdin',
                              'link'  => '#',
                              'icon'  => 'social_linkedin_square'
                              ),
                            ),
        'type'        => 'list-item',
        'section'     => 'footer_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'social_icon_display:is(on)',
        'operator'    => 'and',
        'settings'    => array( 
          array(
            'id'          => 'link',
            'label'       => 'Link',
            'desc'        => '',
            'std'         => '',
            'type'        => 'text',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          ),
          array(
            'id'          => 'icon',
            'label'       => 'Icon',
            'desc'        => '',
            'std'         => '',
            'type'        => 'select',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and',
            'choices'     => $choice
          )
        )
      ),
      array(
        'id'          => 'footer_scripts',
        'label'       => __( 'Footer scripts', 'landx' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'footer_options',
        'rows'        => '3',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
    );

	return apply_filters( 'landx_footer_options', $options );
}  
?>