<?php
/**
 * The template for displaying search form.
 *
 * @package Furnicom_lite
 */

$btn_classes = apply_filters( 'furnicom_lite_search_form_btn_classes', 'btn btn-primary' );
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="search-form__input-wrap">
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'furnicom_lite' ) ?></span>
		<input type="search" class="search-form__field" placeholder="<?php echo esc_attr_x( 'Enter keyword', 'placeholder', 'furnicom_lite' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'furnicom_lite' ) ?>" />
	</div>
	<button type="submit" class="search-form__submit <?php echo esc_attr( $btn_classes ); ?>"><?php esc_html_e( 'Search', 'furnicom_lite' ); ?></button>
</form>
