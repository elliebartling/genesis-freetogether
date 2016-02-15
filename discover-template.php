<?php
/**
* Template Name: Discover Template
* Description: Layout & Formatting used ONLY for the Discover page
*/

add_action( 'wp_enqueue_scripts', 'ft_enqueue_discover_styles' );
function ft_enqueue_discover_styles() {
	wp_enqueue_style( 'discover-page', get_stylesheet_directory_uri() . '/css/discover.css', array(), CHILD_THEME_VERSION);
	// wp_enqueue_style( 'owl', get_stylesheet_directory_uri() . '/css/owl/owl.carousel.css', array());

	wp_enqueue_script( 'discover-js', get_stylesheet_directory_uri() . '/js/discover.js', array('jquery'), ' ', true );
	// wp_enqueue_script( 'owl-init', get_stylesheet_directory_uri() . '/js/owl-init.js', array('jquery'), ' ', true );
	// wp_enqueue_script( 'mixitup', 'http://cdn.jsdelivr.net/jquery.mixitup/latest/jquery.mixitup.min.js', array('jquery'), ' ', true );
	
	// wp_enqueue_script( 'zip-filter', get_stylesheet_directory_uri() . '/js/zip-filter.js', array('jquery', 'mixitup'), ' ', true );
}

remove_action('genesis_after_entry' , 'ft_preview_next_post');
//* Remove the entry title (requires HTML5 theme support)
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action('genesis_entry_footer', 'ft_take_action_button' );





genesis();