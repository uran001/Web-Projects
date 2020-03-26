<?php
/**
 * Template part for displaying post categories.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Furnicom_lite
 */

$utility = furnicom_lite_utility()->utility;

if ( 'post' === get_post_type() ) :

	$cats_visible = ( is_single() ) ? furnicom_lite_is_meta_visible( 'single_post_categories', 'single' ) : furnicom_lite_is_meta_visible( 'blog_post_categories', 'loop' );

	$utility->meta_data->get_terms( array(
		'visible'   => $cats_visible,
		'type'      => 'category',
		'delimiter' => ', ',
		'prefix'    => esc_html( 'in ', 'furnicom_lite' ),
		'before'    => '<span class="post__cats">',
		'after'     => '</span>',
		'echo'      => true,
	) );

endif;
