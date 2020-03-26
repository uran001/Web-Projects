<?php
/**
 * The base template for displaying 404 pages (not found).
 *
 * @package Furnicom_lite
 */
?>
<?php get_header( furnicom_lite_template_base() ); ?>

	<div <?php furnicom_lite_content_wrap_class(); ?>>

		<div class="row">

			<div id="primary" <?php furnicom_lite_primary_content_class(); ?>>

				<main id="main" class="site-main" role="main">

					<?php include furnicom_lite_template_path(); ?>

				</main><!-- #main -->

			</div><!-- #primary -->

			<?php get_sidebar(); // Loads the sidebar.php. ?>

		</div><!-- .row -->

	</div><!-- .site-content_wrap -->

<?php get_footer( furnicom_lite_template_base() ); ?>
