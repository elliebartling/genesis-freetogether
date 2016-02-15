<?php
/**
* Template Name: Carousel Test Template
* Description: Layout & Formatting used ONLY for the Discover page
*/


// include('includes/partner-carousel.php');

add_action( 'wp_enqueue_scripts', 'ft_enqueue_discover_styles' );
function ft_enqueue_discover_styles() {
	wp_enqueue_style( 'discover-page', get_stylesheet_directory_uri() . '/css/discover.css', array(), CHILD_THEME_VERSION);
	wp_enqueue_style( 'owl', get_stylesheet_directory_uri() . '/css/owl/owl.carousel.css', array(), CHILD_THEME_VERSION);
	wp_enqueue_script( 'owl-js', get_stylesheet_directory_uri() . '/js/owl/owl.carousel.js', array('jquery'), ' ', true );
	wp_enqueue_script( 'owl-init', get_stylesheet_directory_uri() . '/js/owl-init.js', array('jquery'), ' ', true );
}

remove_action('genesis_after_entry' , 'ft_preview_next_post');
//* Remove the entry title (requires HTML5 theme support)
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action('genesis_entry_footer', 'ft_take_action_button' );




function ft_display_partners() {
	$users = ["AFF", "CatoInstitute", "TPPF"];

	$partners = ft_get_partner_twitter($users);
	foreach ($partners as $partner) {
		echo $partner['name'];
	// 	// Get the "normal" sized image
	// 	$img = $p['profile_image_url_https'];
	// 	$large_img = str_replace("_normal", "", $img);


	// 	echo '<img src="' . $large_img . '" >';
	// 	echo $p['name'];
	// 	echo $p['location'];
	// 	echo $p['description'];

	}
}

add_action('genesis_after_entry', 'ft_display_partners');

genesis();