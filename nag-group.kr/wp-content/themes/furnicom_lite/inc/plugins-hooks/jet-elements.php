<?php
/**
 * Elementor hooks.
 *
 * @package Furnicom_lite
 */
// Add icon styles in admin.

// Add builder dynamic files.
add_filter( 'furnicom_lite_get_dynamic_css_options', 'furnicom_lite_add_elementor_dynamic_file' );

// Add custom icon support.
add_filter( 'jet-elements/controls/icon/data', 'furnicom_lite_set_theme_icons' );
add_action( 'elementor/editor/after_enqueue_styles', 'furnicom_lite_enqueue_font' );
add_action( 'elementor/frontend/after_register_styles', 'furnicom_lite_enqueue_font' );

// Add custom class at columns if paddings are used
add_action( 'elementor/frontend/element/before_render', 'furnicom_lite_add_column_additional_classes' );

// Add custom class at tabs if border are not used
add_action( 'elementor/widget/render_content', 'furnicom_lite_rewrite_tabs_render_template', 10, 2 );
add_action( 'elementor/widget/print_template', 'furnicom_lite_rewrite_tabs_print_template', 10, 2 );

add_action( 'elementor/element/tabs/section_tabs/after_section_end', 'furnicom_lite_update_tabs_controls' );

/**
 * Add builder dynamic files.
 */
function furnicom_lite_add_elementor_dynamic_file( $options ) {

	$dynamic_files = array(
		FURNICOM_LITE_THEME_DIR . '/assets/css/dynamic/plugins/elementor.css',
	);

	$options['css_files'] = array_merge( $options['css_files'], $dynamic_files );

	return $options;
}

/**
 * Add icon styles in admin.
 */
function furnicom_lite_enqueue_font() {
	wp_enqueue_style( 'nucleo-outline', get_template_directory_uri() . '/assets/css/nucleo-outline.css', array(), '1.0.0' );
}

/**
 * Add custom icon support.
 */
function furnicom_lite_set_theme_icons( $data ) {
	return array(
		'format' => 'nc-icon-outline %s',
		'file'   => get_template_directory() . '/assets/css/nucleo-outline.css',
	);
}

/**
 * Add custom class if paddings are used.
 */
function furnicom_lite_add_column_additional_classes( \Elementor\Element_Base $element ) {

	if( 'column' === $element->get_name() ) {

		$custom_padding = $element->get_settings( 'padding' );

		if ( '' !== $custom_padding['top']
			|| '' !== $custom_padding['bottom']
			|| '' !== $custom_padding['left']
			|| '' !== $custom_padding['right']
		) {
			$element->add_render_attribute(
				'_wrapper',
				array(
					'class' => 'elementor-column-custom-padding',
				)
			);
		}
	}
}

/**
 * Rewrite print tabs template.
 */
