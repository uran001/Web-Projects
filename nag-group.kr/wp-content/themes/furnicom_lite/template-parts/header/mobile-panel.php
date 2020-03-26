<?php
/**
 * Template part for mobile panel in header.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Furnicom_lite
 */
?>
<div class="mobile-panel invert">
	<div class="mobile-panel__inner">
		<?php furnicom_lite_menu_toggle( 'main-menu' ); ?>
		<div class="header-components">
			<?php furnicom_lite_header_search_toggle(); ?>
		</div>
	</div>
	<?php furnicom_lite_header_search( '<div class="header-search">%s<span class="search-form__close"></span></div>' ); ?>
</div>
