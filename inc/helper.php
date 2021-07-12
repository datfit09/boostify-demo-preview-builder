<?php
/**
 * Helper check
 *
 * @package boostify-demo-preview-builder
 */

/**
 * Define Script debug.
 *
 * @return string $suffix
 */
function boostify_demo_preview_suffix() {
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	return $suffix;
}

if ( ! function_exists( 'boostify_img_alt' ) ) {
	/**
	 * SET IMAGE ALT
	 *
	 * @param  [type] $id  type.
	 * @param  string $alt type.
	 */
	function boostify_img_alt( $id = null, $alt = '' ) {
		$data    = get_post_meta( $id, '_wp_attachment_image_alt', true );
		$img_alt = ! empty( $data ) ? $data : $alt;

		return $img_alt;
	}
}

/**
 * Bosstify demo preview
 */
function boostify_demo_preview() {
	global $post;

	$args  = array(
		'post_type'      => 'btfdp_builder',
		'posts_per_page' => 1,
		'post_status'    => 'publish',
	);
	$query = new \WP_Query( $args );

	if ( ! $query->have_posts() ) {
		return;
	}

	while ( $query->have_posts() ) {
		$query->the_post();

		$demo_link   = get_post_meta( get_the_ID(), '_demo_link', true );
		$demo_number = get_post_meta( get_the_ID(), '_demo_number', true );

		if ( '' === $demo_link ) {
			$demo_link = '#';
		}
		?>
		<a class="buy-boostify" href="<?php echo esc_url( $demo_link ); ?>">
			<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewBox="0 0 415.441 415.441" fill="#81b441" xml:space="preserve">
				<path d="M324.63,22.533C135.173,226.428,80.309,371.638,80.309,371.638c41.149,47.743,111.28,43.72,111.28,43.72c73.921,2.31,119.192-43.522,119.192-43.522c91.861-92.516,80.549-355.302,80.549-355.302C372.769-23.891,324.63,22.533,324.63,22.533z"></path>
				<path d="M32.369,181.983c0,0-28.983,57.964,18.859,155.495L178.367,58.01C176.916,58.538,63.691,98.037,32.369,181.983z"></path>
			</svg>

			<span> <?php esc_html_e( 'Buy', 'boostify' ); ?> <strong> <?php echo esc_html( get_the_title() ); ?> </strong></span>
		</a>

		<div class="boostify-demo-preview-popup">
			<div class="boostify-show-demos-preview">
				<span class="boostify-text-demo">
					<?php esc_html_e( 'Demos', 'boostify' ); ?>

					<img src="<?php echo esc_url( BOOSTIFY_DEMO_PREVIEW_URL . 'assets/images/boostify.png' ); ?>" alt="<?php echo esc_attr( 'Boostify Logo' ); ?>" class="boostify-logo">
				</span>

				<span class="boostify-demo-count before">
					<?php echo esc_html( $demo_number ); ?>
				</span>

				<span class="boostify-demo-count after">
					<?php echo esc_html( $demo_number ); ?>
				</span>
			</div>


			<div class="cd-popup">
				<div class="cd-popup-container">
					<?php the_content(); ?>
				</div>
				<a href="#" class="cd-popup-close"></a>
			</div> <!-- cd-popup -->
		</div>
		<?php
	}

	wp_reset_postdata();
}
