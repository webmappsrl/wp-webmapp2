jQuery(document).ready(function( $ ) {

  if($('body').hasClass('login-action-lostpassword')){
    var close = getUrlParameter('webmapp_close');
    language = document.documentElement.lang;
    if(close == 'true'){
      $('#lostpasswordform').hide();
      $('p.message').html(webmapp_login_text[language].data.check_email);
    }
  }

  if($('body').hasClass('login-action-resetpass')){
    var action = getUrlParameter('action');
    if( action == 'resetpass' ) {
      $('<p class="message">La password è stata reimpostata.</p>').appendTo('div#login')

    }
  }
});


var getUrlParameter = function getUrlParameter(sParam) {
  var sPageURL = decodeURIComponent(window.location.search.substring(1)),
    sURLVariables = sPageURL.split('&'),
    sParameterName,
    i;

  for (i = 0; i < sURLVariables.length; i++) {
    sParameterName = sURLVariables[i].split('=');

    if (sParameterName[0] === sParam) {
      return sParameterName[1] === undefined ? true : sParameterName[1];
    }
  }
};