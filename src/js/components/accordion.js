// defines the accordion functionality. Rudimentary it just toggles
// the class .in on an element on click

jQuery(document).ready(function($) {
  $('.accordion-title').click(function(e) {
    e.preventDefault();
    $(this).toggleClass('in');
  });
}); // end ready
