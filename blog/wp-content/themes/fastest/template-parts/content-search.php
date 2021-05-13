<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Fastest
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="https://schema.org/CreativeWork">
	<?php if ( ! is_single() && has_post_thumbnail( $post->ID ) ) : ?>
		<!-- Enclosure 1 if_condition -->
		<div class="entry-header-wrapper">
			<?php
				echo '<div class="home-thumb"><figure class="post-thumbnail"><a href=" ' . esc_url( get_permalink( $post->ID ) ) . '">';
				the_post_thumbnail( 'fastest-home-thumbnail' );
				echo '</a></figure></div>';
			?>
			<div class="home-content">
				<header class="entry-header notsingle">
					<?php the_title( '<h2 class="entry-title" itemprop="headline"><a href="' . esc_url( get_permalink( $post->ID ) ) . '" rel="bookmark">', '</a></h2>' ); ?>
					<?php if ( 'post' === get_post_type() ) : ?>
							<div class="entry-meta">
								<?php fastest_posted_on(); ?>
							</div><!-- .entry-meta -->
					<?php endif; ?>
				</header>

				<div class="entry-content" itemprop="text">
					<?php the_excerpt(); ?>
				</div><!-- .entry-content -->
			</div>
		</div>
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
