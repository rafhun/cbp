// smooth scrolling  by https://css-tricks.com/snippets/jquery/smooth-scrolling/
$(function() {
  var offsetTop = 10;
  $('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') === this.pathname.replace(/^\//,'') && location.hostname === this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top - offsetTop
        }, 1000);
        return false;
      }
    }
  });

  var linkHash = window.location.hash;
  if (linkHash) {
    $(linkHash).click();
  }
});
