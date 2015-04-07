// script for the off-canvas toggle
jQuery(document).ready(function($) {
  var transformer = $('.transformer'),
    menuToggle = $('.off-canvas-toggle'),
    linkItem = $('.js-oc-link'),
    content = $('.content-container'),
    subMenu = $('.menu');

  menuToggle.on('click', function(e) {
    e.preventDefault();
    
    $('html,body').animate({
      scrollTop: 0
    }, 1000);

    transformer.toggleClass('in');
  }); // end menuToggle.on click

  
  content.click(function() {
    if (transformer.hasClass('in')) {
      transformer.removeClass('in');
    }
  }); // end content.click

  // add the back link to all submenus since contrexx is to stupid to do it automatically
  subMenu.prepend('<li class="off-canvas-list-item"><a href="#" class="js-oc-up off-canvas-link icon-back">Zurück</a></li>');
  subMenu.on('click', '.js-oc-up', function(e) {
    var $this = $(this);
    e.preventDefault();
    // alert('test');
    $this.parent().parent().removeClass('in');
  }); // end upLink.on click

  linkItem.on('click', function(e) {
    var $this = $(this);
    if ($this.siblings('.menu').length) {
      e.preventDefault();
      $this.siblings('.menu').toggleClass('in');
    } else {
      return true;
    }
  }); // end linkItem.on click
}); // end ready
