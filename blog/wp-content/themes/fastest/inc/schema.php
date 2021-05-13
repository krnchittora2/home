<?php
/**
 * Schema markup engine for Fastest Theme
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Fastest
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * This function handles the schema markup
 */
function fastest_html_tag_schema() {
	$schema = 'http://schema.org/';

	// Is author page.
	if ( is_author() ) {
		$type = 'ProfilePage';
	} // Is search results page.
	elseif ( is_search() ) {
		$type = 'SearchResultsPage';
	} else {
		$type = 'WebPage';
	}

	echo 'itemscope="itemscope" itemtype="' . esc_attr( $schema ) . esc_attr( $type ) . '"';
}
