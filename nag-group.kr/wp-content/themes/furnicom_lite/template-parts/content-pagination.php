<?php
/**
 * Template part for posts pagination.
 *
 * @package Furnicom_lite
 */

the_posts_pagination(
	array(
		'prev_text' => sprintf( '%s %s', '<i class="nc-icon-mini arrows-1_minimal-left"></i>', esc_html__( 'PREV', 'furnicom_lite' ) ),
		'next_text' => sprintf( '%s %s', esc_html__( 'NEXT', 'furnicom_lite' ), '<i class="nc-icon-mini arrows-1_minimal-right"></i>' ),
	)
);
