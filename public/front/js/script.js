(function ($) {

    "use strict";

    /* ----- Preloader ----- */
    function preloaderLoad() {
        if ($('.preloader').length) {
            $('.preloader').delay(200).fadeOut(300);
        }
        $(".preloader_disabler").on('click', function () {
            $("#preloader").hide();
        });
    }

    /* ----- Navbar Scroll To Fixed ----- */
    function navbarScrollfixed() {
        $('.navbar-scrolltofixed').scrollToFixed();
        var summaries = $('.summary');
        summaries.each(function (i) {
            var summary = $(summaries[i]);
            var next = summaries[i + 1];
            summary.scrollToFixed({
                marginTop: $('.navbar-scrolltofixed').outerHeight(true) + 10,
                limit: function () {
                    var limit = 0;
                    if (next) {
                        limit = $(next).offset().top - $(this).outerHeight(true) - 10;
                    } else {
                        limit = $('.footer').offset().top - $(this).outerHeight(true) - 10;
                    }
                    return limit;
                },
                zIndex: 999
            });
        });
    }

    /** Main Menu Custom Script Start **/
    $(document).on('ready', function () {

        $("#respMenu").aceResponsiveMenu({
            resizeWidth: '768', // Set the same in Media query
            animationSpeed: 'fast', //slow, medium, fast
            accoridonExpAll: false //Expands all the accordion menu on click
        });
    });

    function mobileNavToggle() {
        if ($('#main-nav-bar .navbar-nav .sub-menu').length) {
            var subMenu = $('#main-nav-bar .navbar-nav .sub-menu');
            subMenu.parent('li').children('a').append(function () {
                return '<button class="sub-nav-toggler"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>';
            });
            var subNavToggler = $('#main-nav-bar .navbar-nav .sub-nav-toggler');
            subNavToggler.on('click', function () {
                var Self = $(this);
                Self.parent().parent().children('.sub-menu').slideToggle();
                return false;
            });

        };
    }

    /* ----- Tags Bar Code for job list 1 page ----- */
    $('.tags-bar > span i').on('click', function () {
        $(this).parent().fadeOut();
    });

    /* ----- This code for menu ----- */
    $(window).on('scroll', function () {
        if ($('.scroll-to-top').length) {
            var strickyScrollPos = 100;
            if ($(window).scrollTop() > strickyScrollPos) {
                $('.scroll-to-top').fadeIn(500);
            } else if ($(this).scrollTop() <= strickyScrollPos) {
                $('.scroll-to-top').fadeOut(500);
            }
        };
        if ($('.stricky').length) {
            var headerScrollPos = $('.header-navigation').next().offset().top;
            var stricky = $('.stricky');
            if ($(window).scrollTop() > headerScrollPos) {
                stricky.removeClass('slideIn animated');
                stricky.addClass('stricky-fixed slideInDown animated');
            } else if ($(this).scrollTop() <= headerScrollPos) {
                stricky.removeClass('stricky-fixed slideInDown animated');
                stricky.addClass('slideIn animated');
            }
        };
    });

    $(".mouse_scroll, .mouse_scroll.home8").on('click', function () {
        $('html, body').animate({
            scrollTop: $("#feature-property, #property-city").offset().top
        }, 1000);
    });
    /** Main Menu Custom Script End **/

    /* ----- Blog innerpage sidebar according ----- */
    $(document).ready(function () {
        $('.collapse').on('show.bs.collapse', function () {
            $(this).siblings('.card-header').addClass('active');
        });
        $('.collapse').on('hide.bs.collapse', function () {
            $(this).siblings('.card-header').removeClass('active');
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    });

    /* ----- Menu Cart Button Dropdown ----- */
    $(document).on('ready', function () {
        // Loop through each nav item
        $('.cart_btn').children('ul.cart').children('li').each(function (indexCount) {
            // loop through each dropdown, count children and apply a animation delay based on their index value
            $(this).children('ul.dropdown_content').children('li').each(function (index) {
                // Turn the index value into a reasonable animation delay
                var delay = 0.1 + index * 0.03;
                // Apply the animation delay
                $(this).css("animation-delay", delay + "s")
            });
        });
    });

    /* Menu Search Popup */
    jQuery(document).ready(function ($) {
        var wHeight = window.innerHeight;
        /* search bar middle alignment */
        $('#mk-fullscreen-searchform').css('top', wHeight / 2);
        /* reform search bar */
        jQuery(window).resize(function () {
            wHeight = window.innerHeight;
            $('#mk-fullscreen-searchform').css('top', wHeight / 2);
        });

        /* Search */
        $('#search-button, #search-button2').on('click', function () {
            console.log("Open Search, Search Centered");
            $("div.mk-fullscreen-search-overlay").addClass("mk-fullscreen-search-overlay-show");
        });
        $("button.mk-fullscreen-close").on('click', function () {
            console.log("Closed Search");
            $("div.mk-fullscreen-search-overlay").removeClass("mk-fullscreen-search-overlay-show");
        });
    });

    /* ----- fact-counter ----- */
    function counterNumber() {
        $('div.timer').counterUp({
            delay: 5,
            time: 2000
        });
        // const cd = new Date().getFullYear() + 1
        // $('#countdown').countdown({
        //     year: cd
        // });
    }

    /* ----- Mobile Nav ----- */
    $(function () {
        $('nav#menu').mmenu();
    });

    /* ----- Candidate SIngle Page Price Slider ----- */
    $(function () {
        $("#slider-range").slider({
            range: true,
            min: 50,
            max: 150,
            values: [50, 120],
            slide: function (event, ui) {
                $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
            }
        });
        $("#amount").val("$" + $("#slider-range").slider("values", 0) +
            " - $" + $("#slider-range").slider("values", 1));
    });

    /* ----- Employee List v1 page range slider widget ----- */
    $(document).on('ready', function () {
        $(".slider-range").slider({
            range: true,
            min: 50000,
            max: 130000,
            values: [52239, 98514],
            slide: function (event, ui) {
                $(".amount").val(ui.values[0]);
                $(".amount2").val(ui.values[1]);
            }
        });
        $(".amount").change(function () {
            $(".slider-range").slider('values', 0, $(this).val());
        });
        $(".amount2").change(function () {
            $(".slider-range").slider('values', 1, $(this).val());
        });
    });

    /* ----- Progress Bar ----- */
    if ($('.progress-levels .progress-box .bar-fill').length) {
        $(".progress-box .bar-fill").each(function () {
            var progressWidth = $(this).attr('data-percent');
            $(this).css('width', progressWidth + '%');
            $(this).children('.percent').html(progressWidth + '%');
        });
    }

    /* ----- Background Parallax ----- */
    var isMobile = {
        Android: function () {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function () {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function () {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function () {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function () {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function () {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };

    jQuery(document).on('ready', function () {
        jQuery(window).stellar({
            horizontalScrolling: false,
            hideDistantElements: true,
            verticalScrolling: !isMobile.any(),
            scrollProperty: 'scroll',
            responsive: true
        });
    });

    /* ----- MagnificPopup ----- */
    if (($(".popup-img").length > 0) || ($(".popup-iframe").length > 0) || ($(".popup-img-single").length > 0)) {
        $(".popup-img").magnificPopup({
            type: "image",
            gallery: {
                enabled: true,
            }
        });
        $(".popup-img-single").magnificPopup({
            type: "image",
            gallery: {
                enabled: false,
            }
        });
        $('.popup-iframe').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            preloader: false,
            fixedContentPos: false
        });
        $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false
        });
    };

    $('#myTab a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    })

    /* ----- Wow animation ----- */
    function wowAnimation() {
        var wow = new WOW({
            animateClass: 'animated',
            mobile: true, // trigger animations on mobile devices (default is true)
            offset: 0
        });
        wow.init();
    }

    /* ----- Date & time Picker ----- */
    if ($('.datepicker').length) {
        $('.datepicker').datetimepicker();
    }

    /* ----- Home Maximage Slider ----- */
    if ($('#maximage').length) {
        $('#maximage').maximage({
            cycleOptions: {
                fx: 'fade',
                speed: 3000,
                timeout: 20000,
                prev: '#arrow_left',
                next: '#arrow_right'
            },
            onFirstImageLoaded: function () {
                jQuery('#cycle-loader').hide();
                jQuery('#maximage').fadeIn('fast');
            }
        });
        // Helper function to Fill and Center the HTML5 Video
        jQuery('#html5video').maximage('maxcover');

        // To show it is dynamic html text
        jQuery('.in-slide-content').delay(2000).fadeIn();
    }

    /* ----- Slick Slider For Testimonial ----- */
    if ($('.tes-for').length) {
        $('.tes-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: false,
            autoplay: false,
            autoplaySpeed: 1000,
            asNavFor: '.tes-nav'
        });
        $('.tes-nav').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            asNavFor: '.tes-for',
            dots: false,
            arrows: false,
            centerPadding: '1px',
            centerMode: true,
            focusOnSelect: true
        });
    }

    /*  Testimonial-Slider-Owl-carousel  */
    if ($('.feature_property_slider').length) {
        $('.feature_property_slider').owlCarousel({
            loop: true,
            margin: 30,
            dots: true,
            nav: false,
            rtl: false,
            autoplayHoverPause: false,
            autoplay: false,
            singleItem: true,
            smartSpeed: 1200,
            navText: [
                '<i class="fa fa-arrow-left"></i>',
                '<i class="fa fa-arrow-right"></i>'
            ],
            responsive: {
                0: {
                    items: 1,
                    center: false
                },
                480: {
                    items: 1,
                    center: false
                },
                600: {
                    items: 1,
                    center: false
                },
                768: {
                    items: 2
                },
                992: {
                    items: 2
                },
                1200: {
                    items: 2
                },
                1280: {
                    items: 3
                }
            }
        })
    }

    /*  Testimonial-Slider-Owl-carousel  */
    if ($('.testimonial_grid_slider').length) {
        $('.testimonial_grid_slider').owlCarousel({
            loop: true,
            margin: 15,
            dots: true,
            nav: false,
            rtl: false,
            autoplayHoverPause: false,
            autoplay: false,
            singleItem: true,
            smartSpeed: 1200,
            navText: [
                '<i class="fa fa-arrow-left"></i>',
                '<i class="fa fa-arrow-right"></i>'
            ],
            responsive: {
                0: {
                    items: 1,
                    center: false
                },
                480: {
                    items: 1,
                    center: false
                },
                600: {
                    items: 1,
                    center: false
                },
                768: {
                    items: 1
                },
                992: {
                    items: 1
                },
                1200: {
                    items: 1
                }
            }
        })
    }

    /*  Team-Slider-Owl-carousel  */
    if ($('.team_slider').length) {
        $('.team_slider').owlCarousel({
            loop: true,
            margin: 30,
            dots: false,
            nav: true,
            rtl: false,
            autoplayHoverPause: false,
            autoplay: false,
            singleItem: true,
            smartSpeed: 1200,
            navText: [
                '<i class="flaticon-left-arrow"></i>',
                '<i class="flaticon-right-arrow-1"></i>'
            ],
            responsive: {
                0: {
                    items: 1,
                    center: false
                },
                480: {
                    items: 1,
                    center: false
                },
                520: {
                    items: 2,
                    center: false
                },
                600: {
                    items: 2,
                    center: false
                },
                768: {
                    items: 2
                },
                992: {
                    items: 3
                },
                1200: {
                    items: 4
                },
                1366: {
                    items: 4
                },
                1400: {
                    items: 4
                }
            }
        })
    }

    /*  Best-Property-Slider-Owl-carousel  */
    if ($('.best_property_slider').length) {
        $('.best_property_slider').owlCarousel({
            loop: true,
            margin: 30,
            dots: true,
            nav: false,
            rtl: false,
            autoplayHoverPause: false,
            autoplay: false,
            singleItem: true,
            smartSpeed: 1200,
            navText: [
                '<i class="flaticon-left-arrow"></i>',
                '<i class="flaticon-right-arrow-1"></i>'
            ],
            responsive: {
                0: {
                    items: 1,
                    center: false
                },
                480: {
                    items: 1,
                    center: false
                },
                520: {
                    items: 1,
                    center: false
                },
                600: {
                    items: 2,
                    center: false
                },
                768: {
                    items: 2
                },
                992: {
                    items: 3
                },
                1200: {
                    items: 3
                },
                1366: {
                    items: 4
                },
                1400: {
                    items: 4
                }
            }
        })
    }

    /*  Team-Slider-Owl-carousel  */
    if ($('.feature_property_home3_slider').length) {
        $('.feature_property_home3_slider').owlCarousel({
            loop: false,
            margin: 15,
            dots: false,
            nav: true,
            rtl: false,
            autoplayHoverPause: false,
            autoplay: false,
            singleItem: true,
            smartSpeed: 1200,
            navText: [
                '<i class="flaticon-left-arrow"></i>',
                '<i class="flaticon-right-arrow-1"></i>'
            ],
            responsive: {
                0: {
                    items: 1,
                    center: false
                },
                360: {
                    items: 2,
                    center: false
                },

                400: {
                    items: 2,
                    center: false
                },
                480: {
                    items: 2,
                    center: false
                },
                520: {
                    items: 2,
                    center: false
                },
                600: {
                    items: 2,
                    center: false
                },
                768: {
                    items: 2
                },
                992: {
                    items: 3
                },
                1200: {
                    items: 4
                },
                1366: {
                    items: 5
                },
                1400: {
                    items: 5
                }
            }
        })
    }

    /*  Team-Slider-Owl-carousel  */
    if ($('.feature_property_home6_slider').length) {
        $('.feature_property_home6_slider').owlCarousel({
            loop: false,
            margin: 30,
            dots: false,
            nav: true,
            rtl: false,
            autoplayHoverPause: false,
            autoplay: false,
            singleItem: true,
            smartSpeed: 1200,
            navText: [
                '<i class="flaticon-left-arrow"></i>',
                '<i class="flaticon-right-arrow-1"></i>'
            ],
            responsive: {
                0: {
                    items: 1,
                    center: false
                },
                480: {
                    items: 1,
                    center: false
                },
                520: {
                    items: 2,
                    center: false
                },
                600: {
                    items: 2,
                    center: false
                },
                768: {
                    items: 2
                },
                992: {
                    items: 3
                },
                1200: {
                    items: 4
                },
                1366: {
                    items: 5
                },
                1400: {
                    items: 5
                },
                1500: {
                    items: 5
                },
                1600: {
                    items: 5
                },
                1920: {
                    items: 5
                }
            }
        })
    }

    /*  Team-Slider-Owl-carousel  */
    if ($('.our_agents_home6_slider').length) {
        $('.our_agents_home6_slider').owlCarousel({
            loop: true,
            margin: 30,
            dots: false,
            nav: true,
            rtl: false,
            autoplayHoverPause: false,
            autoplay: false,
            singleItem: true,
            smartSpeed: 1200,
            navText: [
                '<i class="flaticon-left-arrow"></i>',
                '<i class="flaticon-right-arrow-1"></i>'
            ],
            responsive: {
                0: {
                    items: 1,
                    center: false
                },
                480: {
                    items: 1,
                    center: false
                },
                520: {
                    items: 2,
                    center: false
                },
                600: {
                    items: 2,
                    center: false
                },
                768: {
                    items: 2
                },
                992: {
                    items: 3
                },
                1200: {
                    items: 4
                },
                1366: {
                    items: 4
                },
                1400: {
                    items: 5
                }
            }
        })
    }

    /*  Testimonial-Slider-Owl-carousel  */
    if ($('.testimonial_slider_home9').length) {
        $('.testimonial_slider_home9').owlCarousel({
            loop: true,
            margin: 30,
            dots: true,
            nav: false,
            rtl: false,
            autoplayHoverPause: false,
            autoplay: false,
            singleItem: true,
            smartSpeed: 1200,
            navText: [
                '<i class="fa fa-arrow-left"></i>',
                '<i class="fa fa-arrow-right"></i>'
            ],
            responsive: {
                0: {
                    items: 1,
                    center: false
                },
                480: {
                    items: 1,
                    center: false
                },
                600: {
                    items: 1,
                    center: false
                },
                768: {
                    items: 2
                },
                992: {
                    items: 2
                },
                1200: {
                    items: 2
                },
                1280: {
                    items: 2
                }
            }
        })
    }

    /*  One-Grid-Owl-carousel  */
    if ($('.sidebar_feature_property_slider').length) {
        $('.sidebar_feature_property_slider').owlCarousel({
            animateIn: 'fadeIn',
            loop: true,
            margin: 15,
            dots: true,
            nav: true,
            rtl: false,
            autoplayHoverPause: false,
            autoplay: false,
            smartSpeed: 2000,
            singleItem: true,
            navText: [
                '<i class="flaticon-left-arrow-1"></i>',
                '<i class="flaticon-right-arrow-1"></i>'
            ],
            responsive: {
                320: {
                    items: 1,
                    center: false
                },
                480: {
                    items: 1,
                    center: false
                },
                600: {
                    items: 1,
                    center: false
                },
                768: {
                    items: 1
                },
                992: {
                    items: 1
                },
                1200: {
                    items: 1
                }
            }
        })
    }

    /*  One-Grid-Owl-carousel  */
    if ($('.listing_single_property_slider').length) {
        $('.listing_single_property_slider').owlCarousel({
            animateIn: 'fadeIn',
            loop: true,
            margin: 2,
            dots: false,
            nav: true,
            rtl: false,
            autoplayHoverPause: false,
            autoplay: false,
            smartSpeed: 2000,
            singleItem: true,
            navText: [
                '<i class="flaticon-left-arrow-1"></i>',
                '<i class="flaticon-right-arrow-1"></i>'
            ],
            responsive: {
                320: {
                    items: 1,
                    center: false
                },
                480: {
                    items: 1,
                    center: false
                },
                600: {
                    items: 1,
                    center: false
                },
                768: {
                    items: 2
                },
                992: {
                    items: 3
                },
                1200: {
                    items: 3
                }
            }
        })
    }

    /*  One-Grid-Owl-carousel  */
    if ($('.fp_single_item_slider').length) {
        $('.fp_single_item_slider').owlCarousel({
            loop: true,
            margin: 15,
            dots: false,
            nav: true,
            rtl: false,
            autoplayHoverPause: false,
            autoplay: false,
            smartSpeed: 2000,
            singleItem: true,
            navText: [
                '<i class="flaticon-left-arrow-1"></i>',
                '<i class="flaticon-right-arrow-1"></i>'
            ],
            responsive: {
                320: {
                    items: 1,
                    center: false
                },
                480: {
                    items: 1,
                    center: false
                },
                600: {
                    items: 1,
                    center: false
                },
                768: {
                    items: 1
                },
                992: {
                    items: 1
                },
                1200: {
                    items: 1
                }
            }
        })
    }

    /*  Expert-Freelancer-Owl-carousel  */
    if ($(".banner-style-one").length) {
        $(".banner-style-one").owlCarousel({
            loop: true,
            items: 1,
            margin: 0,
            dots: true,
            nav: true,
            animateOut: "slideOutDown",
            animateIn: "fadeIn",
            active: true,
            smartSpeed: 1000,
            autoplay: false
        });
        $(".banner-carousel-btn .left-btn").on("click", function () {
            $(".banner-style-one").trigger("next.owl.carousel");
            return false;
        });
        $(".banner-carousel-btn .right-btn").on("click", function () {
            $(".banner-style-one").trigger("prev.owl.carousel");
            return false;
        });
    }

    /*  Team-Slider-Owl-carousel  */
    if ($('.single_product_slider').length) {
        $('.single_product_slider').owlCarousel({
            loop: true,
            margin: 30,
            dots: true,
            nav: false,
            rtl: false,
            autoplayHoverPause: false,
            autoplay: false,
            singleItem: true,
            smartSpeed: 1200,
            navText: [
                '<i class="flaticon-left-arrow"></i>',
                '<i class="flaticon-right-arrow-1"></i>'
            ],
            responsive: {
                0: {
                    items: 1,
                    center: false
                },
                480: {
                    items: 1,
                    center: false
                },
                520: {
                    items: 1,
                    center: false
                },
                600: {
                    items: 1,
                    center: false
                },
                768: {
                    items: 1
                },
                992: {
                    items: 1
                },
                1200: {
                    items: 1
                },
                1366: {
                    items: 1
                },
                1400: {
                    items: 1
                }
            }
        })
    }


    /*  Team-Slider-Owl-carousel  */
    //    if($('.sn-bar__inner-wraps').length){
    //     $('.sn-bar__inner-wraps').owlCarousel({
    //         loop:false,
    //         margin:-20,
    //         dots:false,
    //         nav:true,
    //         rtl:false,
    //         autoplayHoverPause:false,
    //         autoplay: false,
    //         singleItem: true,
    //         smartSpeed: 1200,
    //         navText: [
    //           '<i class="flaticon-left-arrow"></i>',
    //           '<i class="flaticon-right-arrow-1"></i>'
    //         ],
    //         responsive: {
    //             0: {
    //                 items: 2,
    //                 center: false
    //             },
    //             480:{
    //                 items:2,
    //                 center: false
    //             },
    //             520:{
    //                 items:3,
    //                 center: false
    //             },
    //             600: {
    //                 items: 3,
    //                 center: false
    //             },
    //             768: {
    //                 items: 4
    //             },
    //             992: {
    //                 items: 5
    //             },
    //             1200: {
    //                 items: 6
    //             },
    //             1366: {
    //                 items: 6
    //             },
    //             1400: {
    //                 items: 7
    //             }
    //         }
    //     })
    // }



    /* ----- Scroll To top ----- */
    function scrollToTop() {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 600) {
                $('.scrollToHome').fadeIn();
            } else {
                $('.scrollToHome').fadeOut();
            }
        });

        //Click event to scroll to top
        $('.scrollToHome').on('click', function () {
            $('html, body').animate({ scrollTop: 0 }, 800);
            return false;
        });
    }

    /* ----- Mega Dropdown Content ----- */
    $(document).ready(function () {

        $("#hide_advbtn, #hide_advbtn2").on('click', function () {
            $(".dropdown-content").hide();
        });
        $("#show_advbtn, #show_advbtn2").on('click', function () {
            $("body").addClass("mobile_ovyh");
        });
        $("#show_advbtn, #show_advbtn2").on('click', function () {
            $("body").removeClass("mobile_ovyh");
        });
        $("#prncgs").on('click', function () {
            $(".dd_content2").toggle();
        });
        $("#prncgs2").on('click', function () {
            $(".dd_content2").toggle();
        });



        $(".filter_open_btn").on('click', function () {
            $("body").addClass("body_overlay");
        });

        $(".filter_closed_btn").on('click', function () {
            $("body").removeClass("body_overlay");
        });

        $(".overlay_close").on('click', function () {
            $(".white_goverlay").toggle(500);
        });



    });

    // active class name  script 

    $('.sticky-nav-tabs-container li').on('click', function () {

        $('.sticky-nav-tabs-container li').removeClass('active');
        $(this).addClass('active');
    });

    /* ======
       When document is ready, do
       ====== */
    $(document).on('ready', function () {
        // add your functions

        navbarScrollfixed();
        scrollToTop();
        wowAnimation();
        mobileNavToggle();

        // extending for text toggle
        $.fn.extend({
            toggleText: function (a, b) {
                return this.text(this.text() == b ? a : b);
            }
        });
        if ($('.showFilter').length) {
            $('.showFilter').on('click', function () {
                $(this).toggleText('Show Filter', 'Hide Filter');
                $(this).toggleClass('flaticon-close flaticon-filter-results-button sidebarOpended sidebarClosed');
                $('.listing_toogle_sidebar.sidenav').toggleClass('opened');
                $('.body_content').toggleClass('translated');
            });
        }

        $.fn.extend({
            toggleText2: function (a, b) {
                return this.text(this.text() == b ? a : b);
            }
        });

        if ($('.showBtns').length) {
            $('.showBtns').on('click', function () {
                $(this).toggleText2('Show Filter', 'Hide Filter');
                $(this).toggleClass('flaticon-close flaticon-filter-results-button sidebarOpended2 sidebarClosed2');
                $('.sidebar_content_details').toggleClass('is-full-width');
            });
        }

    });

    /* ======
       When document is loading, do
       ====== */
    // window on Load function
    $(window).on('load', function () {
        // add your functions
        counterNumber();
        preloaderLoad();

    });
    // window on Scroll function
    $(window).on('scroll', function () {
        // add your functions
    });


})(window.jQuery);





