jQuery(document).ready(function ($) {
  $(".owl-carousel.block-product").owlCarousel({
    loop: false,
    margin: 5,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
        nav: false,
      },
      600: {
        items: 2,
        nav: false,
      },
      800: {
        items: 3,
        nav: false,
      },
    },
  });
  $(".owl-carousel.coupon-block").owlCarousel({
    loop: false,
    margin: 10,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
        nav: false,
      },
      800: {
        items: 4,
        nav: false,
      },
    },
  });
  $(".feedback_body").owlCarousel({
    loop: false,
    responsiveClass: true,
    nav: false,
    responsive: {
      0: {
        items: 1,
        nav: false
      }
    },
  });
});
