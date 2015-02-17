/**
 * Enhances a checkbox to display a lock which opens or closes when clicked.
 * @param elem the input to expand
 */
var Lock = function(elem, callback) {
  var $ = $J;

  elem = $(elem);
  elem.hide();

  var isChecked = elem.attr('checked') == 'checked';
  
  var span = $('<span></span>');
  span.addClass('cx-lock');

  span.insertAfter(elem);
  //move the element inside our span
  elem.appendTo(span);

  //sets the right css classes.
  var styleLock = function(isClosed) {
    if(isClosed){
      span.removeClass('cx-lock-open');
      span.addClass('cx-lock-closed');
    }
    else { //not checked
      span.removeClass('cx-lock-closed');
      span.addClass('cx-lock-open');
    }      
  }; 

  styleLock(isChecked);

  span.bind('click', function() {
    isChecked = !isChecked;
    styleLock(isChecked);

    var val = '';
    if(isChecked)
      val = 'checked';
    elem.attr('checked', val);

    callback(isChecked);
  });

  return {
      isLocked: function() {
          return isChecked;
      }
  };
};