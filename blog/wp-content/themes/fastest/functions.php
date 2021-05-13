<?php
/**
 * Fastest functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Fastest
 */

?>
<?php
if ( ! function_exists( 'fastest_setup' ) ) :
	/**
	 * Fastest WordPress theme basic functions
	 */
	function fastest_setup() {

		// Loading Language Package.
		load_theme_textdomain( 'fastest', get_template_directory() . '/languages' );

		// Add Thumbnail Support.
		add_image_size( 'fastest-home-thumbnail', 240, 220, true );
		add_image_size( 'fastest-recent-post-thumbnail', 80, 80, true );
		add_image_size( 'fastest-trending-posts-large', 620, 460, true );
		add_image_size( 'fastest-trending-posts-small', 295, 230, true );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Add title-tag support.
		add_theme_support( 'title-tag' );

		// Add thumbnail support.
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary-menu' => esc_html__( 'Primary', 'fastest' ),
			)
		);

		// Output HTML5 Markup.
		add_theme_support(
			'html5', array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background', apply_filters(
				'fastest_custom_background_args', array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for core custom logo.
		add_theme_support(
			'custom-logo', array(
				'height'      => 70,
				'width'       => 250,
				'flex-height' => true,
				'flex-width'  => true,
				'header-text' => array( 'site-title', 'site-description' ),
			)
		);
	}

endif;
add_action( 'after_setup_theme', 'fastest_setup' );




/**
 * Putting up the default content width.
 */
function fastest_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'fastest_content_width', 640 );
}
add_action( 'after_setup_theme', 'fastest_content_width', 0 );




/**
 * Register Widgets.
 */
function fastest_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'fastest' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'fastest' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'fastest_widgets_init' );




/**
 * Above Header -- Hero Banner.
 */
function fastest_homepage_hero_widget() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Hero Banner Section', 'fastest' ),
			'id'            => 'home-hero',
			'before_widget' => '<div class="hero-info">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="home-hero-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'fastest_homepage_hero_widget' );




/**
 * Below Header -- Features Post Widget Area.
 */
function fastest_homepage_featured_widget() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Home Featured Section', 'fastest' ),
			'id'            => 'home-featured',
			'before_widget' => '<div class="home-featured">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="home-featured-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'fastest_homepage_featured_widget' );




/**
 * Home Advertisement Section - Responsive Adsense.
 */
function fastest_homepage_advertisement_widget() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Home Advertisement', 'fastest' ),
			'id'            => 'home-advert',
			'before_widget' => '<div class="home-below-featured">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="home-below-featured-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'fastest_homepage_advertisement_widget' );




/**
 * Delist Default Recent Post Wudget.
 */
function fastest_custom_recent_post_widget() {
	unregister_widget( 'WP_Widget_Recent_Posts' );
}
add_action( 'widgets_init', 'fastest_custom_recent_post_widget', 11 );




/**
 * Enqueue scripts and styles.
 */
