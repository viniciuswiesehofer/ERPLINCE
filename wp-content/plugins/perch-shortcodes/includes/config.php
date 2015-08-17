<?php
/**
 * Define the shortcode parameters
 *
 * @package PerchShortcodes
 * @since 1.0
 */



/* testimonial Config --- */
$perch_shortcodes['perch-testimonial'] = array(
	'title' => __('Tesitmonial', 'tpsc'),
	'id' => 'perch-testimonial',
	'template' => '[perch-testimonial {{attributes}}] {{content}} [/perch-testimonial]',
	'params' => array(
		'name' => array(
			'std' => 'Jhone doe',
			'type' => 'text',
			'label' => __('Name', 'tpsc'),
			'desc' => __('', 'tpsc')
		),
		'title' => array(
			'std' => 'Marketing maneger',
			'type' => 'text',
			'label' => __('Title', 'tpsc'),
			'desc' => __('e.g. Marketing maneger', 'tpsc'),
		),
		'website' => array(
			'std' => 'http://themeperch.com',
			'type' => 'text',
			'label' => __('Website', 'tpsc'),
			'desc' => __('', 'tpsc'),
		),
		'image' => array(
			'std' => '',
			'type' => 'upload',
			'label' => __('Uplad photo', 'tpsc'),
			'desc' => __('', 'tpsc'),
		),
		'content' => array(
			'std' => 'Lorem ipsum dolor sit amet...',
			'type' => 'textarea',
			'label' => __('Description', 'tpsc'),
			'desc' => __('', 'tpsc'),
		),

	)
);

/* testimonial Config --- */
$perch_shortcodes['perch-clients'] = array(
	'title' => __('Clients logo', 'tpsc'),
	'id' => 'perch-clients-logo',
	'template' => '[perch-clients-logo {{attributes}}]',
	'params' => array(		
		'images' => array(
			'std' => '',
			'type' => 'upload',
			'label' => __('Uplad Logos', 'tpsc'),
			'desc' => __('', 'tpsc'),
		),

	)
);

/* testimonial Config --- */
$perch_shortcodes['perch-carousel'] = array(
	'title' => __('Carousel', 'tpsc'),
	'id' => 'perch-carousel',
	'template' => '[perch-carousel {{attributes}}]',
	'params' => array(		
		'images' => array(
			'std' => '',
			'type' => 'upload',
			'label' => __('Uplad Images', 'tpsc'),
			'desc' => __('', 'tpsc'),
		),
		'thumb_width' => array(
			'std' => 400,
			'type' => 'slider',
			'label' => __('Thumbnail width', 'tpsc'),
			'desc' => __('in pixel', 'tpsc'),
			'min' => 200,
			'max' => 600,
			'step' => 5
		),
		'thumb_height' => array(
			'std' => 272,
			'type' => 'slider',
			'label' => __('Thumbnail height', 'tpsc'),
			'desc' => __('in pixel', 'tpsc'),
			'min' => 100,
			'max' => 500,
			'step' => 2
		),

	)
);

/* skillbar Config --- */
$perch_shortcodes['perch-skillbar'] = array(
	'title' => __('Skillbar', 'tpsc'),
	'id' => 'perch-skillbar',
	'template' => '[perch_skillbar {{attributes}}] {{content}} [/perch_skillbar]',
	'params' => array(
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title', 'tpsc'),
			'desc' => __('', 'tpsc')
		),
		'percentage' => array(
			'std' => '50',
			'type' => 'slider',
			'label' => __('Percentage', 'tpsc'),
			'desc' => __('e.g.: 100', 'tpsc'),
			'min' => 1,
			'max' => 100,
			'step' => 1
		),
		'color' => array(
			'std' => '',
			'type' => 'color',
			'label' => __('Color', 'tpsc'),
			'desc' => __('e.g.: #6adcfa', 'tpsc')
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Class', 'tpsc'),
			'desc' => __('', 'tpsc')
		),
		'show_percent' => array(
			'std' => 'true',
			'type' => 'select',
			'label' => __('Show Percent', 'tpsc'),
			'desc' => __('e.g: true or false', 'tpsc'),
			'options' => array(
				'true' => 'True',
				'false' => 'False',
				
			)
		),
		'visibility' => array(
			'std' => 'all',
			'type' => 'text',
			'label' => __('Visibility', 'tpsc'),
			'desc' => __('e.g: all', 'tpsc')
		),
	)
);

