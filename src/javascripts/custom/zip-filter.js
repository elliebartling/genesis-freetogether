
jQuery(document).ready(function($) {

	$("li#initLabel").on("click", function() {
	    $('ul#zipcodeInput').children('li:not(.init)').toggle();
	    if ($('.zipcode-input-wrap').hasClass('open')) {
	    	$('.zipcode-input-wrap').removeClass('open');
	    	$('.zipcode-input-wrap').addClass('closed');
	    }
	    else {
	    	$('.zipcode-input-wrap').addClass('open');
	    	$('.zipcode-input-wrap').removeClass('closed');
	    }
	    
	});


	// Get the Owl Carousel
	var carousel = $('.owl-stage');

	// For each item, find the class names for the div.item element
	carousel.children('div').each(function() {
		var stateClass = $(this).children('div').attr('class');

		var stateAbbr = stateClass.replace('item ', '');
		// Apply that classname to .owl-item
		$(this).addClass(stateClass);
		$(this).addClass('mix');
		// Add a data attribute to that .owl-item
		$(this).attr('data-state',stateAbbr);
		// $(this).attr('data-visibility', 'yes');
		// $('.owl-carousel').reinit({mouseDrag: false, pullDrag: false, freeDrag: false});
	});

	// Initiate MixItUp plugin, sort by state ascending
	$('.owl-stage').mixItUp();
	// $('.owl-stage').children().removeClass('active');
	$('.owl-stage').mixItUp('sort','state:asc').trigger('next.owl.carousel');
	// $('.owl-carousel').reinit({mouseDrag: false, pullDrag: false, freeDrag: false});
	
	// $('.owl-carousel').trigger('to.owl.carousel', 0);
	// $('.owl-carousel').trigger('prev.owl.carousel');
	// $('.owl-stage').children('div:lt(5)').addClass('active');
	

	// Get all dropdown options
	var allOptions = $("ul#zipcodeInput").children('li:not(.init)');

	// Get all carousel items
	var allItems = $('.owl-stage').children('.owl-item');


	// When user selects a state... magic. Just kidding. Code. Same diff.
	$("ul#zipcodeInput").on("click", "li:not(.init)", function() {

		// Remove "selected" class from the dropdown items
	    allOptions.removeClass('selected');

	    // Add selected to the option the user picked
	    $(this).addClass('selected');

	   	$('.zipcode-input-wrap').addClass('closed');
	    $('.zipcode-input-wrap').removeClass('open');

	    // Change the text of the visible item to the selected item
	    $('.init').html($(this).html() + '<span class="fa fa-angle-down"></span>');
	    allOptions.toggle();

		// Re-sort carousel by state ascending
		$('.owl-stage').mixItUp('sort','state:asc');

		// Tell carousel to move back to the first position if it's been changed.
		$('.owl-carousel').trigger('to.owl.carousel', 0);
	});


	

});