// Xem ảnh trước
function preUpImg() {
    img_up = $('#img_up').val();
    count_img_up = $('#img_up').get(0).files.length;
    $('#formUpImg .box-pre-img').html('<p><strong>Ảnh xem trước</strong></p>');
    $('#formUpImg .box-pre-img').removeClass('hidden');
 
    // Nếu đã chọn ảnh
    if (img_up != '')
    {
        $('#formUpImg .box-pre-img').html('<p><strong>Ảnh xem trước</strong></p>');
        $('#formUpImg .box-pre-img').removeClass('hidden');
        for (i = 0; i <= count_img_up - 1; i++)
        {
            $('#formUpImg .box-pre-img').append('<img src="' + URL.createObjectURL(event.target.files[i]) + '" style="border: 1px solid #ddd; width: 50px; height: 50px; margin-right: 5px; margin-bottom: 5px;"/>');
        }
    } 
    // Ngược lại chưa chọn ảnh
    else
    {
        $('#formUpImg .box-pre-img').html('');
        $('#formUpImg .box-pre-img').addClass('hidden');
    }
}

// Nút reset form  hình ảnh
$('#formUpImg button[type=reset]').on('click', function() {
    $('#formUpImg .box-pre-img').html('');
    $('#formUpImg .box-pre-img').addClass('hidden');
});

// Upload hình ảnh
$('#formUpImg').submit(function(e) {
    img_up = $('#img_up').val();
    count_img_up = $('#img_up').get(0).files.length;
    error_size_img = 0;
    error_type_img = 0;
    $('#formUpImg button[type=submit]').html('Đang tải ...');
 
    // Nếu có chọn ảnh
    if (img_up) {
        e.preventDefault();
         
        // Kiểm tra dung lượng ảnh
        for (i = 0; i <= count_img_up - 1; i++)
        {
            size_img_up = $('#img_up')[0].files[i].size;
            if (size_img_up > 5242880) { // 5242880 byte = 5MB 
                error_size_img += 1; // Lỗi
            } else {
                error_size_img += 0; // Không lỗi
            }
        }
 
        // Kiểm tra định dạng ảnh
        for (i = 0; i <= count_img_up - 1; i++)
        {
            type_img_up = $('#img_up')[0].files[i].type;
            if (type_img_up == 'image/jpeg' || type_img_up == 'image/png' || type_img_up == 'image/gif') {
                error_type_img += 0;
            } else {
                error_type_img += 1;
            }
        }
 
        // Nếu lỗi về size ảnh
        if (error_size_img >= 1) {
            $('#formUpImg button[type=submit]').html('Upload');
            $('#formUpImg .alert').removeClass('hidden');
            $('#formUpImg .alert').html('Một trong các tệp đã chọn có dung lượng lớn hơn mức cho phép.');
        // Nếu số lượng ảnh vượt quá 20 file
        } else if (count_img_up > 20) {
            $('#formUpImg button[type=submit]').html('Upload');
            $('#formUpImg .alert').removeClass('hidden');
            $('#formUpImg .alert').html('Số file upload cho mỗi lần vượt quá mức cho phép.');
        } else if (error_type_img >= 1) {
            $('#formUpImg button[type=submit]').html('Upload');
            $('#formUpImg .alert').removeClass('hidden');
            $('#formUpImg .alert').html('Một trong những file ảnh không đúng định dạng cho phép.');
        } else {
            $(this).ajaxSubmit({ 
                beforeSubmit: function() {
                    target:   '#formUpImg .alert', 
                    $("#formUpImg .box-progress-bar").removeClass('hidden');
                    $("#formUpImg .progress-bar").width('0%');
                },
                uploadProgress: function (event, position, total, percentComplete){ 
                    $("#formUpImg .progress-bar").animate({width: percentComplete + '%'});
                    $("#formUpImg .progress-bar").html(percentComplete + '%');
                },
                success: function (data) {     
                    $('#formUpImg button[type=submit]').html('Upload');
                    $('#formUpImg .alert').attr('class', 'alert alert-success'); 
                    $('#formUpImg .alert').html(data);
                },
                error: function() {
                    $('#formUpImg button[type=submit]').html('Upload');
                    $('#formUpImg .alert').removeClass('hidden');  
                    $('#formUpImg .alert').html('Không thể upload hình ảnh vào lúc này, hãy thử lại sau.');
                },
                resetForm: true
            }); 
            return false;
        }
    // Ngược lại không chọn ảnh
    } else {
        $('#formUpImg button[type=submit]').html('Upload');
        $('#formUpImg .alert').removeClass('hidden');
        $('#formUpImg .alert').html('Vui lòng chọn tệp hình ảnh.');
    }
});

// Xoá nhiều hình ảnh cùng lúc
$('#del_img_list').on('click', function() {
    $confirm = confirm('Bạn có chắc chắn muốn xoá các hình ảnh đã chọn không?');
    if ($confirm == true)
    {
        $id_img = [];
 
        $('#list_img input[type="checkbox"]:checkbox:checked').each(function(i) {
            $id_img[i] = $(this).val();
        });
 
        if ($id_img.length === 0)
        {
            alert('Vui lòng chọn ít nhất một hình ảnh.');
        }
        else
        {
            $.ajax({
                url : '/basiclearn/Newspaper/admin/photos.php',
                type : 'POST',
                data : {
                    id_img : $id_img,
                    action : 'delete_img_list'
                },
                success : function(data) {
                    location.reload();
                }, error : function() {
                    alert('Đã có lỗi xảy ra, hãy thử lại.');
                }
            });
        }
    }
    else
    {
        return false;
    }
});

// Xoá ảnh chỉ định
$('.del-img').on('click', function() {
    $confirm = confirm('Bạn có chắc chắn muốn xoá ảnh này không?');
    if ($confirm == true)
    {
        $id_img = $(this).attr('data-id');
 
        $.ajax({
            url : '/basiclearn/Newspaper/admin/photos.php',
            type : 'POST',
            data : {
                id_img : $id_img,
                action : 'delete_img'
            },
            success : function() {
                location.reload();
            }
        });
    }
    else
    {
        return false;
    }
});