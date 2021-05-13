<?php
/**
 * Custom Featured Grid Post Widget for Fastest Theme
 *
 * @package Fastest
 */
/**
 * Registering the widget
 */


function fastest_homepage_featured_post_widget() {
	register_widget( 'Fastest_Featured_Post_Widget' );
}
add_action( 'widgets_init', 'fastest_homepage_featured_post_widget' );

/**
 * Creating the widget
 */
class Fastest_Featured_Post_Widget extends WP_Widget {
	/**
	 * Defining the constructor
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'header_post_grid',
			'description' => __( 'Place this widget in Home Featured Section for best professional look', 'fastest' ),
		);
		parent::__construct( 'fastest-homepage-header', __( 'Grid Featured Post', 'fastest' ), $widget_ops );
	}
	/**
	 * Defining the argumenets for widget
	 * $args - Loads the widget values on admin - widget area
	 */
	public function widget( $args, $instance ) {
		global $fastest_large_img;
		global $fastest_small_img;
		extract( $args );
		$title     = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$category  = isset( $instance['category'] ) ? $instance['category'] : '';
		$tags      = empty( $instance['tags'] ) ? '' : $instance['tags'];
		$postcount = empty( $instance['postcount'] ) ? '5' : $instance['postcount'];
		$offset    = empty( $instance['offset'] ) ? '' : $instance['offset'];
		$sticky    = isset( $instance['sticky'] ) ? $instance['sticky'] : 0;

		if ( $category ) {
			$cat_url      = get_category_link( $category );
			$before_title = $before_title . '<a href="' . esc_url( $cat_url ) . '" class="widget-title-link">';
			$after_title  = '</a>' . $after_title;
		}

		echo $before_widget;
		if ( ! empty( $title ) ) {
			echo $before_title . esc_html( $title ) . $after_title;
		}
	?>
		<?php
		$args      = array(
			'posts_per_page'      => $postcount,
			'offset'              => $offset,
			'cat'                 => $category,
			'tag'                 => $tags,
			'ignore_sticky_posts' => $sticky,
		);
		$counter   = 1;
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) :

			$count           = 0;
			$remaining_posts = '';
			while ( $the_query->have_posts() ) :
				$the_query->the_post();

				$post_id = get_the_ID();

				$img_src = '';
				if ( has_post_thumbnail( $post_id ) ) {
					$large_featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'fastest-trending-posts-large' );
					$small_featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'fastest-trending-posts-small' );
					$fastest_large_img    = $large_featured_image[0];
					$fastest_small_img    = $small_featured_image[0];
				}
				if ( ! has_post_thumbnail( $post_id ) ) {
					$fastest_large_img = get_template_directory_uri() . '/assets/image/placeholder.png';
					$fastest_small_img = get_template_directory_uri() . '/assets/image/placeholder.png';
				}
				$post_permalink  = get_the_permalink();
				$post_title      = get_the_title();
				$post_date       = get_the_date( 'M d, Y' );
				$post_categories = wp_get_post_categories( $post_id );
				$cat_html        = '';
				if ( ! empty( $post_categories ) ) {
					foreach ( $post_categories as $post_category ) {
						$cat       = get_category( $post_category );
						$cat_html .= '<li class="cat"><a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . $cat->name . '</a></li>';
					}
				}

				if ( $count === 0 ) {

					$first_grid_post = '
			<div class="vkp-featured-content large col-sm-6 col-xs-6">
				<a class="vkp-featured-overlay" href="' . esc_url( $post_permalink ) . '"></a>
					<div class="vkp-featured-data">
						<div class="vkp-featured-it">
							<img src="' . esc_url( $fastest_large_img ) . '">
							<div class="vkp-featured-title">
								<h2>
									<a href="' . esc_url( $post_permalink ) . '">' . esc_html( $post_title ) . '</a>
								</h2>
							</div>
						</div>
					</div>
			</div>';
				} // count==0

				else {

					$remaining_posts .= '<div class="vkp-featured-content small col-sm-6 col-xs-6">
					<a class="vkp-featured-overlay" href="' . esc_url( $post_permalink ) . '"></a>
					<div class="vkp-featured-data">
						<div class="vkp-featured-it">
							<img src="' . esc_url( $fastest_small_img ) . '">
							<div class="vkp-featured-title">
								<h2>
									<a href="' . esc_url( $post_permalink ) . '">' . esc_html( $post_title ) . '</a>
								</h2>
							</div>
						</div>
					</div>
				</div>';
				}

				$count++;
	endwhile;
			wp_reset_postdata();
?>
			<?php echo $first_grid_post; ?>
			<div class="col-sm-6">
				<div class="row">
					<?php echo $remaining_posts; ?>
				</div>
			</div>
		<?php endif; ?>
		<?php
		echo $after_widget;
	}
	/**
	 *  Form control to update user input values.
	 */
	function update( $new_instance, $old_instance ) {
		$instance              = $old_instance;
		$instance['title']     = sanitize_text_field( $new_instance['title'] );
		$instance['category']  = absint( $new_instance['category'] );
		$instance['postcount'] = absint( $new_instance['postcount'] );
		$instance['offset']    = absint( $new_instance['offset'] );
		$instance['tags']      = sanitize_text_field( $new_instance['tags'] );
		$instance['sticky']    = isset( $new_instance['sticky'] ) ? strip_tags( $new_instance['sticky'] ) : '';
		return $instance;
	}
	/**
	 *  Form control to save user input values.
	 */
	function form( $instance ) {
		$defaults = array(
			'title'    => '',
			'category' => '',
			'tags'     => '',
			'sticky'   => 0,
			'offset'   => 0,
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'fastest' ); ?></label>
			<input class="widefat" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Select a Category:', 'fastest' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>">
				<option value="0"
				<?php
				if ( ! $instance['category'] ) {
					echo 'selected="selected"';}
?>
><?php esc_html_e( 'All', 'fastest' ); ?></option>
				<?php
				$categories = get_categories( array( 'type' => 'post' ) );
				foreach ( $categories as $cat ) {
					echo '<option value="' . esc_attr( $cat->cat_ID ) . '"';
					if ( $cat->cat_ID === $instance['category'] ) {
						echo ' selected="selected"'; }
					echo '>' . esc_html( $cat->cat_name ) . ' (' . esc_html( $cat->category_count ) . ')';
					echo '</option>';
				}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'tags' ) ); ?>"><?php esc_html_e( 'Filter Posts by Tags (e.g. blogging):', 'fastest' ); ?></label>
			<input class="widefat" type="text" value="<?php echo esc_attr( $instance['tags'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tags' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'tags' ) ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"><?php esc_html_e( 'Skip:', 'fastest' ); ?></label>
			<input type="text" size="2" value="<?php echo esc_attr( $instance['offset'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" /> <?php esc_html_e( 'Posts', 'fastest' ); ?>
		</p>
		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'sticky' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sticky' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $instance['sticky'] ); ?>/>
			<label for="<?php echo esc_attr( $this->get_field_id( 'sticky' ) ); ?>"><?php esc_html_e( 'Ignore Sticky Posts', 'fastest' ); ?></label>
		</p>
		<?php
	}
}
