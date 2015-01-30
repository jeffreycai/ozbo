jQuery(function($){

  /* homepage scroll */
  $('.home .jumbotron .btn').click(function(event){
    event.preventDefault();
    scrollTo($('#steps1'));
  });
  
  /* booking form modals */
//  $("#ticketModalFailed").modal();
//  $("#ticketModalSuccess").modal();

  /**
   * Scroll to an element
   * 
   * @param {type} elem
   * @returns {undefined}
   */
  function scrollTo($elem) {
    $('html, body').animate({
        scrollTop: ($elem.offset().top - 50)
    }, 400);
  }
});


/**
 * function to test email format
 * 
 * @param {type} email
 * @returns {@exp;regex@call;test}
 */
function isEmail(email) {
  var regex = /^[^\@]+\@[^\@]+\.[^\@]+$/;
  return regex.test(email);
}

