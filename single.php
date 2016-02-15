<?php
/**
* Template Name: Pages template
* Description: Default template for all pages
*/

add_action( 'wp_enqueue_scripts', 'ft_enqueue_page_styles' );
function ft_enqueue_page_styles() {
	wp_enqueue_style( 'pages-styles', get_stylesheet_directory_uri() . '/css/pages.css', array(), CHILD_THEME_VERSION);
}


genesis();
?>