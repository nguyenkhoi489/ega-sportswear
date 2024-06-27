jQuery(document).ready(function($) {
    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
        slidesToShow: 4,
        infinite: false,
        slidesToScroll: 1,
        vertical:true,
        asNavFor: '.slider-for',
        dots: false,
        focusOnSelect: true,
        verticalSwiping:true,
        responsive: [
        {
            breakpoint: 992,
            settings: {
              vertical: false,
            }
        },
        {
          breakpoint: 769,
          settings: {
            vertical: true,
          }
        },
        {
          breakpoint: 580,
          settings: {
            vertical: true,
          }
        },
        {
          breakpoint: 380,
          settings: {
            vertical: true,
            slidesToShow: 1,
          }
        }
        ]
    });
});