jQuery(document).ready(function($) {

    // Slide Toggle
    $(".trending-head a, .close-trending").click(function() {
        $(".trending-menu").slideToggle('fast');
    });
    // Slide Toggle End

    // Mobile Nav
    $("#menu1").metisMenu();

    // Side menubar
    $("#close-btn, #bars-toggle, #search-collapse").click(function() {
        $("#mySidenav, body").toggleClass("active");
    });

    // Search
    $(".search").click(function() {
        if ($(".search-up").css("display") == "none") {
            $(".search-up").css("display", "block");
        } else {
            $(".search-up").css("display", "none");
        }
        return false;
    });
    // Search End

    // Fixed nav
    var yourNavigation = $(".navbar-sec");
    stickyDiv = "sticky-top";
    yourHeader = $("#second-sec").height();

    $(window).scroll(function() {
        if ($(this).scrollTop() > yourHeader) {
            yourNavigation.addClass(stickyDiv);
        } else {
            yourNavigation.removeClass(stickyDiv);
        }
    });
    // Fixed Nav End

    // Scroll Top Js
    $(function() {
        // Scroll Event
        $(window).on("scroll", function() {
            var scrolled = $(window).scrollTop();
            if (scrolled > 600) $(".go-top").addClass("active");
            if (scrolled < 600) $(".go-top").removeClass("active");
        });
        // Click Event
        $(".go-top").on("click", function() {
            $("html, body").animate({ scrollTop: "0" }, 300);
        });
    });

    // WOW Animation JS
    if ($(".wow").length) {
        var wow = new WOW({
            mobile: false,
        });
        wow.init();
    }
    // Scroll Top Js ENd

    // Video Section
    $("#video").owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        autoplay: false,
        autoplayTimeout: 3000,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 3,
            },
            1000: {
                items: 4,
            },
        },
    });
    // Video Section End

    // Photo Feature
    $("#photo-features").owlCarousel({
        loop: true,
        margin: 15,
        nav: true,
        autoplay: true,
        autoplayTimeout: 3000,
        dots: false,
        navText: [
            "<i class='fas fa-chevron-left'></i>",
            "<i class='fas fa-chevron-right'></i>",
        ],
        responsive: {
            0: {
                items: 1,
            },
            700: {
                items: 3,
            },
            1000: {
                items: 4,
            },
        },
    });
    // Photo Feature End

    // Photo Feature
    $("#capitals").owlCarousel({
        loop: true,
        margin: 5,
        nav: true,
        autoplay: true,
        autoplayTimeout: 3000,
        dots: false,
        navText: [
            "<i class='fas fa-chevron-left'></i>",
            "<i class='fas fa-chevron-right'></i>",
        ],
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 3,
            },
            1000: {
                items: 5,
            },
        },
    });
    // Photo Feature End

    // Scroll News
    // $('.js-conveyor-1').jConveyorTicker();

    // Toggle class
    $(document).on("scroll", function() {
        $(".video-popup-wrap").toggleClass(
            "active",
            $(document).scrollTop() > 7000
        );
    });

    $(".close-video").click(function() {
        // alert('dsjflkdsjf')
        $(".video-popup").hide(200);
    });

    // Video Gallery
    $(".video-thumb").click(function() {
        $(".video-thumb > img").removeClass("active");
        $(this).children("img").addClass("active");
    });

    $("div.video-thumb").click(function() {
        $(".video-iframe iframe").attr(
            "src",
            $(this).children("iframe").attr("src").replace("iframe")
        );
    });
    // Video Gallery ENd

    // Change Active Class
    $(document).ready(function() {
        $(".thumbnail-list").click(function() {
            $(".thumbnail-list").removeClass("active");
            $(this).addClass("active");
        });
    });

    // More Less
    $("#show-more-content").hide();

    $("#show-more").click(function() {
        $("#show-more-content").show(300);
        $("#show-less").show();
        $("#show-more").hide();
    });

    $("#show-less").click(function() {
        $("#show-more-content").hide(150);
        $("#show-more").show();
        $(this).hide();
    });

    // $(document).scroll(function () {
    // 	var y = $(this).scrollTop();
    // 	if (y > 2000) {
    // 		$('.video-popup-wrap').fadeIn('slow');
    // 	} else {
    // 		$('.video-popup-wrap').fadeOut('slow');
    // 	}

    // });

    // Font Increase Decrease
    var $affectedElements = $(".change-size p"); // Can be extended, ex. $("div, p, span.someClass")

    // Storing the original size in a data attribute so size can be reset
    $affectedElements.each(function() {
        var $this = $(this);
        $this.data("orig-size", $this.css("font-size"));
    });

    $("#btn-increase").click(function() {
        changeFontSize(1);
    });

    $("#btn-decrease").click(function() {
        changeFontSize(-1);
    });

    $("#btn-orig").click(function() {
        $affectedElements.each(function() {
            var $this = $(this);
            $this.css("font-size", $this.data("orig-size"));
        });
    });

    function changeFontSize(direction) {
        $affectedElements.each(function() {
            var $this = $(this);
            $this.css(
                "font-size",
                parseInt($this.css("font-size")) + direction
            );
        });
    }

    // Skip Ads
    $(".skip-ads-btn").on("click", function() {
        $(".skip-ads-col").addClass("active");
    });

    $(function() {
        setTimeout(function() {
            $(".skip-ads-col").fadeOut(1000);
        }, 10000);
    });

    $(document).ready(function() {
        $("button.nav-item").click(function() {
            $("button.nav-item").removeClass("active");
            $(this).addClass("active");
        });
    });
});

//lozard js
// var observer = lozad('img', {
//     threshold: 0.1,
//     enableAutoReload: true,
//     load: function(el) {
//         el.src = el.getAttribute("data-src");
//         // el.onload = function() {
//         //     toastr["success"](el.localName.toUpperCase() + " " + el.getAttribute(
//         //         "data-index") + " lazy loaded.")
//         // }
//     }
// })
// observer.observe();