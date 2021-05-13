<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fastest
 */

?>

<!doctype html>
<html <?php language_attributes(); ?> class="no-js no-svg" <?php fastest_html_tag_schema(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'fastest' ); ?></a>
	<?php if ( get_header_image() ) : ?>
		<?php if ( is_home() && is_front_page() ) : ?>

			<div class="hero">
				<?php
					$fastest_custom_header_width  = get_custom_header()->width;
					$fastest_custom_header_height = get_custom_header()->height;
				?>
				<img src="<?php header_image(); ?>" width="<?php echo esc_attr( $fastest_custom_header_width ); ?>" height="<?php echo esc_attr( $fastest_custom_header_height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">

				<?php if ( is_active_sidebar( 'home-hero' ) ) : ?>
				<?php
				if ( is_front_page() && is_home() ) {
					dynamic_sidebar( 'home-hero' );
				}
				?>
				<?php endif; ?>
			</div>

		<?php endif; ?>
	<?php endif; ?>
	<?php if ( is_home() && is_front_page() && has_custom_header() ) : ?>
		<header id="masthead" class="site-header custom-active topmost nav-down" itemscope itemtype="https://schema.org/WPHeader">
	<?php else : ?>
		<header id="masthead" class="site-header topmost nav-down" itemscope itemtype="https://schema.org/WPHeader">
	<?php endif ?>
		<div class="wrap">
			<div class="site-branding">
				<?php
					$fastest_logo_control = get_theme_mod( 'custom_logo' );
					$fastest_logo         = wp_get_attachment_image_src( $fastest_logo_control, 'full' );
					$fastest_site_title   = get_bloginfo( 'name' );
					$fastest_site_url     = home_url();

				if ( is_front_page() && is_home() ) {
					if ( has_custom_logo() ) {
						echo '<a class="logo-is-here" href="' . esc_url( $fastest_site_url ) . '" rel="home"><img src="' . esc_url( $fastest_logo[0] ) . '"></a>';
					} elseif ( display_header_text() === false ) {
						echo '<h1 class="site-title-hidden"><a href="' . esc_url( $fastest_site_url ) . '" rel="home"> ' . esc_html( $fastest_site_title ) . ' </a></h1>';
					} else {
						echo '<h1 class="site-title"><a href="' . esc_url( $fastest_site_url ) . '" rel="home"> ' . esc_html( $fastest_site_title ) . ' </a></h1>';
					}
				} else {

					if ( has_custom_logo() ) {
						echo '<a href="' . esc_url( $fastest_site_url ) . '" rel="home"><img src="' . esc_url( $fastest_logo[0] ) . '"></a>';
					} elseif ( display_header_text() === false ) {
						echo '<h1 class="site-title-hidden"><a href="' . esc_url( $fastest_site_url ) . '" rel="home"> ' . esc_html( $fastest_site_title ) . ' </a></h1>';
					} else {
						echo '<p class="site-title"><a href="' . esc_url( $fastest_site_url ) . '" rel="home"> ' . esc_html( $fastest_site_title ) . ' </a></p>';
					}
				}
				?>
				<?php
					$fastest_description = get_bloginfo( 'description', 'display' );
				if ( display_header_text() === true ) {
					echo '<p class="site-description">' . esc_html( $fastest_description ) . '</p>';
				} else {
					echo '<p class="site-description-hidden">' . esc_html( $fastest_description ) . '</p>';
				}
				?>

			</div><!-- .site-branding -->

			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'fastest' ); ?></button>

			<nav id="site-navigation" class="main-navigation" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
			<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary-menu',
						'menu_id'        => 'primary-menu',
						'container'      => '',
						'link_before'    => '<span itemprop="name">',
						'link_after'     => '</span>',
						'items_wrap'     => '
					<ul id="%1$s" class="%2$s">%3$s</ul>',
					)
				);
			?>
			</nav>

		</div>
	</header><!-- #masthead -->
	<div id="content" class="site-content">
		<div class="wrap">

		<?php if ( is_active_sidebar( 'home-featured' ) ) : ?>
			<?php
			if ( is_front_page() || is_home() ) {
				dynamic_sidebar( 'home-featured' );
			}
			?>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'home-advert' ) ) : ?>
			<?php
			if ( is_front_page() || is_home() ) {
				dynamic_sidebar( 'home-advert' );
			}
			?>
		<?php endif;
