<?php
/**
 * Menus configuration.
 *
 * @package Furnicom_lite
 */

add_action( 'after_setup_theme', 'furnicom_lite_register_menus', 5 );
/**
 * Register menus.
 */
function furnicom_lite_register_menus() {

	register_nav_menus( array(
		'top'          => esc_html__( 'Top', 'furnicom_lite' ),
		'main'         => esc_html__( 'Main', 'furnicom_lite' ),
		'main_landing' => esc_html__( 'Landing Main', 'furnicom_lite' ),
		'footer'       => esc_html__( 'Footer', 'furnicom_lite' ),
		'social'       => esc_html__( 'Social', 'furnicom_lite' ),
	) );
}
