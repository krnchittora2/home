<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Fastest
 */

?>

<?php
	$fastest_customizer_authorbio  = get_theme_mod( 'fastest_customizer_authorbio', '1' );
	$fastest_customizer_breadcrumb = get_theme_mod( 'fastest_customizer_breadcrumb', '1' );
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
					<?php
					the_excerpt();

						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'fastest' ),
								'after'  => '</div>',
							)
						);
					?>
				</div><!-- .entry-content -->
			</div>
		</div>

	<?php else : ?>
	<!-- Enclosure 1 else_condition -->

		<header class="entry-header">

			<?php if ( $fastest_customizer_breadcrumb === '1' ) { ?>
				<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#"><?php fastest_breadcrumb(); ?></div>
			<?php } ?>

			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
				if (get_theme_mod("fastest_customizer_featured")):
					?>
                    <div class="featured_post_image">
						<?php the_post_thumbnail(); ?>
                    </div>
				<?php
				endif;
			else :
				the_title( '<h2 class="entry-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php fastest_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</header>

		<div class="entry-content" itemprop="text">
			<?php
			if ( is_single() ) :
					the_content();
			else :
					the_excerpt();
			endif;
					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'fastest' ),
							'after'  => '</div>',
						)
					);
			?>
		</div><!-- .entry-content -->

	<?php endif; ?>
	<!-- Enclosure 1 ends here -->
	<?php if ( is_single() ) : ?>
		<footer class="entry-footer">
			<?php fastest_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
<?php if ( is_single() && $fastest_customizer_authorbio === '1' ) : ?>
	<div class="media author-box">
		<div class="media-figure">
			<?php echo get_avatar( get_the_author_meta( 'email' ), '100' ); ?>
		</div>
		<div class="media-body">
			<h4><?php the_author_posts_link(); ?></h4>
			<p><?php echo wpautop( get_the_author_meta( 'description' ) ); ?></p>
		</div>
	</div>
<?php endif;
