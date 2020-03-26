<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Furnicom_lite
 */
$sidebar_position = get_theme_mod( 'sidebar_position' );

if ( is_active_sidebar( 'sidebar' ) && 'fullwidth' !== $sidebar_position && ! furnicom_lite_is_product_page() ) {
	do_action( 'furnicom_lite_render_widget_area', 'sidebar' );
}