$('.sn-bar__inner-wraps').slick({
    dots: false,
    infinite: false,
    speed: 500,
    slidesToShow: 7,
    slidesToScroll: 1,
    autoplay: false,
    autoplaySpeed: 2000,
    centerPadding: 20,
    variableWidth: true,
    arrows: true,
    prevArrow: '<i class="flaticon-left-arrow"></i>',
   
    nextArrow: '<i class="flaticon-right-arrow-1"></i>',
    responsive: [
        {
            breakpoint: 1300,
            settings: {
                slidesToShow: 6,
                slidesToScroll: 1,
                variableWidth: true,
                infinite: false,
                dots: false,
                vertical: false
            }
        },
        {
            breakpoint: 1200,
            settings: {
                slidesToShow: 6,
                slidesToScroll: 1,
                variableWidth: true,
                infinite: false,
                dots: false,
                vertical: false
            }
        },

        {
            breakpoint: 992,
            settings: {
                arrows: true,
                infinite: false,
                variableWidth: false,
                variableheight: false,
                centerMode: false,
                centerPadding: 20,
                // rtl: true,
                vertical: true,
                verticalSwiping: false,
                slidesToShow: 7,
                slidesToScroll: 1,
                dragging: true,
                //  prevArrow: '<i class="flaticon-close"></i>',


            }
        },

        {
            breakpoint: 480,
            settings: {
                arrows: true,
                infinite: false,
                variableWidth: false,
                variableheight: true,
                centerMode: true,
                centerPadding: 20,
                // rtl: true,
                vertical: true,
                verticalSwiping: true,
                slidesToShow: 7,
                slidesToScroll: 1,
                dragging: true,
            }
        }

    ]
});



