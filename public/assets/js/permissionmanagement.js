$(function() {
    //Datatable
    $("#permission_datatable").DataTable({
        dom: 'Bfrtip',
        pageLength: 50,
        lengthMenu: [
            [10, 25, 50, 100, 250],
            [10, 25, 50, 100, 250],
        ],
        buttons: [
            {
                extend:'copy',
                exportOptions:{
                    columns: [ 0, 1, 2, 3, 4 ]
                }
            }, 
            {
                extend:'csv',
                exportOptions:{
                    columns: [ 0, 1, 2, 3, 4 ]
                }
            }, 
            {
                extend:'excel',
                exportOptions:{
                    columns: [ 0, 1, 2, 3, 4 ]
                }
            }, 
            {
                extend:'pdf',
                exportOptions:{
                    columns: [ 0, 1, 2, 3, 4 ]
                }
            }, 
            {
                extend:'print',
                exportOptions:{
                    columns: [ 0, 1, 2, 3, 4 ]
                }
            }, 
            'pageLength'
        ],
        processing: true,
        serverSide: true,
        paging: true,
        ajax: {
            url: '/permissionmanagement/datatable',
            type: 'POST'
        },
        columns: [
            { data: 'id' },
            { data: 'controller_method' },
            { data: 'perm_desc' },
            { data: 'created_at' },
            { data: 'updated_at' },
            {
                render: function (data, type, row) {
                    return '<button onclick="b_edit('+row.id+', \''+row.controller_method+'\', `'+row.perm_desc+'`)" class="btn btn-warning btn-sm me-2 my-1" type="button">编辑/Edit</button> <button onclick="b_delete('+row.id+', \''+row.controller_method+'\')" class="btn btn-danger btn-sm my-1" type="button">删除/Delete</button>';
                },
                orderable: false
            },
        ]
    });

});
//for toast (notifications)
var toasttarget = document.getElementById('liveToast');
var toast1 = new bootstrap.Toast(toasttarget , []);

function b_edit(id, controller_method, perm_desc){
    clear_form();
    $("#crud_form").show();
    $("#crud_label").html("编辑权限 / Edit Permission "+id);
    $("#action_type").val(id);
    $("#controller_method").val(controller_method);
    $("#perm_desc").val(perm_desc);

    $('html, body').animate({
        scrollTop: $("body").offset().top
    }, 500);
}

function b_delete(id, controller_method){
    $.confirm({
        title: 'Delete Data id '+id,
        icon: 'bi-exclamation-circle',
        content: '您要从数据库中删除'+controller_method+'数据。 / You are about to delete '+controller_method+' data from the database',
        autoClose: 'cancelAction|10000',
        type: 'red',
        escapeKey: 'cancelAction',
        buttons: {
            confirm: {
                btnClass: 'btn-red',
                text: 'Delete '+controller_method+' data',
                action: function(){
                    $.post("/permissionmanagement/delete_data",
                    {
                        id: id,
                        controller_method: controller_method,
                    },
                    function(data, status){
                        if(data.status == 0)
                        {
                            $.alert({
                                title: 'Error',
                                icon: 'bi-exclamation-circle',
                                type: 'red',
                                content: data.message,
                            });
                        } else {
                            $('#permission_datatable').DataTable().ajax.reload();
                            $("#toast_msg").html(data.toast);
                            toast1.show();
                        }
                    });
                }
            },
            cancelAction: {
                text: 'Cancel'
            }
        }
    });
}

function b_add(){
    clear_form();
    $("#crud_form").show();
    $("#crud_label").html("添加权限 / Add Permission");
    $("#action_type").val("add");
}

function b_cancel()
{
    clear_form();
    $("#crud_form").hide();
}

function b_submit()
{
    spinner()
    $.post("/permissionmanagement/save_data",
    {
        controller_method: $('#controller_method').val(),
        perm_desc: $('#perm_desc').val(),
        action_type: $('#action_type').val(),
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
            $('#permission_datatable').DataTable().ajax.reload();
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
    $('#controller_method').val('');
    $('#perm_desc').val('');
    $('#action_type').val('');
}

function spinner() {
  if ($(".spin").hasClass("d-none")) {
    $(".spin").removeClass("d-none")
  } else {
    $(".spin").addClass("d-none")
  }
}