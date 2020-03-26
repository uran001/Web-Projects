<?php
/**
 * Furnicom_lite functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Furnicom_lite
 */
if ( ! class_exists( 'Furnicom_lite_Theme_Setup' ) ) {

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since 1.0.0
	 */
	class Furnicom_lite_Theme_Setup {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * A reference to an instance of cherry framework core class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private $core = null;

		/**
		 * Holder for CSS layout scheme.
		 *
		 * @since 1.0.0
		 * @var   array
		 */
		public $layout = array();

		/**
		 * Holder for current customizer module instance.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		public $customizer = null;

		/**
		 * Holder for current dynamic_css module instance.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		public $dynamic_css = null;

		/**
		 * Sets up needed actions/filters for the theme to initialize.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// Set the constants needed by the theme.
			add_action( 'after_setup_theme', array( $this, 'constants' ), -1 );

			// Load the installer core.
			add_action( 'after_setup_theme', require( trailingslashit( get_template_directory() ) . 'cherry-framework/setup.php' ), 0 );

			// Load the core functions/classes required by the rest of the theme.
			add_action( 'after_setup_theme', array( $this, 'get_core' ), 1 );

			// Language functions and translations setup.
			add_action( 'after_setup_theme', array( $this, 'l10n' ), 2 );

			// Handle theme supported features.
			add_action( 'after_setup_theme', array( $this, 'theme_support' ), 3 );

			// Load the theme includes.
			add_action( 'after_setup_theme', array( $this, 'includes' ), 4 );

			// Initialization of modules.
			add_action( 'after_setup_theme', array( $this, 'init' ), 10 );

			// Load admin files.
			add_action( 'wp_loaded', array( $this, 'admin' ), 1 );

			// Enqueue admin assets.
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );

			// Register public assets.
			add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ), 9 );

			// Enqueue public assets.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ), 20 );

			// Denqueue duplicate assets.
			add_action( 'wp_enqueue_scripts', array( $this, 'denqueue_assets' ), 30 );

			// Overrides the load textdomain function for the 'cherry-framework' domain.
			add_filter( 'override_load_textdomain', array( $this, 'override_load_textdomain' ), 5, 3 );

		}

		/**
		 * Defines the constant paths for use within the core and theme.
		 *
		 * @since 1.0.0
		 */
		public function constants() {
			global $content_width;

			/**
			 * Fires before definitions the constants.
			 *
			 * @since 1.0.0
			 */
			do_action( 'furnicom_lite_constants_before' );

			$template  = get_template();
			$theme_obj = wp_get_theme( $template );

			/** Sets the theme version number. */
			define( 'FURNICOM_LITE_THEME_VERSION', $theme_obj->get( 'Version' ) );

			/** Sets the theme directory path. */
			define( 'FURNICOM_LITE_THEME_DIR', get_template_directory() );

			/** Sets the theme directory URI. */
			define( 'FURNICOM_LITE_THEME_URI', get_template_directory_uri() );

			/** Sets the path to the core framework directory. */
			defined( 'CHERRY_DIR' ) or define( 'CHERRY_DIR', trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'cherry-framework' );

			/** Sets the path to the core framework directory URI. */
			defined( 'CHERRY_URI' ) or define( 'CHERRY_URI', trailingslashit( FURNICOM_LITE_THEME_URI ) . 'cherry-framework' );

			/** Sets the theme includes paths. */
			define( 'FURNICOM_LITE_THEME_CLASSES', trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'inc/classes' );
			define( 'FURNICOM_LITE_THEME_WIDGETS', trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'inc/widgets' );
			define( 'FURNICOM_LITE_THEME_EXT', trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'inc/extensions' );

			/** Sets the theme assets URIs. */
			define( 'FURNICOM_LITE_THEME_CSS', trailingslashit( FURNICOM_LITE_THEME_URI ) . 'assets/css' );
			define( 'FURNICOM_LITE_THEME_JS', trailingslashit( FURNICOM_LITE_THEME_URI ) . 'assets/js' );

			// Sets the content width in pixels, based on the theme's design and stylesheet.
			if ( ! isset( $content_width ) ) {
				$content_width = 885;
			}
		}

		/**
		 * Loads the core functions. These files are needed before loading anything else in the
		 * theme because they have required functions for use.
		 *
		 * @since  1.0.0
		 */
		public function get_core() {
			/**
			 * Fires before loads the core theme functions.
			 *
			 * @since 1.0.0
			 */
			do_action( 'furnicom_lite_core_before' );

			global $chery_core_version;

			if ( null !== $this->core ) {
				return $this->core;
			}

			if ( 0 < sizeof( $chery_core_version ) ) {
				$core_paths = array_values( $chery_core_version );

				require_once( $core_paths[0] );
			} else {
				die( 'Class Cherry_Core not found' );
			}

			$this->core = new Cherry_Core( array(
				'base_dir' => CHERRY_DIR,
				'base_url' => CHERRY_URI,
				'modules'  => array(
					'cherry-js-core' => array(
						'autoload' => true,
					),
					'cherry-ui-elements' => array(
						'autoload' => false,
					),
					'cherry-interface-builder' => array(
						'autoload' => false,
					),
					'cherry-utility' => array(
						'autoload' => true,
						'args'     => array(
							'meta_key' => array(
								'term_thumb' => 'cherry_terms_thumbnails',
							),
						),
					),
					'cherry-widget-factory' => array(
						'autoload' => true,
					),
					'cherry-post-formats-api' => array(
						'autoload' => true,
						'args'     => array(
							'rewrite_default_gallery' => true,
							'gallery_args' => array(
								'size'          => 'furnicom_lite-thumb-l',
								'base_class'    => 'post-gallery',
								'container'     => '<div class="%2$s swiper-container" id="%4$s" %3$s><div class="swiper-wrapper">%1$s</div><div class="swiper-button-prev"></div><div class="swiper-button-next"></div><div class="swiper-pagination"></div></div>',
								'slide'         => '<figure class="%2$s swiper-slide">%1$s</figure>',
								'img_class'     => 'swiper-image',
								'slider_handle' => 'jquery-swiper',
								'slider'        => 'swiper',
								'slider_init'   => array(
									'loop'    => true,
									'buttons' => false,
									'arrows'  => true,
								),
								'popup'         => 'magnificPopup',
								'popup_handle'  => 'magnific-popup',
								'popup_init'    => array(
									'type' => 'image',
								),
							),
							'image_args' => array(
								'size'         => 'furnicom_lite-thumb-l',
								'popup'        => 'magnificPopup',
								'popup_handle' => 'magnific-popup',
								'popup_init'   => array(
									'type' => 'image',
								),
							),
						),
					),
					'cherry-customizer' => array(
						'autoload' => false,
					),
					'cherry-dynamic-css' => array(
						'autoload' => false,
					),
					'cherry-google-fonts-loader' => array(
						'autoload' => false,
					),
					'cherry-term-meta' => array(
						'autoload' => false,
					),
					'cherry-post-meta' => array(
						'autoload' => false,
					),
					'cherry-breadcrumbs' => array(
						'autoload' => false,
					),
				),
			) );

			return $this->core;
		}

		/**
		 * Loads the theme translation file.
		 *
		 * @since 1.0.0
		 */
		public function l10n() {
			/*
			 * Make theme available for translation.
			 * Translations can be filed in the /languages/ directory.
			 */
			load_theme_textdomain( 'furnicom_lite', trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'languages' );
		}

		/**
		 * Adds theme supported features.
		 *
		 * @since 1.0.0
		 */
		public function theme_support() {

			// Enable support for Post Thumbnails on posts and pages.
			add_theme_support( 'post-thumbnails' );

			// Enable HTML5 markup structure.
			add_theme_support( 'html5', array(
				'comment-list',
				'comment-form',
				'search-form',
				'gallery',
				'caption',
			) );

			// Enable default title tag.
			add_theme_support( 'title-tag' );

			// Enable post formats.
			add_theme_support( 'post-formats', array(
				'aside',
				'gallery',
				'image',
				'link',
				'quote',
				'video',
				'audio',
				'status',
			) );

			// Enable custom background.
			add_theme_support( 'custom-background', array(
				'default-color' => 'ffffff',
			) );

			// Add default posts and comments RSS feed links to head.
			add_theme_support( 'automatic-feed-links' );

			// Enable support Selective Refresh for widgets into customize.
			add_theme_support( 'customize-selective-refresh-widgets' );

			// Add support for mobile menu
			add_theme_support( 'tm-custom-mobile-menu' );

			// Allow copy custom sidebars into child theme on activation
			add_theme_support( 'cherry_migrate_sidebars' );
		}

		/**
		 * Loads the theme files supported by themes and template-related functions/classes.
		 *
		 * @since 1.0.0
		 */
		public function includes() {
			/**
			 * Configurations.
			 */
			require_once trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'config/layout.php';
			require_once trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'config/menus.php';
			require_once trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'config/sidebars.php';
			require_if_theme_supports( 'post-thumbnails', trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'config/thumbnails.php' );

			/**
			 * Functions.
			 */
			require_once trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'inc/template-tags.php';
			require_once trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'inc/template-menu.php';
			require_once trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'inc/template-meta.php';
			require_once trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'inc/template-comment.php';
			require_once trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'inc/template-related-posts.php';
			require_once trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'inc/extras.php';
			require_once trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'inc/context.php';
			require_once trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'inc/customizer.php';
			require_once trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'inc/hooks.php';
			require_once trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'inc/register-plugins.php';

			/**
			 * Third party plugins hooks.
			 */

			if ( class_exists( 'Cherry_Projects' ) ) {
				require_once trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'inc/plugins-hooks/cherry-projects.php';
			}

			if ( class_exists( 'Cherry_Services_List' ) ) {
				require_once trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'inc/plugins-hooks/cherry-services-list.php';
			}

			if ( class_exists( 'Cherry_Team_Members' ) ) {
				require_once trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'inc/plugins-hooks/cherry-team-members.php';
			}

			if ( class_exists( 'Cherry_Trending_Posts' ) ) {
				require_once trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'inc/plugins-hooks/cherry-trending-posts.php';
			}

			if ( class_exists( 'TM_Testimonials_Plugin' ) ) {
				require_once trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'inc/plugins-hooks/cherry-testi.php';
			}

			if ( class_exists( 'tm_mega_menu' ) ) {
				require_once trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'inc/plugins-hooks/tm-mega-menu.php';
			}

			if ( class_exists( 'Jet_Elements' ) ) {
				require_once trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'inc/plugins-hooks/jet-elements.php';
			}

			if ( class_exists( 'TM_Photo_Gallery' ) ) {
				require_once trailingslashit( FURNICOM_LITE_THEME_DIR ) . 'inc/plugins-hooks/tm-photo-gallery.php';
			}



			/**
			 * Classes.
			 */
			if ( ! is_admin() ) {
				require_once trailingslashit( FURNICOM_LITE_THEME_CLASSES ) . 'class-wrapping.php';
			}

			require_once trailingslashit( FURNICOM_LITE_THEME_CLASSES ) . 'class-widget-area.php';
			require_once trailingslashit( FURNICOM_LITE_THEME_CLASSES ) . 'class-tgm-plugin-activation.php';

			/**
			 * Extensions.
			 */
			require_once trailingslashit( FURNICOM_LITE_THEME_EXT ) . 'tm-mega-menu.php';
			require_once trailingslashit( FURNICOM_LITE_THEME_EXT ) . 'import.php';
			require_once trailingslashit( FURNICOM_LITE_THEME_EXT ) . 'elementor.php';
		}

		/**
		 * Run initialization of modules.
		 *
		 * @since 1.0.0
		 */
		public function init() {
			$this->customizer  = $this->get_core()->init_module( 'cherry-customizer', furnicom_lite_get_customizer_options() );
			$this->dynamic_css = $this->get_core()->init_module( 'cherry-dynamic-css', furnicom_lite_get_dynamic_css_options() );
			$this->get_core()->init_module( 'cherry-google-fonts-loader', furnicom_lite_get_fonts_options() );
			$this->get_core()->init_module( 'cherry-term-meta', array(
				'tax'      => 'category',
				'priority' => 10,
				'fields'   => array(
					'cherry_terms_thumbnails' => array(
						'type'                => 'media',
						'value'               => '',
						'multi_upload'        => false,
						'library_type'        => 'image',
						'upload_button_text'  => esc_html__( 'Set thumbnail', 'furnicom_lite' ),
						'label'               => esc_html__( 'Category thumbnail', 'furnicom_lite' ),
					),
				),
			) );
			$this->get_core()->init_module( 'cherry-term-meta', array(
				'tax'      => 'post_tag',
				'priority' => 10,
				'fields'   => array(
					'cherry_terms_thumbnails' => array(
						'type'                => 'media',
						'value'               => '',
						'multi_upload'        => false,
						'library_type'        => 'image',
						'upload_button_text'  => esc_html__( 'Set thumbnail', 'furnicom_lite' ),
						'label'               => esc_html__( 'Tag thumbnail', 'furnicom_lite' ),
					),
				),
			) );
			$this->get_core()->init_module( 'cherry-post-meta', apply_filters( 'furnicom_lite_page_settings_meta',  array(
				'id'            => 'page-settings',
				'title'         => esc_html__( 'Page settings', 'furnicom_lite' ),
				'page'          => array( 'post', 'page', 'team', 'projects', 'cherry-services' ),
				'context'       => 'normal',
				'priority'      => 'high',
				'callback_args' => false,
				'fields'        => array(
					'tabs' => array(
						'element' => 'component',
						'type'    => 'component-tab-horizontal',
					),
					'layout_tab' => array(
						'element'     => 'settings',
						'parent'      => 'tabs',
						'title'       => esc_html__( 'Layout Options', 'furnicom_lite' ),
					),
					'header_tab' => array(
						'element'     => 'settings',
						'parent'      => 'tabs',
						'title'       => esc_html__( 'Header Style', 'furnicom_lite' ),
						'description' => esc_html__( 'Header style settings', 'furnicom_lite' ),
					),
					'header_elements_tab' => array(
						'element'     => 'settings',
						'parent'      => 'tabs',
						'title'       => esc_html__( 'Header Elements', 'furnicom_lite' ),
						'description' => esc_html__( 'Enable/Disable header elements', 'furnicom_lite' ),
					),
					'breadcrumbs_tab' => array(
						'element'     => 'settings',
						'parent'      => 'tabs',
						'title'       => esc_html__( 'Breadcrumbs', 'furnicom_lite' ),
						'description' => esc_html__( 'Breadcrumbs settings', 'furnicom_lite' ),
					),
					'footer_tab' => array(
						'element'     => 'settings',
						'parent'      => 'tabs',
						'title'       => esc_html__( 'Footer Settings', 'furnicom_lite' ),
						'description' => esc_html__( 'Footer settings', 'furnicom_lite' ),
					),
					'furnicom_lite_sidebar_position' => array(
						'type'          => 'radio',
						'parent'        => 'layout_tab',
						'title'         => esc_html__( 'Sidebar layout', 'furnicom_lite' ),
						'description'   => esc_html__( 'Sidebar position global settings redefining. If you select inherit option, global setting will be applied for this layout', 'furnicom_lite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options'       => array(
							'inherit' => array(
								'label'   => esc_html__( 'Inherit', 'furnicom_lite' ),
								'img_src' => trailingslashit( FURNICOM_LITE_THEME_URI ) . 'assets/images/admin/inherit.svg',
							),
							'one-left-sidebar' => array(
								'label'   => esc_html__( 'Sidebar on left side', 'furnicom_lite' ),
								'img_src' => trailingslashit( FURNICOM_LITE_THEME_URI ) . 'assets/images/admin/page-layout-left-sidebar.svg',
							),
							'one-right-sidebar' => array(
								'label'   => esc_html__( 'Sidebar on right side', 'furnicom_lite' ),
								'img_src' => trailingslashit( FURNICOM_LITE_THEME_URI ) . 'assets/images/admin/page-layout-right-sidebar.svg',
							),
							'fullwidth' => array(
								'label'   => esc_html__( 'No sidebar', 'furnicom_lite' ),
								'img_src' => trailingslashit( FURNICOM_LITE_THEME_URI ) . 'assets/images/admin/page-layout-fullwidth.svg',
							),
						),
					),
					'furnicom_lite_header_container_type' => array(
						'type'          => 'radio',
						'parent'        => 'layout_tab',
						'title'         => esc_html__( 'Header layout', 'furnicom_lite' ),
						'description'   => esc_html__( 'Header layout global settings redefining. If you select inherit option, global setting will be applied for this layout', 'furnicom_lite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options'       => array(
							'inherit'   => array(
								'label'   => esc_html__( 'Inherit', 'furnicom_lite' ),
								'img_src' => trailingslashit( FURNICOM_LITE_THEME_URI ) . 'assets/images/admin/inherit.svg',
							),
							'boxed'     => array(
								'label'   => esc_html__( 'Boxed', 'furnicom_lite' ),
								'img_src' => trailingslashit( FURNICOM_LITE_THEME_URI ) . 'assets/images/admin/type-boxed.svg',
							),
							'fullwidth' => array(
								'label'   => esc_html__( 'Fullwidth', 'furnicom_lite' ),
								'img_src' => trailingslashit( FURNICOM_LITE_THEME_URI ) . 'assets/images/admin/type-fullwidth.svg',
							),
						),
					),
					'furnicom_lite_content_container_type' => array(
						'type'          => 'radio',
						'parent'        => 'layout_tab',
						'title'         => esc_html__( 'Content layout', 'furnicom_lite' ),
						'description'   => esc_html__( 'Content layout global settings redefining. If you select inherit option, global setting will be applied for this layout', 'furnicom_lite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options'       => array(
							'inherit'   => array(
								'label'   => esc_html__( 'Inherit', 'furnicom_lite' ),
								'img_src' => trailingslashit( FURNICOM_LITE_THEME_URI ) . 'assets/images/admin/inherit.svg',
							),
							'boxed'     => array(
								'label'   => esc_html__( 'Boxed', 'furnicom_lite' ),
								'img_src' => trailingslashit( FURNICOM_LITE_THEME_URI ) . 'assets/images/admin/type-boxed.svg',
							),
							'fullwidth' => array(
								'label'   => esc_html__( 'Fullwidth', 'furnicom_lite' ),
								'img_src' => trailingslashit( FURNICOM_LITE_THEME_URI ) . 'assets/images/admin/type-fullwidth.svg',
							),
						),
					),
					'furnicom_lite_footer_container_type'  => array(
						'type'          => 'radio',
						'parent'        => 'layout_tab',
						'title'         => esc_html__( 'Footer layout', 'furnicom_lite' ),
						'description'   => esc_html__( 'Footer layout global settings redefining. If you select inherit option, global setting will be applied for this layout', 'furnicom_lite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options'       => array(
							'inherit'   => array(
								'label'   => esc_html__( 'Inherit', 'furnicom_lite' ),
								'img_src' => trailingslashit( FURNICOM_LITE_THEME_URI ) . 'assets/images/admin/inherit.svg',
							),
							'boxed'     => array(
								'label'   => esc_html__( 'Boxed', 'furnicom_lite' ),
								'img_src' => trailingslashit( FURNICOM_LITE_THEME_URI ) . 'assets/images/admin/type-boxed.svg',
							),
							'fullwidth' => array(
								'label'   => esc_html__( 'Fullwidth', 'furnicom_lite' ),
								'img_src' => trailingslashit( FURNICOM_LITE_THEME_URI ) . 'assets/images/admin/type-fullwidth.svg',
							),
						),
					),
					'furnicom_lite_header_layout_type' => array(
						'type'    => 'radio',
						'parent'  => 'header_tab',
						'title'   => esc_html__( 'Header Layout', 'furnicom_lite' ),
						'value'   => 'inherit',
						'options' => furnicom_lite_get_header_layout_pm_options(),
					),
					'furnicom_lite_header_nav_panel_position' => array(
						'type'          => 'radio',
						'parent'        => 'header_tab',
						'title'         => esc_html__( 'Navigation section position', 'furnicom_lite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options' => array(
							'inherit' => array(
								'label' => esc_html__( 'Inherit', 'furnicom_lite' ),
							),
							'static'    => array(
								'label' => esc_html__( 'Static', 'furnicom_lite' ),
							),
							'over'   => array(
								'label' => esc_html__( 'Over Content', 'furnicom_lite' ),
							),
						),
						'master' => 'header_layout_type_style_5',
					),
					'furnicom_lite_header_transparent_layout' => array(
						'type'          => 'radio',
						'parent'        => 'header_tab',
						'title'         => esc_html__( 'Header Overlay', 'furnicom_lite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options' => array(
							'inherit' => array(
								'label' => esc_html__( 'Inherit', 'furnicom_lite' ),
							),
							'true'    => array(
								'label' => esc_html__( 'Enable', 'furnicom_lite' ),
							),
							'false'   => array(
								'label' => esc_html__( 'Disable', 'furnicom_lite' ),
							),
						),
					),
					'furnicom_lite_header_invert_color_scheme' => array(
						'type'          => 'radio',
						'parent'        => 'header_tab',
						'title'         => esc_html__( 'Invert Color Scheme', 'furnicom_lite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options' => array(
							'inherit' => array(
								'label' => esc_html__( 'Inherit', 'furnicom_lite' ),
							),
							'true'    => array(
								'label' => esc_html__( 'Enable', 'furnicom_lite' ),
							),
							'false'   => array(
								'label' => esc_html__( 'Disable', 'furnicom_lite' ),
							),
						),
					),
					'furnicom_lite_top_panel_visibility' => array(
						'type'          => 'select',
						'parent'        => 'header_elements_tab',
						'title'         => esc_html__( 'Top panel', 'furnicom_lite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options' => array(
							'inherit' => esc_html__( 'Inherit', 'furnicom_lite' ),
							'true'    => esc_html__( 'Enable', 'furnicom_lite' ),
							'false'   => esc_html__( 'Disable', 'furnicom_lite' ),
						),
					),
					'furnicom_lite_header_top_panel_contact_block_visibility' => array(
						'type'          => 'select',
						'parent'        => 'header_elements_tab',
						'title'         => esc_html__( 'Top Panel Contact Block', 'furnicom_lite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options' => array(
							'inherit' => esc_html__( 'Inherit', 'furnicom_lite' ),
							'true'    => esc_html__( 'Enable', 'furnicom_lite' ),
							'false'   => esc_html__( 'Disable', 'furnicom_lite' ),
						),
					),
					'furnicom_lite_header_contact_block_visibility' => array(
						'type'          => 'select',
						'parent'        => 'header_elements_tab',
						'title'         => esc_html__( 'Header Contact Block', 'furnicom_lite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options' => array(
							'inherit' => esc_html__( 'Inherit', 'furnicom_lite' ),
							'true'    => esc_html__( 'Enable', 'furnicom_lite' ),
							'false'   => esc_html__( 'Disable', 'furnicom_lite' ),
						),
					),
					'furnicom_lite_header_btn_visibility' => array(
						'type'          => 'select',
						'parent'        => 'header_elements_tab',
						'title'         => esc_html__( 'Header CTA button', 'furnicom_lite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options' => array(
							'inherit' => esc_html__( 'Inherit', 'furnicom_lite' ),
							'true'    => esc_html__( 'Enable', 'furnicom_lite' ),
							'false'   => esc_html__( 'Disable', 'furnicom_lite' ),
						),
					),
					'furnicom_lite_header_search' => array(
						'type'          => 'select',
						'parent'        => 'header_elements_tab',
						'title'         => esc_html__( 'Header Search', 'furnicom_lite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options' => array(
							'inherit' => esc_html__( 'Inherit', 'furnicom_lite' ),
							'true'    => esc_html__( 'Enable', 'furnicom_lite' ),
							'false'   => esc_html__( 'Disable', 'furnicom_lite' ),
						),
					),
					'furnicom_lite_header_menu_style' => array(
						'type'          => 'select',
						'parent'        => 'header_elements_tab',
						'title'         => esc_html__( 'Main menu style', 'furnicom_lite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options' => array(
							'inherit' => esc_html__( 'Inherit', 'furnicom_lite' ),
							'style-1' => esc_html__( 'Style 1', 'furnicom_lite' ),
							'style-2' => esc_html__( 'Style 2', 'furnicom_lite' ),
						),
					),
					'furnicom_lite_breadcrumbs_visibillity' => array(
						'type'          => 'radio',
						'parent'        => 'breadcrumbs_tab',
						'title'         => esc_html__( 'Breadcrumbs visibillity', 'furnicom_lite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options' => array(
							'inherit' => array(
								'label' => esc_html__( 'Inherit', 'furnicom_lite' ),
							),
							'true'    => array(
								'label' => esc_html__( 'Enable', 'furnicom_lite' ),
							),
							'false'   => array(
								'label' => esc_html__( 'Disable', 'furnicom_lite' ),
							),
						),
					),
					'furnicom_lite_footer_layout_type' => array(
						'type'    => 'select',
						'parent'  => 'footer_tab',
						'title'   => esc_html__( 'Footer Layout', 'furnicom_lite' ),
						'value'   => 'inherit',
						'options' => furnicom_lite_get_footer_layout_pm_options(),
					),
					'furnicom_lite_footer_widget_area_visibility' => array(
						'type'          => 'select',
						'parent'        => 'footer_tab',
						'title'         => esc_html__( 'Footer Widgets Area', 'furnicom_lite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options' => array(
							'inherit' => esc_html__( 'Inherit', 'furnicom_lite' ),
							'true'    => esc_html__( 'Enable', 'furnicom_lite' ),
							'false'   => esc_html__( 'Disable', 'furnicom_lite' ),
						),
					),
					'furnicom_lite_footer_contact_block_visibility' => array(
						'type'          => 'select',
						'parent'        => 'footer_tab',
						'title'         => esc_html__( 'Footer Contact Block', 'furnicom_lite' ),
						'value'         => 'inherit',
						'display_input' => false,
						'options' => array(
							'inherit' => esc_html__( 'Inherit', 'furnicom_lite' ),
							'true'    => esc_html__( 'Enable', 'furnicom_lite' ),
							'false'   => esc_html__( 'Disable', 'furnicom_lite' ),
						),
					),
				),
			) ) );
		}

		/**
		 * Load admin files for the theme.
		 *
		 * @since 1.0.0
		 */
		public function admin() {

			// Check if in the WordPress admin.
			if ( ! is_admin() ) {
				return;
			}
			add_action( 'admin_notices',  array( $this, 'furnicom_lite_premium_notice' ), 1 );
			add_action( 'admin_head', array( $this, 'furnicom_lite_premium_notice_styles' ) );
			add_action( 'admin_menu', array( $this, 'furnicom_lite_update_to_pro_appearance_menu_item' ) );
		}
		public function furnicom_lite_premium_notice() {
			$id = 'furnicom_lite_premium_notice';
			$class = 'notice';
			$message = __( 'Check out <a href="https://www.templatemonster.com/wordpress-themes/65625.html" target="_blank">Furnicom_lite premium</a>! Get more features, widgets and 24/7 support.', '__furnicom_lite' );

			printf( '<div id="%1$s" class="%2$s"><p>%3$s</p></div>', $id, $class, $message );
		}

		public function furnicom_lite_premium_notice_styles() {
			?>
			<style type="text/css">
				#furnicom_lite_premium_notice {
					color: #377900;
					border: 1px solid #74a739;
					border-radius: 3px;
					background-color: #f0f8e2;
					box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
				}
				#furnicom_lite_premium_notice.notice p {
					margin: 1em 0;
				}
				#furnicom_lite-update-to-pro-wrapper {
					max-width: 962px;
				}
				#furnicom_lite-update-to-pro-wrapper p {
					margin: 2em 0;
				}
				.furnicom_lite-btns-wrapper {
					max-width: 962px;
					text-align: center;
				}
				.furnicom_lite-btn {
					margin: 0 10px;
					padding: 0 45px;
					display: inline-block;
					height: 60px;
					font-size: 14px;
					line-height: 60px;
					color: #fff;
					border-radius: 3px;
					text-decoration: none;
					text-align: center;
					outline: none;
					background: #000;
				}
				.furnicom_lite-btn:hover, .furnicom_lite-btn:focus {
					color: #fff;
				}
				.furnicom_lite-btn:before {
					vertical-align: top;
					margin-right: 8px;
					font-family: 'dashicons';
					font-size: 20px;
				}
				.furnicom_lite-btn.furnicom_lite-btn-view {
					background: #309df4;
					background: linear-gradient(to bottom,#42a5f5 0,#2196f3 100%);
				}
				.furnicom_lite-btn.furnicom_lite-btn-view:before {
					content: "\f504";
				}
				.furnicom_lite-btn.furnicom_lite-btn-view:hover {
					background: #1b7bd8;
					background: linear-gradient(to bottom,#2196f3 0,#1976d2 100%);
				}
				.furnicom_lite-btn.furnicom_lite-btn-to-pro {
					background: #74a739;
					background: linear-gradient(to bottom,#83bd40 0,#6a9e2e 100%);
				}
				.furnicom_lite-btn.furnicom_lite-btn-to-pro:before {
					content: "\f174";
				}
				.furnicom_lite-btn.furnicom_lite-btn-to-pro:hover {
					background: #65972b;
					background: linear-gradient(to bottom,#72a536 0,#588821 100%);
				}
			</style>
			<?php
		}

		public function furnicom_lite_update_to_pro_appearance_menu_item() {
			add_theme_page( 'Update to Pro', 'Update to Pro', 'edit_theme_options', 'furnicom_lite-update-to-pro', array( $this, 'furnicom_lite_update_to_pro_callback' ) );
		}


		public function furnicom_lite_update_to_pro_callback() {
			?>
			<div class="wrap">
				<h2>Update to Pro</h2>
				<div id="furnicom_lite-update-to-pro-wrapper">
					<img src="<?php echo FURNICOM_LITE_THEME_URI ?>/assets/images/admin/furnicom-premium.jpg">
					<p><strong>Furnicom_lite</strong> - this fully responsive Furniture Store WordPress Theme will help you to create a fully-functional, fresh and modern website for your furniture store. By using the Customizer, which is a built-in visual settings manager, you can setup fonts, site structure, widgets positioning, images and colors schemes to adjust your future website as much as you want. The main advantage is that you can see the result immediately, without having to work with the source code. Just install this theme and be sure that with our Furniture Store WordPress Theme your store will be represented on the web from the best side. </p>
					<div class="furnicom_lite-btns-wrapper">
						<a href="https://www.templatemonster.com/wordpress-themes/65625.html" class="furnicom_lite-btn furnicom_lite-btn-view" target="_blank">Furnicom_lite Free Demo</a>
						<a href="https://www.templatemonster.com/wordpress-themes/65625.html" class="furnicom_lite-btn furnicom_lite-btn-to-pro" target="_blank">Furnicom_lite Free</a>
					</div>
				</div><!-- mnt-options -->
			</div><!-- wrap -->
			<?php
		}

		/**
		 * Enqueue admin-specific assets.
		 *
		 * @since 1.0.0
		 */
		public function enqueue_admin_assets( $hook ) {

			wp_enqueue_style( 'furnicom_lite-admin-fix-style', FURNICOM_LITE_THEME_CSS . '/admin-fix.min.css', array(), FURNICOM_LITE_THEME_VERSION );

			$available_pages = array(
				'widgets.php',
			);

			if ( ! in_array( $hook, $available_pages ) ) {
				return;
			}

			wp_enqueue_style( 'furnicom_lite-admin-style', FURNICOM_LITE_THEME_CSS . '/admin.min.css', array(), FURNICOM_LITE_THEME_VERSION );
		}

		/**
		 * Register assets.
		 *
		 * @since 1.0.0
		 */
		public function register_assets() {
			wp_register_script( 'jquery-slider-pro', FURNICOM_LITE_THEME_JS . '/min/jquery.slider-pro.min.js', array( 'jquery' ), '1.2.4', true );
			wp_register_script( 'jquery-swiper', FURNICOM_LITE_THEME_JS . '/min/swiper.jquery.min.js', array( 'jquery' ), '3.3.0', true );
			wp_register_script( 'magnific-popup', FURNICOM_LITE_THEME_JS . '/min/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );
			wp_register_script( 'object-fit-images', FURNICOM_LITE_THEME_JS . '/min/ofi.min.js', array(), '3.0.1', true );
			wp_register_script( 'anime', FURNICOM_LITE_THEME_JS . '/min/anime.min.js', array(), '1.0.0', true );
			wp_register_script( 'tilter', FURNICOM_LITE_THEME_JS . '/tilter.js', array(), '1.0.0', true );

			wp_register_style( 'jquery-slider-pro', FURNICOM_LITE_THEME_CSS . '/slider-pro.min.css', array(), '1.2.4' );
			wp_register_style( 'jquery-swiper', FURNICOM_LITE_THEME_CSS . '/swiper.min.css', array(), '3.3.0' );
			wp_register_style( 'magnific-popup', FURNICOM_LITE_THEME_CSS . '/magnific-popup.min.css', array(), '1.1.0' );
			wp_register_style( 'font-awesome', FURNICOM_LITE_THEME_CSS . '/font-awesome.min.css', array(), '4.7.0' );
			wp_register_style( 'nucleo-outline', FURNICOM_LITE_THEME_CSS . '/nucleo-outline.css', array(), '1.0.0' );
			wp_register_style( 'nucleo-mini', FURNICOM_LITE_THEME_CSS . '/nucleo-mini.css', array(), '1.0.0' );
		}

		/**
		 * Enqueue assets.
		 *
		 * @since 1.0.0
		 */
		public function enqueue_assets() {

			wp_enqueue_style( 'furnicom_lite-theme-style', get_stylesheet_uri(),
				array( 'font-awesome', 'magnific-popup', 'nucleo-outline', 'nucleo-mini' ),
				FURNICOM_LITE_THEME_VERSION
			);

			/**
			 * Filter the depends on main theme script.
			 *
			 * @since 1.0.0
			 * @var   array
			 */
			$depends = apply_filters( 'furnicom_lite_theme_script_depends', array( 'cherry-js-core', 'hoverIntent', 'anime', 'tilter' ) );

			wp_enqueue_script( 'furnicom_lite-theme-script', FURNICOM_LITE_THEME_JS . '/theme-script.js', $depends, FURNICOM_LITE_THEME_VERSION, true );

			wp_add_inline_style( 'furnicom_lite-theme-style', furnicom_lite_breadcrumns_inline_css() );

			/**
			 * Filter the strings that send to scripts.
			 *
			 * @since 1.0.0
			 * @var   array
			 */
			$labels = apply_filters( 'furnicom_lite_theme_localize_labels', array(
				'totop_button'  => '',
				'header_layout' => get_theme_mod( 'header_layout_type', furnicom_lite_theme()->customizer->get_default( 'header_layout_type' ) ),
			) );

			$more_button_options = apply_filters( 'furnicom_lite_theme_more_button_options', array(
				'more_button_type'             => get_theme_mod( 'more_button_type', furnicom_lite_theme()->customizer->get_default( 'more_button_type' ) ),
				'more_button_text'             => get_theme_mod( 'more_button_text', furnicom_lite_theme()->customizer->get_default( 'more_button_text' ) ),
				'more_button_icon'             => get_theme_mod( 'more_button_icon', furnicom_lite_theme()->customizer->get_default( 'more_button_icon' ) ),
				'more_button_image_url'        => get_theme_mod( 'more_button_image_url', furnicom_lite_theme()->customizer->get_default( 'more_button_image_url' ) ),
				'retina_more_button_image_url' => get_theme_mod( 'retina_more_button_image_url', furnicom_lite_theme()->customizer->get_default( 'retina_more_button_image_url' ) ),
			) );

			wp_localize_script( 'furnicom_lite-theme-script', 'furnicom_lite', apply_filters(
				'furnicom_lite_theme_script_variables',
				array(
					'ajaxurl'             => esc_url( admin_url( 'admin-ajax.php' ) ),
					'labels'              => $labels,
					'more_button_options' => $more_button_options,
				) ) );

			// Threaded Comments.
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

		/**
		 * Denqueue duplicate assets.
		 *
		 * @since 1.0.0
		 */
		public function denqueue_assets() {

			/**
			 * Filter the dequeue handles.
			 *
			 * @since 1.0.0
			 * @var   array
			 */
			$dequeue_handles = apply_filters( 'furnicom_lite_dequeue_handles', array(
				'style' => array(
					'tm-pg-grid',
					'tm-pg-font-awesome',
				),

				'script' => array(
					'booked-font-awesome',
				),
			) );

			foreach ( $dequeue_handles[ 'style' ] as $handle ) {
				wp_dequeue_style( $handle );
			}

			foreach ( $dequeue_handles[ 'script' ] as $handle ) {
				wp_dequeue_script( $handle );
			}

		}

		/**
		 * Overrides the load textdomain functionality when 'cherry-framework' is the domain in use.
		 *
		 * @since  1.0.0
		 * @link   https://gist.github.com/justintadlock/7a605c29ae26c80878d0
		 *
		 * @param  bool   $override Override.
		 * @param  string $domain   Text domain.
		 * @param  string $mofile   Mofile.
		 *
		 * @return bool
		 */
		public function override_load_textdomain( $override, $domain, $mofile ) {

			// Check if the domain is our framework domain.
			if ( 'cherry-framework' === $domain ) {

				global $l10n;

				// If the theme's textdomain is loaded, assign the theme's translations
				// to the framework's textdomain.
				if ( isset( $l10n['furnicom_lite'] ) ) {
					$l10n[ $domain ] = $l10n['furnicom_lite'];
				}

				// Always override.  We only want the theme to handle translations.
				$override = true;
			}

			return $override;
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}
	}
} // End if().

/**
 * Returns instance of main theme configuration class.
 *
 * @since  1.0.0
 * @return object
 */
function furnicom_lite_theme() {
	return Furnicom_lite_Theme_Setup::get_instance();
}

furnicom_lite_theme();