// <!-- Header find loacation dropdown scripts  -->

function get_autocomplete() {
    $('.dropdown-accordion').show();

    $("#rotate_arr").addClass("img-arrow");

    $(document).bind('focusin.dropdown-accordion click.dropdown-accordion', function (e) {
        if ($(e.target).closest('.dropdown-accordion, #contfilter').length) return;
        $(document).unbind('.dropdown-accordion');
        $('.dropdown-accordion').fadeOut('medium');
    });
}

function close_autocomplete() {
    $("#rotate_arr").removeClass("img-arrow");
    $('#cls-ico').val('');
    // $("#rotate_arr").css( "transform : rotate(0deg)", "transistion:0.3s" );
}

function clearInput() {
    $('#contfilter').val('');
    $('#cls-ico').hide();
    $('#rotate_arr').show();
    filtersearch('');

}

function change_ico() {
    var searchloc = $("#contfilter").val();
    if (searchloc == "") {
        $('#cls-ico').hide();
        $('#rotate_arr').show();
    }
    else {
        $('#cls-ico').show();
        $('#rotate_arr').hide();
    }
}
$(document).ready(function () {

    $('.dropdown-accordion').hide();

    $(".ml").find(".cont-link").each(function (index) {
        $(this).attr("id", "data-li-" + index);
    });

    // $("#contfilter").keyup(function () {



    // });

    $('.ml .cont-link').click(function () {
        $(this).toggleClass('active');
        $('.ml ').not(this).removeClass('active');
        var v = $(this).attr("id");
        console.log(v);
        var vx = $("#" + v).text();
        $("#contfilter").val(vx);
        $('.dropdown-accordion').hide();
        // $(".search-inputbox", "body").removeClass("tagbox");
    });
});

