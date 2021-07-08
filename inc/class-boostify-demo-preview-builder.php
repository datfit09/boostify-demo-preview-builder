<?php
/**
 * Class Boostify Demo Preview Builder
 *
 * Main Plugin class
 *
 * @package boostify-demo-preview-builder
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Boostify_Demo_Preview_Builder' ) ) {
	/**
	 * Main Boostify Demo Preview Builder
	 *
	 * @class Boostify_Demo_Preview_Builder
	 *
	 * Written by pcd
	 */
	class Boostify_Demo_Preview_Builder {
		private static $instance; //phpcs:ignore

		/**
		 * Instance
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Boostify Demo Preview Builder Constructor.
		 */
		public function __construct() {
			$this->includes();
			$this->hooks();
			$this->cpt();
		}

		/**
		 * Includes
		 */
		public function includes() {
			include_once BOOSTIFY_DEMO_PREVIEW_PATH . 'inc/admin/class-admin.php';
			include_once BOOSTIFY_DEMO_PREVIEW_PATH . 'inc/admin/class-metabox.php';
			include_once BOOSTIFY_DEMO_PREVIEW_PATH . 'inc/class-template.php';
			include_once BOOSTIFY_DEMO_PREVIEW_PATH . 'inc/helper.php';
			include_once BOOSTIFY_DEMO_PREVIEW_PATH . 'inc/elementor/class-elementor.php';
			include_once BOOSTIFY_DEMO_PREVIEW_PATH . 'inc/elementor/class-template-dp-render.php';
		}

		/**
		 * Hook
		 */
		public function hooks() {
			add_action( 'init', array( $this, 'post_types' ) );
			add_action( 'plugins_loaded', array( $this, 'init' ) );
			add_action( 'body_class', array( $this, 'body_ver' ) );
			add_action( 'elementor/controls/controls_registered', array( $this, 'modify_controls' ), 10, 1 );
			add_action( 'elementor/editor/wp_head', array( $this, 'enqueue_icon' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'style' ), 99 );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_icon' ), 99 );
			add_action( 'admin_notices', array( $this, 'notice_plugin' ) );
			add_action( 'admin_notices', array( $this, 'notice_theme_support' ) );
			add_action( 'wp_footer', 'bosstify_demo_preview' );
		}

		/**
		 * Custom post type
		 */
		public function cpt() {
			add_post_type_support( 'btfdp_builder', 'elementor' );
		}

		/**
		 * Body Version
		 *
		 * @param string $classes type.
		 */
		public function body_ver( $classes ) {
			$classes[] = 'boostify-demo-preview-' . BOOSTIFY_DEMO_PREVIEW_VER;

			return $classes;
		}

		/**
		 * Post types
		 */
		public function post_types() {
			register_post_type(
				'btfdp_builder',
				array(
					'supports'     => array( 'title', 'page-attributes' ),
					'hierarchical' => true,
					'rewrite'      => array( 'slug' => 'btfdp_builder' ),
					'has_archive'  => false,
					'public'       => true,
					'labels'       => array(
						'name'          => esc_html__( 'Boostify Demo Preview Builder', 'boostify' ),
						'add_new_item'  => esc_html__( 'Add New Demo Preview', 'boostify' ),
						'edit_item'     => esc_html__( 'Edit Demo Preview', 'boostify' ),
						'all_items'     => esc_html__( 'All Demo Preview', 'boostify' ),
						'singular_name' => esc_html__( 'Elementor Builder', 'boostify' ),
					),
					'menu_icon'    => 'dashicons-visibility',
				)
			);
		}

		/**
		 * Init
		 */
		public function init() {
			new Boostify_Demo_Preview\Metabox();
			new Boostify_Demo_Preview\Template_Sg_Render();
		}

		/**
		 * Test
		 *
		 * @param string $value type.
		 */
		public function test( $value = '' ) {
			new Boostify_Demo_Preview\Theme_Support();
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
		 * Add ionicons
		 */
		public function enqueue_icon() {
			wp_enqueue_style(
				'ionicons',
				BOOSTIFY_DEMO_PREVIEW_URL . '/assets/css/ionicons.css',
				array(),
				BOOSTIFY_DEMO_PREVIEW_VER
			);
		}

		/**
		 * Style
		 */
		public function style() {
			// FontAweSome 5 Free.
			wp_enqueue_style(
				'fontawesome-5-free',
				BOOSTIFY_DEMO_PREVIEW_URL . 'assets/css/fontawesome/fontawesome.css',
				array(),
				BOOSTIFY_DEMO_PREVIEW_VER
			);

			// Style.
			wp_enqueue_style(
				'boostify-dp-style',
				BOOSTIFY_DEMO_PREVIEW_URL . 'assets/css/style.css',
				array(),
				BOOSTIFY_DEMO_PREVIEW_VER
			);
		}

		/**
		 * Notice when do not install or active Elementor.
		 */
		public function notice_plugin() {
			if ( ! defined( 'ELEMENTOR_VERSION' ) || ! is_callable( 'Elementor\Plugin::instance' ) ) {

				if ( file_exists( WP_PLUGIN_DIR . '/elementor/elementor.php' ) ) {
					$url = network_admin_url() . 'plugins.php?s=elementor';
				} else {
					$url = network_admin_url() . 'plugin-install.php?s=elementor';
				}

				echo '<div class="notice notice-error">';
				/* Translators: URL to install or activate Elementor plugin. */
				echo '<p>' . sprintf( __( 'The <strong>Demo Preview Elementor</strong> plugin requires <strong><a href="%s">Elementor</strong></a> plugin installed & activated.', 'demo-preview-elementor' ) . '</p>', $url );// phpcs:ignore
				echo '</div>';
			}
		}

		/**
		 * Notice when do not theme Support
		 */
		public function notice_theme_support() {
			if ( ! current_theme_supports( 'boostify-demo-preview' ) ) {
				?>
				<div class="notice notice-error">
					<p><?php echo esc_html__( 'Your current theme is not supported Boostify Demo Preview Plugin', 'boostify' ); ?></p>
				</div>
				<?php
			}
		}
	}

	Boostify_Demo_Preview_Builder::instance();
}