/* spacing Config space --- */
$perch_shortcodes['perch-spacing'] = array(
	'title' => __('Spacing', 'tpsc'),
	'id' => 'perch-spacing',
	'template' => '[perch_spacing {{attributes}}]',
	'params' => array(
		'size' => array(
			'std' => '20',
			'type' => 'slider',
			'label' => __('Size', 'tpsc'),
			'desc' => __('in pixel', 'tpsc'),
			'min' => 1,
			'max' => 200,
			'step' => 1
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Class', 'tpsc'),
			'desc' => __('', 'tpsc'),
		)
	)
);

/* social Config  --- */
$perch_shortcodes['perch-social'] = array(
	'title' => __('Social', 'tpsc'),
	'id' => 'perch-social',
	'template' => '[perch_social {{attributes}}] {{content}} [/perch_social]',
	'params' => array(
		'icon' => array(
			'std' => '',
			'type' => 'iconpicker',
			'label' => __('Icon', 'tpsc'),
			'desc' => __('', 'tpsc')
		),
		'url' => array(
			'std' => 'http://themeperch.com',
			'type' => 'text',
			'label' => __('URL', 'tpsc'),
			'desc' => __('', 'tpsc'),
		),
		'title' => array(
			'std' => 'Follow Us',
			'type' => 'text',
			'label' => __('Follow Us', 'tpsc'),
			'desc' => __('', 'tpsc')
		),
		'target' => array(
			'std' => '',
			'type' => 'select',
			'label' => __('Class', 'tpsc'),
			'desc' => __('e.g: class1 class2', 'tpsc'),
			'options' => array(
				'blank' => 'Blank',
				'self' => 'Self',
				
			)
		),
		'rel' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Rel', 'tpsc'),
			'desc' => __('', 'tpsc'),
		),
		'border_radius' => array(
			'std' => 0,
			'type' => 'slider',
			'label' => __('Border Radius', 'tpsc'),
			'desc' => __('in pixel', 'tpsc'),
			'min' => 0,
			'max' => 50,
			'step' => 1
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Class', 'tpsc'),
			'desc' => __('e.g.: class1 class2', 'tpsc'),
		)
	)
);

/* Highlight Config --- */
$perch_shortcodes['perch-highlight'] = array(
	'title' => __('Highlight', 'tpsc'),
	'id' => 'perch-highlight',
	'template' => '[perch_highlight {{attributes}}] {{content}} [/perch_highlight]',
	'params' => array(
		'color' => array(
			'std' => '#6adcfa',
			'type' => 'color',
			'label' => __('Color', 'tpsc'),
			'desc' => __('e.g.: #6adcfa', 'tpsc')
		),
		'content' => array(
			'std' => 'Lorem ipsum dolor sit amet...',
			'type' => 'textarea',
			'label' => __('Text', 'tpsc'),
			'desc' => __('', 'tpsc')
		),
		'visibility' => array(
			'std' => 'all',
			'type' => 'text',
			'label' => __('Visibility', 'tpsc'),
			'desc' => __('', 'tpsc'),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Class', 'tpsc'),
			'desc' => __('', 'tpsc'),
		)
	)
);

