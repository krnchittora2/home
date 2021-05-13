<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Fastest
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses fastest_header_style()
 */
function fastest_custom_header_setup() {
	add_theme_support(
		'custom-header', apply_filters(
			'fastest_custom_header_args', array(
				'default-image' => '',
				'width'         => 1980,
				'height'        => 250,
				'flex-height'   => true,
				'flex-width'    => true,
			)
		)
	);
}
add_action( 'after_setup_theme', 'fastest_custom_header_setup' );