function furnicom_lite_rewrite_tabs_print_template( $template, $widget ) {

	if ( 'tabs' !== $widget->get_name() ) {
		return $template;
	}

	ob_start();

	?>

	<div class="elementor-tabs <# if ( 0 === settings.border_width.size ) { #> elementor-tabs-borderless<# } #>" data-active-tab="{{ editSettings.activeItemIndex ? editSettings.activeItemIndex : 0 }}" role="tablist">
		<#
		if ( settings.tabs ) {
			var counter = 1; #>
			<div class="elementor-tabs-wrapper" role="tab">
				<#
				_.each( settings.tabs, function( item ) { #>
					<div class="elementor-tab-title elementor-tab-desktop-title" data-tab="{{ counter }}">
						<# if ( item.tab_icon ) { #>
						<div class="elementor-tab-title__icon">
							<i class="{{{ item.tab_icon }}}"></i>
						</div>
						<# } #>
						<div class="elementor-tab-title__text">
							{{{ item.tab_title }}}
						</div>
					</div>
				<#
					counter++;
				} ); #>
			</div>

			<# counter = 1; #>
			<div class="elementor-tabs-content-wrapper" role="tabpanel">
				<#
				_.each( settings.tabs, function( item ) { #>
					<div class="elementor-tab-title elementor-tab-mobile-title" data-tab="{{ counter }}">{{{ item.tab_title }}}</div>
					<div class="elementor-tab-content elementor-clearfix elementor-repeater-item-{{ item._id }}" data-tab="{{ counter }}">{{{ item.tab_content }}}</div>
				<#
				counter++;
				} ); #>
			</div>
		<# } #>
	</div>
	<?php

	return ob_get_clean();
}

/**
 * Rewrite render tabs template.
 */
function furnicom_lite_rewrite_tabs_render_template( $element, $data ) {

	if ( 'tabs' !== $data->get_name() ) {
		return $element;
	}

	$settings = $data->get_settings();
	$tabs     = $settings['tabs'];

	$wrap_class = 'elementor-tabs';

	if ( 0 == $settings['border_width']['size'] ) {
		$wrap_class .= ' elementor-tabs-borderless';
	}

	ob_start();

	?>
	<div class="<?php echo $wrap_class; ?>" role="tablist">
		<?php
		$counter = 1; ?>
		<div class="elementor-tabs-wrapper" role="tab">
			<?php foreach ( $tabs as $item ) : ?>
				<div class="elementor-tab-title elementor-tab-desktop-title" data-tab="<?php echo $counter; ?>">
					<?php if ( ! empty( $item['tab_icon'] ) ) : ?>
					<div class="elementor-tab-title__icon">
						<i class="<?php echo $item['tab_icon']; ?>"></i>
					</div>
					<?php endif; ?>
					<div class="elementor-tab-title__text"><?php echo $item['tab_title']; ?></div>
				</div>
			<?php
				$counter++;
			endforeach; ?>
		</div>

		<?php
		$counter = 1; ?>
		<div class="elementor-tabs-content-wrapper" role="tabpanel">
			<?php foreach ( $tabs as $item ) : ?>
				<div class="elementor-tab-title elementor-tab-mobile-title" data-tab="<?php echo $counter; ?>"><?php echo $item['tab_title']; ?></div>
				<div class="elementor-tab-content elementor-clearfix" data-tab="<?php echo $counter; ?>"><?php echo furnicom_lite_parse_text_editor( $item['tab_content'], $data ); ?></div>
			<?php
				$counter++;
			endforeach; ?>
		</div>
	</div>
	<?php

	return ob_get_clean();
}

function furnicom_lite_parse_text_editor( $content, $data ) {

		$content = apply_filters( 'widget_text', $content, $data->get_settings() );

		$content = shortcode_unautop( $content );
		$content = do_shortcode( $content );

		if ( $GLOBALS['wp_embed'] instanceof WP_Embed ) {
			$content = $GLOBALS['wp_embed']->autoembed( $content );
		}

		return $content;
	}

/**
 * Add icon controls to tabs widget.
 *
 * @param  object $widget Widget instance.
 */
function furnicom_lite_update_tabs_controls( $widget ) {

	$widget->update_control(
		'tabs',
		array(
			'fields' => array(
				array(
					'name'        => 'tab_icon',
					'label'       => esc_html__( 'Icon', 'furnicom_lite' ),
					'type'        => Elementor\Controls_Manager::ICON,
					'label_block' => true,
				),
				array(
					'name'        => 'tab_title',
					'label'       => esc_html__( 'Title & Content', 'furnicom_lite' ),
					'type'        => Elementor\Controls_Manager::TEXT,
					'default'     => esc_html__( 'Tab Title', 'furnicom_lite' ),
					'placeholder' => esc_html__( 'Tab Title', 'furnicom_lite' ),
					'label_block' => true,
				),
				array(
					'name'        => 'tab_content',
					'label'       => esc_html__( 'Content', 'furnicom_lite' ),
					'default'     => esc_html__( 'Tab Content', 'furnicom_lite' ),
					'placeholder' => esc_html__( 'Tab Content', 'furnicom_lite' ),
					'type'        => Elementor\Controls_Manager::WYSIWYG,
					'show_label'  => false,
				),
			),
		)
	);

	$widget->update_control(
		'type',
		array(
			'options' => [
				'horizontal'      => esc_html__( 'Horizontal', 'furnicom_lite' ),
				'vertical'        => esc_html__( 'Vertical', 'furnicom_lite' ),
				'icon_horizontal' => esc_html__( 'Horizontal With Icon', 'furnicom_lite' ),
				'icon_vertical'   => esc_html__( 'Vertical With Icon', 'furnicom_lite' ),
			],
		)
	);

}
