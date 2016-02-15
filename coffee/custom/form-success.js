jQuery(document).ready(function($) {

	$('.button').on("click", function() {
		$('.site-footer').removeClass('invisible').addClass('visible');
	});

	$('.button').on("click", function(){
		setTimeout($('.response').attr("style", "opacity: 0"), 8000).delay(800).attr("display:none");
		});

});