function filtersearch(val) {
    var filter = val;

    count = 0;
    $(".ml").each(function () {
        if (filter.trim() == "") {
            $(this).css("visibility", "visible");
            $(this).fadeIn();
        } else if ($(this).text().search(new RegExp(filter, "i")) < 0) {
            $(this).css("visibility", "hidden");
            $(this).fadeOut();
        } else {
            $(this).css("visibility", "visible");
            $(this).fadeIn();
        }

    });
}



// banner slider scripts //


var $status = $('.pagingInfo');
var $slickElement = $('.slick-carousel');
$slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
    $('.banpagination').remove();
    var i = (currentSlide ? currentSlide : 0) + 1;
    $status.append('<span class="banpagination"><span class="first_char" id="digit3">' + i + '</span><span class="slash">/</span><span class="second_char">' + slick.slideCount + '</span></span>')


});

$('.slick-carousel').slick({
    dots: true,
    infinite: true,
    speed: 2000,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 1000,
    variableWidth: false,
    arrows: false,


    prevArrow: '<i class="flaticon-left-arrow"></i>',
    nextArrow: '<i class="flaticon-right-arrow-1"></i>',
    responsive: [
        {
            breakpoint: 1300,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                variableWidth: false,
                infinite: false,
                dots: false,
                vertical: false,
                arrows: false,

            }
        },
        {
            breakpoint: 1200,
            settings: {
                autoplay: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                variableWidth: false,
                infinite: false,
                dots: false,
                vertical: false,
                arrows: false,
            }
        },


        {
            breakpoint: 992,
            settings: {
                autoplay: true,
                arrows: true,
                infinite: true,
                variableWidth: false,
                variableheight: true,
                // rtl: true,
                vertical: false,
                verticalSwiping: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                dragging: true,
                arrows: false,

            }
        },

        {
            breakpoint: 480,
            settings: {
                arrows: false,
                infinite: false,
                variableWidth: false,
                autoplay: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                verticalSwiping: true,
                vertical: false,
                autoplay: true,
                dragging: true,
                arrows: false,
            }
        }

    ]
});




