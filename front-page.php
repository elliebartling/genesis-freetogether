<?php
/*
* Custom Home Page
*/

//* Hook after post widget area after post content
add_action( 'genesis_before_content', 'ft_featured_header' );
	function ft_featured_header() {
		$featured = get_pages('category_name=Featured');
		$featured_video = get_the_post_video_url($featured->ID);
		// echo 'testingblah' . $featured_video;
		// echo get_metadata('page', 51, 'fvp_video', true);

		$post_video = $featured_video;
		// $post_video = https://vimeo.com/example

		if (strpos($post_video, 'vimeo.com') !== FALSE) {
			
			$x = explode('/', $post_video);
			// $x = ['https:', 'vimeo.com', 'example']

			$video_id = array_pop($x);
			// $video_id = 'example'

			// **** MAGIC NUMBER ****
			// Hack fix for the time being to display the correct video
			// Right now, Featured Video Plus is pulling from *posts* not pages
			// Fix before handoff.
			$video_id = '155747456';


			$player_url = '//player.vimeo.com/video/' . $video_id . '?autoplay=1&color=FFF';
			// $player_url = '//player.vimeo.com/video/example'




		} 


//

		if ( $featured ) {
			genesis_widget_area( 'featured-header', array(
				'before' => '<div class="featured-header widget-area">' . '<a class="featured-header" data-featherlight="iframe" href="' . $player_url . '"><div class="play-button"></div></a>',
				'after' => '</div>'
			) );

		}

}


/* Display Featured Image on top of the post and add play button*/
// add_action( 'genesis_before_loop', 'ft_featured_post_video', 8 );
// function ft_featured_post_video() {

// }


genesis();
?>