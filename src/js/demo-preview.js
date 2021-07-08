/**
 * Demo Preview js
 *
 * @package boostify-demo-preview
 */

'use strict';

// Size guide.
function boostifyDemoPreview() {
	var demoPreview = jQuery( '.boostify-demo-preview-popup' ),
		popUp       = jQuery( '.cd-popup' ),
		button      = jQuery( '.boostify-show-demos-preview' );

	demoPreview.on(
		'click',
		function(e) {
			e.preventDefault();
			demoPreview.toggleClass( 'is-visible' );
		}
	);

	demoPreview.click(
		function() {
			if ( demoPreview.hasClass( 'is-visible' ) ) {
				button.addClass( 'boostify-demos-open' );
			} else {
				button.removeClass( 'boostify-demos-open' );
			}
		}
	);

	// close popup when clicking the esc keyboard button.
	jQuery( document ).keyup(
		function( event ) {
			if ( event.which == '27' ) {
				jQuery( '.cd-popup' ).removeClass( 'is-visible' );
			}
		}
	);
};

jQuery( document ).ready(
	function(){
		// For frontend.
		jQuery( window ).on(
			'load',
			function() {
				boostifyDemoPreview();
			}
		);

		if ( undefined !== window.elementorFrontend && undefined !== window.elementorFrontend.hooks ) {
			boostifyDemoPreview();

			window.elementorFrontend.hooks.addAction(
				'frontend/element_ready/global',
				function() {
					boostifyDemoPreview();
				}
			);
		}
	}
);