// all categories  responsive shows js



$(".listul-fcls").on('click', function (e) {
    $(".ul-drop-down").show();
});

function checkWidth() {
    if ($(window).width() < 992) {

        $('.ul-drop-down').addClass('open');
    }
}
$(window).resize(checkWidth);



if ($(window).width() < 992) {

    $('.listul-fcls').addClass('click-dropdown')
    $('.ul-drop-down').addClass('sub-menu-dropdown')
}

$(document).on("click", ".flaticon-right-arrow-1.slick-arrow", function () {
    if ($(window).width() < 992) {
        $(".listclass").addClass("open-cat");
        $('#overallscroll_div .flaticon-right-arrow-1.slick-arrow').hide();
    }
    $(".sn-barh60").addClass("open-cat");
})

$(document).on("click", ".flaticon-left-arrow.slick-disabled", function () {
    $('#overallscroll_div').find('input[type=checkbox]:checked').removeAttr('checked');
    if ($(window).width() < 992) {
        $(".listclass").removeClass("open-cat");

        $('#overallscroll_div .flaticon-right-arrow-1.slick-arrow').show();
    }
    // $(".sn-barh60").removeClass("open-cat");


})

function checkWidth() {

    $('.listclass').removeClass('open-cat');
}

$(window).resize(checkWidth);


