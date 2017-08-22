
// @codekit-prepend 'lib/jquery.1.12.4.js'

/* We bind a submit function to the form once it has been submitted */

$("form").submit(function (event) {

  /* In order to prevent the page from reloading which is the default action when a form is submitted we add the following line */

  event.preventDefault();

  /* This is where we define our Ajax call to our PHP script which does all the work for us */

  $.ajax({
    url: "submit.php",
    method: "POST",
    data: $("#form").serialize(),
    dataType: "json",

    /* Before we send the form data to our PHP script we are going to display our loading screen to show the user that something is happening behind the scenes */

    beforeSend: function () {
      $("body").animate({
          scrollTop: 0 
      }, "fast");

      $(".loader").fadeIn();
      $("body").css("overflow", "hidden");
    },

    /* Once our PHP script is done, it will send us a JSON encoded response, this is where we will check what response we received and display the apporiate message */

    complete: function (data) {

      if (data.responseJSON.nameError != undefined) {

        /* If there is an error, we will display it and reset the Google reCAPTCHA */

        $(".message").removeClass("success");
        $(".message").fadeOut(function () {
          $(".message").html(data.responseJSON.nameError).addClass("error").fadeIn();
        });

        grecaptcha.reset();

      } else if (data.responseJSON.emailError != undefined) {

        $(".message").removeClass("success");
        $(".message").fadeOut(function () {
          $(".message").html(data.responseJSON.emailError).addClass("error").fadeIn();
        });
        grecaptcha.reset();

      } else if (data.responseJSON.captchaError != undefined) {

        $(".message").removeClass("success");
        $(".message").fadeOut(function () {
          $(".message").html(data.responseJSON.captchaError).addClass("error").fadeIn();
        });
        grecaptcha.reset();

      } else if (data.responseJSON.mailChimpMessage != undefined) {

        $(".message").removeClass("success");
        $(".message").fadeOut(function () {
          $(".message").html(data.responseJSON.mailChimpMessage).addClass("success").fadeIn();
        });
        grecaptcha.reset();

      } else if (data.responseJSON.agreeError != undefined) {

        $(".message").removeClass("success");
        $(".message").fadeOut(function () {
          $(".message").html(data.responseJSON.agreeError).addClass("error").fadeIn();
        });
        grecaptcha.reset();

      }

      /* Once we have gone through all the possible responses and displayed the appropriate message we can hide the loading screen */

      $(".loader").fadeOut();
      $("body").css("overflow", "scroll");

    }
  });

});











