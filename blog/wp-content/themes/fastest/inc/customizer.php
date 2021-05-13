<?php
/**
 * Fastest Theme Customizer
 *
 * @package Fastest
 */
add_action( 'customize_register', 'fastest_customizer_changes' );

/**
 * Chaning the position of the options in customizer
 *
 * @param WPCustomize $wp_customize - Extending the WordPress customizer functionality.
 */
function fastest_customizer_changes( $wp_customize ) {

	// =============================================================
	// Making the changes to Name of Settings.
	// =============================================================
	$wp_customize->get_section( 'colors' )->priority       = 30;
	$wp_customize->get_section( 'header_image' )->priority = 20;

	$wp_customize->get_section( 'colors' )->title       = __( 'Manage Theme Colors', 'fastest' );
	$wp_customize->get_section( 'header_image' )->title = __( 'Featured Hero Image', 'fastest' );

}

/**
 * Initialize the customizer function
 */
function fastest_customizer( $wp_customize ) {

	// Homepage Numeric Pagination Support.
		$wp_customize->add_section(
			'fastest_customizer_global_settings',
			array(
				'title'    => esc_html__( 'Global Settings', 'fastest' ),
				'priority' => 50,
			)
		);

	// Single Post Control Section.
		$wp_customize->add_section(
			'fastest_customizer_single_post',
			array(
				'title'    => esc_html__( 'Single Post Settings', 'fastest' ),
				'priority' => 51,
			)
		);


	$wp_customize->add_section( 'fastest_customizer_featured' , array(
		'title'      => __('Featured Images on Posts?','fastest'),
		'priority'   => 30,
	) );

	$wp_customize->add_setting(
		'fastest_customizer_featured',
		array(
			'default'  => false,
			'sanitize_callback' => 'wp_strip_all_tags',

		)
	);
	$wp_customize->add_control(
		'fastest_customizer_featured', array(
			'type' => 'checkbox',
			'label'       => esc_html__( 'Add featured images on posts?', 'fastest' ),
			'section'     => 'fastest_customizer_featured',
			'settings'    => 'fastest_customizer_featured',
			'priority'    => 1,
		)
	);

	/**
	 * Radio box sanitization function.
	 */
	function fastest_sanitize_radio( $input, $setting ) {
		$input   = sanitize_key( $input );
		$choices = $setting->manager->get_control( $setting->id )->choices;
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}

	/**
	 * Hex color sanitization function.
	 */
	function fastest_sanitize_hex_color( $hex_color, $setting ) {
		// Sanitize $input as a hex value.
		$hex_color = sanitize_hex_color( $hex_color );

		// If $input is a valid hex value, return it; otherwise, return the default.
		return ( ! is_null( $hex_color ) ? $hex_color : $setting->default );
	}

	// Adding breadcrumb control setting.
		$wp_customize->add_setting(
			'fastest_customizer_breadcrumb',
			array(
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'default'           => '1',
				'sanitize_callback' => 'fastest_sanitize_radio',
			)
		);

		$wp_customize->add_control(
			'fastest_customizer_breadcrumb',
			array(
				'label'       => esc_html__( 'Show/Hide Breadcrumbs', 'fastest' ),
				'description' => sprintf( __( 'Enable or disable the breadcrumbs on single posts', 'fastest' ) ),
				'section'     => 'fastest_customizer_single_post',
				'type'        => 'radio',
				'choices'     => array(
					'1' => __( 'ON', 'fastest' ),
					'0' => __( 'OFF', 'fastest' ),
				),
			)
		);

	// Adding Numeric Pagination Control Setting.
		$wp_customize->add_setting(
			'fastest_customizer_number_pagination',
			array(
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'default'           => '0',
				'sanitize_callback' => 'fastest_sanitize_radio',
			)
		);

		$wp_customize->add_control(
			'fastest_customizer_number_pagination',
			array(
				'label'       => esc_html__( 'Enable Numeric Pagination', 'fastest' ),
				'description' => sprintf( __( 'Enable or disable Numeric Pagination', 'fastest' ) ),
				'section'     => 'fastest_customizer_global_settings',
				'type'        => 'radio',
				'choices'     => array(
					'1' => __( 'ON', 'fastest' ),
					'0' => __( 'OFF', 'fastest' ),
				),
			)
		);

	// Adding author bio control setting.
		// Adding Author Bio control setting.
		$wp_customize->add_setting(
			'fastest_customizer_authorbio',
			array(
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'default'           => '1',
				'sanitize_callback' => 'fastest_sanitize_radio',
			)
		);

		$wp_customize->add_control(
			'fastest_customizer_authorbio',
			array(
				'label'       => esc_html__( 'Show/Hide Author Bio', 'fastest' ),
				'description' => sprintf( __( 'Enable or disable author bio box on single posts', 'fastest' ) ),
				'section'     => 'fastest_customizer_single_post',
				'type'        => 'radio',
				'choices'     => array(
					'1' => __( 'ON', 'fastest' ),
					'0' => __( 'OFF', 'fastest' ),
				),
			)
		);

	// Color Definations Starting From Here.   ---------------------------------->
	// Only Color Related Settings Below Plz.  ---------------------------------->
		// Accent Color.
		$wp_customize->add_setting(
			'fastest_accent_color',
			array(
				'default'           => '#26519e',
				'sanitize_callback' => 'fastest_sanitize_hex_color',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'fastest_accent_color',
				array(
					'label'       => esc_html__( 'Accent Color', 'fastest' ),
					'description' => esc_html__( 'Control color of hyperlinks, buttons, on:focus elements.', 'fastest' ),
					'section'     => 'colors',
					'settings'    => 'fastest_accent_color',
					'priority'    => 1,
				)
			)
		);

		// Hero Text Color.
		$wp_customize->add_setting(
			'fastest_hero_text_color',
			array(
				'default'           => '#fff',
				'sanitize_callback' => 'fastest_sanitize_hex_color',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'fastest_hero_text_color',
				array(
					'label'       => esc_html__( 'Hero Image Text Color', 'fastest' ),
					'description' => esc_html__( 'Change the color of the text on the HERO image.', 'fastest' ),
					'section'     => 'colors',
					'settings'    => 'fastest_hero_text_color',
					'priority'    => 2,
				)
			)
		);

		// Header Background Color.
		$wp_customize->add_setting(
			'fastest_header_bg_color',
			array(
				'default'           => '#26519e',
				'sanitize_callback' => 'fastest_sanitize_hex_color',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'fastest_header_bg_color',
				array(
					'label'       => esc_html__( 'Header Background', 'fastest' ),
					'description' => esc_html__( 'Change the background color of Header.', 'fastest' ),
					'section'     => 'colors',
					'settings'    => 'fastest_header_bg_color',
					'priority'    => 3,
				)
			)
		);

		// Header Text Colors.
		$wp_customize->add_setting(
			'fastest_header_text_color',
			array(
				'default'           => '#ffffff',
				'sanitize_callback' => 'fastest_sanitize_hex_color',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'fastest_header_text_color',
				array(
					'label'       => esc_html__( 'Header Text Color', 'fastest' ),
					'description' => esc_html__( 'Change the color of Text on Header Area.', 'fastest' ),
					'section'     => 'colors',
					'settings'    => 'fastest_header_text_color',
					'priority'    => 4,
				)
			)
		);

		// Header Text on:hover Color.
		$wp_customize->add_setting(
			'fastest_header_text_hover_color',
			array(
				'default'           => '#dddddd',
				'sanitize_callback' => 'fastest_sanitize_hex_color',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'fastest_header_text_hover_color',
				array(
					'label'       => esc_html__( 'Header Text on:hover Color', 'fastest' ),
					'description' => esc_html__( 'Change the on:hover color of Text on Header Area.', 'fastest' ),
					'section'     => 'colors',
					'settings'    => 'fastest_header_text_hover_color',
					'priority'    => 5,
				)
			)
		);

		// Footer Background Color.
		$wp_customize->add_setting(
			'fastest_footerbg_color',
			array(
				'default'           => '#ececec',
				'sanitize_callback' => 'fastest_sanitize_hex_color',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'fastest_footerbg_color',
				array(
					'label'       => esc_html__( 'Footer Background Color', 'fastest' ),
					'description' => esc_html__( 'Change the color of the footer area.', 'fastest' ),
					'section'     => 'colors',
					'settings'    => 'fastest_footerbg_color',
					'priority'    => 6,
				)
			)
		);

		// Footer Background Color.
		$wp_customize->add_setting(
			'fastest_footertext_color',
			array(
				'default'           => '#404040',
				'sanitize_callback' => 'fastest_sanitize_hex_color',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'fastest_footertext_color',
				array(
					'label'       => esc_html__( 'Footer Text Color', 'fastest' ),
					'description' => esc_html__( 'Change the color of text in footer area.', 'fastest' ),
					'section'     => 'colors',
					'settings'    => 'fastest_footertext_color',
					'priority'    => 7,
				)
			)
		);

}
add_action( 'customize_register', 'fastest_customizer' );