//end

// responsive add styles  script 
function checkWidth() {
    if ($(window).width() < 400) {
        $('.fa-bell-o').css('font-size', '18px');
        $('.flaticon-envelope').css('font-size', '18px');
        $('.logindiv span').css('font-size', '14px');
        // $('.flaticon-heart ').css('font-size', '16px');
        $('.flaticon-share').css('font-size', '16px');
    }
}
$(window).resize(checkWidth);





// <!-- responsive menu checkbox click script  -->

$('input.inside_sub-menu-checkbox').on('change', function () {
    $('input.inside_sub-menu-checkbox ').not(this).prop('checked', false);
});
$(' input.sub-menu-checkbox').on('change', function () {

    $(' input.sub-menu-checkbox').not(this).prop('checked', false);
});

if ($(window).width() < 992) {

    function get(las_id) {
        //  alert('#sub-menu-checkbox_'+las_id);
        $('i.flaticon-angle-arrow-down').removeClass('rotatearr');
        if ($('#sub-menu-checkbox_' + las_id).is(":checked")) {
            // $('i.flaticon-angle-arrow-down').css({'transform': 'rotate(180deg)', 'transistion': '0.3s'});
            $('#sub-menu-ico_' + las_id).addClass('rotatearr');
        } else {
            // $('sub-menu-ico_'+las_id).css({'transform': 'rotate(0deg)', 'transistion': '0.3s' });
            $('#sub-menu-ico_' + las_id).removeClass('rotatearr');
        }
    }

}
// end


