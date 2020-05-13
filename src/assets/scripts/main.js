import $ from 'jquery';

$(".nav_container").load("./components/nav-component.html");
$(".footer_container").load("./components/footer-component.html");

$('.slick').slick({
    infinite: false,
    autoplay: true,
    arrows: false,
    slidesToShow: 3,
    slidesToScroll: 1,
    centerMode: true,
    responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 1,
            slidesToScroll: .5,
            centerMode: false,
          }
        }
      ]
});