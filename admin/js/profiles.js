// Xem ảnh avatar trước
function preUpAvt() {
    img_avt = $('#img_avt').val();
    $('#formUpAvt .box-pre-img').html('<p><strong>Ảnh xem trước</strong></p>');
    $('#formUpAvt .box-pre-img').removeClass('hidden');
  
    // Nếu đã chọn ảnh
    if (img_avt != '')
    {
        $('#formUpAvt .box-pre-img').html('<p><strong>Ảnh xem trước</strong></p>');
        $('#formUpAvt .box-pre-img').removeClass('hidden');
        $('#formUpAvt .box-pre-img').append('<img src="' + URL.createObjectURL(event.target.files[0]) + '" style="border: 1px solid #ddd; width: 50px; height: 50px; margin-right: 5px; margin-bottom: 5px;"/>');
    } 
    // Ngược lại chưa chọn ảnh
    else
    {
        $('#formUpAvt .box-pre-img').html('');
        $('#formUpAvt .box-pre-img').addClass('hidden');
    }
}

// Upload ảnh đại diện
$('#formUpAvt').submit(function(e) {
    img_avt = $('#img_avt').val();
    $('#formUpAvt button[type=submit]').html('Đang tải ...');
  
    // Nếu có chọn ảnh
    if (img_avt) {
        size_img_avt = $('#img_avt')[0].files[0].size;
        type_img_avt = $('#img_avt')[0].files[0].type;
 
        e.preventDefault();
        // Nếu lỗi về size ảnh
        if (size_img_avt > 5242880) { // 5242880 byte = 5MB 
            $('#formUpAvt button[type=submit]').html('Upload');
            $('#formUpAvt .alert-danger').removeClass('hidden');
            $('#formUpAvt .alert-danger').html('Tệp đã chọn có dung lượng lớn hơn mức cho phép.');
        // Nếu lỗi về định dạng ảnh
        } else if (type_img_avt != 'image/jpeg' && type_img_avt != 'image/png' && type_img_avt != 'image/gif') {
            $('#formUpAvt button[type=submit]').html('Upload');
            $('#formUpAvt .alert-danger').removeClass('hidden');
            $('#formUpAvt .alert-danger').html('File ảnh không đúng định dạng cho phép.');
        } else {
            $(this).ajaxSubmit({ 
                beforeSubmit: function() {
                    target:   '#formUpAvt .alert-danger', 
                    $("#formUpAvt .box-progress-bar").removeClass('hidden');
                    $("#formUpAvt .progress-bar").width('0%');
                },
                uploadProgress: function (event, position, total, percentComplete){ 
                    $("#formUpAvt .progress-bar").animate({width: percentComplete + '%'});
                    $("#formUpAvt .progress-bar").html(percentComplete + '%');
                },
                success: function (data) {     
                    $('#formUpAvt button[type=submit]').html('Upload');
                    $('#formUpAvt .alert-danger').attr('class', 'alert alert-success'); 
                    $('#formUpAvt .alert-success').html(data);
                },
                error: function() {
                    $('#formUpAvt button[type=submit]').html('Upload');
                    $('#formUpAvt .alert-danger').removeClass('hidden');  
                    $('#formUpAvt .alert-danger').html('Không thể upload hình ảnh vào lúc này, hãy thử lại sau.');
                },
                resetForm: true
            }); 
            return false;
        }
    // Ngược lại không chọn ảnh
    } else {
        $('#formUpAvt button[type=submit]').html('Upload');
        $('#formUpAvt .alert-danger').removeClass('hidden');
        $('#formUpAvt .alert-danger').html('Vui lòng chọn tệp hình ảnh.');
    }
});

// Xoá ảnh đại diện
$('#del_avt').on('click', function() {
    $confirm = confirm('Bạn có chắc chắn muốn xoá ảnh đại diện này không?');
    if ($confirm == true)
    {
        $.ajax({
            url : '/basiclearn/Newspaper/admin/profile.php',
            type : 'POST',
            data : {
                action : 'delete_avt'
            }, success : function() {
                location.reload();
            }, error : function() {
                alert('Đã có lỗi xảy ra, vui lòng thử lại.');
            }
        });
    }
    else {
        return false;
    }
});

// Cập nhật thông tin khác
$('#formUpdateInfo button').on('click', function() {
    $('#formUpdateInfo button').html('Đang tải ...');
    $dn_update = $('#dn_update').val();
    $email_update = $('#email_update').val();
    $fb_update = $('#fb_update').val();
    $gg_update = $('#gg_update').val();
    $tt_update = $('#tt_update').val();
    $phone_update = $('#phone_update').val();
    $desc_update = $('#desc_update').val();
 
    if ($dn_update && $email_update) {
        $.ajax({
            url :'/basiclearn/Newspaper/admin/profiles.php',
            type : 'POST',
            data : {
                dn_update : $dn_update,
                email_update : $email_update,
                fb_update : $fb_update,
                gg_update : $gg_update,
                tt_update : $tt_update,
                phone_update : $phone_update,
                desc_update : $desc_update,
                action : 'update_info'
            }, success : function(data) {
                $('#formUpdateInfo .alert').removeClass('hidden');
                $('#formUpdateInfo .alert').html(data);
            }, error : function() {
                $('#formUpdateInfo .alert').removeClass('hidden');
                $('#formUpdateInfo .alert').html('Đã có lỗi xảy ra, vui lòng thử lại.');
            }
        });
        $('#formUpdateInfo button').html('Lưu thay đổi');
    } else {
        $('#formUpdateInfo button').html('Lưu thay đổi');
        $('#formUpdateInfo .alert').removeClass('hidden');
        $('#formUpdateInfo .alert').html('Vui lòng điền đầy đủ thông tin.');
    }
});

$('#formChangePw button').on('click', function() {
    $('#formChangePw button').html('Đang tải ...'); 
    $old_pw_change = $('#oldPwChange').val();
    $new_pw_change = $('#newPwChange').val();
    $re_new_pw_change = $('#reNewPwChange').val();
    if ($old_pw_change && $new_pw_change && $re_new_pw_change) {
        $.ajax({
            url : '/basiclearn/Newspaper/admin/profiles.php',
            type : 'POST',
            data : {
                old_pw_change : $old_pw_change,
                new_pw_change : $new_pw_change,
                re_new_pw_change : $re_new_pw_change,
                action : 'change_pw'
            }, success : function(data) {
                $('#formChangePw .alert').removeClass('hidden');
                $('#formChangePw .alert').html(data);
            }, error : function() {
                $('#formChangePw .alert').removeClass('hidden');
                $('#formChangePw .alert').html('Đã có lỗi xảy ra, vui lòng thủ lại.');
            }
        });
        $('#formChangePw button').html('Lưu thay đổi');
    } else {
        $('#formChangePw button').html('Lưu thay đổi');
        $('#formChangePw .alert').removeClass('hidden');
        $('#formChangePw .alert').html('Vui lòng điền đầy đủ thông tin.');
    }
});