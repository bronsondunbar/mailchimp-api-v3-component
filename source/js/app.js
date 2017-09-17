
// @codekit-prepend 'lib/jquery.1.12.4.js'

$("form").submit(function (event) {

  event.preventDefault();

  $.ajax({
    url: "submit.php",
    method: "POST",
    data: $("#form").serialize(),
    dataType: "json",

    beforeSend: function () {
      $("body").animate({
          scrollTop: 0 
      }, "fast");

      $(".loader").fadeIn();
      $("body").css("overflow", "hidden");
    },

    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR);
      console.log(textStatus);
      console.log(errorThrown);
    },

    complete: function (data) {

      if (data.responseJSON.nameError != undefined) {

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

        $("#name").val("");
        $("#email").val("");
        $("#userAgree").attr("checked", false);

      } else if (data.responseJSON.agreeError != undefined) {

        $(".message").removeClass("success");
        $(".message").fadeOut(function () {
          $(".message").html(data.responseJSON.agreeError).addClass("error").fadeIn();
        });
        grecaptcha.reset();

      }

      $(".loader").fadeOut();
      $("body").css("overflow", "scroll");

    }
  });

});











