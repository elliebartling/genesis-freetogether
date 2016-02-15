<?php
/**
* Template Name: Pages template
* Description: Default template for all pages
*/

add_action( 'wp_enqueue_scripts', 'ft_enqueue_page_styles' );
function ft_enqueue_page_styles() {
	wp_enqueue_style( 'pages-styles', get_stylesheet_directory_uri() . '/css/pages.css', array(), CHILD_THEME_VERSION);
}

remove_action('genesis_after_entry' , 'ft_preview_next_post');
//* Remove the entry title (requires HTML5 theme support)
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action('genesis_entry_footer', 'ft_take_action_button' );

genesis();
?>