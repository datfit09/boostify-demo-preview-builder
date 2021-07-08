<?php
/**
 * The Meta Box
 *
 * @package boostify-demo-preview-builder
 */

namespace Boostify_Demo_Preview;

defined( 'ABSPATH' ) || exit;

/**
 * Main Boostify Demo Preview Metabox Class
 *
 * @class Boostify_Demo_Preview_Metabox
 */
class Metabox {

	/**
	 * Boostify Demo Preview Metabox Constructor.
	 */
	public function __construct() {
		$this->hooks();
	}

	/**
	 * Hook
	 */
	public function hooks() {
		add_action( 'add_meta_boxes', array( $this, 'setup_demo_preview_metabox' ) );
		add_action( 'save_post', array( $this, 'save_demo_preview_metabox' ) );
	}

	/**
	 * Type Builder
	 */
	public function type_builder() {
		$type = array(
			'demo_preview' => __( 'Demo Preview', 'boostify' ),
		);

		return $type;
	}

	/**
	 * Setup Metabox
	 */
	public function setup_demo_preview_metabox() {
		add_meta_box(
			'boostify_metabox_settings_demo_preview',
			__( 'Demo Preview Settings', 'boostify' ),
			array( $this, 'demo_preview_markup' ),
			'btfdp_builder',
			'side',
			'high'
		);
	}

	/**
	 * Metabox Markup
	 *
	 * @param  object $post Post object.
	 * @return void
	 */
	public function demo_preview_markup( $post ) {
		$types       = $this->type_builder();
		$demo_link   = get_post_meta( $post->ID, '_demo_link', true );
		$demo_number = get_post_meta( $post->ID, '_demo_number', true );
		wp_nonce_field( 'save_data', 'data_nonce' );
		?>
			<div class="form-meta-footer">
				<?php $this->dp_display( $post ); ?>
			</div>
		<?php
	}

	/**
	 * Metabox Save
	 *
	 * @param  number $post_id Post ID.
	 * @return void
	 */
	public function save_demo_preview_metabox( $post_id ) {
		if ( ! isset( $_POST['data_nonce'] ) ) {
			return;
		}
		$data_nonce = $_POST['data_nonce'];
		// Check if the nonce has not been assigned a value.
		if ( ! isset( $data_nonce ) ) {
			return $post_id;
		}
		// Check if the nonce value does not match.
		if ( ! wp_verify_nonce( $data_nonce, 'save_data' ) ) {
			return $post_id;
		}

		/* OK, it's safe for us to save the data now. */

		// Sanitize the user input.
		$demo_link   = sanitize_text_field( $_POST['demo_link'] );
		$demo_number = sanitize_text_field( $_POST['demo_number'] );

		// Update the meta field.
		update_post_meta( $post_id, '_demo_link', $demo_link );
		update_post_meta( $post_id, '_demo_number', $demo_number );

	}

	/**
	 * Demo Preview display
	 *
	 * @param string $post type.
	 */
	public function dp_display( $post ) {
		$demo_link   = get_post_meta( $post->ID, '_demo_link', true );
		$demo_number = get_post_meta( $post->ID, '_demo_number', true );
		wp_nonce_field( 'save_data', 'data_nonce' );
		?>
		<div class="input-wrapper">
			<div class="condition-group display--on">
				<div class="parent-item">
					<label for="demo_number"><?php echo esc_html__( 'Link Buy', 'boostify' ); ?></label>
					<input name="demo_link" type="text" id="demo_link" value="<?php echo esc_attr( $demo_link ); ?>" class="regular-text" placeholder="https://">
				</div>

				<div class="parent-item">
					<label for="demo_number"><?php echo esc_html__( 'Number Demo', 'boostify' ); ?></label>
					<input name="demo_number" type="text" id="demo_number" value="<?php echo esc_attr( $demo_number ); ?>" class="regular-text" placeholder="68">
				</div>
			</div>
		</div>
		<?php
	}
}

