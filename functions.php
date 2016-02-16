<?php
// This is the localhost server
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );
include('includes/partner-carousel.php');
include('includes/video-lightboxes/video-lightboxes.php');
include('includes/take-action-modal.php');
include('includes/social-media-footer.php');


//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'FreeTogether Theme' );
define( 'CHILD_THEME_URL', 'http://wwww.emergentorder.com' );
define( 'CHILD_THEME_VERSION', '2.0.0' );
define('STYLESHEET_URI', get_stylesheet_directory_uri() );


//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'ft_enqueue_styles' );
function ft_enqueue_styles() {
	// wp_enqueue_style( 'bootstrap-light', get_stylesheet_directory_uri() . '/css/bootstrap/bootstrap.css', array());
	wp_enqueue_style( 'main-style', get_stylesheet_directory_uri() . '/css/main.css', array(), CHILD_THEME_VERSION );
	wp_enqueue_script( 'main-js', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'), ' ', true );

}
add_action( 'admin_print_scripts-post-new.php', 'ft_admin_enqueue_scripts', 11 );
add_action( 'admin_print_scripts-post.php', 'ft_admin_enqueue_scripts', 11 );
function ft_admin_enqueue_scripts() {
	global $post_type;
	if ('partner' == $post_type) {
		wp_enqueue_script( 'twitter-API-js', get_stylesheet_directory_uri() . '/js/admin-twitter.js', array('jquery'), ' ', true );
		wp_enqueue_style( 'admin-styles', get_stylesheet_directory_uri() . '/css/admin-styles.css', array(), CHILD_THEME_VERSION );
		
	}
	if ('post' == $post_type) {
		wp_enqueue_script( 'tweet-counter-js', get_stylesheet_directory_uri() . '/js/admin-twitter-counter.js', array('jquery'), ' ', true );
	}
}


//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add Accessibility support
add_theme_support( 'genesis-accessibility', array( 'headings', 'drop-down-menu',  'search-form', 'skip-links', 'rems' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'footer-widgets','footer' ) );

/** Exclude "Featured" category from posts */
add_action( 'pre_get_posts', 'ft_exclude_category_from_home' );
function ft_exclude_category_from_home( $query ) {

	$featured = get_cat_id('featured');

    if( $query->is_main_query() && $query->is_home() ) {
        $query->set( 'cat', '-' .$featured );
    }
}
// Add support for post thumbnails
add_theme_support('post-thumbnails'); 

// Add Post Thumbnail Support
set_post_thumbnail_size(1500, 850, TRUE);

// if ( is_mobile() ) {
// // Add Post Thumbnail Support
// set_post_thumbnail_size(500, 500, TRUE);
// }

// Don't show admin bar
show_admin_bar(false);

//* Display a custom favicon
add_filter( 'genesis_pre_load_favicon', 'sp_favicon_filter' );
function sp_favicon_filter( $favicon_url ) {
	return get_stylesheet_directory_uri() . '/images/favicons/favicon.ico';
}


//* Register Featured content header area
genesis_register_sidebar( array(
	'id'            => 'featured-header',
	'name'          => __( 'Featured Header', 'freetogether' ),
	'description'   => __( 'This is a widget area for featuring a reel at the top of the page', 'freetogether' ),
) );

//* Register Take Action modal 
genesis_register_sidebar( array(
	'id'            => 'email-capture-modal',
	'name'          => __( 'Email Capture Modal', 'freetogether' ),
	'description'   => __( 'This is a widget area for the email capture popover', 'freetogether' ),
) );

//* Register Social Media Footer
genesis_register_sidebar( array(
	'id'            => 'social-media-footer',
	'name'          => __( 'Social Media Footer', 'freetogether' ),
	'description'   => __( 'This is a widget area for the social media footer', 'freetogether' ),
) );


//* Add "Person Name" meta box to the site

add_filter( 'rwmb_meta_boxes', 'ft_meta_boxes' );
function ft_meta_boxes( $meta_boxes ) {
    $meta_boxes[] = array(
        'title'      => __( 'About This Story', 'textdomain' ),
        'post_types' => 'post',
        'fields'     => array(
            array(
                'id'   => 'name',
                'name' => __( 'Full Name of Protagonist', 'textdomain' ),
                'type' => 'text',
            ),
            array(
                'id'   => 'twitter',
                'name' => __( 'Twitter Content', 'textdomain' ),
                'type' => 'text',
            ),
            // array(
            //     'id'   => 'facebook',
            //     'name' => __( 'Facebook Content', 'textdomain' ),
            //     'type' => 'textarea',
            // ),
            array(
                'id'   => 'email-content',
                'name' => __( 'Email Content', 'textdomain' ),
                'type' => 'textarea',
            ),
        ),
        'validation'  => array(
        	'rules'		=> array(
        		"twitter" => array(
        			'maxlength' => 116
        		)
        	)

        )
    );
    return $meta_boxes;
}


add_action( 'genesis_entry_header' , 'ft_show_story_name' );
function ft_show_story_name() {
	$name = rwmb_meta( 'name' );

	// Checks to make sure Name field isn't blank
	if ($name) {
		echo '<div class="entry-story-name">';
		echo $name;
		echo '\'s Story</div>';
	}
}




//* Add next and previous posts below Entry

add_action( 'genesis_after_entry' , 'ft_preview_next_post');
function ft_preview_next_post() {
	$currentPostID = get_the_ID();
	$prevPost = get_adjacent_post( false, '', true);
	$nextPost = get_adjacent_post( false, '', false);

	$exclude_ids = array($currentPostID, $prevPost->ID);


	// Get posts in a random order
	// Exclude previous post and this post from array
	$args = array(
		'posts_per_page' => 2,
		'exclude' => $exclude_ids,
		'category_name' => 'stories',
		'orderby' => 'rand' 
		);
	$posts_array = get_posts( $args );
	

	// Print the opening div structure for the posts
	echo '<div class="preview-navigation">';

	// Print the first two posts in that array
	foreach ($posts_array as $post) {
		$permalink = get_the_permalink($post->ID);
		?>
			<!-- SHOW A PREVIEW VIDEO -->
			<div class="preview-wrap">
				<div class="preview-video">
					<a class="video-thumbnail" href="<?php echo $permalink ?>">
						<?php
							echo get_the_post_thumbnail($post->ID, 'large');
						?>					
					<div class="play-button" ></div>
					</a>
				</div>

				<!-- SHOW A PREVIEW TITLE -->
				<div class="preview-meta">
					<div class="preview-title">
						<a href="<?php echo $permalink ?>" title="<?php the_title_attribute($post->ID); ?>"><?php echo get_the_title($post->ID); ?></a>
					</div>
					<div class="preview-story-name">
						<p><?php echo rwmb_meta( 'name', '', $post->ID ); ?>'s story</p>
					</div>
				</div>
			</div>

		<?php
	}

	// Print the closing div structure for the posts
	echo '</div>';	

}




//* Add Email Capture bar to bottom of each post
add_action('genesis_after_entry' , 'ft_email_capture_bar');
function ft_email_capture_bar() {
	?>
	<div class="email-capture-bar">
		<div class="email-capture-flag">
			<img src="<?php echo get_stylesheet_directory_uri() . '/images/logo-color.png' ?>">
		</div>
		<div class="email-capture-form">
			<div id="mc_embed_signup">
				<form action="//econstories.us7.list-manage.com/subscribe/post?u=3c416ed673b4f6e99320b1e76&amp;id=20afa62c9c" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					<div class="label">
						<label for="email">Learn more about stories in your state.</label>
					</div>
					<div class="form">
						<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
			            <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
						    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_3c416ed673b4f6e99320b1e76_20afa62c9c" tabindex="-1" value=""></div>
						  	<input type="submit" value="&#xf3d6;" name="subscribe" id="mc-embedded-subscribe" class="button">
			        </div>
		        </form>
		    </div>
	    </div>
	</div>


	<?php

}

//* Create Email Capture Shortcode

function ft_email_capture_box($cta) { 

	extract(shortcode_atts(array(
        "cta" => 'Learn More'
    ), $cta));

	?>
	<div class="email-capture-form featured-email-capture-form">
		<div id="mc_embed_signup">
			<form action="//econstories.us7.list-manage.com/subscribe/post?u=3c416ed673b4f6e99320b1e76&amp;id=20afa62c9c" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					
					<div class="label">
						<label for="email">Get notified of FreeTogether developments:</label>
					</div>
					<div class="form">
		            	<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
			            <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_3c416ed673b4f6e99320b1e76_20afa62c9c" tabindex="-1" value=""></div>
  	<input type="submit" value="&#xf3d6;" name="subscribe" id="mc-embedded-subscribe" class="button">
			        </div>
		        </form>
		    </div>
	</div>
	<?php 
}
add_shortcode('email_capture', 'ft_email_capture_box');

//* Actually do the shortcode within the widget area
add_filter('widget_text', 'do_shortcode');



//* Take Action button shortcode
function ft_take_action_button() {

	// Get post ID
	$post = get_the_ID();
	$fullName = rwmb_meta( 'name' );
	$allNames = explode(" ", $fullName);

	// If this is part of a post, get the first name of the Story Name field
	echo '<div class="take-action-cta">';
	if ($post) {
		echo '<div class="take-action-text">';
		echo 'Click here to learn more';
		if ($fullName) {
			echo ' about ';
			echo $allNames[0];
			echo '\'s story';
		}
		echo '.';
		echo '</div>';
	}
	// And echo text about this story with the button

	// And then echo the button
	echo '<button class="button take-action-button" data-toggle="modal" data-target="#takeAction">Take Action</button>';
	echo '</div>';



}
add_shortcode('take-action-button', 'ft_take_action_button');






add_action('genesis_entry_footer', 'ft_take_action_button' );



function add_menu_atts( $atts, $item, $args ) {
	$menu = wp_get_nav_menu_items( 'main' , '');

	$menu_item = array(23, 7, 109, 63);
	if (in_array($item->ID, $menu_item)) {
		$atts['data-toggle'] = 'modal';
		$atts['data-target'] = '#takeAction';
	}
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_menu_atts', 10, 3 );







//* Section shortcodes for Discover Page
function ft_discover_layout_shortcode( $atts, $content = null) {

	$output = '';
	$section_atts = shortcode_atts( array(
        'id' => 'ID',
        'title' => ''
    ), $atts );

	$output .= '<div class="section section-' . $section_atts['id'] . '">';
	if ($section_atts['title']) {
		$output .= '<div class="section-title"><span>' . $section_atts['title'] . '</span></div>';
	}
	$output .= do_shortcode( $content );
	$output .= '</div>';

	return $output;
}

add_shortcode('ft-section', 'ft_discover_layout_shortcode');

//* Section shortcodes for Discover Page
function ft_column_layout_shortcode( $atts, $content = null) {

    $output = '';
    $column_atts = shortcode_atts( array(
       'class' => ''
   ), $atts );

    $output .= '<div class="column ' . $column_atts['class'] . '">';
    $output .= do_shortcode( $content );
    $output .= '</div>';

    return $output;
}

add_shortcode('column', 'ft_column_layout_shortcode');

//* Column-wrapper shortcodes for Discover Page
function ft_column_wrapper_shortcode( $atts, $content = null) {

    $output = '';
    $column_atts = shortcode_atts( array(
       'class' => ''
   ), $atts );

    $output .= '<div class="column-wrapper ' . $column_atts['class'] . '">';
    $output .= do_shortcode( $content );
    $output .= '</div>';

    return $output;
}

add_shortcode('column-wrapper', 'ft_column_wrapper_shortcode');


//* Create Partner organizations post type
add_action( 'init', 'register_cpt_partner' );

function register_cpt_partner() {

	$labels = array(
		'name' => __( 'Partners', 'partner' ),
		'singular_name' => __( 'Partner', 'partner' ),
		'add_new' => __( 'Add New', 'partner' ),
		'add_new_item' => __( 'Add New Partner', 'partner' ),
		'edit_item' => __( 'Edit', 'partner' ),
		'new_item' => __( 'New Partner', 'partner' ),
		'view_item' => __( 'View Partner', 'partner' ),
		'search_items' => __( 'Search Partners', 'partner' ),
		'not_found' => __( 'No partners found', 'partner' ),
		'not_found_in_trash' => __( 'No partners found in Trash', 'partner' ),
		'parent_item_colon' => __( 'Parent Partner:', 'partner' ),
		'menu_name' => __( 'Partners', 'partner' ),
	);

	$args = array(
		'labels' => $labels,
		'hierarchical' => false,
		'description' => 'FreeTogether partner organizations, for the Discover page',
		'supports' => array( 'title', 'excerpt', 'thumbnail' ),
		'taxonomies' => array( 'post_tag' ),
		'public' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 20,
		'menu_icon' => 'dashicons-heart',
		'show_in_nav_menus' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => true,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => true,
		'capability_type' => 'post'
	);

	register_post_type( 'partner', $args );
}


add_filter( 'rwmb_meta_boxes', 'ft_partner_orgs_custom_fields' );
function ft_partner_orgs_custom_fields( $meta_boxes_orgs ) {
	$prefix = 'ft_org_';
    $meta_boxes_orgs[] = array(

        'title'      => __( 'Partner Organization Details', "{$prefix}" ),
        'post_types' => 'partner',
        'fields'     => array(
			array(
				'name'        => __( 'Organization State', "{$prefix}" ),
				'id'          => $prefix . 'state',
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => array(
					'AL' => __( 'AL', "{$prefix}" ),
					'AK' => __( 'AK', "{$prefix}" ),
					'AZ' => __( 'AZ', "{$prefix}" ),
					'AR' => __( 'AR', "{$prefix}" ),
					'CA' => __( 'CA', "{$prefix}" ),
					'CO' => __( 'CO', "{$prefix}" ),
					'CT' => __( 'CT', "{$prefix}" ),
					'DE' => __( 'DE', "{$prefix}" ),
					'DC' => __( 'DC', "{$prefix}" ),
					'FL' => __( 'FL', "{$prefix}" ),
					'GA' => __( 'GA', "{$prefix}" ),
					'HI' => __( 'HI', "{$prefix}" ),

					'ID' => __( 'ID', "{$prefix}" ),
					'IL' => __( 'IL', "{$prefix}" ),
					'IN' => __( 'IN', "{$prefix}" ),
					'IA' => __( 'IA', "{$prefix}" ),
					'KS' => __( 'KS', "{$prefix}" ),
					'KY' => __( 'KY', "{$prefix}" ),
					'LA' => __( 'LA', "{$prefix}" ),
					'ME' => __( 'ME', "{$prefix}" ),
					'MD' => __( 'MD', "{$prefix}" ),

					'MA' => __( 'MA', "{$prefix}" ),
					'MI' => __( 'MI', "{$prefix}" ),
					'MN' => __( 'MN', "{$prefix}" ),
					'MS' => __( 'MS', "{$prefix}" ),
					'MO' => __( 'MO', "{$prefix}" ),
					'MT' => __( 'MT', "{$prefix}" ),
					'NE' => __( 'NE', "{$prefix}" ),
					'NV' => __( 'NV', "{$prefix}" ),
					'NH' => __( 'NH', "{$prefix}" ),

					'NJ' => __( 'NJ', "{$prefix}" ),
					'NM' => __( 'NM', "{$prefix}" ),
					'NY' => __( 'NY', "{$prefix}" ),
					'NC' => __( 'NC', "{$prefix}" ),
					'ND' => __( 'ND', "{$prefix}" ),
					'OH' => __( 'OH', "{$prefix}" ),
					'OK' => __( 'OK', "{$prefix}" ),
					'OR' => __( 'OR', "{$prefix}" ),
					'PA' => __( 'PA', "{$prefix}" ),

					'RI' => __( 'RI', "{$prefix}" ),
					'SC' => __( 'SC', "{$prefix}" ),
					'SD' => __( 'SD', "{$prefix}" ),
					'TN' => __( 'TN', "{$prefix}" ),
					'TX' => __( 'TX', "{$prefix}" ),
					'UT' => __( 'UT', "{$prefix}" ),
					'VT' => __( 'VT', "{$prefix}" ),
					'VA' => __( 'VA', "{$prefix}" ),
					'WA' => __( 'WA', "{$prefix}" ),

					'WV' => __( 'WV', "{$prefix}" ),
					'WI' => __( 'WI', "{$prefix}" ),
					'WY' => __( 'WY', "{$prefix}" ),
					
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'placeholder' => __( 'Select a State', "{$prefix}" ),
			),
            array(
                'id'   => $prefix . 'desc',
                'name' => __( 'Short Description', "{$prefix}" ),
                'type' => 'textarea',
            ),
            array(
                'id'   => $prefix . 'url',
                'name' => __( 'Org Website URL', "{$prefix}" ),
                'type' => 'text',
            ),
            // OEMBED
			array(
				'name' => __( 'Social Logo', 'your-prefix' ),
				'id'   => "{$prefix}image",
				'desc' => __( 'If possible, we pulled a logo from this organization\'s Twitter profile. If this is correct, you don\'t need to do anything else. If you\'d rather use a different logo, you can upload one below.' , '{$prefix}' ),
				'type' => 'text',
			),
            // DRAG & DROP IMAGE UPLOAD
			array(
				'name' => __( 'Organization Logo', "{$prefix}" ),
				'id'   => $prefix . 'plupload_image',
				'type' => 'plupload_image',
			),
			// THICKBOX IMAGE UPLOAD (WP 3.3+)
			array(
				'name' => __( 'Thickbox Image Upload', 'your-prefix' ),
				'id'   => "{$prefix}thickbox",
				'type' => 'thickbox_image',
			),
			// COLOR PICKER
			array(
				'name' => __( 'Color picker', "{$prefix}" ),
				'id'   => "{$prefix}color",
				'type' => 'color',
			),
        ),
    );
    return $meta_boxes_orgs;
}


function ft_be_zipcode_filter() {
	$args = 'type=select';
	// $all_states = rwmb_meta('', $args);

	$selectbox = '<li class="init" id="initLabel">Select Your State<span class="fa fa-angle-down"></span></li><div class="zipcode-input-wrap closed"><ul class="zipcode" id="zipcodeInput">';

	$selectbox .='
<li class="dropdown-item filter" data-filter="all">All States</li>
		<li class="dropdown-item filter" data-filter=".AL">Alabama</li>
		<li class="dropdown-item filter" data-filter=".AK">Alaska</li>
		<li class="dropdown-item filter" data-filter=".AZ">Arizona</li>
		<li class="dropdown-item filter" data-filter=".AR">Arkansas</li>
		<li class="dropdown-item filter" data-filter=".CA">California</li>
		<li class="dropdown-item filter" data-filter=".CO">Colorado</li>
		<li class="dropdown-item filter" data-filter=".CT">Connecticut</li>
		<li class="dropdown-item filter" data-filter=".DE">Delaware</li>
		<li class="dropdown-item filter" data-filter=".DC">District of Columbia</li>
		<li class="dropdown-item filter" data-filter=".FL">Florida</li>
		<li class="dropdown-item filter" data-filter=".GA">Georgia</li>
		<li class="dropdown-item filter" data-filter=".HI">Hawaii</li>
		<li class="dropdown-item filter" data-filter=".ID">Idaho</li>
		<li class="dropdown-item filter" data-filter=".IL">Illinois</li>
		<li class="dropdown-item filter" data-filter=".IN">Indiana</li>
		<li class="dropdown-item filter" data-filter=".IA">Iowa</li>
		<li class="dropdown-item filter" data-filter=".KS">Kansas</li>
		<li class="dropdown-item filter" data-filter=".KY">Kentucky</li>
		<li class="dropdown-item filter" data-filter=".LA">Louisiana</li>
		<li class="dropdown-item filter" data-filter=".ME">Maine</li>
		<li class="dropdown-item filter" data-filter=".MD">Maryland</li>
		<li class="dropdown-item filter" data-filter=".MA">Massachusetts</li>
		<li class="dropdown-item filter" data-filter=".MI">Michigan</li>
		<li class="dropdown-item filter" data-filter=".MN">Minnesota</li>
		<li class="dropdown-item filter" data-filter=".MS">Mississippi</li>
		<li class="dropdown-item filter" data-filter=".MO">Missouri</li>
		<li class="dropdown-item filter" data-filter=".MT">Montana</li>
		<li class="dropdown-item filter" data-filter=".NE">Nebraska</li>
		<li class="dropdown-item filter" data-filter=".NV">Nevada</li>
		<li class="dropdown-item filter" data-filter=".NH">New Hampshire</li>
		<li class="dropdown-item filter" data-filter=".NJ">New Jersey</li>
		<li class="dropdown-item filter" data-filter=".NM">New Mexico</li>
		<li class="dropdown-item filter" data-filter=".NY">New York</li>
		<li class="dropdown-item filter" data-filter=".NC">North Carolina</li>
		<li class="dropdown-item filter" data-filter=".ND">North Dakota</li>
		<li class="dropdown-item filter" data-filter=".OH">Ohio</li>
		<li class="dropdown-item filter" data-filter=".OK">Oklahoma</li>
		<li class="dropdown-item filter" data-filter=".OR">Oregon</li>
		<li class="dropdown-item filter" data-filter=".PA">Pennsylvania</li>
		<li class="dropdown-item filter" data-filter=".RI">Rhode Island</li>
		<li class="dropdown-item filter" data-filter=".SC">South Carolina</li>
		<li class="dropdown-item filter" data-filter=".SD">South Dakota</li>
		<li class="dropdown-item filter" data-filter=".TN">Tennessee</li>
		<li class="dropdown-item filter" data-filter=".TX">Texas</li>
		<li class="dropdown-item filter" data-filter=".UT">Utah</li>
		<li class="dropdown-item filter" data-filter=".VT">Vermont</li>
		<li class="dropdown-item filter" data-filter=".VA">Virginia</li>
		<li class="dropdown-item filter" data-filter=".WA">Washington</li>
		<li class="dropdown-item filter" data-filter=".WV">West Virginia</li>
		<li class="dropdown-item filter" data-filter=".WI">Wisconsin</li>
		<li class="dropdown-item filter" data-filter=".WY">Wyoming</li>
	</ul></div>';

	$output .= '<div class="zipcodeField freetogether-form"><form method="post"  accept-charset="UTF-8" class="grid">';
    $output .= '<div class="label"><label for="zip">Filter Partner Organizations by Your State:</label></div>';
    $output .= $selectbox;
    // $output .= '<input class="zipcode" id="zipcodeInput" name="zip" placeholder="Your State" type="text" required="">';
    // $output .= '<button class="button" id="zipcodeFilter"><h3><span style="float:right" class="ion-ios-arrow-thin-right"></span></h3></button>';
    $output .= '</form></div>';

    return $output;
}

add_shortcode('zipcode_filter','ft_be_zipcode_filter');

add_shortcode('partners_carousel','ft_partner_post_carousel');




add_filter( 'rwmb_meta_boxes', 'ft_partner_orgs_social_media' );
function ft_partner_orgs_social_media( $meta_boxes_orgs_social ) {
$prefix = 'ft_org_';
    $meta_boxes_orgs_social[] = array(
    	'id' 		 => 'partner_org_social',
        'title'      => __( 'Partner Organization Social Media', "{$prefix}" ),
        'post_types' => 'partner',
        'autosave'	 => true,
        'fields'     => array(
            array(
                'id'   => $prefix . 'twitter',
                'name' => __( 'Twitter', "{$prefix}" ),
                'desc' => 'Do *NOT* include the \'@\' symbol.',
                'type' => 'text',
            ),
            array(
                'id'   => $prefix . 'button',
                'name' => '',
                'type' => 'button',
                // 'attributes' => array(
                // 	'style' => 'background-color: red;'
                // ),
            ),
        ),
    );
    return $meta_boxes_orgs_social;
}

do_action('rwmb_after_save_post', 'ft_partner_orgs_twitter_call');
function ft_partner_orgs_twitter_call() {
	$twitter_name = rwmb_meta('ft_org_twitter');

	$partner = ft_get_single_partner_twitter($twitter_name);
	echo $partner;
	echo $partners['name'];

	// rwmb_meta('ft_org_desc') = $partner['name'];

}


function ft_be_floating_social_media_icons() {
	if (! is_page_template('discover-template.php')) {
		$post = get_the_ID();
		$permalink = get_the_permalink($post);
		$postlink = urlencode($permalink);
		$twitter = 'http://www.twitter.com/intent/tweet?text=' . urlencode(rwmb_meta('twitter', '', $post)) . '&url=' . $postlink;
		$facebook = 'https://www.facebook.com/sharer/sharer.php?u=' . $postlink;
		$email = 'mailto:?&body=' . rawurlencode(rwmb_meta('email-content', '', $post)) . '%0A%0A' . $postlink;

		$output = '<div class="post-social">';
			$output .= '<div class="icons-wrap">';
				$output .= '<a class="social social-js facebook" href="' . $facebook . '"><span class="fa fa-facebook"></span></a>';
				$output .= '<a target="_blank" class="social social-js twitter" href="' . $twitter . '"><span class="fa fa-twitter"></span></a>';
				$output .= '<a class="social email" href="' . $email . '"><span class="ion-paper-airplane"></span></a>';
			$output .= '</div>';
		$output .= '</div>';

		echo $output;
	}
}
add_action('genesis_before_entry_content', 'ft_be_floating_social_media_icons');













