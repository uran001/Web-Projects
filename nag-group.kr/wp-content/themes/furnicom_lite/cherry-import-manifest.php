<?php
/**
 * Default manifest file
 *
 * @var array
 *
 * @package Furnicom_lite
 */

$settings = array(
	'xml' => false,
	'advanced_import' => array(
		'default' => array(
			'label'    => esc_html__( 'Furnicom_lite', 'furnicom_lite' ),
			'full'     => get_template_directory() . '/assets/demo-content/default/default-full.xml',
			'thumb'    => get_template_directory_uri() . '/assets/demo-content/default/default-thumb.png',
			'demo_url' => 'http://ld-wp2.template-help.com/wptheme/furnicom_lite/',
		),
	),
	'import' => array(
		'chunk_size' => 3,
	),
	'slider' => array(
		'path' => 'https://raw.githubusercontent.com/JetImpex/wizard-slides/master/slides.json',
	),
	'export' => array(
		'options' => array(
			'cherry_projects_options',
			'cherry_projects_options_default',
			'elementor_default_generic_fonts',
			'elementor_container_width',
			'elementor_cpt_support',
			'elementor_disable_color_schemes',
			'elementor_disable_typography_schemes',
			'elementor_css_print_method',
			'elementor_editor_break_lines',
			'elementor_global_image_lightbox',
			'tm-mega-menu-effect',
			'tm-mega-menu-duration',
			'tm-mega-menu-parent-container',
			'tm-mega-menu-location',
			'tm-mega-menu-mobile-trigger',
			'site_icon',
		),
		'tables' => array(
		),
	),
);
