<?php
/**
 * Class description
 *
 * @package   package_name
 * @author    Cherry Team
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Furnicom_lite_Elementor' ) ) {

	/**
	 * Define Furnicom_lite_Elementor class
	 */
	class Furnicom_lite_Elementor {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Constructor for the class
		 */
		public function __construct() {
			add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'edit_scripts' ) );
			add_filter( 'cherry_ui_add_data_to_element', array( $this, 'is_elementor_widget' ) );
		}

		/**
		 * Set $add_js_to_response into true if is elementor widget request.
		 *
		 * @param  boolean $add_js_to_response
		 * @return boolean
		 */
		public function is_elementor_widget( $add_js_to_response ) {

			if ( isset( $_REQUEST['action'] ) && 'elementor_editor_get_wp_widget_form' === $_REQUEST['action'] ) {
				return true;
			} else {
				return $add_js_to_response;
			}

		}

		/**
		 * Register widgets assets in editor
		 *
		 * @return [type] [description]
		 */
		public function edit_scripts() {

			$js_core = furnicom_lite_theme()->get_core()->modules['cherry-js-core'];
			$ui      = furnicom_lite_theme()->get_core()->init_module( 'cherry-ui-elements' );
			$builder = furnicom_lite_theme()->get_core()->init_module( 'cherry-interface-builder' );

			wp_enqueue_media();

			$js_core->enqueue_cherry_scripts();
			$ui->enqueue_admin_assets();
			$builder->enqueue_assets();

			wp_enqueue_script(
				'furnicom_lite-edit',
				get_template_directory_uri() . '/assets/js/elementor-edit.js',
				array( 'elementor-editor' ),
				'1.0.0',
				true
			);

			wp_localize_script( 'furnicom_lite-edit', 'furnicom_liteEditData', $this->get_data() );

			wp_enqueue_style(
				'furnicom_lite-edit',
				get_template_directory_uri() . '/assets/css/elementor-edit.css',
				array(),
				'1.0.0'
			);
		}

		/**
		 * Returns JS for elementor-edit.js data
		 *
		 * @return array
		 */
		public function get_data() {

			return array(
				'widgets' => $this->get_widgets(),
			);

		}

		/**
		 * Save widgets list into js variable
		 */
		public function get_widgets() {

			global $wp_widget_factory;

			if ( empty( $wp_widget_factory->widgets ) ) {
				return array();
			}

			$result = array();

			foreach ( $wp_widget_factory->widgets as $widget ) {

				if ( ! isset( $widget->widget_id ) ) {
					continue;
				}

				if ( false === strpos( $widget->widget_id, 'furnicom_lite' ) ) {
					continue;
				}

				$result[] = $widget->widget_id;
			}

			return $result;
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

}

/**
 * Returns instance of Furnicom_lite_Elementor
 *
 * @return object
 */
function furnicom_lite_elementor() {
	return Furnicom_lite_Elementor::get_instance();
}

furnicom_lite_elementor();