/* Config box --- */
$perch_shortcodes['perch-box'] = array(
	'title' => __('Box', 'tpsc'),
	'id' => 'perch-box',
	'template' => '[perch_box {{attributes}}] {{content}} [/perch_box]',
	'params' => array(		
		'color' => array(
			'std' => 'gray',
			'type' => 'color',
			'label' => __('Color', 'tpsc'),
			'desc' => __('', 'tpsc')
		),
		'float' => array(
			'std' => 'center',
			'type' => 'select',
			'label' => __('Float', 'tpsc'),
			'desc' => __('', 'tpsc'),
			'options' => array(
				'left' => 'Left',
				'center' => 'Center',
				'right' => 'right'			
			)
		),
		'text_align' => array(
			'std' => 'left',
			'type' => 'select',
			'label' => __('Text Align', 'tpsc'),
			'desc' => __('', 'tpsc'),
			'options' => array(
				'left' => 'Left',
				'center' => 'Center',
				'justify' => 'Justify',
				'right' => 'right'			
			)
		),
		'width' => array(
			'std' => '100',
			'type' => 'slider',
			'label' => __('Width', 'tpsc'),
			'desc' => __('in percentage', 'tpsc'),
			'min' => 0,
			'max' => 100,
			'step' => 1
		),
		'margin_top' => array(
			'std' => 10,
			'type' => 'slider',
			'label' => __('Margin Top', 'tpsc'),
			'desc' => __('in pixel', 'tpsc'),
			'min' => 0,
			'max' => 100,
			'step' => 1
		),
		'margin_bottom' => array(
			'std' => 10,
			'type' => 'slider',
			'label' => __('Margin Bottom', 'tpsc'),
			'desc' => __('in pixel', 'tpsc'),
			'min' => 0,
			'max' => 100,
			'step' => 1
		),
		'content' => array(
			'std' => 'Lorem ipsum dolor sit amet...',
			'type' => 'textarea',
			'label' => __('Text', 'tpsc'),
			'desc' => __('', 'tpsc')
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Class', 'tpsc'),
			'desc' => __('', 'tpsc'),
		),
		'visibility' => array(
			'std' => 'all',
			'type' => 'text',
			'label' => __('Visibility', 'tpsc'),
			'desc' => __('e.g: all', 'tpsc')
		),
		'fade_in' => array(
			'std' => '',
			'type' => 'select',
			'label' => __('Fade In', 'tpsc'),
			'desc' => __('e.g: true or false', 'tpsc'),
			'options' => array(
				'true' => 'True',
				'false' => 'False',
				
			)
		)
	)
);





/* Config accordion --- */
$perch_shortcodes['perch-accordion'] = array(
    'title' => __('Accordion', 'tpsc'),
    'id' => 'perch-accordion',
    'template' => '[perch_accordion] {{child_shortcode}} [/perch_accordion]',
    'notes' => __('Click \'Add Tag\' to add a new tag. Drag and drop to reorder tabs.', 'tpsc'),
    'params' => array(),
    'child_shortcode' => array(
        'params' => array(
            'title' => array(
                'std' => 'Title',
                'type' => 'text',
                'label' => __('Accordion Title', 'tpsc'),
                'desc' => __('Title of the Accordion.', 'tpsc'),
            ),
            'content' => array(
                'std' => 'Nullam laoreet, velit ut condimentum feugiat, felis nibh ornare massa.',
                'type' => 'textarea',
                'label' => __('Accordion Content', 'tpsc'),
                'desc' => __('Add the Accordion content.', 'tpsc')
            )
        ),
        'template' => '[perch_accordion_section {{attributes}}] {{content}} [/perch_accordion_section]',
        'clone_button' => __('Add Tab', 'tpsc')
    )
);


