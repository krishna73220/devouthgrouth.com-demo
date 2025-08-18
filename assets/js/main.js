$(document).ready(function () {
    // Toggle navbar on button click
    $('.navbar-toggler').on('click', function () {
        $('#navbarNav').toggleClass('show');
    });

    // Close button functionality
    $('.close-btn').on('click', function () {
        $('#navbarNav').removeClass('show');
    });

    // Toggle dropdown menu on click
    $('.nav-menus > a').on('click', function (e) {
        e.preventDefault();
        $(this).parent().toggleClass('open').find('.dropdown-menu').slideToggle();
    });

    // Header Scroll for Desktop
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 50) {
            $('.navbar').addClass('header-scrolled');
        } else {
            $('.navbar').removeClass('header-scrolled');
        }
    });
});


// dg counter here
$(document).ready(function () {
    $('.counter').each(function () {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).data('count')
        }, {
            duration: 4000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now) + '+');
            }
        });
    });
});
// dg counter ended here

// dg offer services crowsel started here

// offer services crowsel ended here
// For dg seo partner area started here

// $(document).ready(function(){
//     console.log('dg seo partner carousel is working');
//     $('.owl-carousel.partner-carousel').owlCarousel({
//         loop: true,
//         autoplay: true,
//         margin: 30,
//         nav: false, // Hide navigation buttons
//         autoplayTimeout: 3000,
//         smartSpeed: 1000,
//         dots: false,
//         responsive: {
//             0: {
//                 items: 2
//             },
//             600: {
//                 items: 3
//             },
//             1000: {
//                 items: 6
//             }
//         }
//     });
// });

// For dg seo partner area ended here
  $(document).ready(function () {
    // Show or hide the scroll-up button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) { // Adjust the number based on when you want the button to appear
            $('#scrollUpBtn').addClass('active-scroll');
        } else {
            $('#scrollUpBtn').removeClass('active-scroll');
        }
    });

    // Smooth scroll to top
    $('#scrollUpBtn').click(function (e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, 800); // Adjust the scroll speed if needed
        return false;
    });
});

// **** 7 years exp. ***********************************

$(document).ready(function () {
    console.log('Carousel for niwax-logo-slider initialized');

    $('.niwax-logo-slider.owl-carousel').owlCarousel({
      loop: false,
      autoplay: true,
      margin: 20,
      nav: false,
      autoplayTimeout: 3000,
      smartSpeed: 1000,
      dots: false,
      responsive: {
        0: {
          items: 2
        },
        600: {
          items: 3
        },
        1000: {
          items: 4
        }
      }
    });
  });

/*
Project Name: DG Digital
Author: Er. Hrisheekesh Kumar (https://www.instagram.com/kumarhrisheekesh/)
Author URI: https://www.dgdigital.in/
Description: Best Software Comapny In Ptana
*/