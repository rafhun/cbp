// this script will make the whole teaser box clickable by looking
// for the next link element in its children and loading that href
// upon being clicked

jQuery(document).ready(function($) {
  $('.news-teaser').click(function(e) {
    e.preventDefault();
    // go to the next .news-teaser-text, find a within and extract its href
    var href = $(this).attr('href');
    window.location.href=href;
  });
}); // end ready
