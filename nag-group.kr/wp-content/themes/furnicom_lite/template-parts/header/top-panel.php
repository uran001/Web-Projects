<?php
/**
 * Template part for top panel in header.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Furnicom_lite
 */

// Don't show top panel if all elements are disabled.
if ( ! furnicom_lite_is_top_panel_visible() ) {
	return;
}
?>

<div <?php echo furnicom_lite_get_html_attr_class( array( 'top-panel' ), 'top_panel_bg' ); ?>>
	<div class="container">
		<div class="top-panel__container">
			<?php furnicom_lite_top_message( '<div class="top-panel__message">%s</div>' ); ?>
			<?php furnicom_lite_contact_block( 'header_top_panel' ); ?>

			<div class="top-panel__wrap-items">
				<div class="top-panel__menus">
					<?php furnicom_lite_top_menu(); ?>
					<?php furnicom_lite_login_link(); ?>
					<?php furnicom_lite_social_list( 'header' ); ?>
				</div>
			</div>
		</div>
	</div>
</div><!-- .top-panel -->
