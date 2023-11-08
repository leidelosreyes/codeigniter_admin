$(function() {
    //Datatable
    $("#role_datatable").DataTable({
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
                    columns: [ 0, 1, 2, 3 ]
                }
            }, 
            {
                extend:'csv',
                exportOptions:{
                    columns: [ 0, 1, 2, 3 ]
                }
            }, 
            {
                extend:'excel',
                exportOptions:{
                    columns: [ 0, 1, 2, 3 ]
                }
            }, 
            {
                extend:'pdf',
                exportOptions:{
                    columns: [ 0, 1, 2, 3 ]
                }
            }, 
            {
                extend:'print',
                exportOptions:{
                    columns: [ 0, 1, 2, 3 ]
                }
            }, 
            'pageLength'
        ],
        processing: true,
        serverSide: true,
        paging: true,
        ajax: {
            url: '/rolemanagement/datatable',
            type: 'POST'
        },
        columns: [
            { data: 'id' },
            { data: 'role_name' },
            { data: 'role_desc' },
            { data: 'permission_id'},
            { data: 'created_at' },
            { data: 'updated_at' },
            {
                render: function (data, type, row) {
                    return '<button onclick="b_edit('+row.id+', \''+row.role_name+'\', `'+row.role_desc+'`, \''+row.permission_id+'\' )" class="btn btn-warning btn-sm me-2 my-1" type="button">编辑/Edit</button> <button onclick="b_delete('+row.id+', \''+row.role_name+'\')" class="btn btn-danger btn-sm my-1" type="button">删除/Delete</button>';
                },
                orderable: false
            },
        ]
    });

});
//for toast (notifications)
var toasttarget = document.getElementById('liveToast');
var toast1 = new bootstrap.Toast(toasttarget , []);

function b_edit(id, role_name, role_desc, permission_id){
    clear_form();
    $("#crud_form").show();
    $("#crud_label").html("编辑角色 / Edit Role "+id);
    $("#action_type").val(id);

    $("#role_name").val(role_name);
    $("#role_desc").val(role_desc);
    var arrayValues = permission_id.split(',');
    $.each(arrayValues, function(i, val){
        $("input[id='perm_" + val + "']").prop('checked', true);
    });

    $('html, body').animate({
        scrollTop: $("body").offset().top
    }, 500);
}

function b_delete(id, role_name){
    $.confirm({
        title: 'Delete Data id '+id,
        icon: 'bi-exclamation-circle',
        content: '您将从数据库中删除'+role_name+'的数据 / You are about to delete '+role_name+' data from the database',
        autoClose: 'cancelAction|10000',
        type: 'red',
        escapeKey: 'cancelAction',
        buttons: {
            confirm: {
                btnClass: 'btn-red',
                text: 'Delete '+role_name+' data',
                action: function(){
                    $.post("/rolemanagement/delete_data",
                    {
                        id: id,
                        role_name: role_name,
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
                            $('#role_datatable').DataTable().ajax.reload();
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
    $("#crud_label").html("添加角色 / Add Role");
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
    var permission_id = $("#perm_list input:checkbox:checked").map(function(){
        return $(this).val();
    }).get();

    $.post("/rolemanagement/save_data",
    {
        role_name: $('#role_name').val(),
        role_desc: $('#role_desc').val(),
        permission_id: permission_id,
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
            $('#role_datatable').DataTable().ajax.reload();
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
    $('#role_name').val('');
    $('#role_desc').val('');
    $('input:checkbox').removeAttr('checked');
    $('input[name="permission_list"]').each(function() {
        this.checked = false;
    });
    $('#action_type').val('');
}
function spinner() {
  if ($(".spin").hasClass("d-none")) {
    $(".spin").removeClass("d-none")
  } else {
    $(".spin").addClass("d-none")
  }
}
