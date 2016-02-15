<?php

//* Set up Discover page's carousel of partner post types
function ft_partner_post_carousel() {
    // Set up your arguments array to include your post type,
    // order, posts per page, etc.

    $args = array(
        'post_type' => 'partner',
        'posts_per_page' => 100,
        'orderby' => 'meta_value=ft_org_state',
        'order' => 'ASC'
    );

    // Get the posts from Partner post types
    $partners = get_posts($args);

    // Build the carousel outer structure
    $output = '';
    $output .= '<div class="owl-carousel">';

    // Loop through all of the results
    foreach ($partners as $partner)
    {

    	// Get partner organization name
    	$name = get_the_title($partner);
    	$desc = rwmb_meta( 'ft_org_desc', '', $partner->ID );
    	$url  = rwmb_meta( 'ft_org_url', '', $partner->ID );
    	$logo_url = rwmb_meta( 'ft_org_image', '', $partner->ID );

    	$args = 'type=image';
    	$uploaded_logos = rwmb_meta( 'ft_org_plupload_image', $args , $partner->ID );

    	// Get the featured image
    	// $logo_id = get_post_thumbnail_id($partner->ID);
    	// $logo_array = wp_get_attachment_image_src($logo_id, 'large', true);
    	// $logo = $logo_array[0];

    	// Get the partner organization's state
    	$state = rwmb_meta( 'ft_org_state', '', $partner->ID );


     	// If the item has a logo, set that as the background image,
     	// otherwise, just make a div.item
        $output .= '<div class="item ' . $state . '">';

        if ($uploaded_logos) {
        	$output .= '<div class="has-logo" style="background:url(';
        	
        	// Returns the first item in the array
        	$logo = reset($uploaded_logos);

        	$output .= $logo['full_url'];
        	$output .= ')"> </div>';
        } elseif ($logo_url) {
        	$output .= '<div class="has-logo" style="background:url(';
        	$output .= $logo_url;
        	$output .= ')"> </div>';
        }
        
        // Add an overlay div, to darken on hover with the name of the 
        // partner organization.
        if ($url) {
        	$output .= '<a class="item-link" href="' . $url . '" target="blank">';
        }
        $output .= '<div class="item-overlay">';
        $output .= '<h4>' . $name . '</h4>';
        $output .= '<h5>' . $desc . '</h5>';
        $output .='</div>';
        if ($url) {
        	$output .='</a>';
        }


        // Get org's Twitter colors
        $color = rwmb_meta('ft_org_color', '', $partner->ID);
        // Add a colorful flag with the name of the partner org's state.
        if ($state) {
        $output .= '<div class="state"><div class="state-triangle" style="background-color:';
        // $output .= $color;
        $output .= '"></div><div class="state-name">' . $state . '</div></div>';
    	}

        // Close item
        $output .= '</div>';
        

        // End foreach
    }

    // Close carousel structure
    $output .= '</div><div class="owl-carousel-copy hide"></div>';

    
    // Return output
    return $output;
}



?>