function fastest_scripts() {

	// Loading the main stylesheet.
	wp_enqueue_style( 'fastest-style', get_stylesheet_uri() );

	// Loading the font handpicked for minimal blogging.
	wp_enqueue_style( 'fastest-icons', get_stylesheet_directory_uri() . '/assets/css/fastest-icons.css' );

	// Custom made Sticky header script.
	wp_enqueue_script( 'fastest-sticky-header', get_stylesheet_directory_uri() . '/assets/js/stickyheader.js', array( 'jquery' ), '' );

	// Loading mobile responsive navigation script.
	wp_enqueue_script( 'fastest-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array( 'jquery' ), '20151215', true );

	// Loading skip link focus fix script.
	wp_enqueue_script( 'fastest-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '007', true );

	// Loading screen reader text.
	wp_localize_script(
		'fastest-navigation', 'fastest_ScreenReaderText', array(
			'expand'   => __( 'Expand child menu', 'fastest' ),
			'collapse' => __( 'Collapse child menu', 'fastest' ),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'fastest_scripts' );




/**
 * Loading Files From Other Folders In This Theme.
 */
// Start the Schema Markup Engine.
require get_template_directory() . '/inc/schema.php';

// Implement the Custom Header feature.
require get_template_directory() . '/inc/custom-header.php';


// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';


// Functions which enhance the theme by hooking into WordPress.
require get_template_directory() . '/inc/template-functions.php';


// Customizer additions.
require get_template_directory() . '/inc/customizer.php';


// Load Custom recent post widget.
require_once get_template_directory() . '/inc/class-fastest-recent-posts.php';


// Load Custom Grid Post Widget.
require get_template_directory() . '/inc/class-fastest-featured-post-widget.php';

// Load Custom Dashboard
//include get_template_directory() . '/inc/dashboard.php';


// Load Jetpack compatibility file.
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}



/**
 * Adding Schema Markup To Navigation Elements.
 *
 * @param Attrs $atts -- Holds the menu attributes from array.
 *
 * @param Item  $item -- Holds the menu item.
 *
 * @param Args  $args -- Holds the menu arguments.
 */
function fastest_add_menu_attributes( $atts, $item, $args ) {
	$atts['itemprop'] = 'url';
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'fastest_add_menu_attributes', 10, 3 );




/**
 * Changing excerpt lenght.
 *
 * @param Length $length -- Holds the string length.
 */
function fastest_excerpt_length( $length ) {
	if ( ! is_admin() ) {
		return 45;
	}
}
add_filter( 'excerpt_length', 'fastest_excerpt_length', 999 );




/**
 * Changing excerpt more.
 *
 * @param More $more -- Holds the Read More string.
 */
function fastest_excerpt_more( $more ) {
	global $post;
	if ( is_admin() ) {
		return $more; }
	return '&#46;&#46;&#46;';
}
add_filter( 'excerpt_more', 'fastest_excerpt_more' );




if ( ! function_exists( 'fastest_breadcrumb' ) ) {

	/**
	 * Loading Breadcrumb Navigation Support.
	 */
	function fastest_breadcrumb() {
		if ( is_front_page() || is_archive() || is_author() || is_tag() || is_post_type_archive() ) {
			return;
		}
		echo '<span class="home"><i class="fastest-icon icon-home"></i></span>';
		echo '<span typeof="v:Breadcrumb" class="root"><a rel="v:url" property="v:title" href="';
		echo esc_url( home_url() );
		echo '">' . esc_html( sprintf( __( 'Home', 'fastest' ) ) );
		echo '</a></span><span class="seperator">&#8250;</i></span>';
		if ( is_single() ) {
			$categories = get_the_category();
			if ( $categories ) {
				$level         = 0;
				$hierarchy_arr = array();
				foreach ( $categories as $cat ) {
					$anc       = get_ancestors( $cat->term_id, 'category' );
					$count_anc = count( $anc );
					if ( 0 < $count_anc && $level < $count_anc ) {
						$level         = $count_anc;
						$hierarchy_arr = array_reverse( $anc );
						array_push( $hierarchy_arr, $cat->term_id );
					}
				}
				if ( empty( $hierarchy_arr ) ) {
					$category = $categories[0];
					echo '<span typeof="v:Breadcrumb"><a href="' . esc_url( get_category_link( $category->term_id ) ) . '" rel="v:url" property="v:title">' . esc_html( $category->name ) . '</a></span><span class="seperator">&#8250;</span>';
				} else {
					foreach ( $hierarchy_arr as $cat_id ) {
						$category = get_term_by( 'id', $cat_id, 'category' );
						echo '<span typeof="v:Breadcrumb"><a href="' . esc_url( get_category_link( $category->term_id ) ) . '" rel="v:url" property="v:title">' . esc_html( $category->name ) . '</a></span><span class="seperator">&#8250;</i></span>';
					}
				}
			}
		} elseif ( is_page() ) {
			$parent_id = wp_get_post_parent_id( get_the_ID() );
			if ( $parent_id ) {
				$breadcrumbs = array();
				while ( $parent_id ) {
					$page          = get_page( $parent_id );
					$breadcrumbs[] = '<span typeof="v:Breadcrumb"><a href="' . esc_url( get_permalink( $page->ID ) ) . '" rel="v:url" property="v:title">' . esc_html( get_the_title( $page->ID ) ) . '</a></span><span><i class="fastest-icon icon-angle-double-right"></i></span>';
					$parent_id     = $page->post_parent;
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				foreach ( $breadcrumbs as $crumb ) {
					echo esc_attr( $crumb ); }
			}
			echo '<span><span>';
			the_title();
			echo '</span></span>';
		} elseif ( is_category() ) {
			global $fastest_wp_query;
			$cat_obj       = $fastest_wp_query->get_queried_object();
			$this_cat_id   = $cat_obj->term_id;
			$hierarchy_arr = get_ancestors( $this_cat_id, 'category' );
			if ( $hierarchy_arr ) {
				$hierarchy_arr = array_reverse( $hierarchy_arr );
				foreach ( $hierarchy_arr as $cat_id ) {
					$category = get_term_by( 'id', $cat_id, 'category' );
					echo '<span typeof="v:Breadcrumb"><a href="' . esc_url( get_category_link( $category->term_id ) ) . '" rel="v:url" property="v:title">' . esc_html( $category->name ) . '</a></span><span><i class="fastest-icon icon-angle-double-right"></i></span>';
				}
			}
			echo '<span><span>';
			single_cat_title();
			echo '</span></span>';
		} elseif ( is_author() ) {
			echo '<span><span>';
			if ( get_query_var( 'author_name' ) ) :
				$curauth = get_user_by( 'slug', get_query_var( 'author_name' ) );
			else :
				$curauth = get_userdata( get_query_var( 'author' ) );
			endif;
			echo esc_html( $curauth->nickname );
			echo '</span></span>';
		} elseif ( is_search() ) {
			echo '<span><span>';
			the_search_query();
			echo '</span></span>';
		} elseif ( is_tag() ) {
			echo '<span><span>';
			single_tag_title();
			echo '</span></span>';
		}
	}
}




/**
 * Cleaning the Archive Titles.
 * $title - This holds the actual title of archive and author page.
 *
 * @param Title $title -- Holds the Title of various archive pages.
 */
function fastest_archive_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'fastest_archive_title' );
