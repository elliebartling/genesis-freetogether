var lastScrollTop = 0;
$(document).ready(function($) {
	var didScroll = false;
	var st = $(window).scrollTop();
	// console.log('JS Loaded Sucessfully');
	if ( $('body').hasClass('desktop') ) {
			// console.log('Has Desktop Class');
			$('.site-footer').addClass('invisible');
			console.log("desktop")
		}


	$(window).scroll(function(event) {
		didScroll = true;
		st = $(window).scrollTop();
		console.log("scrolled");
	});

	setInterval(function() {
		if (didScroll) {
			hasScrolled(st);
			didScroll = false;
		}
	}, 250);

});


function hasScrolled(st) {

	var delta = 5;
	var navbarHeight = $('.site-header').outerHeight();


	console.log(st);
	console.log(lastScrollTop);
	console.log(delta);
	console.log(Math.abs(lastScrollTop - st) <= delta);
	if (Math.abs(lastScrollTop - st) <= delta){
		console.log("Doin math")
		return;
	}

	if (st > lastScrollTop && st > navbarHeight) {
		// $('.site-header').addClass('invisible');
		// $('.site-header').removeClass('visible');
		$('.site-footer').addClass('invisible');
		$('.site-footer').removeClass('visible');
		console.log("add invisible");
	}
	else {
		if (st + $(window).height() < $(document).height()) {
			// $('.site-header').removeClass('invisible');
			// $('.site-header').addClass('visible');
			$('.site-footer').removeClass('invisible');
			$('.site-footer').addClass('visible');
			console.log("remove invisible");
		}
	}

	lastScrollTop = st;
}
