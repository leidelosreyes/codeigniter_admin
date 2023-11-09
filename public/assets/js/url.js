$(function() {
    // $('.datepicker').datepicker();
    //Datatable
    $("#url_datatable").DataTable({
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
            url: '/admin/url/datatable',
            type: 'POST'
        },
        columns: [
            { data: 'id' },
            { data: 'base_url' },
            { data: 'created_at' },
             {
                render: function (data, type, row) {
                    return '<button onclick="b_edit('+row.id+', \''+row.base_url+'\')" class="btn btn-warning btn-sm me-2 my-1" type="button">编辑/Edit</button>';
                },
                orderable: false
            },
        ]
    });

});
//for toast (notifications)
var toasttarget = document.getElementById('liveToast');
var toast1 = new bootstrap.Toast(toasttarget , []);

function b_edit(id, base_url){
    clear_form();
    $("#crud_form").show();
    $("#crud_label").html("编辑用户");
    $("#action_type").val(id);
    $("#url").val(base_url);
}

function spinner() {
    if ($("#spineradmin").hasClass("d-none")) {
        $("#spineradmin").removeClass("d-none");
    } else {
        $("#spineradmin").addClass("d-none");
    }
}

function b_cancel()
{
    clear_form();
    $("#crud_form").hide();
}
function b_submit()
{
    spinner()
    $.post("/admin/url/save_data",
    {
        url: $('#url').val(),
        id: $("#action_type").val()
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
            $('#url_datatable').DataTable().ajax.reload();
            $("#toast_msg").html(data.toast);
            toast1.show();
            clear_form();
            $("#crud_form").hide();
        }
        spinner()
        //alert("Data: " + data + "\nStatus: " + status);
    });
}

function clear_form()
{
    $('#url').val('');
}
