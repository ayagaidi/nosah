;
(function($) {
  'use strict';

  $(document).ready(function() {

    //variables
    const testimonials = $('.testimonials');
    const testimonials2 = $('.testimonials2');
    const testimonials3 = $('.testimonials3');
    const screenshorts = $('.screenshorts');
    const screenshorts7 = $('.screenshorts7');
    const testimonialsRTL = $('.testimonials-rtl');
    const selecteEffect = $('.ns select')
    const logos = $('.logos');

    //Testimonial
    if (testimonials.length > 0) {
      testimonials.owlCarousel({
        loop: true,
        nav: false,
        dots: false,
        responsiveClass: true,
        responsive: {
          0: {
            items: 1,
          },
          600: {
            items: 2
          },
          1000: {
            items: 3
          }
        }
      })
    }

    //Testimonial 2
    if (testimonials2.length > 0) {
      testimonials2.owlCarousel({
        loop: true,
        nav: true,
        navText: ["<i class='far fa-long-arrow-left'></i>", "<i class='far fa-long-arrow-right'></i>"],
        dots: false,
        responsiveClass: true,
        responsive: {
          0: {
            items: 1,
          },
          600: {
            items: 2
          },
          1000: {
            items: 3
          }
        }
      })
    }

    //Testimonial 3
    if (testimonials3.length > 0) {
      testimonials3.owlCarousel({
        loop: true,
        nav: false,
        dots: false,
        responsiveClass: true,
        margin: 30,
        items: 1
      })
    }

    //Screenshort
    if (screenshorts.length > 0) {
      screenshorts.owlCarousel({
        loop: true,
        nav: false,
        dots: false,
        responsiveClass: true,
        margin: 0,
        responsive: {
          0: {
            items: 1,
          },
          600: {
            items: 2
          },
          1000: {
            items: 4
          }
        }
      })
    };

    //Screenshort 7
    if (screenshorts7.length > 0) {
      screenshorts7.owlCarousel({
        loop: true,
        nav: true,
        dots: false,
        navText: ["<i class='fal fa-long-arrow-left'></i>", "<i class='fal fa-long-arrow-right'></i>"],
        responsiveClass: true,
        margin: 0,
        responsive: {
          0: {
            items: 1,
          },
          600: {
            items: 2
          },
          1000: {
            items: 4
          }
        }
      })
    };


    // Testimonial RTL
    if (testimonialsRTL.length > 0) {
      testimonialsRTL.slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        rtl: true,
        arrows: false,
        autoplay: true
      })
    }

    //Logo Carousel
    if (logos.length > 0) {
      logos.owlCarousel({
        loop: true,
        nav: false,
        dots: false,
        responsive: {
          0: {
            items: 2
          },
          600: {
            items: 3
          },
          1000: {
            items: 6
          }
        }
      })
    }

    // Nice Select active
    if (selecteEffect.length > 0) {
      selecteEffect.niceSelect();
    }


    //Aos animation
    AOS.init({
      once: true,
      disable: 'mobile'
    });


    //dropdown menu
    const dropdownAngkor = $('li.dropdown > a');
    const dropdown = $('li.dropdown');
    dropdownAngkor.on('click', function(e) {
      e.preventDefault();
      $(this).parent(dropdown).toggleClass('active');
    });

    const hasParrentDropdownAngkor = $('li.has-parrent-dropdown > a');
    const hasDropdownChildren = $('li.has-parrent-dropdown');
    hasParrentDropdownAngkor.on('click', function(e) {
      e.preventDefault();
      $(this).parent(hasDropdownChildren).toggleClass('active');
    });

    //mega menu

    const megamenu = $('li.mega-menu');;
    const megamenuList = $('li.mega-menu > a');
    const megaMenuItems = $('.mega-menu-list');
    megamenuList.on('click', function(e) {
      e.preventDefault();
      $(this).parent(megamenu).toggleClass('active');
      megaMenuItems.toggleClass('active');
    })


    // scroll function
    var scrollFunc = $('#scroll a[href*="#"], a.up-btn');
    var bodyAnimate = $('html, body');
    scrollFunc.on('click', function() {
      bodyAnimate.animate({
          scrollTop: $($(this).attr('href')).offset().top,
        },
        1000,
        'linear'
      )
    })

    // Product Slide
    if ($('.gallery-thumbs').length > 0) {
      var galleryThumbs = new Swiper('.gallery-thumbs', {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
      });
      var galleryTop = new Swiper('.gallery-top', {
        spaceBetween: 10,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
        thumbs: {
          swiper: galleryThumbs
        }
      });

    }


    //price swiper slider
    if ($('.price7').length > 0) {

      var swiper = new Swiper(".price7", {
        effect: "coverflow",
        grabCursor: true,
        loop: true,
        centeredSlides: true,
        slidesPerView: "auto",
        coverflowEffect: {
          rotate: 0,
          stretch: 0,
          depth: 250,
          modifier: 1,
          slideShadows: true,
        },

      });
    }

    //Product quantity
    $('.minus').click(function() {
      var $input = $(this).parent().find('input');
      var count = parseInt($input.val()) - 1;
      count = count < 1 ? 1 : count;
      $input.val(count);
      $input.change();
      return false;
    });
    $('.plus').click(function() {
      var $input = $(this).parent().find('input');
      $input.val(parseInt($input.val()) + 1);
      $input.change();
      return false;
    });


    if ($('.videoPlay-hero3').length > 0) {
      $(".videoPlay-hero3").modalVideo();
    }
    if ($('.video-btn-blog').length > 0) {
      $(".video-btn-blog").modalVideo();
    }
    if ($('.video-video-btn').length > 0) {
      $(".video-video-btn").modalVideo();
    }



  })

  //load function
  $(window).on('load', function() {

    //preloader initalize
    function preloaderFunc() {
      const preloader = $('.preloader');
      if (preloader.length) {
        preloader.delay(200).fadeOut(500);
      }
    }
    preloaderFunc();

  });

})(window.jQuery);
