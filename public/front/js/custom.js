jQuery(document).ready(function($) {


    // Mobile Nav
    $("#menu1").metisMenu();

    // Side menubar
    $("#close-btn, .toggle-btn").click(function() {
        $("#mySidenav, body").toggleClass("active");
    });
    // MObile Nav End

   // Search Toggle
   $("#search").click(function(){
      $(".search-toggle").slideToggle('fast');
  });
   // Search Toggle End


// Dropdown
$(document).ready(function(){
    $(".dropdown").hover(            
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideDown("fast");
            $(this).toggleClass('open');        
        },
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideUp("fast");
            $(this).toggleClass('open');       
        }
        );
});
// Dropdown End



// Gallery
$(document).ready(function(){
    $('#lightgallery').lightGallery();
});
// Gallery End


// Videos
$('#video-gallery').lightGallery();
// Videos End


// News
$('.newss').owlCarousel({
    loop:true,
    dots:false,
    margin:20,
    nav:true,
    navText : ["<i class='las la-angle-left'></i>","<i class='las la-angle-right'></i>"],
    responsive:{
        0:{
            items:1
        },
        768:{
            items:3
        },
        992:{
            items:4
        }
    }
})
// News End


// News
$('.blogs').owlCarousel({
    loop:true,
    dots:false,
    margin:20,
    nav:true,
    navText : ["<i class='las la-angle-left'></i>","<i class='las la-angle-right'></i>"],
    responsive:{
        0:{
            items:1
        },
        768:{
            items:3
        },
        992:{
            items:4
        }
    }
})
// News End


// Thumbnail Slider
$('#image-gallery').lightSlider({
    gallery: true,
    item: 1,
    thumbItem: 6,
    slideMargin: 0,
    thumbMargin: 10,
    speed: 500,
    auto: true,
    loop: true,
    keyPress: true,
    controls: true,
    enableTouch: true,
    verticalHeight: 450,
    prevHtml: '<i class="fas fa-angle-left"></i>',
    nextHtml: '<i class="fas fa-angle-right"></i>',
    responsive: [{
        breakpoint: 767,
        settings: {
            thumbItem: 4,
        }
    },
    {
        breakpoint: 575,
        settings: {
            thumbItem: 3,
        }
    }
    ],
    onSliderLoad: function() {
        $('#image-gallery').removeClass('cS-hidden');
    }
});

    // Thumbnail Slider End



    // More Less
    $('#show-more-content').hide();

    $('#show-more').click(function(){
        $('#show-more-content').show(300);
        $('#show-less').show();
        $('#show-more').hide();
    });

    $('#show-less').click(function(){
        $('#show-more-content').hide(150);
        $('#show-more').show();
        $(this).hide();
    });

    // More Less End

// Header active
var yourNavigation = $(".header");
stickyDiv = "active";
yourHeader = $('.header-part').height();

$(window).scroll(function() {
    if( $(this).scrollTop() > yourHeader ) {
        yourNavigation.addClass(stickyDiv);
    } else {
        yourNavigation.removeClass(stickyDiv);
    }
});

// Header Active End


// Scroll Top Js
$(function(){
        // Scroll Event
        $(window).on('scroll', function(){
            var scrolled = $(window).scrollTop();
            if (scrolled > 600) $('.go-top').addClass('active');
            if (scrolled < 600) $('.go-top').removeClass('active');
        });  
        // Click Event
        $('.go-top').on('click', function() {
            $("html, body").animate({ scrollTop: "0" },  300);
        });
    });

    // WOW Animation JS
    if($('.wow').length){
        var wow = new WOW({
            mobile: false
        });
        wow.init();
    }
// Scroll Top Js ENd



});