/* Config heading --- */
$perch_shortcodes['perch-heading'] = array(
	'title' => __('Heading', 'tpsc'),
	'id' => 'perch-heading',
	'template' => '[perch_heading {{attributes}}] {{content}} [/perch_heading]',
	'params' => array(
		'title' => array(
			'std' => 'Sample Heading',
			'type' => 'text',
			'label' => __('Title', 'tpsc'),
			'desc' => __('', 'tpsc')
		),
		'heading_icon_left' => array(
			'std' => '',
			'type' => 'iconpicker',
			'label' => __('Icon Left', 'tpsc'),
			'desc' => __('Pick a icon', 'tpsc')
		),
		'heading_icon_right' => array(
			'std' => '',
			'type' => 'iconpicker',
			'label' => __('Icon Right', 'tpsc'),
			'desc' => __('pick a icon', 'tpsc')
		),
		'type' => array(
			'std' => '',
			'type' => 'select',
			'label' => __('Type', 'tpsc'),
			'desc' => __('', 'tpsc'),
			'options' => array(
				'h1' => 'H1',
				'h2' => 'H2',
				'h3' => 'H3',
				'h4' => 'H4',
				'h5' => 'H5',
				'h6' => 'H6'		
			)
		),
		'text_align' => array(
			'std' => 'left',
			'type' => 'select',
			'label' => __('Text Align', 'tpsc'),
			'desc' => __('', 'tpsc'),
			'options' => array(
				'left' => 'Left',
				'center' => 'Center',
				'justify' => 'Justify',
				'right' => 'right'			
			)
		),
		'style' => array(
			'std' => 'double-line',
			'type' => 'select',
			'label' => __('Style', 'tpsc'),
			'desc' => __('', 'tpsc'),
			'options' => array(
				'single-line' => 'Single Line',
				'double-line' => 'Double Line',			
			)
			
		),
		'margin_top' => array(
			'std' => 10,
			'type' => 'slider',
			'label' => __('Margin Top', 'tpsc'),
			'desc' => __('in pixel', 'tpsc'),
			'min' => 0,
			'max' => 100,
			'step' => 1
		),
		'margin_bottom' => array(
			'std' => 10,
			'type' => 'slider',
			'label' => __('Margin Bottom', 'tpsc'),
			'desc' => __('in pixel', 'tpsc'),
			'min' => 0,
			'max' => 100,
			'step' => 1
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Class', 'tpsc'),
			'desc' => __('', 'tpsc'),
		),
		'font_size' => array(
			'std' => 14,
			'type' => 'slider',
			'label' => __('Font Size', 'tpsc'),
			'desc' => __('in pixel', 'tpsc'),
			'min' => 8,
			'max' => 100,
			'step' => 1
		),
		
		'color' => array(
			'std' => '#323232',
			'type' => 'color',
			'label' => __('Color', 'tpsc'),
			'desc' => __('', 'tpsc')
		),
		
	)
);

/* Config heading --- */
$perch_shortcodes['perch-googlemap'] = array(
	'title' => __('Google Map', 'tpsc'),
	'id' => 'perch-googlemap',
	'template' => '[perch_googlemap {{attributes}}] {{content}} [/perch_googlemap]',
	'params' => array(
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title', 'tpsc'),
			'desc' => __('', 'tpsc')
		),
		'location' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Location', 'tpsc'),
			'desc' => __('', 'tpsc'),
		),
		'width' => array(
			'std' => 100,
			'type' => 'slider',
			'label' => __('Width', 'tpsc'),
			'desc' => __('in percent', 'tpsc'),
			'min' => 1,
			'max' => 100,
			'step' => 1
		),
		'height' => array(
			'std' => 300,
			'type' => 'slider',
			'label' => __('Height', 'tpsc'),
			'desc' => __('in pixel', 'tpsc'),
			'min' => 1,
			'max' => 500,
			'step' => 5
		),
		'zoom' => array(
			'std' => 8,
			'type' => 'slider',
			'label' => __('Zoom', 'tpsc'),
			'desc' => __('', 'tpsc'),
			'min' => 1,
			'max' => 20,
			'step' => 1
		),
		'align' => array(
			'std' => 'left',
			'type' => 'select',
			'label' => __('Align', 'tpsc'),
			'desc' => __('', 'tpsc'),
			'options' => array(
				'left' => 'Left',
				'center' => 'Center',
				'right' => 'right'			
			)
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Class', 'tpsc'),
			'desc' => __('', 'tpsc'),
		),
		'visibility' => array(
			'std' => 'all',
			'type' => 'text',
			'label' => __('Visibility', 'tpsc'),
			'desc' => __('', 'tpsc')
		),
	)
);

