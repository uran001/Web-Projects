<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Furnicom_lite
 */
?>

	</div><!-- #content -->

	<footer id="colophon" <?php furnicom_lite_footer_class() ?> role="contentinfo">
		<?php get_template_part( 'template-parts/footer/footer-area' ); ?>
		<?php get_template_part( 'template-parts/footer/layout', get_theme_mod( 'footer_layout_type', furnicom_lite_theme()->customizer->get_default( 'footer_layout_type' ) ) ); ?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
