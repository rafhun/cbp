// script for the off-canvas toggle
jQuery(document).ready(function($) {
  var transformer = $('.transformer'),
    menuToggle = $('.off-canvas-toggle'),
    linkItem = $('.off-canvas-list-item'),
    upLink = $('.off-canvas-up');
    // subMenu = $('.menu');

  menuToggle.on('click', function(e) {
    e.preventDefault();
    transformer.toggleClass('in');
  }); // end menuToggle.on click

  linkItem.on('click', function(e) {
    var $this = $(this);
    if ($this.find('.menu').length) {
      e.preventDefault();
      $this.find('.menu').toggleClass('in');
    } else {
      return true;
    }
  }); // end linkItem.on click

  upLink.on('click', function(e) {
    var $this = $(this);
    e.preventDefault();

    $this.parent('.menu.in').removeClass('in');
  }); // end upLink.on click
}); // end ready
