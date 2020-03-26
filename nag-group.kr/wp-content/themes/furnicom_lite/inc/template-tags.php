<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Furnicom_lite
 */

/**
 * Show top panel message.
 *
 * @since  1.0.0
 * @param  string $format Output formatting.
 * @return void
 */
function furnicom_lite_top_message( $format = '%s' ) {
	$message = get_theme_mod( 'top_panel_text', furnicom_lite_theme()->customizer->get_default( 'top_panel_text' ) );

	if ( ! $message ) {
		return;
	}

	printf( $format, wp_kses( wp_unslash( $message ), wp_kses_allowed_html( 'post' ) ) );
}

/**
 * Show header search.
 *
 * @since  1.0.0
 * @param  string $format Output formatting.
 * @return void
 */
function furnicom_lite_header_search( $format = '%s' ) {
	$is_enabled = get_theme_mod( 'header_search', furnicom_lite_theme()->customizer->get_default( 'header_search' ) );

	if ( ! $is_enabled ) {
		return;
	}

	printf( $format, get_search_form( false ) );
}

/**
 * Show header search toggle.
 * @return void
 */
function furnicom_lite_header_search_toggle() {
	$is_enabled = get_theme_mod( 'header_search', furnicom_lite_theme()->customizer->get_default( 'header_search' ) );

	if ( ! $is_enabled ) {
		return;
	}

	echo apply_filters( 'furnicom_lite_header_search_toggle', '<div class="search-form__toggle"></div>' );
}

/**
 * Show footer logo, uploaded from customizer.
 *
 * @since  1.0.0
 * @return void
 */
function furnicom_lite_footer_logo() {
	if ( ! get_theme_mod( 'footer_logo_visibility', furnicom_lite_theme()->customizer->get_default( 'footer_logo_visibility' ) ) ) {
		return;
	}

	$logo_url           = get_theme_mod( 'footer_logo_url' );
	$invert_logo_url    = get_theme_mod( 'invert_footer_logo_url', furnicom_lite_theme()->customizer->get_default( 'invert_footer_logo_url' ) );
	$footer_bg          = get_theme_mod( 'footer_bg', furnicom_lite_theme()->customizer->get_default( 'footer_bg' ) );
	$footer_bg_first    = get_theme_mod( 'footer_bg_first', furnicom_lite_theme()->customizer->get_default( 'footer_bg_first' ) );
	$footer_layout_type = get_theme_mod( 'footer_layout_type', furnicom_lite_theme()->customizer->get_default( 'footer_layout_type' ) );

	if ( 'style-1' !== $footer_layout_type && 'dark' === furnicom_lite_hex_color_is_light_or_dark( $footer_bg ) ) {
		$logo_url = $invert_logo_url;
	}

	if ( 'style-1' == $footer_layout_type && 'dark' === furnicom_lite_hex_color_is_light_or_dark( $footer_bg_first ) ) {
		$logo_url = $invert_logo_url;
	}

	if ( ! $logo_url ) {
		return;
	}

	$url      = esc_url( home_url( '/' ) );
	$alt      = esc_attr( get_bloginfo( 'name' ) );
	$logo_url = esc_url( furnicom_lite_render_theme_url( $logo_url ) );
	$logo_id  = furnicom_lite_get_image_id_by_url( furnicom_lite_render_theme_url( $logo_url ) );
	$logo_src = wp_get_attachment_image_src( $logo_id, 'full' );

	if ( $logo_id && $logo_src ) {
		$atts = ' width="' . esc_attr( $logo_src[1] ) . '" height="' . esc_attr( $logo_src[2] ) . '"';
	} else {
		$atts = '';
	}

	$logo_format = apply_filters(
		'furnicom_lite_footer_logo_format',
		'<div class="footer-logo"><a href="%2$s" class="footer-logo_link"><img src="%1$s" alt="%3$s" class="footer-logo_img" %4$s></a></div>'
	);

	printf( $logo_format, $logo_url, $url, $alt, $atts );
}

/**
 * Show footer copyright text.
 *
 * @since  1.0.0
 * @return void
 */
function furnicom_lite_footer_copyright() {
	$copyright = get_theme_mod( 'footer_copyright', furnicom_lite_theme()->customizer->get_default( 'footer_copyright' ) );
	$format    = '<div class="footer-copyright">%s</div>';

	if ( empty( $copyright ) ) {
		return;
	}

	printf( $format, wp_kses( furnicom_lite_render_macros( wp_unslash( $copyright ) ), wp_kses_allowed_html( 'post' ) ) );
}

