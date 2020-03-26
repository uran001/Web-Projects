<?php
/**
 * TM-Wizard configuration.
 *
 * @var array
 *
 * @package Furnicom_lite
 */

$plugins = array(
    'cherry-data-importer' => array(
        'name'   => esc_html__( 'Cherry Data Importer', 'furnicom_lite' ),
        'source' => 'remote', // 'local', 'remote', 'wordpress' (default).
        'path'   => 'https://github.com/CherryFramework/cherry-data-importer/archive/master.zip',
        'access' => 'base',
    ),
    'cherry-projects' => array(
        'name'   => esc_html__( 'Cherry Projects', 'furnicom_lite' ),
        'access' => 'skins',
    ),

    'cherry-sidebars' => array(
        'name'   => esc_html__( 'Cherry Sidebars', 'furnicom_lite' ),
        'access' => 'base',
    ),

    'elementor' => array(
        'name'   => esc_html__( 'Elementor Page Builder', 'furnicom_lite' ),
        'access' => 'base',
    ),
    'jet-elements' => array(
        'name'   => esc_html__( 'Jet Elements addon For Elementor', 'furnicom_lite' ),
        'source' => 'local',
        'path'   => FURNICOM_LITE_THEME_DIR . '/assets/includes/plugins/jet-elements.zip',
        'access' => 'base',
    ),
    'tm-mega-menu' => array(
        'name'   => esc_html__( 'TM Mega Menu', 'furnicom_lite' ),
        'source' => 'remote',
        'path'   => 'http://cloud.cherryframework.com/downloads/free-plugins/tm-mega-menu.zip',
        'access' => 'skins',
    ),

    'contact-form-7' => array(
        'name'   => esc_html__( 'Contact Form 7', 'furnicom_lite' ),
        'access' => 'skins',
    ),
);

/**
 * Skins configuration example
 *
 * @var array
 */
$skins = array(
    'base' => array(
        'cherry-data-importer',
        'cherry-sidebars',
        'elementor',
        'jet-elements',
    ),
    'advanced' => array(
        'default' => array(
            'full'  => array(
                'cherry-projects',
                'tm-mega-menu',
                'contact-form-7',
            ),
            'lite'  => false,
            'demo'  => 'http://ld-wp2.template-help.com/wptheme/furnicom_lite/',
            'thumb' => get_template_directory_uri() . '/assets/demo-content/default/default-thumb.png',
            'name'  => esc_html__( 'Furnicom_lite', 'furnicom_lite' ),
        ),


    ),
);

$texts = array(
    'theme-name' => 'Furnicom_lite'
);