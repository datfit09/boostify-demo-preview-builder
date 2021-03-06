<?php
/**
 * Class Demo Preview Elementor
 *
 * Main Plugin class
 *
 * @since 1.2.0
 *
 * @package boostify-demo-preview-builder
 */

namespace Boostify_Demo_Preview;

/**
 * Class Elementor
 */
class Elementor {
	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $instance = null;

	private $modules_manager; //phpcs:ignore
	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Register custom widget categories
	 *
	 * @param string $elements_manager type.
	 */
	public function add_elementor_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'ht_bfdp_builder',
			array(
				'title' => esc_html__( 'Boostify Demo Preview', 'boostify' ),
			)
		);
	}


	/**
	 * Widget Class
	 */
	public function get_widgets() {
		$widgets = array(
			'Image_Retina',
			'Landing_Image',
		);

		return $widgets;
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function autoload_widgets() {
		$widgets = $this->get_widgets();
		foreach ( $widgets as $widget ) {
			$filename = strtolower( $widget );
			$filename = str_replace( '_', '-', $filename );
			$filename = BOOSTIFY_DEMO_PREVIEW_PATH . 'inc/elementor/widgets/class-' . $filename . '.php';

			if ( is_readable( $filename ) ) {
				include $filename;
			}
		}
	}

	/**
	 * Add icon for elementor
	 *
	 * @param string $controls_registry type.
	 */
	public function modify_controls( $controls_registry ) {
		// Get existing icons.
		$icons = $controls_registry->get_control( 'icon' )->get_settings( 'options' );
		// Append new icons.
		$new_icons = array_merge(
			array(
				'ion-android-arrow-dropdown'  => 'Ion Dropdown',
				'ion-android-arrow-dropright' => 'Ion Dropright',
				'ion-android-arrow-forward'   => 'Ion Forward',
				'ion-chevron-right'           => 'Ion Right',
				'ion-chevron-down'            => 'Ion Downr',
				'ion-ios-arrow-down'          => 'Ion Ios Down',
				'ion-ios-arrow-forward'       => 'Ion Ios Forward',
				'ion-ios-arrow-thin-right'    => 'Thin Right',
				'ion-navicon'                 => 'Ion Navicon',
				'ion-navicon-round'           => 'Navicon Round',
				'ion-android-menu'            => 'Menu',
				'ion-ios-search'              => 'Search',
				'ion-ios-search-strong'       => 'Search Strong',
			),
			$icons
		);
		// Then we set a new list of icons as the options of the icon control.
		$controls_registry->get_control( 'icon' )->set_settings( 'options', $new_icons );
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function init_widgets() {
		$this->autoload_widgets();
		// Its is now safe to include Widgets files.
		$widget_manager = \Elementor\Plugin::instance()->widgets_manager;
		foreach ( $this->get_widgets() as $widget ) {
			$class_name = 'Boostify_Demo_Preview\Widgets\\' . $widget;

			$widget_manager->register_widget_type( new $class_name() );
		}
	}

	/**
	 * Setup hook
	 */
	private function setup_hooks() {
		// Register Module.
		add_action( 'elementor/init', array( $this, 'register_abstract' ) );
		// Register custom widget categories.
		add_action( 'elementor/elements/categories_registered', array( $this, 'add_elementor_widget_categories' ) );
		// Register widgets.
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'init_widgets' ) );
		add_action( 'elementor/controls/controls_registered', array( $this, 'modify_controls' ), 10, 1 );
	}

	/**
	 * Register abstract
	 */
	public function register_abstract() {
		require BOOSTIFY_DEMO_PREVIEW_PATH . 'inc/elementor/abstract/class-base-widget.php';
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {
		$this->setup_hooks();
	}
}
// Instantiate Boostify_Demo_Preview\Elementor Class.
Elementor::instance();

