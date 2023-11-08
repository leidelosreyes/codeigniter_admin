$(function() {
    // for onload events
});
//for toast (notifications)
var toasttarget = document.getElementById('liveToast');
var toast1 = new bootstrap.Toast(toasttarget , []);

function b_submit()
{
    spinner();
    $.post("/myprofile/save_data",
    {
        username: $('#username').val(),
        email: $('#email').val(),
        password: $('#password').val(),
        passconf: $('#passconf').val(),
        gsecret: $('#gsecret').val(),
        action_type: $('#action_type').val(),
        role_id: $('#role_id').val()
    },
    function(data, status){
        if(data.status == 0)
        {
            $.alert({
                title: 'Error',
                icon: 'bi-exclamation-circle',
                type: 'red',
                content: data.validation,
            });
        } else {
            $("#toast_msg").html(data.toast);
            toast1.show();
        }
        spinner();
    });
}

function b_gcode()
{   
    spinner()
    $.get("/usermanagement/getGAuth", function(data, status){
        $("#gsecret").val(data.gsecret);
        $("#toast_msg").html(data.toast);
        $("#gimg").attr("src", data.gimg);
        toast1.show();
        spinner()
    });
    
}


function spinner() {
  if ($(".spin").hasClass("d-none")) {
      $(".spin").removeClass("d-none")
  } else {
      $(".spin").addClass("d-none")
  }
}
