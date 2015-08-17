<?php
function landx_styling_options( $options = array() ){
	$options = array(
		array(
        'id'          => 'preset_color',
        'label'       => __( 'Preset color', THEMENAME ),
        'desc'        => '',
        'std'         => '#008ed6',
        'type'        => 'colorpicker',
        'section'     => 'styling_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'action'      => array(
                array(
                'selector' => '.woocommerce span.onsale, .woocommerce-page span.onsale, .woocommerce ul.products li.product .onsale, .colored-line, .color-bg, .standard-button, .standard-button:hover, .feature-list-1 li .icon-container,
                .feature-list li .icon-container, .feature-list-2 li .icon-container, .screenshots .owl-theme .owl-controls .owl-page span,
                .perch-social-icon, .search-submit, .newsletter-submit, .widget_newsletterwidget:before',
                'property'   => 'background-color'
                ),
                array(
                'selector' => 'a, .colored-text, .non-sticky .navbar-nav > li > a:hover, .secondary-button:hover, .sticky-navigation .main-navigation .current a,
                .sticky-navigation .navbar-nav > li > a:hover, .feature .icon, .contact-link, .contact-link:hover , .social-icons li a:hover,
                h5 span , h5 strong, h1 strong, h2 strong, h3 strong, body .colored-text, .sidebar li span, .sidebar li span a,
                .demo-style-switch .switch-button:hover, .woocommerce .star-rating, .navbar-nav > li > a.cart-contents ',
                'property'   => 'color'
                ),
                array(
                    'selector' => '.secondary-button:hover, .vertical-registration-form .input-box:focus,.vertical-registration-form .input-box:active ,
                    .vertical-registration-form .input-box:focus, .vertical-registration-form .input-box:active, .newsletter-firstname:focus, 
                    .newsletter-lastname:focus, .newsletter-email:focus, .newsletter-firstname:active, .newsletter-lastname:active, .newsletter-email:active,
					.intro-section .wpcf7 .wpcf7-form-control.input-box:focus,.intro-section .wpcf7 .wpcf7-form-control.input-box:active,.intro-section .wpcf7 .wpcf7-form-control.textarea-box:focus,.intro-section .wpcf7 .wpcf7-form-control.textarea-box:active',
                    'property'   => 'border-color'
                ),
                array(
                    'selector' => '.subscription-form .input-box:focus, .subscription-form .input-box:active, .input-box:active,
.textarea-box:active, .input-box:focus,.textarea-box:focus, .vertical-registration-form .input-box, .vertical-registration-form .input-box:focus, .vertical-registration-form .input-box:active,
.newsletter-sex, .newsletter-firstname,  .newsletter-lastname, .newsletter-email,.intro-section .wpcf7 .wpcf7-form-control.input-box,.intro-section .wpcf7 .wpcf7-form-control.input-box:focus,.intro-section .wpcf7 .wpcf7-form-control.input-box:active,.intro-section .wpcf7 .wpcf7-form-control.textarea-box,.intro-section .wpcf7 .wpcf7-form-control.textarea-box:focus,.intro-section .wpcf7 .wpcf7-form-control.textarea-box:active',

                    'property'   => 'border-left-color'
                ),
                array(
                    'selector' => '.vertical-registration-form .input-box, .form-control:focus, .newsletter-firstname,  .newsletter-lastname, .newsletter-email,
					.intro-section .wpcf7 .wpcf7-form-control.input-box,.intro-section .wpcf7 .wpcf7-form-control.textarea-box',
                    'property' => 'border-top-color',
                    'opacity' => .5
                ),
                array(
                    'selector' => '.vertical-registration-form .input-box, .form-control:focus, .newsletter-firstname,  .newsletter-lastname, .newsletter-email,
					.intro-section .wpcf7 .wpcf7-form-control.input-box,.intro-section .wpcf7 .wpcf7-form-control.textarea-box',
                    'property' => 'border-right-color',
                    'opacity' => .5
                ),
                array(
                    'selector' => '.vertical-registration-form .input-box, .form-control:focus, .newsletter-firstname,  .newsletter-lastname, .newsletter-email,
					.intro-section .wpcf7 .wpcf7-form-control.input-box,.intro-section .wpcf7 .wpcf7-form-control.textarea-box',
                    'property' => 'border-bottom-color',
                    'opacity' => .5
                )
            )        

      ),
      array(
        'id'          => 'font_color',
        'label'       => __( 'Global font color', THEMENAME ),
        'desc'        => '',
        'std'         => '#727272',
        'type'        => 'colorpicker',
        'section'     => 'styling_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'action'      => array(
                array(
                'selector' => 'body, .sidebar li a',
                'property'   => 'color'
                )
            )        

      ),
	  array(
        'id'          => 'woocommerce_color',
        'label'       => __( 'Products color', THEMENAME ),
        'desc'        => '',
        'std'         => '#008ed6',
        'type'        => 'colorpicker',
        'section'     => 'styling_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'action'      => array(
				array(
                'selector' => '.woocommerce #content input.button.alt,.woocommerce #respond input#submit.alt,.woocommerce a.button.alt,
				.woocommerce button.button.alt,.woocommerce input.button.alt,.woocommerce-page #content input.button.alt,.woocommerce-page #respond input#submit.alt,
				.woocommerce-page a.button.alt,.woocommerce-page button.button.alt,.woocommerce-page input.button.alt,.woocommerce #content input.button,
				.woocommerce #respond input#submit,.woocommerce a.button,.woocommerce button.button,.woocommerce input.button,.woocommerce-page #content input.button,
				.woocommerce-page #respond input#submit,.woocommerce-page a.button,.woocommerce-page button.button,.woocommerce-page input.button,
				.woocommerce #content input.button.alt:hover,.woocommerce #respond input#submit.alt:hover,.woocommerce a.button.alt:hover,.woocommerce button.button.alt:hover,
				.woocommerce input.button.alt:hover,.woocommerce-page #content input.button.alt:hover,.woocommerce-page #respond input#submit.alt:hover,
				.woocommerce-page a.button.alt:hover,.woocommerce-page button.button.alt:hover,.woocommerce-page input.button.alt:hover,.woocommerce #content input.button:hover,
				.woocommerce #respond input#submit:hover,.woocommerce a.button:hover,.woocommerce button.button:hover,.woocommerce input.button:hover,
				.woocommerce-page #content input.button:hover,.woocommerce-page #respond input#submit:hover,.woocommerce-page a.button:hover,.woocommerce-page button.button:hover,
				.woocommerce-page input.button:hover, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle,.woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle',
                'property'   => 'background-color'
                ),
                array(
                'selector' => '.woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price, .woocommerce #content div.product p.price,
				.woocommerce #content div.product span.price,.woocommerce div.product p.price,.woocommerce div.product span.price,.woocommerce-page #content div.product p.price,
				.woocommerce-page #content div.product span.price,.woocommerce-page div.product p.price,.woocommerce-page div.product span.price',
                'property'   => 'color'
                )
            )        

      ),
    );

	return apply_filters( 'landx_styling_options', $options );
}  
?>