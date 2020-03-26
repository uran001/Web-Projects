<?php
/**
 * Template part for displaying post author.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Furnicom_lite
 */

$utility = furnicom_lite_utility()->utility;

if ( 'post' === get_post_type() ) :

	$author_visible = ( is_single() ) ? furnicom_lite_is_meta_visible( 'single_post_author', 'single' ) : furnicom_lite_is_meta_visible( 'blog_post_author', 'loop' );

	$utility->meta_data->get_author( array(
		'visible' => $author_visible,
		'prefix'  => esc_html( 'By ', 'furnicom_lite' ),
		'class'   => 'posted-by__author',
		'html'    => '<span class="posted-by">%1$s<a href="%2$s" %3$s %4$s rel="author">%5$s%6$s</a></span>',
		'echo'    => true,
	) );

endif;
