<?php
/*
* Custom Home Page
*/

//* Hook after post widget area after post content
add_action( 'genesis_before_content', 'ft_featured_header' );
	function ft_featured_header() {

		$featured_query_args = array(
			'post_type'  => 'post',
		  'meta_key'   => '_is_ns_featured_post',
		  'meta_value' => 'yes',
		);
		$featured = new WP_Query( $featured_query_args );

		global $wp_query;
		$temp_query = $wp_query;
		$wp_query   = NULL;
		$wp_query   = $featured;

		if ( $featured->have_posts() ) {

			?>

			<div class="featured-header widget-area">

			  <!-- the loop -->
			  <?php while ( $featured->have_posts() ) : $featured->the_post(); ?>
					<?php

					$featured_video = get_the_post_video_url();
					$post_video = $featured_video;
					// $post_video = https://vimeo.com/example

					if (strpos($post_video, 'vimeo.com') !== FALSE) {

						$x = explode('/', $post_video);
						// $x = ['https:', 'vimeo.com', 'example']

						$video_id = array_pop($x);
						// $video_id = 'example'

						$player_url = '//player.vimeo.com/video/' . $video_id . '?autoplay=1&color=FFF';
						// $player_url = '//player.vimeo.com/video/example'
						// echo "Player URL: " . $player_url;

					}

					?>
					<article <?php post_class(); ?>>
						<a class="featured-header-link" data-featherlight="iframe" href="<?= $player_url ?>">
							<div class="play-button"></div>
							<div class="img-wrap">
							<?php echo get_the_post_thumbnail($post, 'large'); ?>
							</div>
						</a>
						<div class="entry-content">
							<?php the_content(); ?>
						</div>
					</article>
			  <?php endwhile; ?>
				<!-- end of the loop -->

			</div>

			<?php
		}
		else {
			echo "no content";
		}


		// Reset postdata
		wp_reset_postdata();
		// Reset main query object
		$wp_query = NULL;
		$wp_query = $temp_query;


		// echo 'testingblah' . $featured_video;
		// echo get_metadata('page', 51, 'fvp_video', true);






		}


//

		// if ( $featured ) {
		// 	genesis_widget_area( 'featured-header', array(
		// 		'before' => '<div class="featured-header widget-area">' . '<a class="featured-header" data-featherlight="iframe" href="' . $player_url . '"><div class="play-button"></div></a>',
		// 		'after' => '</div>'
		// 	) );
		//
		// }


/* Display Featured Image on top of the post and add play button*/
// add_action( 'genesis_before_loop', 'ft_featured_post_video', 8 );
// function ft_featured_post_video() {

// }


genesis();
?>
