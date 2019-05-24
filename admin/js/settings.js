// Trạng thái website
$('#formStatusWeb button').on('click', function() {
    $stt_web = $('#formStatusWeb input[name="stt_web"]:radio:checked').val();
 
    $.ajax({
        url : '/basiclearn/Newspaper/admin/settings.php',
        type : 'POST',
        data : {
            stt_web : $stt_web,
            action : 'stt_web'
        }, success : function() {
            $('#formStatusWeb .alert').attr('class', 'alert alert-success');
            $('#formStatusWeb .alert').html('Thay đổi thành công.');
                        location.reload();
        }, error : function() {
            $('#formStatusWeb .alert').removeClass('hidden');
            $('#formStatusWeb .alert').html('Đã có lỗi xảy ra, hãy thử lại.');
        }
    });
});

// Chỉnh sửa thông tin website
$('#formInfoWeb button').on('click', function() {
    $title_web = $('#title_web').val();
    $descr_web = $('#descr_web').val();
    $keywords_web = $('#keywords_web').val();
 
    $.ajax({
        url : '/basiclearn/Newspaper/admin/setting.php',
        type : 'POST',
        data : {
            title_web : $title_web,
            descr_web : $descr_web,
            keywords_web : $keywords_web,
            action : 'info_web'
        }, success : function() {
            $('#formInfoWeb .alert').attr('class', 'alert alert-success');
            $('#formInfoWeb .alert').html('Thay đổi thành công.');
            location.reload();
        }, error : function() {
            $('#formInfoWeb .alert').removeClass('hidden');
            $('#formInfoWeb .alert').html('Đã có lỗi xảy ra, hãy thử lại.');
        }
 
    });
});