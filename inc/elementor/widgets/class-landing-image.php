<?php
/**
 * Widget Elementor Landing Image
 *
 * @package boostify-demo-preview-builder
 */

namespace Boostify_Demo_Preview\Widgets;

use Boostify_Demo_Preview\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Landing image widget.
 *
 * Widget that displays an landing image for landing page.
 *
 * @since 1.0.0
 */
class Landing_Image extends Base_Widget {
	/**
	 * Get widget name.
	 *
	 * Retrieve landing image widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ht-dp-landing-image';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve landing image widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Landing Image', 'boostify' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve landing image widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-image-rollover';
	}

	/**
	 * Register category box widget controls.
	 *
	 * Add different input fields to allow the user to change and customize the widget settings
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() { //phpcs:ignore
		$this->start_controls_section(
			'section_landing',
			array(
				'label' => esc_html__( 'Landing Image', 'boostify' ),
			)
		);

		$this->add_control(
			'image',
			array(
				'label'   => esc_html__( 'Choose Image', 'boostify' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => array(
					'active' => true,
				),
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_control(
			'title_text',
			array(
				'label'       => esc_html__( 'Title Text', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => esc_html__( 'This is the heading', 'boostify' ),
				'placeholder' => esc_html__( 'Enter your text title', 'boostify' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Link to', 'boostify' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => array(
					'active' => true,
				),
				'placeholder' => esc_html__( 'https://your-link.com', 'boostify' ),
				'separator'   => 'before',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			array(
				'label' => esc_html__( 'Content', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_style',
			array(
				'label'     => esc_html__( 'Title', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .boostify-landing-image-title',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render landing image widget output on the front end.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$image     = $settings['image'];
		$image_url = $image['url'];
		$image_alt = boostify_img_alt( $image['id'], esc_attr__( 'Landing Image', 'boostify' ) );

		$href = '#';
		$attr = '';

		if ( ! empty( $settings['link']['url'] ) ) {
			$href = $settings['link']['url'];

			if ( 'on' === $settings['link']['is_external'] ) {
				$attr .= ' target="_blank"';
			}

			if ( 'on' === $settings['link']['nofollow'] ) {
				$attr .= ' rel="nofollow"';
			}
		}
		?>
		<div class="boostify-landing-image">
			<div class="card">
				<div class="card__image">
					<a href="<?php echo esc_url( $href ); ?>" <?php echo wp_kses_post( $attr ); ?> class="boostify-landing-image-link">
						<span class="boostify-landing-image-text"><?php echo esc_html__( 'View Demo', 'boostify' ); ?></span>
					</a>

					<img src="<?php echo esc_url( $image_url ); ?>" alt="image" />
				</div>
			</div>

			<div class="boostify-landing-image-content">
				<h3 class="boostify-landing-image-title">
					<a href="<?php echo esc_url( $href ); ?>" <?php echo wp_kses_post( $attr ); ?>><?php echo esc_html( $settings['title_text'] ); ?></a>
				</h3>
			</div>
		</div><!-- .boostify-landing-image -->
		<?php
	}
}
