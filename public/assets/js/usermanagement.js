$(function() {
    //Datatable
    $("#user_datatable").DataTable({
        order: [[0, 'asc']],
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
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                }
            }, 
            {
                extend:'csv',
                exportOptions:{
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                }
            }, 
            {
                extend:'excel',
                exportOptions:{
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                }
            }, 
            {
                extend:'pdf',
                exportOptions:{
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                }
            }, 
            {
                extend:'print',
                exportOptions:{
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                }
            }, 
            'pageLength'
        ],
        processing: true,
        serverSide: true,
        paging: true,
        ajax: {
            url: '/usermanagement/datatable',
            type: 'POST'
        },
        columns: [
            { data: 'id' },
            { data: 'username' },
            { data: 'email' },
            { data: 'gsecret' },
            { 
                render: function(data, type, row){
                    var t_role = '';
                    $.each(roles_list, function(index, value){
                        if(value.id == row.role_id){
                            t_role = value.role_name;
                        }
                    })
                    return t_role;
                }
            },
            { data: 'created_at' },
            { data: 'updated_at' },
            {
                render: function (data, type, row) {
                    return '<button onclick="b_edit('+row.id+', \''+row.username+'\', \''+row.email+'\', \''+row.gsecret+'\', \''+row.role_id+'\')" class="btn btn-warning btn-sm me-2 my-1" type="button">编辑/Edit</button> <button onclick="b_delete('+row.id+', \''+row.username+'\')" class="btn btn-danger btn-sm my-1" type="button">删除/Delete</button>';
                },
                orderable: false
            },
        ]
    });

});
//for toast (notifications)
var toasttarget = document.getElementById('liveToast');
var toast1 = new bootstrap.Toast(toasttarget , []);

function b_edit(id, username, email, gsecret, role_id){
    clear_form();
    $("#crud_form").show();
    $("#crud_label").html("编辑用户 / Edit User "+id);
    $("#action_type").val(id);
    $("#username").val(username);
    $("#email").val(email);
    $("#gsecret").val(gsecret);
    $("#role_id").val(role_id);

    $.post("/usermanagement/getGAuthImg",
    {
        secret: gsecret
    },
    function(data, status){
        $("#gimg").attr("src", data.gimg);
    });

    $('html, body').animate({
        scrollTop: $("body").offset().top
    }, 500);


}

function b_delete(id, username){
    $.confirm({
        title: 'Delete Data id '+id,
        icon: 'bi-exclamation-circle',
        content: '你要从数据库中删除'+username+'数据 / You are about to delete '+username+' data from the database',
        autoClose: 'cancelAction|10000',
        type: 'red',
        escapeKey: 'cancelAction',
        buttons: {
            confirm: {
                btnClass: 'btn-red',
                text: 'Delete '+username+' data',
                action: function(){
                    $.post("/usermanagement/delete_data",
                    {
                        id: id,
                        username: username,
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
                            $('#user_datatable').DataTable().ajax.reload();
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
    $("#crud_label").html("添加用户 / Add User");
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
    $.post("/usermanagement/save_data",
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
            $('#user_datatable').DataTable().ajax.reload();
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
    $('#username').val('');
    $('#email').val('');
    $('#password').val('');
    $('#passconf').val('');
    $('#gsecret').val('');
    $('#action_type').val('');
    $("#gimg").attr("src", '');
    $('#role_id').val(0);
}

function b_gcode()
{
    $.get("/usermanagement/getGAuth", function(data, status){
        $("#gsecret").val(data.gsecret);
        $("#toast_msg").html(data.toast);
        $("#gimg").attr("src", data.gimg);
        toast1.show();
    });
}

function spinner() {
  if ($(".spin").hasClass("d-none")) {
    $(".spin").removeClass("d-none")
  } else {
    $(".spin").addClass("d-none")
  }
}