/* Config heading --- */
$perch_shortcodes['perch-divider'] = array(
	'title' => __('Divider', 'tpsc'),
	'id' => 'perch-divider',
	'template' => '[perch_divider {{attributes}}] {{content}} [/perch_divider]',
	'params' => array(
		'style' => array(
			'std' => 'fadeout',
			'type' => 'select',
			'label' => __('Style', 'tpsc'),
			'desc' => __('', 'tpsc'),
			'options' => array(
				'fadeout' => 'Fade Out',
				'fadein' => 'Fade In',
				'solid' => 'solid',
				'dashed' => 'dashed',
				'dotted' => 'dotted',
				'double' => 'double'			
			)
		),
		'margin_top' => array(
			'std' => 20,
			'type' => 'slider',
			'label' => __('Margin top', 'tpsc'),
			'desc' => __('in pixel', 'tpsc'),
			'min' => 0,
			'max' => 100,
			'step' => 1
		),
		'margin_bottom' => array(
			'std' => 20,
			'type' => 'slider',
			'label' => __('Margin Bottom', 'tpsc'),
			'desc' => __('in pixel', 'tpsc'),
			'min' => 0,
			'max' => 100,
			'step' => 1
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Class', 'tpsc'),
			'desc' => __('', 'tpsc'),
		),
		'visibility' => array(
			'std' => 'all',
			'type' => 'text',
			'label' => __('Visibility', 'tpsc'),
			'desc' => __('', 'tpsc')
		),
	)
);

/* pricing Config --- */


/* perch_callout_shortcode Config --- */

$perch_shortcodes['perch_callout_shortcode'] = array(
	'title' => __('Callout', 'tpsc'),
	'id' => 'perch_callout_shortcode',
	'template' => '[perch_callout {{attributes}}] {{content}} [/perch_callout]',
	'params' => array(
		'fade_in' => array(
			'type' => 'select',
			'label' => __('FadeIn', 'tpsc'),
			'desc' => __('', 'tpsc'),
			'options' => array(
				'true' => 'True',
				'false' => 'False',
				
			)
		),
		'content' => array(
			'std' => 'Lorem ipsum dolor sit amet.',
			'type' => 'textarea',
			'label' => __('Caption', 'tpsc'),
			'desc' => __('', 'tpsc'),
		),
		'button_text' => array(
			'std' => 'Sample button',
			'type' => 'text',
			'label' => __('Button text', 'tpsc'),
			'desc' => __('', 'tpsc'),
		),
		'button_color' => array(
			'std' => '#1e73be',
			'type' => 'color',
			'label' => __('Button color', 'tpsc'),
			'desc' => __('', 'tpsc'),
		),
		'button_size' => array(
			'type' => 'select',
			'label' => __('Button size', 'tpsc'),
			'desc' => __('', 'tpsc'),
			'options' => array(
				'default' => 'Default',
				'small' => 'Small',
				'medium' => 'Medium',
				'large' => 'Large',
			),
		),
		'button_icon_left' => array(
			'type' => 'iconpicker',
			'label' => __('Button left icon', 'tpsc'),
			'desc' => __('Pick a icon', 'tpsc'),
			'std' => '',
		),	
		'button_icon_right' => array(
			'type' => 'iconpicker',
			'label' => __('Button right icon', 'tpsc'),
			'desc' => __('Pick a icon', 'tpsc'),
			'std' => '',
		),
		'button_border_radius' => array(
			'type' => 'slider',
			'label' => __('Button border radius', 'tpsc'),
			'desc' => __('', 'tpsc'),
			'std' => '1',
			'min' => '0',
			'max' => '50',
			'step' => '1'
		),
		'button_url' => array(
			'std' => 'http://themeperch.com',
			'type' => 'text',
			'label' => __('Button url', 'tpsc'),
			'desc' => __('', 'tpsc'),
		),
		'button_rel' => array(
			'type' => 'select',
			'label' => __('Button Rel', 'tpsc'),
			'desc' => __('', 'tpsc'),
			'options' => array(
				'none' => 'None',
				'nofollow' => 'nofollow',
				
			)
		),
		'button_target' => array(
			'type' => 'select',
			'label' => __('Button Rel', 'tpsc'),
			'desc' => __('', 'tpsc'),
			'options' => array(
				'' => 'Self',
				'_blank' => 'Blank',
				
			)
		)

	)
);

