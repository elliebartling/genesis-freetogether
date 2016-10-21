<?php
/*
Plugin Name: Video Lightboxes
Plugin URI:
Description: Click on featured images and open the corresponding video in a featherlight lightbox
Author: Ellen Marie Bartling
Author URI: http://wwww.emergentorder.com
Version: 1
License: GPL2
Text Domain: video-lightboxes
*/

// Define

define( 'VIDEO_LIGHTBOXES_PATH', get_stylesheet_directory_uri() . '/includes/video-lightboxes/' );
define( 'VIDEO_LIGHTBOXES_FIELD', '_video_lightboxes' );
define( 'VIDEO_LIGHTBOXES_VERSION', '1' );

function vl_enqueue_scripts() {
	// wp_enqueue_script( 'video-lightboxes-js', VIDEO_LIGHTBOXES_PATH . 'js/featherlight.min.js', '', false, true );
	// wp_enqueue_script( 'video-lightboxes-js', VIDEO_LIGHTBOXES_PATH . 'js/lightbox-init.js', '', false, true );
	wp_enqueue_script( 'video-lightboxes-js', get_stylesheet_directory_uri() . '/js/lightboxes.js' );

	// wp_enqueue_style( 'featherlight', VIDEO_LIGHTBOXES_PATH . 'js/featherlight.min.css' );
	// wp_enqueue_style( 'video-lightboxes-style', VIDEO_LIGHTBOXES_PATH . 'js/lightbox-css.css' );
}
add_action( 'wp_enqueue_scripts', 'vl_enqueue_scripts' );

//* Remove the post image (requires HTML5 theme support)
// remove_action( 'genesis_entry_content', 'genesis_do_post_image');

/* Display Featured Image on top of the post and add play button*/
add_action( 'genesis_before_entry', 'vl_featured_post_image', 8 );
function vl_featured_post_image() {

	$post_video = get_the_post_video_url( $post_id );
	// $post_video = https://vimeo.com/example

	if (strpos($post_video, 'vimeo.com') !== FALSE) {

		$x = explode('/', $post_video);
		// $x = ['https:', 'vimeo.com', 'example']

		$video_id = array_pop($x);
		// $video_id = 'example'

		$player_url = '//player.vimeo.com/video/' . $video_id . '?autoplay=1&color=FFF';
		// $player_url = '//player.vimeo.com/video/example'

	}

	echo '<div class="entry">';
	echo '<a class="video-thumbnail" href="';
	echo $player_url;
	echo '" data-featherlight="iframe">';
	echo '<div class="entry-thumbnail">';

    the_post_thumbnail('large' ); //you can use medium, large or a custom size
    echo '<div class="play-button"></div>';
    echo '</div>';
    echo '</a>';
    // echo get_the_post_video( $post_id );
    // echo '<iframe class="lightbox" src="' . get_the_post_video_url( $post_id ) . '" id="';
    // echo get_the_ID();
    // echo '" style="border:none;" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>';
    // echo '</div>';
}

add_action( 'genesis_after_entry', 'vl_entry_structural_wrap', 8 );
function vl_entry_structural_wrap() {
	echo '</div>';
}

add_image_size( 'header', 1600, 9999, TRUE );
