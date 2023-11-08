$(function () {
  // place your code
  $("#login_form").submit(function (e) {
    spinner()
    e.preventDefault()
    $.ajax({
      type: "POST",
      url: "/xoy75hZUKrBPCe2",
      data: {
        username: $("#username").val(),
        password: $("#password").val(),
        gsecret: $("#gsecret").val(),
      },
      success: function (result) {
        //console.log(result.status);
        if (result.status == 1) {
          // do redirect here
          window.location.replace("/dashboard")
        }
        if (result.status == 0) {
          $("#form_errors").removeClass("d-none")
        }
        spinner()
      },
    })
  })

  // for form control setfocus
  $(".form-control").focus(function () {
    if (!$("#form_errors").hasClass("d-none")) {
      $("#form_errors").addClass("d-none")
    }
  })
  function spinner() {
    if ($(".login-spinner").hasClass("d-none")) {
      $(".login-spinner").removeClass("d-none")
    } else {
      $(".login-spinner").addClass("d-none")
    }
  }
})
