jQuery(document).ready(function(){
	jQuery("#twitter").after("<div style=\"color:#666;\"><small>Tweet length: </small><span id=\"tweet_counter\"></span><span style=\"font-weight:bold; padding-left:7px;\">/ 116</span><small><span style=\"font-weight:bold; padding-left:7px;\">character(s).</span></small></div>");
	     jQuery("span#tweet_counter").text(jQuery("#twitter").val().length);
	     jQuery("#twitter").keyup( function() {
	         if(jQuery(this).val().length > 500){
	            jQuery(this).val(jQuery(this).val().substr(0, 116));
	        }
	     jQuery("span#tweet_counter").text(jQuery("#twitter").val().length);
	   });
	});