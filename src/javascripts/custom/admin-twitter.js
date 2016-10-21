// Get Twitter username from Twitter field

// Search Twitter API with that information

// Store Twitter User's web URL, logo, description 
// & location in variables

// Save those variables to metaboxes



jQuery(document).ready(function($) {

	$('#ft_org_button').text("Check for Twitter Account");

	$('#ft_org_button').on('click', function (e) {
		e.preventDefault();

		var user = $('#ft_org_twitter').val();
		// $('#ft_org_button').append('<p>' + user + '</p>');


		$.ajax({
				url: '../wp-content/themes/genesis-freetogether/get_twitter_user.php',
				type: 'POST',
				data: {'user': user},
				// dataType: json,
				success: function(response) {


					if (typeof response.errors === 'undefined' || response.errors.length < 1) {
						
						var data = JSON.parse(response);
						var $tweets = $('#partner_org_social');
						$tweets.append('<div id="partner-social-profile">');
						$('#partner_org_social p:first').text('Success!');
						$('#partner_org_social p:first').append(' We found ' + data.name + ' on Twitter, so you don\'t have to fill out as much data by hand.</p>');

						$('#ft_org_desc').val(data.description);
						$('#ft_org_url').val(data.url);


						var image = data.profile_image_url.replace("_normal", "");
						var imagePreview = '<div class="image-preview" style="background: url(' + image + '); background-size: cover; width: 200px; height: 200px; border-radius: 2px; margin: 2rem;"></div>';


						// var thickboxHtml = '<div class="rwmb-image-bar"><a class="rwmb-delete-file" href="#" data-attachment_id="NaN">×</a></div><input type="hidden" name="ft_org_thickbox[]" value="NaN">';
						$('#ft_org_image').val(image);
						// $('.rwmb-thickbox_image-wrapper ul').append('<li id="item_NaN"><img src="' + image + '">' + thickboxHtml + '</li>');
						// $('#ft_org_plupload_image').val(image);
						$('#ft_org_image_description').append('<div id="image-preview"></div>');
						$('#image-preview').html(imagePreview);

						var location = data.location.split(",");
						var state = location[1].substr(1,2);
						$('#ft_org_state').val(state);

						var color = data.profile_link_color;
						$('#ft_org_color').val('#' + color);						
						$('.wp-color-result').attr('style', 'background-color: #' + color + ';');


					} else {
						$('#partner_org_social p:first').text('Response error');
					}

				},
				error: function(errors) {
					$('#partner_org_social p:first').text('Request error');
				}
			});

	});

});