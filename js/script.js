// Recommend Plan
//========================//

jQuery(function($){
  $('#rec-slick').slick({
        autoplay: true, // PC
        dots:false,
        slidesToShow: 3,
        slidesToScroll: 1,
        fade: false,
        centerMode: true,
        centerPadding: '100px',
        pauseOnHover: true,
        swipe: true,
        arrows: false,
        autoplaySpeed: 5000,
        speed: 1000,
        cssEase: 'ease',
        responsive: [
        {
        breakpoint: 767,  // SP
            settings: {
            fade: false,
            slidesToShow: 1,
            centerMode: true,
            centerPadding: 0,
            }
        },
    ]});
});

// FAQ
//========================//

jQuery(function($){
  $(".js-accordion .title").on( 'click', function() {
    $(this).next().slideToggle();
        return false;
    });
});

// Nav
//========================//

jQuery(function($){
  $(".js-hamburger").on( 'click', function() {
    $(this).toggleClass('-active');
    $('.nav-wrap').toggleClass('-active');
    });
});

// Animation
//========================//
jQuery(function(){
    new WOW().init();
});
