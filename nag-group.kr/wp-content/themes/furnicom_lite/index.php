<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Furnicom_lite
 */

if ( have_posts() ) :

	if ( is_home() && ! is_front_page() ) : ?>
		<header>
			<?php printf( apply_filters( 'furnicom_lite_single_post_title_html', '<h1 class="page-title screen-reader-text">%s</h1>' ), single_post_title( null, false ) ); ?>
		</header>

	<?php
	endif; ?>

	<div <?php furnicom_lite_posts_list_class(); ?>>

	<?php furnicom_lite_ads_home_before_loop() ?>

	<?php
	/* Start the Loop */
	while ( have_posts() ) : the_post();

		/*
		 * Include the Post-Format-specific template for the content.
		 * If you want to override this in a child theme, then include a file
		 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
		 */
		get_template_part( 'template-parts/post/content', get_post_format() );

	endwhile; ?>

	</div><!-- .posts-list -->

	<?php get_template_part( 'template-parts/content', 'pagination' );

else :

	get_template_part( 'template-parts/content', 'none' );

endif; ?>
