<?php
/**
 * Plugin Name: Boostify Demo Preview Builder
 * Plugin URI: https://boostifythemes.com
 * Description: Create Demo Preview for your site using Elementor Page Builder.
 * Version: 1.0.0
 * Author: Woostify
 * Author URI: https://woostify.com
 */

define( 'BOOSTIFY_DEMO_PREVIEW_PATH', plugin_dir_path( __FILE__ ) );
define( 'BOOSTIFY_DEMO_PREVIEW_URL', plugin_dir_url( __FILE__ ) );
define( 'BOOSTIFY_DEMO_PREVIEW_VER', '1.0.0' );

require_once BOOSTIFY_DEMO_PREVIEW_PATH . 'inc/class-boostify-demo-preview-builder.php';
