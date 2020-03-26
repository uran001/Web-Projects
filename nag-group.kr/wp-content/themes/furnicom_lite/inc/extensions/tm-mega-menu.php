<?php
/**
 * Extends basic functionality for better TM Mega Menu compatibility
 *
 * @package Furnicom_lite
 */

/**
 * Check if Mega Menu plugin is activated.
 *
 * @return bool
 */
function furnicom_lite_is_mega_menu_active() {
	return class_exists( 'tm_mega_menu' );
}

add_filter( 'furnicom_lite_theme_script_variables', 'furnicom_lite_pass_mega_menu_vars' );

/**
 * Pass Mega Menu variables.
 *
 * @param  array  $vars Variables array.
 * @return array
 */
function furnicom_lite_pass_mega_menu_vars( $vars = array() ) {

	if ( ! furnicom_lite_is_mega_menu_active() ) {
		return $vars;
	}

	$vars['megaMenu'] = array(
		'isActive' => true,
		'location' => get_option( 'tm-mega-menu-location' ),
	);

	return $vars;
}
