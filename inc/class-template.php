<?php
/**
 * Class Template
 *
 * @package boostify-demo-preview-builder
 */

namespace Boostify_Demo_Preview;

/**
 * Comments
 *
 * Handle comments (reviews and order notes).
 *
 * @package boostify-demo-preview-builder
 *
 * Written by pcd
 */

defined( 'ABSPATH' ) || exit;

/**
 * Boostify Demo Preview Template Class.
 */
class Template {

	private static $instance; //phpcs:ignore

	/**
	 * Post ID
	 *
	 * @var int
	 */
	public $post_id;

	/**
	 * Post type
	 *
	 * @var String
	 */
	public $post_type;

	/**
	 *  Initiator
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Hook in methods.
	 */
	public function __construct() {
		add_action( 'wp_head', array( $this, 'wp_head' ) );
		add_filter( 'single_template', array( $this, 'single_template' ) );
	}

	/**
	 * Single template
	 *
	 * @param string $single_template type.
	 */
	public function single_template( $single_template ) {
		if ( 'btfdp_builder' == get_post_type() ) { // phpcs:ignore
			$single_template = BOOSTIFY_DEMO_PREVIEW_PATH . 'templates/dp.php';
		}
		return $single_template;
	}

	/**
	 * Wp head
	 */
	public function wp_head() {
		wp_reset_postdata();
	}
}

Template::instance();

