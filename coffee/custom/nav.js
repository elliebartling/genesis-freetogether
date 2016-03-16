jQuery(document).ready(function($) {
	var didScroll;
	var lastScrollTop = 0;
	var delta = 5;
	var navbarHeight = $('.site-header').outerHeight();

	// console.log('JS Loaded Sucessfully');
	if ( $('body').hasClass('desktop') ) {
			// console.log('Has Desktop Class');
			$('.site-footer').addClass('invisible');
		}


	$(window).scroll(function(event) {
		didScroll = true;
	});

	setInterval(function() {
		if (didScroll) {
			hasScrolled();
			didScroll = false;
		}
	}, 250);

	function hasScrolled() {
		var st = $(this).scrollTop();
		if (Math.abs(lastScrollTop - st) <= delta){
			return;
		}

		if (st > lastScrollTop && st > navbarHeight) {
			// $('.site-header').addClass('invisible');
			// $('.site-header').removeClass('visible');
			$('.site-footer').addClass('invisible');
			$('.site-footer').removeClass('visible');

		}
		else {
			if (st + $(window).height() < $(document).height()) {
				// $('.site-header').removeClass('invisible');
				// $('.site-header').addClass('visible');
				$('.site-footer').removeClass('invisible');
				$('.site-footer').addClass('visible');
			}
		}

		lastScrollTop = st;
	}

		
		
});