/* Toggle Config --- */

$perch_shortcodes['toggle'] = array(
	'title' => __('Toggle', 'tpsc'),
	'id' => 'tpsc-toggle-shortcode',
	'template' => ' {{child_shortcode}} ', // There is no wrapper shortcode
	'notes' => __('Click \'Add Toggle\' to add a new toggle. Drag and drop to reorder toggles.', 'tpsc'),
	'params' => array(),
	'child_shortcode' => array(
		'params' => array(
			'title' => array(
				'type' => 'text',
				'label' => __('Toggle Content Title', 'tpsc'),
				'desc' => __('Add the title that will go above the toggle content', 'tpsc'),
				'std' => 'Title'
			),
			'content' => array(
				'std' => 'Content',
				'type' => 'textarea',
				'label' => __('Toggle Content', 'tpsc'),
				'desc' => __('Add the toggle content. Will accept HTML', 'tpsc'),
			),
		),
		'template' => '[perch_toggle {{attributes}}] {{content}} [/perch_toggle]',
		'clone_button' => __('Add Toggle', 'tpsc')
	)
);

/* Tabs Config --- */

$perch_shortcodes['tabs'] = array(
    'title' => __('Tab', 'tpsc'),
    'id' => 'tpsc-tabs-shortcode',
    'template' => '[perch_tabgroup] {{child_shortcode}} [/perch_tabgroup]',
    'notes' => __('Click \'Add Tag\' to add a new tag. Drag and drop to reorder tabs.', 'tpsc'),
    'params' => array(),
    'child_shortcode' => array(
        'params' => array(
            'title' => array(
                'std' => 'Title',
                'type' => 'text',
                'label' => __('Tab Title', 'tpsc'),
                'desc' => __('Title of the tab.', 'tpsc'),
            ),
            'content' => array(
                'std' => 'Tab Content',
                'type' => 'textarea',
                'label' => __('Tab Content', 'tpsc'),
                'desc' => __('Add the tabs content.', 'tpsc')
            )
        ),
        'template' => '[perch_tab {{attributes}}] {{content}} [/perch_tab]',
        'clone_button' => __('Add Tab', 'tpsc')
    )
);

/* Columns Config --- */

$perch_shortcodes['columns'] = array(
	'title' => __('Columns', 'tpsc'),
	'id' => 'tpsc-columns-shortcode',
	'template' => ' {{child_shortcode}} ', // There is no wrapper shortcode
	'notes' => __('Click \'Add Column\' to add a new column. Drag and drop to reorder columns.', 'tpsc'),
	'params' => array(),
	'child_shortcode' => array(
		'params' => array(
			'column' => array(
				'type' => 'select',
				'label' => __('Column Type', 'tpsc'),
				'desc' => __('Select the width of the column.', 'tpsc'),
				'options' => array(
					'one-third' => __('One Third', 'tpsc'),
					'two-third' => __('Two Thirds', 'tpsc'),
					'one-half' => __('One Half', 'tpsc'),
					'one-fourth' => __('One Fourth', 'tpsc'),
					'three-fourth' => __('Three Fourth', 'tpsc'),
					'one-fifth' => __('One Fifth', 'tpsc'),
					'two-fifth' => __('Two Fifth', 'tpsc'),
					'three-fifth' => __('Three Fifth', 'tpsc'),
					'four-fifth' => __('Four Fifth', 'tpsc'),
					'one-sixth' => __('One Sixth', 'tpsc'),
					'five-sixth' => __('Five Sixth', 'tpsc')
				)
			),
			'last' => array(
				'type' => 'checkbox',
				'label' => __('Last column', 'tpsc'),
				'desc' => __('Set whether this is the last column.', 'tpsc'),
				'default' => false
			),
			'content' => array(
				'std' => __('Column content', 'tpsc'),
				'type' => 'textarea',
				'label' => __('Column Content', 'tpsc'),
				'desc' => __('Add the column content.', 'tpsc')
			)
		),
		'template' => '[perch_column {{attributes}}] {{content}} [/perch_column]',
		'clone_button' => __('Add Column', 'tpsc')
	)
);