/**
 * Show contact block.
 *
 * @since  1.0.0
 * @param string $target Current block position: header, footer.
 */
function furnicom_lite_contact_block( $target = 'header' ) {
	$contact_block_visibility = get_theme_mod( $target . '_contact_block_visibility', furnicom_lite_theme()->customizer->get_default( $target . '_contact_block_visibility' ) );

	if ( ! $contact_block_visibility ) {
		return;
	}

	$contact_item_count = apply_filters( 'furnicom_lite_contact_item_count', array(
		'header'           => 3,
		'header_top_panel' => 4,
		'footer'           => 3,
	) );

	$contact_info = array();

	for ( $i = 1; $i <= $contact_item_count[ $target ]; $i ++ ) {
		$icon  = get_theme_mod( $target . '_contact_icon_' . $i, furnicom_lite_theme()->customizer->get_default( $target . '_contact_icon_' . $i ) );
		$label = get_theme_mod( $target . '_contact_label_' . $i, furnicom_lite_theme()->customizer->get_default( $target . '_contact_label_' . $i ) );
		$value = get_theme_mod( $target . '_contact_text_' . $i, furnicom_lite_theme()->customizer->get_default( $target . '_contact_text_' . $i ) );
		if ( ! $icon && ! $value && ! $label ) {
			continue;
		}
		$contact_info [ 'item_' . $i ] = array(
			'icon'  => $icon,
			'label' => $label,
			'value' => $value,
		);
	}

	if ( ! $contact_info ) {
		return;
	}

	$icon_format = apply_filters( 'furnicom_lite_contact_block_icon_format', '<i class="contact-block__icon nc-icon-mini %1$s"></i>' );

	$html = '<div class="contact-block contact-block--' . $target . '"><div class="contact-block__inner">';

	foreach ( $contact_info as $key => $value ) {
		$icon           = ( $value['icon'] ) ? sprintf( $icon_format, $value['icon'] ) : '';
		$label          = ( $value['label'] ) ? sprintf( '<span class="contact-block__label">%1$s</span>', wp_unslash( $value['label'] ) ) : '';
		$text           = ( $value['value'] ) ? sprintf( '<span class="contact-block__text">%1$s</span>', wp_kses( wp_unslash( $value['value'] ), wp_kses_allowed_html( 'post' ) ) ) : '';
		$item_mod_class = ( $value['icon'] ) ? 'contact-block__item--icon' : '';

		$html .= sprintf( '<div class="contact-block__item %1$s">%2$s<div class="contact-block__value-wrap">%3$s%4$s</div></div>', $item_mod_class, $icon, $label, $text );
	}

	$html .= '</div></div>';

	echo $html;
}

/**
 * Show Social list.
 *
 * @since  1.0.0
 * @since  1.0.1 Added new param - $type.
 * @return void
 */
function furnicom_lite_social_list( $context = '', $type = 'icon' ) {
	$visibility_in_header = get_theme_mod( 'header_social_links', furnicom_lite_theme()->customizer->get_default( 'header_social_links' ) );
	$visibility_in_footer = get_theme_mod( 'footer_social_links', furnicom_lite_theme()->customizer->get_default( 'footer_social_links' ) );

	if ( ! $visibility_in_header && ( 'header' === $context ) ) {
		return;
	}

	if ( ! $visibility_in_footer && ( 'footer' === $context ) ) {
		return;
	}

	echo furnicom_lite_get_social_list( $context, $type );
}

/**
 * Show sticky menu label grabbed from options.
 *
 * @param bool $echo Print or return sticky label html.
 *
 * @since  1.0.0
 * @return string|void
 */
