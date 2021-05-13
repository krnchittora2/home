<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fastest
 */

?>
	</div><!-- .wrap -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="wrap">
			<div class="site-info">
				<div class="left">
					<?php
						esc_html_e( 'Copyright &copy;&nbsp;', 'fastest' );
						echo bloginfo();
					?>
				</div>
				<div class="right">
					<p>
						<?php
							/* translators: 1: Theme name, 2: Theme author. */
							printf( esc_html__( '%1$s', 'fastest' ), '<a href="' . esc_url( __( 'https://wpvkp.com/fastest-wordpress-theme/', 'fastest' ) ) . '" target="_blank" rel="nofollow noreferrer">Fastest</a> Theme by WPVKP' );
						?>
					</p>
				</div>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