/* Button Config --- */

$perch_shortcodes['perch_button'] = array(
	'title' => __('Button', 'tpsc'),
	'id' => 'perch_button',
	'template' => '[perch_button {{attributes}}] {{content}} [/perch_button]',
	'params' => array(
		'title' => array(
			'std' => 'Sample button',
			'type' => 'text',
			'label' => __('Button text', 'tpsc'),
			'desc' => __('', 'tpsc'),
		),
		'color' => array(
			'std' => '#1e73be',
			'type' => 'color',
			'label' => __('Button color', 'tpsc'),
			'desc' => __('', 'tpsc'),
		),
		'size' => array(
			'type' => 'select',
			'label' => __('Button size', 'tpsc'),
			'desc' => __('', 'tpsc'),
			'options' => array(
				'default' => 'Default',
				'small' => 'Small',
				'medium' => 'Medium',
				'large' => 'Large',
			),
		),
		'icon_left' => array(
			'type' => 'iconpicker',
			'label' => __('Button left icon', 'tpsc'),
			'desc' => __('Pick a icon', 'tpsc'),
			'std' => '',
		),	
		'icon_right' => array(
			'type' => 'iconpicker',
			'label' => __('Button right icon', 'tpsc'),
			'desc' => __('Pick a icon', 'tpsc'),
			'std' => '',
		),
		'border_radius' => array(
			'type' => 'slider',
			'label' => __('Button border radius', 'tpsc'),
			'desc' => __('', 'tpsc'),
			'std' => '1',
			'min' => '0',
			'max' => '50',
			'step' => '1'
		),
		'url' => array(
			'std' => 'http://themeperch.com',
			'type' => 'text',
			'label' => __('Button url', 'tpsc'),
			'desc' => __('', 'tpsc'),
		),
		'rel' => array(
			'type' => 'select',
			'label' => __('Button Rel', 'tpsc'),
			'desc' => __('', 'tpsc'),
			'options' => array(
				'none' => 'None',
				'nofollow' => 'nofollow',
				
			)
		),
		'target' => array(
			'type' => 'select',
			'label' => __('Button Rel', 'tpsc'),
			'desc' => __('', 'tpsc'),
			'options' => array(
				'' => 'Self',
				'_blank' => 'Blank',
				
			)
		)
	)
);

/*perch blog post*/
$perch_shortcodes['perch-blogposts'] = array(
	'title' => __('Blog posts', 'tpsc'),
	'id' => 'perch-blogposts',
	'template' => '[perch_blog_posts {{attributes}}]',
	'params' => array(
		'column' => array(
			'std' => '3',
			'min' => '1',
			'max' => '6',
			'step' => '1',
			'type' => 'slider',
			'label' => __('Column', 'tpsc'),
			'desc' => __('', 'tpsc')
		),
		'posts_per_page' => array(
			'std' => '4',
			'min' => '1',
			'max' => '12',
			'step' => '1',
			'type' => 'slider',
			'label' => __('Posts per page', 'tpsc'),
			'desc' => __('', 'tpsc'),
		),
		'orderby' => array(
			'std' => 'title',
			'type' => 'select',
			'label' => __('Order By', 'tpsc'),
			'desc' => __('', 'tpsc'),
			'options' => array(
				'title' => 'Title',
				'date' => 'Date'		
			)
		),
		'order' => array(
			'std' => 'DESC',
			'type' => 'select',
			'label' => __('Order', 'tpsc'),
			'desc' => __('', 'tpsc'),
			'options' => array(
				'DESC' => 'DESC',
				'ASC' => 'ASC'		
			)
		),
		'see_all_posts_text' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('See All Posts Text', 'tpsc'),
			'desc' => __('See All Posts', 'tpsc'),
		)
	)
);
 

?>