function furnicom_lite_sticky_label( $echo = true ) {

	if ( ! is_sticky() || ! is_home() || is_paged() ) {
		return;
	}

	$sticky_type = get_theme_mod(
		'blog_sticky_type',
		furnicom_lite_theme()->customizer->get_default( 'blog_sticky_type' )
	);

	$content     = '';
	$icon_format = apply_filters( 'furnicom_lite_sticky_icon_format', '<i class="nc-icon-mini %1$s"></i>' );

	switch ( $sticky_type ) {

		case 'icon':
			$icon = get_theme_mod(
				'blog_sticky_icon',
				furnicom_lite_theme()->customizer->get_default( 'blog_sticky_icon' )
			);
			$content = sprintf( $icon_format, $icon );
			break;

		case 'label':
			$label = get_theme_mod(
				'blog_sticky_label',
				furnicom_lite_theme()->customizer->get_default( 'blog_sticky_label' )
			);
			$content = furnicom_lite_render_icons( $label );
			break;

		case 'both':
			$icon = get_theme_mod(
				'blog_sticky_icon',
				furnicom_lite_theme()->customizer->get_default( 'blog_sticky_icon' )
			);
			$label = get_theme_mod(
				'blog_sticky_label',
				furnicom_lite_theme()->customizer->get_default( 'blog_sticky_label' )
			);
			$content = sprintf( $icon_format, $icon ) . furnicom_lite_render_icons( $label );
			break;
	}

	if ( empty( $content ) ) {
		return;
	}

	$sticky_format = apply_filters( 'furnicom_lite_sticky_label_format', '<span class="sticky__label type-%2$s">%1$s</span>' );

	if ( ! wp_validate_boolean( $echo ) ) {
		return sprintf( $sticky_format, $content, $sticky_type );
	} else {
		printf( $sticky_format, $content, $sticky_type );
	}
}

/**
 * Display the header logo.
 *
 * @since  1.0.0
 * @return void
 */
function furnicom_lite_header_logo() {
	$type = get_theme_mod( 'header_logo_type', furnicom_lite_theme()->customizer->get_default( 'header_logo_type' ) );
	$logo = furnicom_lite_get_site_title_by_type( $type );

	if ( is_front_page() && is_home() ) {
		$tag = 'h1';
	} else {
		$tag = 'div';
	}

	$format = apply_filters(
		'furnicom_lite_header_logo_format',
		'<%1$s class="site-logo site-logo--%4$s"><a class="site-logo__link" href="%2$s" rel="home">%3$s</a></%1$s>'
	);

	printf( $format, $tag, esc_url( home_url( '/' ) ), $logo, $type );
}

/**
 * Retrieve the site title (image or text).
 *
 * @since  1.0.0
 * @return string
 */
function furnicom_lite_get_site_title_by_type( $type ) {

	if ( ! in_array( $type, array( 'text', 'image' ) ) ) {
		$type = 'text';
	}

	$logo = get_bloginfo( 'name' );

	if ( 'text' === $type ) {
		return $logo;
	}

	$logo_url        = get_theme_mod( 'header_logo_url', furnicom_lite_theme()->customizer->get_default( 'header_logo_url' ) );
	$invert_logo_url = get_theme_mod( 'invert_header_logo_url', furnicom_lite_theme()->customizer->get_default( 'invert_header_logo_url' ) );
	$header_invert   = get_theme_mod( 'header_invert_color_scheme', furnicom_lite_theme()->customizer->get_default( 'header_invert_color_scheme' ) );

	if ( $header_invert && $invert_logo_url ) {
		$logo_url = $invert_logo_url;
	}

	if ( ! $logo_url ) {
		return $logo;
	}

	$logo_url               = furnicom_lite_render_theme_url( $logo_url );
	$retina_logo            = '';
	$retina_logo_url        = get_theme_mod( 'retina_header_logo_url', furnicom_lite_theme()->customizer->get_default( 'retina_header_logo_url' ) );
	$invert_retina_logo_url = get_theme_mod( 'invert_retina_header_logo_url', furnicom_lite_theme()->customizer->get_default( 'invert_retina_header_logo_url' ) );

	if ( $header_invert && $invert_retina_logo_url ) {
		$retina_logo_url = $invert_retina_logo_url;
	}

	$retina_logo_url = furnicom_lite_render_theme_url( $retina_logo_url );
	$logo_id         = furnicom_lite_get_image_id_by_url( $logo_url );

	if ( $retina_logo_url ) {
		$retina_logo = sprintf( 'srcset="%s 2x"', esc_url( $retina_logo_url ) );
	}

	$logo_src = wp_get_attachment_image_src( $logo_id, 'full' );

	if ( $logo_id && $logo_src ) {
		$atts = ' width="' . $logo_src[1] . '" height="' . $logo_src[2] . '"';
	} else {
		$atts = '';
	}

	$format_image = apply_filters( 'furnicom_lite_header_logo_image_format',
		'<img src="%1$s" alt="%2$s" class="site-link__img" %3$s%4$s>'
	);

	return sprintf( $format_image, esc_url( $logo_url ), esc_attr( $logo ), $retina_logo, $atts );
}

/**
 * Display the site description.
 *
 * @since  1.0.0
 * @return void
 */
