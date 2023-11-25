$(function() {
    // $('.datepicker').datepicker();
    //Datatable
    $("#links_datatable").DataTable({
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
            url: '/admin/links/datatable',
            type: 'POST'
        },
        columns: [
            { data: 'id' },
            { data: 'links' },
            { data: 'key' },
            { data: 'created_at' },
             {
                render: function (data, type, row) {
                    return '<button onclick="b_edit('+row.id+', \''+row.links+'\', \''+row.key+'\',)" class="btn btn-warning btn-sm me-2 my-1" type="button">编辑/Edit</button> <button onclick="b_delete('+row.id+')" class="btn btn-danger btn-sm my-1" type="button">删除/Delete</button>';
                },
                orderable: false
            },
        ]
    });

});
//for toast (notifications)
var toasttarget = document.getElementById('liveToast');
var toast1 = new bootstrap.Toast(toasttarget , []);

function b_edit(id, links,key){
    clear_form();
    $("#crud_form").show();
    $("#crud_label").html("編輯連結 / Edi links");
    $("#action_type").val(id);
    $("#links").val(links);
    $("#key").val(key);
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
    $.post("/admin/links/save_data",
    {
        links: $('#links').val(),
        key: $('#key').val(),
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
            $('#links_datatable').DataTable().ajax.reload();
            $("#toast_msg").html(data.toast);
            toast1.show();
            clear_form();
            $("#crud_form").hide();
        }
        spinner()
        //alert("Data: " + data + "\nStatus: " + status);
    });
}


function b_delete(id){
    $.confirm({
        title: 'Delete Data id '+id,
        icon: 'bi-exclamation-circle',
        content: '你要从数据库中删除数据 / You are about to delete data from the database',
        autoClose: 'cancelAction|10000',
        type: 'red',
        escapeKey: 'cancelAction',
        buttons: {
            confirm: {
                btnClass: 'btn-red',
                text: 'Delete  data',
                action: function(){
                    $.post("/admin/links/delete_data",
                    {
                        id: id,
                    },
                    function(data){
                        if(data.status == 0)
                        {
                            $.alert({
                                title: '錯誤',
                                icon: 'bi-exclamation-circle',
                                type: 'red',
                                content: data.message,
                            });
                        } else {
                            $('#links_datatable').DataTable().ajax.reload();
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

function clear_form()
{
    $('#links').val('');
    $('#key').val('');
}

function b_add(){
    clear_form();
    $("#crud_form").show();
    $("#crud_label").html("Create Links");
    $("#action_type").val("add");
}
