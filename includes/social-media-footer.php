<?php
//* Remove the site footer
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
//* Customize the site footer
add_action( 'genesis_after_content', 'bg_custom_footer' );
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
				<a class="social-square facebook social social-js" href="<?php echo $facebook ?>">
						<span class="ion-social-facebook"></span>
				</a>
				<a class="social social-js social-square twitter" href=" <?php echo $twitter ?> ">
						<span class="ion-social-twitter"></span>
				</a>
				<a class="social social-square email" href=" <?php echo $email ?> ">
						<span class="ion-paper-airplane"></span>
				</a>
				<a class="social social-square subscribe" href="#" data-toggle="modal" data-target="#takeAction">
					<span class="footer-take-action">Take&nbsp;Action</span>
				</a>
				
				
			</div>
			<div class="social-square email-capture-form small-form" id="mc_embed_signup">
				<form action="//econstories.us7.list-manage.com/subscribe/post?u=3c416ed673b4f6e99320b1e76&amp;id=20afa62c9c" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
				    <div id="mc_embed_signup_scroll">
						<div class="form">
							<div class="label"><label for="email">Stay informed about FreeTogether:</label></div>
							<div class="input">
				            	<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="your email">
					            <input class="button" type="submit" value="&#xf3d6;" name="subscribe" id="mc-embedded-subscribe" class="button">
					                <!-- <h3 class="button-cta"><span class="ion-ios-arrow-thin-right"></span></h3> -->
				            </div>
							<div id="mce-responses" class="clear">
								<div class="response" id="mce-error-response" style="display:none"></div>
								<div class="response" id="mce-success-response" style="display:none"></div>
							</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
							<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_3c416ed673b4f6e99320b1e76_20afa62c9c" tabindex="-1" value="">
							</div>

    <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script>
    <script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
			        	</div>
			    	</div>
		        </form>
			</div>
		</div>
	</div>

<?php
}

// Creating the widget 
class wpb_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'wpb_widget', 

// Widget name will appear in UI
__('Social Media Widget', 'wpb_widget_domain'), 

// Widget description
array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
$desc = apply_filters( 'widget_title', $instance['desc'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
echo __( 'Hello, World!', 'wpb_widget_domain' );
echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) || isset( $instance[ 'desc' ] ) ) {
$title = $instance[ 'title' ];
$desc = $instance[ 'desc' ];
}
else {
$title = __( 'New title', 'wpb_widget_domain' );
$desc = __( 'New desc', 'wpb_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id( 'desc' ); ?>"><?php _e( 'Description:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'desc' ); ?>" name="<?php echo $this->get_field_name( 'desc' ); ?>" type="text" value="<?php echo esc_attr( $desc ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['desc'] = ( ! empty( $new_instance['desc'] ) ) ? strip_tags( $new_instance['desc'] ) : '';
return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );


?>