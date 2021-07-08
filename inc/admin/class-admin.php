<?php
/**
 * The Admin
 *
 * @package boostify-demo-preview-builder
 */

namespace Boostify_Demo_Preview;

defined( 'ABSPATH' ) || exit;

/**
 * Main Boostify Demo Preview Admin Class
 *
 * @class Boostify_Demo_Preview_Admin
 */
class Admin {
	private static $instance; //phpcs:ignore

	/**
	 * Instance description
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Boostify Demo Preview Admin Constructor.
	 */
	public function __construct() {
		$this->hooks();
	}

	/**
	 * Hooks
	 */
	public function hooks() {
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_style' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_wp_style' ) );
		add_filter( 'manage_btfdp_builder_posts_columns', array( $this, 'columns_head' ) );
		add_action( 'manage_btfdp_builder_posts_custom_column', array( $this, 'columns_content' ), 10, 2 );
	}

	/**
	 * Load_admin_style description
	 */
	public function load_admin_style() {
		wp_enqueue_style(
			'boostify-dp-admin',
			BOOSTIFY_DEMO_PREVIEW_URL . 'assets/css/admin/admin.css',
			array(),
			BOOSTIFY_DEMO_PREVIEW_VER
		);

		wp_enqueue_style(
			'ionicons',
			BOOSTIFY_DEMO_PREVIEW_URL . '/assets/css/ionicons.css',
			array(),
			BOOSTIFY_DEMO_PREVIEW_VER
		);
	}

	/**
	 * Load_wp_style description
	 */
	public function load_wp_style() {
		wp_enqueue_script(
			'boostify-dp-demo-preview',
			BOOSTIFY_DEMO_PREVIEW_URL . 'assets/js/demo-preview.min.js',
			array( 'jquery' ),
			BOOSTIFY_DEMO_PREVIEW_VER,
			true
		);
	}
	/**
	 * Columns_head description
	 *
	 * @param  string $columns type.
	 * @return string type.
	 */
	public function columns_head( $columns ) {
		$date_column = $columns['date'];

		unset( $columns['date'] );
		$columns['shortcode'] = __( 'Shortcode', 'boostify' );
		$columns['date']      = $date_column;

		return $columns;
	}

	/**
	 * SHOW THE FEATURED IMAGE
	 *
	 * @param string $column_name type.
	 * @param string $post_id type.
	 */
	public function columns_content( $column_name, $post_id ) {
		$type = get_post_meta( $post_id, 'bdp_type', true );
		switch ( $column_name ) {
			case 'shortcode':
				ob_start();
				?>
				<span class="bdp-shortcode-col-wrap">
					<input type="text" readonly="readonly" value="[bdp id='<?php echo esc_attr( $post_id ); ?>']" class="bdp-large-text code">
				</span>

				<?php

				ob_get_contents();
				break;
		}
	}
}

Admin::instance();

