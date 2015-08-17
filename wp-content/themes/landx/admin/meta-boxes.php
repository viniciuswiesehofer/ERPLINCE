<?php
/**
 * Initialize the meta boxes. 
 */

add_action( 'admin_init', 'landx_meta_boxes' );


function landx_meta_boxes() {
    global $wpdb, $post;
  if( function_exists( 'ot_get_option' ) ): 
  $my_meta_box = array(
    'id'        => 'landx_meta_box',
    'title'     => 'Landx page Settings',
    'desc'      => '',
    'pages'     => array( 'page' ),
    'context'   => 'normal',
    'priority'  => 'high',
    'fields'    => array(     
     array(
        'id'          => 'header_settings',
        'label'       => 'Header settings',      
        'type'        => 'tab',
        'operator'    => 'and'
      ), 	
      array(
        'id'          => 'custom_title',
        'label'       => 'Custom Title',
        'desc'        => '',
        'std'         => 'off',
        'type'        => 'on-off',
        'class'       => '',
        'choices'     => array(),
        'condition'	  => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'title',
        'label'       => 'Title',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array(),
        'operator'    => 'and',
        'condition'	  => 'custom_title:is(on)'
      ),
      array(
        'id'          => 'subtitle',
        'label'       => 'Sub-title',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'class'       => '',
        'rows'		  => 3,
        'choices'     => array(),
        'operator'    => 'and',
        'condition'	  => 'custom_title:is(on)'
      ), 
           
      array(
        'id'          => 'header_bg',
        'label'       => 'Custom header Background',
        'desc'        => '',
        'std'         => 'off',
        'type'        => 'on-off',
        'class'       => '',
        'choices'     => array(),
        'operator'    => 'and',
        'condition'	  => ''
      ),
      array(
        'id'          => 'custom__header_bg',
        'label'       => 'Background',
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'class'       => '',
        'choices'     => array(),
        'operator'    => 'and',
        'condition'   => 'header_bg:is(on)'
      ), 
      array(
        'id'          => 'content_tab',
        'label'       => 'Layout settings',      
        'type'        => 'tab',
        'operator'    => 'and'
      ), 
      array(
        'id'          => 'page_layout',
        'label'       => __( 'Default layout', THEMENAME ),
        'desc'        => '',
        'std'         => 'rs',
        'type'        => 'radio-image',
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
          ),
        )
      ),
      array(
        'id'          => 'sidebar',
        'label'       => 'Select sidebar',
        'desc'        => '',
        'std'         => 'sidebar-1',
        'type'        => 'sidebar-select',
        'class'       => '',
        'choices'     => array(),
        'operator'    => 'and',
        'condition'   => 'page_layout:not(full)'
      ),
      array(
        'id'          => 'one_page__settings',
        'label'       => 'One page settings',      
        'type'        => 'tab',
        'operator'    => 'and'
      ), 
      array(
            'id'          => 'display_page_title',
            'label'       => 'Display page title in one-page',
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
            'choices'     => '',
          ),
            array(
            'id'          => 'content_alignment',
            'label'       => 'Title/content alignment',
            'desc'        => '',
            'std'         => 'left',
            'type'        => 'select',
            'class'       => '',
            'rows'      => '',
            'choices'     => array(
                array(
                    'value'       => 'left',
                    'label'       => 'Left',
                    'src'         => ''
                  ),
                  array(
                    'value'       => 'center',
                    'label'       => 'Center',
                    'src'         => ''
                  )
              ),
            'operator'    => 'and',
            'condition'   => ''
          ),
          array(
            'id'          => 'image_position',
            'label'       => 'Featured Image Position',
            'desc'        => '',
            'std'         => 'right',
            'type'        => 'select',
            'class'       => '',
            'rows'      => '',
            'choices'     => array(
                array(
                    'value'       => 'left',
                    'label'       => 'Left',
                    'src'         => ''
                  ),
                  array(
                    'value'       => 'right',
                    'label'       => 'Right',
                    'src'         => ''
                  )
              ),
            'operator'    => 'and',
            'condition'   => ''
          ),
          array(
        'id'          => 'jump_button',
        'label'       => __( 'Quick jumpto button', THEMENAME ),
        'desc'        => 'Display after this page content.',
        'std'         => 'off',
        'type'        => 'on-off',        
        'operator'    => 'and',        
      ),
      array(
        'id'          => 'buttons',
        'label'       => __( 'Add new button', THEMENAME ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'list-item',
        'section'     => 'header_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'jump_button:is(on)',
        'operator'    => 'and',
        'settings'    => array(
            array(
                'id'          => 'button_type',
                'label'       => 'Button type',
                'desc'        => '',
                'std'         => 'standard-button',
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
                        'value'       => 'standard-button',
                        'label'       => 'Standard button',
                        'src'         => ''
                      ),
                      array(
                        'value'       => 'secondary-button-white',
                        'label'       => 'Standard button white',
                        'src'         => ''
                      ),
                    ),
                ),
                array(
                    'id'          => 'link_type',
                    'label'       => 'Link type',
                    'desc'        => '',
                    'std'         => 'inner',
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
                                'value'       => 'inner',
                                'label'       => 'Inner this page',
                                'src'         => ''
                              ),
                              array(
                                'value'       => 'external',
                                'label'       => 'Outside of this page',
                                'src'         => ''
                              ),
                              array(
                                'value'       => 'customlink',
                                'label'       => 'Custom link',
                                'src'         => ''
                              ),
                        ),
                    ),
                    array(
                        'id'          => 'custom_url',
                        'label'       => 'Custom_url',
                        'desc'        => '',
                        'std'         => '#',
                        'type'        => 'text',
                        'rows'        => '',
                        'post_type'   => '',
                        'taxonomy'    => '',
                        'min_max_step'=> '',
                        'class'       => '',
                        'condition'   => 'link_type:is(customlink)',
                        'operator'    => 'and',
                        'choices'     => '',
                    ),
                    array(
                        'id'          => 'page_id',
                        'label'       => 'Select a page',
                        'desc'        => '',
                        'std'         => '',
                        'type'        => 'page-select',
                        'rows'        => '',
                        'post_type'   => '',
                        'taxonomy'    => '',
                        'min_max_step'=> '',
                        'class'       => '',
                        'condition'   => 'link_type:not(customlink)',
                        'operator'    => 'and',
                        'choices'     => '',
                    ),
            )    
        ),
          
          array(
            'id'          => 'bg_style',
            'label'       => 'Background style',
            'desc'        => '',
            'std'         => 'dark',
            'type'        => 'select',
            'class'       => '',
            'rows'        => '',
            'choices'     => array(
                    array(
                        'value'       => 'dark',
                        'label'       => 'Dark',
                        'src'         => ''
                      ),
                      array(
                        'value'       => 'light',
                        'label'       => 'Light',
                        'src'         => ''
                      )
                ),
            'operator'    => 'and',
            'condition'   => ''
          ),
          array(
            'id'          => 'background',
            'label'       => 'Background image',
            'desc'        => '',
            'std'         => THEMEURI.'/images/bg-image-1.jpg',
            'type'        => 'upload',
            'class'       => '',
            'choices'     => array(),
            'operator'    => 'and',
            'condition'   => ''
          ),
	  
	  array(
        'id'          => 'form_display',
        'label'       => 'subscription-form display',
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'class'       => '',
        'choices'     => array(),
        'condition'   => '',
        'operator'    => 'and'
      ),
	  array(
        'id'          => 'form_select_option',
        'label'       => 'Select a subscription form',
        'desc'        => '',
        'std'         => 'mailchimp',
        'type'        => 'select',
        'class'       => '',
        'choices'     => array(               
                array(
                'value'       => 'mailchimp',
                'label'       => 'Mailchimp',
                'src'         => ''
                ),
                array(
                'value'       => 'contactform',
                'label'       => 'Contact form 7',
                'src'         => ''
                ),
            ),
        'condition'   => 'form_display:is(on)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'form_position',
        'label'       => 'subscription-form display position',
        'desc'        => '',
        'std'         => 'right',
        'type'        => 'select',
        'class'       => '',
        'choices'     => array(               
                array(
                'value'       => 'right',
                'label'       => 'Right',
                'src'         => ''
                ),
                array(
                'value'       => 'bottom',
                'label'       => 'Bottom',
                'src'         => ''
                ),
            ),
        'condition'   => 'form_display:is(on)',
        'operator'    => 'and'
      ),
	  array(
        'id'          => 'contact_form_shortcode',
        'label'       => 'Contact form 7 shortcode',
        'desc'        => 'Need to active contact form 7 plugin and then add a shortcode here.',
        'std'         => '',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array(),
        'condition'   => 'form_display:is(on),form_select_option:is(contactform)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'form_title',
        'label'       => 'Form title',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array(),
        'condition'   => 'form_display:is(on),form_select_option:is(mailchimp)',
        'operator'    => 'and'
      ),
     array(
        'id'          => 'form_type',
        'label'       => 'Form type',
        'desc'        => 'Only horizontal and vertical form is available.',
        'std'         => 'vertical',
        'type'        => 'select',
        'class'       => '',
        'choices'     => array(               
                array(
                'value'       => 'vertical',
                'label'       => 'Vertical',
                'src'         => ''
                ),
                array(
                'value'       => 'horizontal',
                'label'       => 'Horizontal',
                'src'         => ''
                ),
            ),
        'condition'   => 'form_display:is(on),form_select_option:is(mailchimp)',
        'operator'    => 'and'
      ),
     array(
        'id'          => 'form_field_settings',
        'label'       => 'Form field settings',
        'desc'        => '',
        'std'         => 'off',
        'type'        => 'on-off',
        'class'       => '',
        'choices'     => array(),
        'condition'   => 'form_display:is(on),form_select_option:is(mailchimp)',
        'operator'    => 'and'
      ),
     array(
        'id'          => 'name_placeholder',
        'label'       => 'Default text in name field',
        'desc'        => '',
        'std'         => 'Your Name',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array(),
        'condition'   => 'form_display:is(on),form_field_settings:is(on),form_type:is(vertical),form_select_option:is(mailchimp)',
        'operator'    => 'and'
      ),
     array(
        'id'          => 'email_placeholder',
        'label'       => 'Default text in email field',
        'desc'        => '',
        'std'         => 'Your Email',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array(),
        'condition'   => 'form_display:is(on),form_field_settings:is(on),form_select_option:is(mailchimp)',
        'operator'    => 'and'
      ),
     array(
        'id'          => 'phone_placeholder',
        'label'       => 'Default text in Phone field',
        'desc'        => '',
        'std'         => 'Phone number',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array(),
        'condition'   => 'form_display:is(on),form_field_settings:is(on),form_type:is(vertical),form_select_option:is(mailchimp)',
        'operator'    => 'and'
      ),
     array(
        'id'          => 'form_submit_button_text',
        'label'       => 'Submit button text',
        'desc'        => '',
        'std'         => 'GET STARTED',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array(),
        'condition'   => 'form_display:is(on),form_field_settings:is(on),form_select_option:is(mailchimp)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'one_page__animation',
        'label'       => 'One page animation',      
        'type'        => 'tab',
        'operator'    => 'and'
      ), 
      array(
        'id'          => 'title_animation',
        'label'       => 'Title animation',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'class'       => '',
        'choices'     => landx_animation_select(),
        'condition'   => '',
        'operator'    => 'and'
      ), 
      array(
        'id'          => 'content_animation',
        'label'       => 'Content animation',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'class'       => '',
        'choices'     => landx_animation_select(),
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'featured_image_animation',
        'label'       => 'Featured image animation',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'class'       => '',
        'choices'     => landx_animation_select(),
        'condition'   => '',
        'operator'    => 'and'
      ), 
      array(
        'id'          => 'form_animation',
        'label'       => 'Subscription form animation',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'class'       => '',
        'choices'     => landx_animation_select(),
        'condition'   => '',
        'operator'    => 'and'
      ), 
      array(
        'id'          => 'button_animation',
        'label'       => 'Quick jump button animation',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'class'       => '',
        'choices'     => landx_animation_select(),
        'condition'   => '',
        'operator'    => 'and'
      ),     
      
    )
  );
  
  ot_register_meta_box( $my_meta_box );
  endif;  //if( function_exists( 'ot_get_option' ) ):

}



