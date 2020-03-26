<?php
/**
 * Template part for style-2 header layout.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Furnicom_lite
 */

$search_visible        = get_theme_mod( 'header_search', furnicom_lite_theme()->customizer->get_default( 'header_search' ) );
?>
<div class="header-container_wrap container">

	<div class="header-row__flex">
		<div class="site-branding">
			<?php furnicom_lite_header_logo() ?>
			<?php furnicom_lite_site_description(); ?>
		</div>

		<div class="header-components__contact-button">
			<?php
			furnicom_lite_header_btn();
			furnicom_lite_contact_block( 'header' );
			 ?>
			<?php furnicom_lite_login_link(); ?>
		</div>
	</div>

	<div class="header-nav-wrapper">
		<?php furnicom_lite_main_menu(); ?>

		<?php if ( $search_visible ) : ?>
			<div class="header-components"><?php
				furnicom_lite_header_search_toggle();
			?></div>
		<?php endif; ?>

		<?php furnicom_lite_header_search( '<div class="header-search">%s<span class="search-form__close"></span></div>' ); ?>
	</div>

</div>