function furnicom_lite_site_description() {
	$show_desc = get_theme_mod( 'show_tagline', furnicom_lite_theme()->customizer->get_default( 'show_tagline' ) );

	if ( ! $show_desc ) {
		return;
	}

	$description = get_bloginfo( 'description', 'display' );

	if ( ! ( $description || is_customize_preview() ) ) {
		return;
	}

	$format = apply_filters( 'furnicom_lite_site_description_format', '<div class="site-description">%s</div>' );

	printf( $format, $description );
}

/**
 * Display box with information about author.
 *
 * @since  1.0.0
 * @return void
 */
function furnicom_lite_post_author_bio() {
	$is_enabled = get_theme_mod( 'single_author_block', furnicom_lite_theme()->customizer->get_default( 'single_author_block' ) );

	if ( ! $is_enabled ) {
		return;
	}

	if ( ! is_singular( 'post' ) ) {
		return;
	}

	get_template_part( 'template-parts/content', 'author-bio' );
}

/**
 * Display header-box for modern single post.
 */
function furnicom_lite_single_post_full_width_section() {

	if ( ! is_singular( 'post' ) ) {
		return;
	}

	while ( have_posts() ) : the_post();
		get_template_part( 'template-parts/post/content-single-header', get_post_format() );
	endwhile;
}

/**
 * Display a link to all posts by an author.
 *
 * @since  1.0.0
 * @return string An HTML link to the author page.
 */
function furnicom_lite_get_the_author_posts_link() {
	ob_start();
	the_author_posts_link();
	$author = ob_get_clean();

	return $author;
}

/**
 * Display the breadcrumbs.
 *
 * @since  1.0.0
 * @return void
 */
function furnicom_lite_site_breadcrumbs() {
	$breadcrumbs_visibillity       = get_theme_mod( 'breadcrumbs_visibillity', furnicom_lite_theme()->customizer->get_default( 'breadcrumbs_visibillity' ) );
	$breadcrumbs_page_title        = get_theme_mod( 'breadcrumbs_page_title', furnicom_lite_theme()->customizer->get_default( 'breadcrumbs_page_title' ) );
	$breadcrumbs_path_type         = get_theme_mod( 'breadcrumbs_path_type', furnicom_lite_theme()->customizer->get_default( 'breadcrumbs_path_type' ) );
	$breadcrumbs_front_visibillity = get_theme_mod( 'breadcrumbs_front_visibillity', furnicom_lite_theme()->customizer->get_default( 'breadcrumbs_front_visibillity' ) );

	$breadcrumbs_settings = apply_filters( 'furnicom_lite_breadcrumbs_settings', array(
		'wrapper_format'    => '<div class="container"><div class="row">%1$s<div class="breadcrumbs__items">%2$s</div></div></div>',
		'page_title_format' => '<div class="breadcrumbs__title"><h5 class="page-title">%s</h5></div>',
		'separator'         => '&#47;',
		'show_title'        => $breadcrumbs_page_title,
		'path_type'         => $breadcrumbs_path_type,
		'show_on_front'     => $breadcrumbs_front_visibillity,
		'labels'            => array(
			'browse'         => esc_html__( 'You Are Here:', 'furnicom_lite' ),
			'error_404'      => esc_html__( '404 Not Found', 'furnicom_lite' ),
			'archives'       => esc_html__( 'Archives', 'furnicom_lite' ),
			/* Translators: %s is the search query. The HTML entities are opening and closing curly quotes. */
			'search'         => esc_html__( 'Search results for &#8220;%s&#8221;', 'furnicom_lite' ),
			/* Translators: %s is the page number. */
			'paged'          => esc_html__( 'Page %s', 'furnicom_lite' ),
			/* Translators: Minute archive title. %s is the minute time format. */
			'archive_minute' => esc_html__( 'Minute %s', 'furnicom_lite' ),
			/* Translators: Weekly archive title. %s is the week date format. */
			'archive_week'   => esc_html__( 'Week %s', 'furnicom_lite' ),
		),
		'date_labels' => array(
			'archive_minute_hour' => esc_html_x( 'g:i a', 'minute and hour archives time format', 'furnicom_lite' ),
			'archive_minute'      => esc_html_x( 'i', 'minute archives time format', 'furnicom_lite' ),
			'archive_hour'        => esc_html_x( 'g a', 'hour archives time format', 'furnicom_lite' ),
			'archive_year'        => esc_html_x( 'Y', 'yearly archives date format', 'furnicom_lite' ),
			'archive_month'       => esc_html_x( 'F', 'monthly archives date format', 'furnicom_lite' ),
			'archive_day'         => esc_html_x( 'j', 'daily archives date format', 'furnicom_lite' ),
			'archive_week'        => esc_html_x( 'W', 'weekly archives date format', 'furnicom_lite' ),
		),
		'css_namespace' => array(
			'module'    => 'breadcrumbs',
			'content'   => 'breadcrumbs__content',
			'wrap'      => 'breadcrumbs__wrap',
			'browse'    => 'breadcrumbs__browse',
			'item'      => 'breadcrumbs__item',
			'separator' => 'breadcrumbs__item-sep',
			'link'      => 'breadcrumbs__item-link',
			'target'    => 'breadcrumbs__item-target',
		),
	) );

	if ( $breadcrumbs_visibillity ) {
		furnicom_lite_theme()->get_core()->init_module( 'cherry-breadcrumbs', $breadcrumbs_settings );
		do_action( 'cherry_breadcrumbs_render' );
	}
}