/**
 * Enable OT Meta Boxes for post formats
 */
//add_filter( 'ot_post_formats', '__return_true' );
/**
 * Filter for OT Video Meta-box 
 */
function perch_video_ot_meta_box_post_format_video() {

    return array(
        'id'        => 'ot-post-format-video',
        'title'     => 'Video Post',
        'desc'      => 'Embed video from services like Youtube, Vimeo, or Hulu. You can find a list of supported oEmbed sites in the <a target="_blank" href="http://codex.wordpress.org/Embeds">Wordpress Codex</a>',
        'pages'     => array( 'post' ),
        'context'   => 'side',
        'priority'  => 'low',
        'fields'    => array(
            array(
                'id'          => 'perch_oembed_videos',
                'label'       => '',
                'desc'        => '',
                'std'         => '',
                'type'        => 'text',
                'rows'        => '',
                'post_type'   => '',
                'taxonomy'    => '',
                'class'       => '',
                'settings'    => ''
            )
        )
    );
}
//add_filter( 'ot_meta_box_post_format_video', 'perch_video_ot_meta_box_post_format_video' );

/**
 * Filter for OT Video Meta-box 
 */
function perch_video_ot_meta_box_post_format_audio() {

    return array(
        'id'        => 'ot-post-format-audio',
        'title'     => 'Audio Post',
        'desc'      => 'Embed audio from services like Rdio, Soundcloud, or Spotify. You can find a list of supported oEmbed sites in the <a target="_blank" href="http://codex.wordpress.org/Embeds">Wordpress Codex</a>',
        'pages'     => array( 'post' ),
        'context'   => 'side',
        'priority'  => 'low',
        'fields'    => array(
            array(
                'id'          => 'perch_oembed_audio',
                'label'       => '',
                'desc'        => '',
                'std'         => '',
                'type'        => 'text',
                'rows'        => '',
                'post_type'   => '',
                'taxonomy'    => '',
                'class'       => '',
                'settings'    => ''
            )
        )
    );
}
//add_filter( 'ot_meta_box_post_format_audio', 'perch_video_ot_meta_box_post_format_audio' );

