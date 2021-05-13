<?php
/**

 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Fastest
 */

if ( ! function_exists( 'fastest_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function fastest_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time itemprop="datePublished" class="entry-date published" datetime="%1$s">%2$s</time><time itemprop="dateModified" class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'On %s', 'post date', 'fastest' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'fastest' ),
			'<span class="author vcard" itemprop="author" itemscope itemtype="http://schema.org/Person">
				<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" itemprop="url" rel="author">
					<span itemprop="name">' . esc_html( get_the_author() ) . '</span>
				</a>
			</span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'fastest_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function fastest_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'fastest' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Topics %1$s', 'fastest' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'fastest' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'tags %1$s', 'fastest' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'fastest' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}
	}
endif;



/**
 * Custom Comments template
 */
if ( ! function_exists( 'fastest_comment_form' ) ) {

	/**
	 * Custom comment form for Fastest theme
	 */
	function fastest_comment_form( $comment, $args, $depth ) {
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>" style="position:relative;" itemscope itemtype="http://schema.org/UserComments">
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment->comment_author_email, 80 ); ?>
					<div class="comment-metadata">
						<?php printf( '<span class="fn" itemprop="creator" itemscope itemtype="http://schema.org/Person">%s</span>', get_comment_author_link() ); ?>
						<time><?php comment_date( get_option( 'date_format' ) ); ?></time>
						<span class="comment-meta">
							<?php edit_comment_link( __( '(Edit)', 'fastest' ), '  ', '' ); ?>
						</span>
					</div>
				</div>
				<?php if ( $comment->comment_approved === '0' ) : ?>
					<em><?php esc_html_e( 'Your comment is awaiting moderation.', 'fastest' ); ?></em>
					<br />
				<?php endif; ?>
				<div class="commentmetadata" itemprop="commentText">
					<?php comment_text(); ?>
					<span class="reply">
						<?php
						comment_reply_link(
							array_merge(
								$args, array(
									'depth'     => $depth,
									'max_depth' => $args['max_depth'],
								)
							)
						);
?>
					</span>
				</div>
			</div>
	<?php
	}
}


if ( ! function_exists( 'fastest_primary_category' ) ) {
	function fastest_primary_category() {

		$first_category = get_the_category_list( esc_html__( ', ', 'fastest' ) );

		echo esc_attr( $first_category );
	}
}


if ( ! function_exists( 'fastest_meta_date' ) ) :
	/**
	 * Displays the post date
	 */
	function fastest_meta_date() {

		$time_string = sprintf(
			'<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date published updated" datetime="%3$s">%4$s</time></a>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

		return '<span class="meta-date">' . $time_string . '</span>';

	}
endif;

if ( ! function_exists( 'fastest_meta_author' ) ) :
	/**
	 * Displays the post author
	 */
	function fastest_meta_author() {

		$author_string = sprintf(
			'<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( esc_html( 'View all posts by %s', 'fastest' ), get_the_author() ) ),
			esc_html( get_the_author() )
		);

		return '<span class="meta-author">By ' . $author_string . '</span>';

	}
endif;

if ( ! function_exists( 'fastest_more_link' ) ) :
	/**
	 * Displays the more link on posts
	 */
	function fastest_more_link() {
		?>

		<a href="<?php echo esc_url( get_permalink() ); ?>" class="more-link"><?php esc_html_e( 'Read more', 'fastest' ); ?></a>

		<?php
	}
endif;
