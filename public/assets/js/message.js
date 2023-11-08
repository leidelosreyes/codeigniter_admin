$(function() {
    // $('.datepicker').datepicker();
    //Datatable
    $("#message_datatable").DataTable({
        // order: [[3, 'desc']],
        dom: 'Bfrtip',
        pageLength: 50,
        lengthMenu: [
            [10, 25, 50, 100, 250],
            [10, 25, 50, 100, 250],
        ],
        processing: true,
        serverSide: true,
        paging: true,
        ajax: {
            url: '/message/datatable',
            type: 'POST'
        },
        columns: [
            { data: 'id' },
            { data: 'mobile_number' },
            { data: 'created_at' }
        ]
    });

});
//for toast (notifications)
var toasttarget = document.getElementById('liveToast');
var toast1 = new bootstrap.Toast(toasttarget , []);

function b_add_csv()
{
    $('#csv_file').val("");
    $("#upload_form").show();
    $("#crud_form").hide();
}

function b_down_csv()
{
    $("#upload_form").hide();
    $("#crud_form").show();
}

function b_cancel_csv()
{
    $('#csv_file').val("");
    $("#upload_form").hide();
    $("#crud_form").hide();
}

function b_submit_csv() {
    var form = $('#upform')[0];
    var data = new FormData(form);

    $('#csv_submit_btn').prop('disabled', true);  
    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "/message/save_data_csv",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function (data) {
            if(data.status == 0)
            {
                $.alert({
                    title: 'Error',
                    icon: 'bi-exclamation-circle',
                    type: 'red',
                    content: data.validation,
                });
            } else {
                $.alert({
                    title: 'Batch Upload (CSV) Complete.',
                    content: data.result,
                    icon: 'bi-info-circle',
                    type: 'blue',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    buttons: {
                        okay: {
                            text: 'Okay',
                            btnClass: 'btn-primary'
                        }
                    }
                });
                $('#message_datatable').DataTable().ajax.reload();
                clear_form();
            }
            $('#csv_submit_btn').prop('disabled', false);
            spinner();
        },
        error: function (e) {
            $.alert({
                title: 'Error',
                icon: 'bi-exclamation-circle',
                type: 'red',
                content:'发生了一个意外的错误。请联系您的服务器管理员。 / An unexpected error has occured. Please contact your server administrator.',
            });
            $('#csv_submit_btn').prop('disabled', false);
            spinner();
        }
        
    });    
}

function spinner() {
    if ($("#spineradmin").hasClass("d-none")) {
        $("#spineradmin").removeClass("d-none");
    } else {
        $("#spineradmin").addClass("d-none");
    }
}

function clear_form()
{
    $('#message').val('');
    $('#csv_file').val('');
}