/**
 * Display the page preloader.
 *
 * @since  1.0.0
 * @return void
 */
function furnicom_lite_get_page_preloader() {
	$page_preloader = get_theme_mod( 'page_preloader', furnicom_lite_theme()->customizer->get_default( 'page_preloader' ) );

	if ( $page_preloader ) {
		echo '<div class="page-preloader-cover">
					<svg class="preloader-icon" width="34" height="38" viewBox="0 0 34 38">
					<path class="preloader-path" stroke-dashoffset="0" d="M29.437 8.114L19.35 2.132c-1.473-.86-3.207-.86-4.68 0L4.153 8.114C2.68 8.974 1.5 10.56 1.5 12.28v11.964c0 1.718 1.22 3.306 2.69 4.165l10.404 5.98c1.47.86 3.362.86 4.834 0l9.97-5.98c1.472-.86 2.102-2.45 2.102-4.168V12.28c0-1.72-.59-3.306-2.063-4.166z">
					</path>
				</svg>
			</div>';
	}
}

/**
 * Check if top panel visible or not
 *
 * @return bool
 */
function furnicom_lite_is_top_panel_visible() {
	$message              = get_theme_mod( 'top_panel_text', furnicom_lite_theme()->customizer->get_default( 'top_panel_text' ) );
	$menu                 = has_nav_menu( 'top' ) && get_theme_mod( 'top_menu_visibility', furnicom_lite_theme()->customizer->get_default( 'top_menu_visibility' ) );
	$contact_block        = get_theme_mod( 'header_top_panel_contact_block_visibility', furnicom_lite_theme()->customizer->get_default( 'header_top_panel_contact_block_visibility' ) );
	$social_menu          = get_theme_mod( 'header_social_links', furnicom_lite_theme()->customizer->get_default( 'header_social_links' ) );
	$top_panel_visibility = get_theme_mod( 'top_panel_visibility', furnicom_lite_theme()->customizer->get_default( 'top_panel_visibility' ) );

	$conditions = apply_filters( 'furnicom_lite_top_panel_visibility_conditions', array( $message, $menu, $contact_block, $social_menu ) );

	$is_visible = false;

	if ( ! $top_panel_visibility ) {
		return $is_visible;
	}

	foreach ( $conditions as $condition ) {

		if ( ! empty( $condition ) ) {
			$is_visible = true;
		}
	}

	return $is_visible;
}

/**
 * Display the ads.
 *
 * @since  1.0.0
 * @param  string $location location of ads in theme.
 * @return void
 */
function furnicom_lite_ads( $location ) {
	$ads    = trim( get_theme_mod( 'ads_' . $location, furnicom_lite_theme()->customizer->get_default( 'ads_' . $location ) ) );
	$format = '<div class="' . $location . '-ads">%s</div>';

	if ( empty( $ads ) ) {
		return;
	}

	printf( $format, wp_specialchars_decode( $ads, ENT_QUOTES ) );
}

/**
 * Display sidebar.
 */
function furnicom_lite_get_sidebar() {
	$sidebar_services = get_theme_mod( 'sidebar_services', furnicom_lite_theme()->customizer->get_default( 'sidebar_services' ) );
	$sidebar_projects = get_theme_mod( 'sidebar_projects', furnicom_lite_theme()->customizer->get_default( 'sidebar_projects' ) );

	if ( class_exists( 'Cherry_Services_List' ) && is_singular( 'cherry-services' ) && $sidebar_services ) {
		get_sidebar( 'single-service' ); // Loads the sidebar-single-service.php template.
	} else if ( class_exists( 'Cherry_Projects' ) && is_singular( 'projects' ) && $sidebar_projects ) {
		get_sidebar( 'single-project' ); // Loads the sidebar-single-project.php template.
	} else {
		get_sidebar(); // Loads sidebar.php
	}
}