/**
 * Filter for OT quote Meta-box 
 */
function perch_video_ot_meta_box_post_format_quote() {

    return array(
        'id'        => 'ot-post-format-quote',
        'title'     => 'Quote Post',
        'desc'      => '',
        'pages'     => array( 'post' ),
        'context'   => 'side',
        'priority'  => 'low',
        'fields'    => array(
            array(
                'id'          => 'quote_title',
                'label'       => 'Name',
                'desc'        => '',
                'std'         => '',
                'type'        => 'text',
                'rows'        => '',
                'post_type'   => '',
                'taxonomy'    => '',
                'class'       => '',
                'settings'    => ''
            ),
            array(
                'id'          => 'quote_link',
                'label'       => 'Quote source link',
                'desc'        => '',
                'std'         => '',
                'type'        => 'text',
                'rows'        => '',
                'post_type'   => '',
                'taxonomy'    => '',
                'class'       => '',
                'settings'    => ''
            ),
            array(
                'id'          => 'quote_text',
                'label'       => 'Quote text',
                'desc'        => '',
                'std'         => '',
                'type'        => 'textarea',
                'rows'        => '2',
                'post_type'   => '',
                'taxonomy'    => '',
                'class'       => '',
                'settings'    => ''
            )
        )
    );
}
//add_filter( 'ot_meta_box_post_format_quote', 'perch_video_ot_meta_box_post_format_quote' );
?>