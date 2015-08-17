<?php
/**
 * Creates the admin interface to add shortcodes to the widget
 *
 * @package  PerchShortcodes
 * @since 2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
add_action('widgets_init',
     create_function('', 'return register_widget("Perch_Shortcode_Widget");')
);
/**
 * TPSC_Admin_Insert class
 */
class Perch_Shortcode_Widget extends WP_Widget {

	/**
	 * __construct function
	 *
	 * @access public
	 * @return  void
	 */
	public function __construct() {
		parent::__construct(
			'perch_shortcode_widget', // Base ID
			__( 'LandX shortcode generator', 'perch' ), // Name
			array( 'description' => __( 'Generate your shortcode', 'perch' ), ) // Args
		);
		
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
		 $shortcode = ! empty( $instance['shortcode'] ) ? $instance['shortcode'] : '';
		$output = '<p><a onclick="tpscAddClass(jQuery(this));" href="#TB_inline?width=4000&amp;inlineId=tpsc-choose-shortcode" class="thickbox button tpsc-thicbox" title="' . __( 'Insert Shortcode', 'tpsc' ) . '">' . __( 'Insert Shortcode', 'tpsc' ) . '</a></p>';
		$output .= '<p><textarea id="'.$this->get_field_id( 'shortcode' ).'" name="'.$this->get_field_name( 'shortcode' ).'" class="perch-shortcode-area widefat">'.$shortcode.'</textarea></p>';
		echo $output;
	}


	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo do_shortcode($instance['shortcode']);
	}


	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['shortcode'] = ( ! empty( $new_instance['shortcode'] ) ) ?  $new_instance['shortcode']  : '';

		return $instance;
	}
	
	
}