/**
 * Display the header ads.
 */
function furnicom_lite_ads_header() {
	furnicom_lite_ads( 'header' );
}

/**
 * Display ads for before loop location.
 */
function furnicom_lite_ads_home_before_loop() {
	furnicom_lite_ads( 'home_before_loop' );
}

/**
 * Display ads for before loop content.
 */
function furnicom_lite_ads_post_before_content() {
	furnicom_lite_ads( 'post_before_content' );
}

/**
 * Display ads for before comments.
 */
function furnicom_lite_ads_post_before_comments() {
	furnicom_lite_ads( 'post_before_comments' );
}

/**
 * Header custom button.
 */
function furnicom_lite_header_btn() {
	$btn_visibility = get_theme_mod( 'header_btn_visibility', furnicom_lite_theme()->customizer->get_default( 'header_btn_visibility' ) );
	$btn_text       = get_theme_mod( 'header_btn_text', furnicom_lite_theme()->customizer->get_default( 'header_btn_text' ) );
	$icon           = get_theme_mod( 'header_btn_icon', furnicom_lite_theme()->customizer->get_default( 'header_btn_icon' ) );
	$icon_location  = get_theme_mod( 'header_btn_icon_location', furnicom_lite_theme()->customizer->get_default( 'header_btn_icon_location' ) );
	$btn_url        = get_theme_mod( 'header_btn_url', furnicom_lite_theme()->customizer->get_default( 'header_btn_url' ) );
	$btn_target     = get_theme_mod( 'header_btn_target', furnicom_lite_theme()->customizer->get_default( 'header_btn_target' ) );
	$btn_style      = get_theme_mod( 'header_btn_style', furnicom_lite_theme()->customizer->get_default( 'header_btn_style' ) );


	if ( ! $btn_visibility ) {
		return;
	}

	if ( ! $btn_text || ! $btn_url ) {
		return;
	}

	$icon          = $icon ? '<i class="nc-icon-mini  ' . esc_attr( $icon ) . '"></i>' : '';
	$icon_location = $icon ? 'btn-with-icon header-icon-' . $icon_location : '';
	$btn_style     = 'btn-' . $btn_style;

	$target = $btn_target ? ' target="_blank"' : '';

	$format = apply_filters( 'furnicom_lite_header_btn_html_format', '<div class="header-btn-wrap"><a class="header-btn btn %6$s %5$s" href="%2$s"%3$s>%4$s %1$s</a></div>' );

	printf( $format, wp_kses( wp_unslash( $btn_text ), wp_kses_allowed_html( 'post' ) ), esc_url( furnicom_lite_render_macros( $btn_url ) ), $target, $icon, $icon_location, $btn_style );
}

/**
 * Checks post listing for default & small image.
 */
function furnicom_lite_check_for_small_image_default_listing() {
	$blog_layout_type    = get_theme_mod( 'blog_layout_type', furnicom_lite_theme()->customizer->get_default( 'blog_layout_type' ) );
	$blog_featured_image = get_theme_mod( 'blog_featured_image', furnicom_lite_theme()->customizer->get_default( 'blog_featured_image' ) );

	if ( 'default' == $blog_layout_type && 'small' == $blog_featured_image ) {
		return true;
	}

	return false;
}

/**
 * Bradcrumbs bg image.
 */
function furnicom_lite_breadcrumns_inline_css() {
	$breadcrumbs_bg_image = get_theme_mod( 'breadcrumbs_bg_image', furnicom_lite_theme()->customizer->get_default( 'breadcrumbs_bg_image' ) );

	if ( $breadcrumbs_bg_image ) {
		$breadcrumbs_bg_image    = esc_url( sprintf( $breadcrumbs_bg_image, get_template_directory_uri() ) );
		$breadcrumbs_bg_position = get_theme_mod( 'breadcrumbs_bg_position', furnicom_lite_theme()->customizer->get_default( 'breadcrumbs_bg_position' ) );

		$css = '.breadcrumbs:before { background-image: url( ' . $breadcrumbs_bg_image . ' ); background-position: ' . $breadcrumbs_bg_position . '; }';

		return $css;
	}
}