add_action( 'wp_head', 'fastest_custom_css' );

/**
 * Output our custom Accent Color setting CSS Style
 */
function fastest_custom_css() {
	?>
	<style type="text/css">
		a, .entry-content a, a:hover, .entry-content a:hover, h2.entry-title a:hover, footer#colophon a:hover, h2.entry-title a:hover, .recentcomments a:hover { color: <?php echo esc_attr( get_theme_mod( 'fastest_accent_color', '#26519e' ) ); ?>; }

		.page-numbers.current, .comment-reply-link, .form-submit input, .nav-links span:hover, .nav-links a:hover { background-color:<?php echo esc_attr( get_theme_mod( 'fastest_accent_color' ) ); ?>; }

		h4.widgettitle {border-bottom: 2px solid <?php echo esc_attr( get_theme_mod( 'fastest_accent_color', '#26519e' ) ); ?> }

		.page-numbers.current, .nav-links span:hover, .nav-links a:hover, .nav-previous a:hover, .nav-next a:hover, .comment-reply-link:hover, .form-submit input:hover { border: 2px solid <?php echo esc_attr( get_theme_mod( 'fastest_accent_color', '#26519e' ) ); ?>; }

		.hero p, .hero h1, .hero h2, .hero h3, .hero h4, .hero h5, .hero h6 { color:<?php echo esc_attr( get_theme_mod( 'fastest_hero_text_color', '#fff' ) ); ?>; }

		.site-header, .main-navigation ul ul a { background-color:<?php echo esc_attr( get_theme_mod( 'fastest_header_bg_color', '#26519e' ) ); ?>; }

		.site-header a, .site-description, .main-navigation .desktop-dropdownsymbol { color:<?php echo esc_attr( get_theme_mod( 'fastest_header_text_color', '#fff' ) ); ?>; }

		.site-header a:hover, .main-navigation .desktop-dropdownsymbol:hover, .main-navigation li li a:hover { color:<?php echo esc_attr( get_theme_mod( 'fastest_header_text_hover_color', '#ddd' ) ); ?>; }

		footer#colophon { background-color:<?php echo esc_attr( get_theme_mod( 'fastest_footerbg_color', '#ececec' ) ); ?>; }

		footer#colophon a, footer#colophon { color:<?php echo esc_attr( get_theme_mod( 'fastest_footertext_color' ) ); ?>; }
	</style>
	<?php
}
