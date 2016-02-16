jQuery(document).ready(function($) {

    $('.owl-carousel').owlCarousel({
        loop:false,
        margin:10,
        nav:true,
        mouseDrag: false,
        pullDrag: false,
        freeDrag: false,
        navText: ['<span class="ion-ios-arrow-left"></span>','<span class="ion-ios-arrow-right"></span>'],
        // autoWidth: false,
        responsiveClass: true,
        responsive:{
            0:{
                items:1,
                nav: false
            },
            800:{
                items:3,
                nav: true
            },
            1000:{
                items:4,
                nav: true
            },
            1500:{
                items:5,
                nav: true
            }
        }
    });


});