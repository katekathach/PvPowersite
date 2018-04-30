var loginCheck;

$(document).ready( function() {
   initCheckLogin();
});

function initCheckLogin()
{
   loginCheck = setInterval( function() { checkLogin(); }, 1000);
   
}

function checkLogin()
{
   data = "a=cl";
   $.post('js/ajax.php', data, function(response) {
      var loggedIn = jQuery.parseJSON( response );
      if(loggedIn.success)
      {
         clearInterval(loginCheck);
         closeLogin();
      }
   });
}

function closeLogin()
{
   $('#loading').hide();
   $('#successMessage').show();
   if(window.opener != null)
      window.opener.closeLoginWindow();
}