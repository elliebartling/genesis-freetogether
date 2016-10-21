<? php

//* Add Email Capture bar to bottom of each post
add_action('genesis_after_entry' , 'ft_email_capture_bar');
function ft_email_capture_bar() {
	?>
	<div class="email-capture-bar">
		<div class="email-capture-flag">
			<img src="<?php echo get_stylesheet_directory_uri() . '/images/logo-color.png' ?>">
		</div>
		<div class="email-capture-form">
			<form method="post" accept-charset="UTF-8" class="grid" _lpchecked="1">
				<input type="hidden" name="action" value="xoxco/custom/mailchimp">
				<input type="hidden" name="redirect" value="thanks">
				<div class="label">
					<label for="email">Learn more about stories in your state.</label>
				</div>
				<div class="form">
	            	<input class="email" name="email" placeholder="Your Email" type="text" required="">
		            <button class="button">
		                <h3 class="button-cta"><span class="ion-ios-arrow-thin-right"></span></h3>
		            </button>
		        </div>
	        </form>
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
		<form method="post" accept-charset="UTF-8" class="grid" _lpchecked="1">
				<input type="hidden" name="action" value="xoxco/custom/mailchimp">
				<input type="hidden" name="redirect" value="thanks">
				<div class="label">
					<label for="email">Get notified of FreeTogether developments:</label>
				</div>
				<div class="form">
	            	<input class="email" name="email" placeholder="Your Email" type="text" required="">
		            <button class="button">
		                <h3 class="button-cta"><span class="ion-ios-arrow-thin-right"></span></h3>
		            </button>
		        </div>
	        </form>
	</div>
	<?php 
}
add_shortcode('email_capture', 'ft_email_capture_box');

//* Actually do the shortcode within the widget area
add_filter('widget_text', 'do_shortcode');


//* Remove the site footer
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
//* Customize the site footer
add_action( 'genesis_after_entry', 'bg_custom_footer' );
function bg_custom_footer() { 
	$post = get_the_ID();
	$permalink = 'http://www.freetogether.org/';
	$postlink = urlencode($permalink);
	$twitter = 'http://www.twitter.com/intent/tweet?text=' . '&url=' . $postlink;
	$facebook = 'https://www.facebook.com/sharer/sharer.php?u=' . $postlink;
	$email = 'mailto:?&body=' . '%0A%0A' . $postlink;

	?>

	<div class="site-footer">
		<div class="footer-wrap">
			<div class="icons-wrap">
				<a class="social social-js" href=" <?php echo $twitter ?> "><span class="ion-social-twitter-outline"></span></a>
				<a class="social social-js" href="<?php echo $facebook ?>"><span class="ion-social-facebook-outline"></span></a>
			</div>
			<!-- <link href="//cdn-images.mailchimp.com/embedcode/horizontal-slim-10_7.css" rel="stylesheet" type="text/css"> -->
			<div class="email-capture-form small-form" id="mc_embed_signup">
				<form action="//econstories.us7.list-manage.com/subscribe/post?u=3c416ed673b4f6e99320b1e76&amp;id=20afa62c9c" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
				    <div id="mc_embed_signup_scroll">
						<div class="form">
							<div class="label"><label for="email">Stay informed about FreeTogether:</label></div>
							<div class="input">
				            	<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="your email">
					            <input class="button" type="submit" value="" name="subscribe" id="mc-embedded-subscribe" class="button">
					                <!-- <h3 class="button-cta"><span class="ion-ios-arrow-thin-right"></span></h3> -->
				            </div>
		<div id="mce-responses" class="clear">
			<div class="response" id="mce-error-response" style="display:none"></div>
			<div class="response" id="mce-success-response" style="display:none"></div>
			</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
		    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_3c416ed673b4f6e99320b1e76_20afa62c9c" tabindex="-1" value="">
		</div>


    <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
			        </div>
			    </div>
		        </form>
			</div>
		</div>
	</div>

<?php
}




//* Create the Take Action modal
function ft_take_action_modal() {
	?>
		<div class="modal fade take-action-modal" tabindex="-1" role="dialog" id="takeAction">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title">Take Action</h4>
		      </div>
		      <div class="modal-body">
		        <p>Free Together partners with state-based organizations on targeted issues. Enter your zipcode and email below, and we’ll match you with an organization that’s working on issues in your state.</p>
		      </div>
		      <div class="modal-footer">
		      	<div id="mc_embed_signup">
			       <form action="//econstories.us7.list-manage.com/subscribe/post?u=3c416ed673b4f6e99320b1e76&amp;id=20afa62c9c" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
						<div class="form">
			            	<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Your Email" required>
			            	<input type="zipcode" value="" name="ZIPCODE" class="zip" id="mce-ZIP" placeholder="Your Zipcode">
			            	<div class="have-story-wrapper">
			            		<input type="checkbox" value="1" name="group[12969][1]" id="mce-group[12969]-12969-0" class="have-story">
			            		<!-- <input class="have-story" name="story" type="checkbox"> -->
			            		<label class="have-story-label" for="story">I have a story to tell.</label>
			            	</div>
			            	<input type="submit" value="Match Me &#xf3d6;" name="subscribe" id="mc-embedded-subscribe" class="button match-me">
				            <button class="button">
								Match Me <span style="float:right" class="ion-ios-arrow-thin-right"></span>
				            </button>
				        </div>
			        </form>
			    </div>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->



	<?php 
}
add_action('genesis_after_content','ft_take_action_modal');



