<?php
/**
 * The template for displaying author bio.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Furnicom_lite
 */

if ( ! get_the_author_meta( 'description' ) ) {
	return;
}
?>
<div class="post-author-bio">
	<h5 class="post-author__super-title title-decoration"><?php esc_html_e( 'About the author', 'furnicom_lite' ); ?></h5>

	<div class="post-author__holder clear">
		<div class="post-author__avatar"><?php
			echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'furnicom_lite_author_bio_avatar_size', 78 ), '', esc_attr( get_the_author_meta( 'nickname' ) ) );
		?></div>
		<div class="post-author__content"><?php
			echo get_the_author_meta( 'description' );
		?></div>
	</div>
</div><!--.post-author-bio-->
