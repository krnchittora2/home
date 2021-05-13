/**
 * File stickyheader.js.
 *
 * Makes Header Super Sticky
 *
 * @package Fastest
 */

(function($) {

	// Hide Header on on scroll down.
	var didScroll;
	var lastScrollTop = 0;
	var delta         = 5;
	var navbarHeight  = $( 'header' ).outerHeight();

	$( window ).scroll(
		function(event){
			didScroll = true;
		}
	);

	setInterval(
		function() {
			if (didScroll) {
				hasScrolled();
				didScroll = false;
			}
		}, 250
	);

	function hasScrolled() {
		var st = $( this ).scrollTop();

		// Make sure they scroll more than delta.
		if (Math.abs( lastScrollTop - st ) <= delta) {
			return;
		}

		// If they scrolled down and are past the navbar, add class .nav-up.
		// This is necessary so you never see what is "behind" the navbar.
		if (st > lastScrollTop && st > navbarHeight) {
			// Scroll Down.
			$( 'header' ).removeClass( 'topmost nav-down' ).addClass( 'nav-up' );
			$( 'nav' ).removeClass( 'toggled-on' );
		} else {
			// Scroll Up.
			if (st + $( window ).height() < $( document ).height()) {
				$( 'header' ).removeClass( 'nav-up' ).addClass( 'nav-down' );
			}
		}

		lastScrollTop = st;
	}

	$( document ).scroll(
		function() {
			if ($( window ).scrollTop() === 0) {
				$( 'header' ).removeClass( 'nav-up' ).addClass( 'topmost nav-down' );
			}
		}
	);

}(jQuery));