$("#show_advbtn, #show_advbtn2").on('click', function () {
    $(".dropdown-content").show();
});


// categories page responsive side add close  scripts 

$(".filter_open_btn_2").on('click', function () {
    $(".sidebar_content_details.style3").addClass("sidebar_ml0");

});

$(".filter_closed_btn").on('click', function () {
    $(".sidebar_content_details.style3").removeClass("sidebar_ml0");
});

if ($(window).width() < 992) {
    $(".sidebar_content_details.style3").removeClass("sidebar_ml0");
}

function chatWidth() {
    if ($(window).width() < 992) {

        // $('.contact_sidebar').addClass('contact_sidebar_div');
        $(".back-opt").css('display', 'none');

        $(".backtomove_cont").on('click', function () {
            $(".contact_sidebar").css('transform', 'translate(11px)');

            $(".back-opt").css('display', 'none');
        });

        $(".move_to-contact").on('click', function () {
            $(".contact_sidebar").css('transform', 'translate(-200%)');
            $(".back-opt").css('display', 'flex');
        });
    }
}


$(document).ready(function () {

    chatWidth();


});


/*Scroll to top when arrow up clicked BEGIN*/
$(window).scroll(function() {
var height = $(window).scrollTop();
if (height > 500) {
$('.scrollToHome').fadeIn();
} else {
$('.scrollToHome').fadeOut();
}
});
$(".scrollToHome").click(function(event) {
event.preventDefault();
$("html, body").animate({ scrollTop: 0 }, "slow");
return false;
});
// });
/*Scroll to top when arrow up clicked END*/




// inital page is load scroll to  top script

window.scrollTo({ top: 0, behavior: 'smooth' });

//end



// modal inside radio box working script 
 $(' .radioboxstyle input.custom-control-input').on('change', function () {
           $(' .radioboxstyle input.custom-control-input ').not(this).prop('checked', false);
           if ($(this).prop('checked') == true) {
              $('.custom-control-label').removeClass("primary_clr");
              $(this).parent().children('.custom-control-label').addClass("primary_clr");
           } else {
              $('.custom-control-label').removeClass("primary_clr");
           }
    
        });

// end

$(document).ready(function () { 
    // alert('hiih');
         var a = $(".wids").outerWidth();

      $(".make_fix").css('width', parseInt(a) - 10);

   });
   
   

   