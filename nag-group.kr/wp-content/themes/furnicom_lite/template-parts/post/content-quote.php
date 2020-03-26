<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Furnicom_lite
 */
?>

<?php
	$blog_layout_type    = get_theme_mod( 'blog_layout_type', furnicom_lite_theme()->customizer->get_default( 'blog_layout_type' ) );
	$blog_featured_image = get_theme_mod( 'blog_featured_image', furnicom_lite_theme()->customizer->get_default( 'blog_featured_image' ) );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'posts-list__item card' ); ?>>

	<?php $blog_layout_type = get_theme_mod( 'blog_layout_type', furnicom_lite_theme()->customizer->get_default( 'blog_layout_type' ) ); ?>

	<?php if ( 'default' == $blog_layout_type && 'small' !== $blog_featured_image ) : ?>
		<div class="posts-list__left-col"><?php
			get_template_part( 'template-parts/post/post-meta/content-meta-date' );

			if ( 'small' !== $blog_featured_image ) {
				furnicom_lite_share_buttons( 'loop' );
			}
		?></div><!-- .posts-list__left-col -->
	<?php endif; ?>

	<div class="posts-list__right-col">
		<?php
			if ( 'default' !== $blog_layout_type || furnicom_lite_check_for_small_image_default_listing() ) :
				get_template_part( 'template-parts/post/post-meta/content-meta-date' );
			endif;
		?>

		<div class="posts-list__item-content">

			<header class="entry-header"><?php
				get_template_part( 'template-parts/post/post-meta/content-meta-author' );
				get_template_part( 'template-parts/post/post-meta/content-meta-categories' );
			?></header><!-- .entry-header -->

			<div class="post-featured-content"><?php
				do_action( 'cherry_post_format_quote' );
				get_template_part( 'template-parts/post/post-components/post-sticky' );
			?></div><!-- .post-featured-content -->

			<div class="entry-content"><?php
				get_template_part( 'template-parts/post/post-components/post-content' );
			?></div><!-- .entry-content -->

			<footer class="entry-footer">
				<div class="entry-meta-container"><?php
					get_template_part( 'template-parts/post/post-meta/content-meta-tags' );
					get_template_part( 'template-parts/post/post-meta/content-meta-comments' );
				?></div>

				<div class="entry-footer-bottom"><?php
					get_template_part( 'template-parts/post/post-components/post-button' );

					if ( 'default' !== $blog_layout_type || furnicom_lite_check_for_small_image_default_listing() ) :
						furnicom_lite_share_buttons( 'loop' );
					endif;
				?></div><!-- .entry-footer-bottom -->
			</footer><!-- .entry-footer -->
		</div><!-- .posts-list__item-content -->
	</div><!-- .posts-list__right-col -->

</article><!-- #post-## -->
