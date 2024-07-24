$(function() {
    //Datatable
    $("#gbhvip399_datatable").DataTable({
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
            url: '/gbhvip399/datatable',
            type: 'POST'
        },
        columns: [
            { data: 'id' },
            { data: 'item' },
            { data: 'value' },
            { data: 'title'},
            { data: 'created_at' },
            { data: 'updated_at' },
            {
                render: function (data, type, row) {
                    return '<button onclick="b_edit('+row.id+', \''+row.item+'\', `'+row.value+'`, `'+row.title+'` )" class="btn btn-warning btn-sm me-2 my-1" type="button">编辑/Edit</button> <button onclick="b_delete('+row.id+', \''+row.value+'\')" class="btn btn-danger btn-sm my-1" type="button">删除/Delete</button>';
                },
                orderable: false
            },
        ],
    });

   

});
//for toast (notifications)
var toasttarget = document.getElementById('liveToast');
var toast1 = new bootstrap.Toast(toasttarget , []);

function b_edit(id, item, value, title){
    clear_form();
    $("#crud_form").show();
    $("#crud_label").html("Edit Config "+id);
    $("#action_type").val(id);

    $("#item").val(item);
    $("#value").val(value);
    $("#title").val(title);

    $('html, body').animate({
        scrollTop: $("body").offset().top
    }, 500);
}

function b_delete(id, value){
    $.confirm({
        title: 'Delete Data id '+id,
        icon: 'bi-exclamation-circle',
        content: '您将从数据库中删除'+value+'的数据',
        autoClose: 'cancelAction|10000',
        type: 'red',
        escapeKey: 'cancelAction',
        buttons: {
            confirm: {
                btnClass: 'btn-red',
                text: 'Delete  data',
                action: function(){
                    $.post("/gbhvip399/delete_data",
                    {
                        id: id,
                        name: value,
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
                            $('#gbhvip399_datatable').DataTable().ajax.reload();
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
    $("#crud_label").html("Add Config");
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
    
    $.post("/gbhvip399/save_data",
    {
        item: $('#item').val(),
        value: $('#value').val(),
        title: $('#title').val(),
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
            $('#gbhvip399_datatable').DataTable().ajax.reload();
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
    $('#item').val('');
    $('#value').val('');
    $('#title').val('');
    $('#action_type').val('');
}
function spinner() {
  if ($(".spin").hasClass("d-none")) {
    $(".spin").removeClass("d-none")
  } else {
    $(".spin").addClass("d-none")
  }
}
