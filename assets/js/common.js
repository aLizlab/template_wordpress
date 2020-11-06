//sp-menu
$(function ($) {
  let scrollPos = 0;
  $('.menu').on('click', function () {
    if ($('body').hasClass('fixed')) {
      $('body').removeClass('fixed').css('top', 0 + 'px');
      window.scrollTo(0, scrollPos);
    } else {
      scrollPos = $(window).scrollTop();
      $('body').addClass('fixed').css('top', -scrollPos + 'px');
    }

    $('.header').toggleClass('header-open');
  });
});