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
		button      = jQuery( '.boostify-show-demos-preview' ),
		close       = jQuery( '.cd-popup-close' );

	button.on(
		'click',
		function(e) {
			e.preventDefault();
			popUp.toggleClass( 'is-visible' );
		}
	);

	close.on(
		'click',
		function() {
			popUp.removeClass( 'is-visible' );
		}
	);

	// close popup when clicking the esc keyboard button.
	jQuery( document ).keyup(
		function( event ) {
			if ( event.which == '27' ) {
				popUp.removeClass( 'is-visible' );
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
