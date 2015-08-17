<?php
/**
 * Iconize_Walker_Nav_Menu class for WordPress versions greater than 3.6.
 *
 * @package Iconize_WP
 * @author  Mladen Ivančević <ivancevic.mladen@gmail.com>
 * @since 1.0.0
 * @uses Walker_Nav_Menu
 */
class Iconize_Walker_Nav_Menu extends Walker_Nav_Menu {

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {

			if ( ! empty( $value ) ) {

				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
		
		$icon_args = array();

		$icon_args['icon_name']           = $item->icon_name;
		$icon_args['icon_set']            = $item->icon_set;
		$icon_args['icon_transform']      = $item->icon_transform;
		$icon_args['icon_size']           = $item->icon_size;
		$icon_args['icon_align']          = $item->icon_align;
		$icon_args['icon_custom_classes'] = $item->icon_custom_classes;
		$icon_args['icon_color']          = $item->icon_color;
		$icon_args['icon_position']       = $item->icon_position;

		// If hover effect selected, add "iconized-hover-trigger" class to link
		$plugin_instance = Iconize_WP::get_instance();
		$hovers = $plugin_instance->get_iconize_dialog_dropdown_options_for( 'hover' );
		$hovers = array_keys( $hovers );

		$link_class = '';

		if ( ! empty( $icon_args['icon_transform'] ) && in_array( $icon_args['icon_transform'], $hovers ) ) {

			$link_class = ' class="iconized-hover-trigger"';
		}

		$icon = iconize_get_icon( $icon_args , 'menu_item' );

		if ( 'after' === $icon_args['icon_position'] ) {

			$title = apply_filters( 'the_title', $item->title, $item->ID ) . $icon;

		} else {

			$title = $icon . apply_filters( 'the_title', $item->title, $item->ID );
		}
		
		$item_output = $args->before;
		$item_output .= '<a'. $attributes . $link_class .'>';
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

	}
	
}
?>