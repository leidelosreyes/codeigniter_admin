$(function() {
    //Datatable
    $("#image_datatable").DataTable({
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
            url: '/admin/image/datatable',
            type: 'POST'
        },
        columns: [
            { data: 'id' },
            { data: 'images' },
            { data: 'updated_at' },
            {
                render: function (data, type, row) {
                    var baseURL = window.location.protocol + "//" + window.location.host + "/" + "uploads/";
                    var imageUrl = baseURL + row.images;

                    console.log(imageUrl);
                    return '<button onclick="b_edit('+row.id+', \''+imageUrl+'\')" class="btn btn-warning btn-sm me-2 my-1" type="button">编辑/Edit</button> <button onclick="b_delete('+row.id+')" class="btn btn-danger btn-sm my-1" type="button">删除/Delete</button>  <img src="' +  imageUrl + '" alt="Image"  style="width: 100px; height: 100px;">';
                },
                orderable: false
            },
        ]
    });

});
//for toast (notifications)
var toasttarget = document.getElementById('liveToast');
var toast1 = new bootstrap.Toast(toasttarget , []);

function b_edit(id, imageUrl){
    console.log(imageUrl);
    clear_form();
    $("#crud_form").show();
    $("#crud_label").html("編輯影像 / Edit Image ");
    $("#action_type").val(id);
    $("#images_1").attr("src", imageUrl);
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
                    $.post("/admin/image/delete_data",
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
                            $('#image_datatable').DataTable().ajax.reload();
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
    $("#crud_label").html("Create Image");
    $("#action_type").val("add");
}

function b_cancel()
{
    clear_form();
    $("#crud_form").hide();
}

function b_submit() {
    var formData = new FormData();
    // Append the form fields to the FormData object
    formData.append('action_type', $("#action_type").val());

    var fileInput = $('#images')[0];
    formData.append('images', fileInput.files[0]);

    // $('#csv_submit_btn').prop('disabled', true);  
    $.ajax({
        url: "/admin/image/save_data",
        type: "POST",
        data: formData,
        processData: false,  // Prevent jQuery from automatically converting data to string
        contentType: false,  // 
        cache: false,
        timeout: 600000,
        success: function (data) {
            if(data.status == 0)
            {
                $.alert({
                    title: '錯誤',
                    icon: 'bi-exclamation-circle',
                    type: 'red',
                    content: data.validation,
                });
            } else {
                $.alert({
                    title: '廣告上傳完成。',
                    content: data.result,
                    icon: 'bi-info-circle',
                    type: 'blue',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    buttons: {
                        okay: {
                            text: '好的',
                            btnClass: 'btn-primary'
                        }
                    }
                });
                $('#image_datatable').DataTable().ajax.reload();
                clear_form();
            }
            $('#submit_btn').prop('disabled', false);
        },
        error: function (e) {
            $.alert({
                title: '錯誤',
                icon: 'bi-exclamation-circle',
                type: 'red',
                content:'发生了一个意外的错误。请联系您的服务器管理员。 / An unexpected error has occured. Please contact your server administrator.',
            });
            $('#submit_btn').prop('disabled', false);
            spinner();
        }
        
    });    
}
function clear_form()
{
    $("#images_1").attr("src", "");
    $("#images").val("");
}

function spinner() {
  if ($(".spin").hasClass("d-none")) {
    $(".spin").removeClass("d-none")
  } else {
    $(".spin").addClass("d-none")
  }
}