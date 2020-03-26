<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Furnicom_lite
 */

$page_404_image     = get_theme_mod( 'page_404_image', furnicom_lite_theme()->customizer->get_default( 'page_404_image' ) );
$btn_style_preset   = get_theme_mod( 'page_404_btn_style_preset', furnicom_lite_theme()->customizer->get_default( 'page_404_btn_style_preset' ) );
$text_color         = get_theme_mod( 'page_404_text_color', furnicom_lite_theme()->customizer->get_default( 'page_404_text_color' ) );
$additional_class   = ( 'light' === $text_color ) ? 'invert' : 'regular';
$page_404_image_url = '';

if ( $page_404_image ) {
	$page_404_image_url = esc_url( furnicom_lite_render_theme_url( $page_404_image ) );
	$page_404_image_url = '<img src="' . $page_404_image_url . '">';
}
?>
<section class="error-404 not-found <?php echo $additional_class; ?>">
	<header class="page-header">
		<h1 class="page-title screen-reader-text"><?php esc_html_e( '404', 'furnicom_lite' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<div class="row">
			<div class="col-xs-12 col-md-6 image-404"><?php
				echo $page_404_image_url;
			?></div>
			<div class="col-xs-12 col-md-6">
				<h3 class="title-decoration__bottom title-decoration__big"><?php esc_html_e( 'Page Not Found.', 'furnicom_lite' ); ?></h3>
				<p><?php esc_html_e( 'Unfortunately the page you were looking for could not be found.', 'furnicom_lite' ); ?></p>
				<p><a class="btn btn-<?php echo sanitize_html_class( $btn_style_preset ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Go to home!', 'furnicom_lite' ); ?></a></p>
			</div>
		</div>

	</div><!-- .page-content -->
</section><!-- .error-404 -->
