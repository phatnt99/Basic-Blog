// Thêm bài viết
$('#formAddPost button').on('click', function() {

    $title_add_post = $('#title_add_post').val();
    $slug_add_post = $('#slug_add_post').val();
 
    if ($title_add_post == '' || $slug_add_post == '') {
        $('#formAddPost .alert').removeClass('hidden');
        $('#formAddPost .alert').html('Vui lòng điền đầy đủ thông tin.');
    } else {
        $.ajax({
            url : '/basiclearn/Newspaper/admin/posts.php',
            type : 'POST',
            data : {
                title_add_post : $title_add_post,
                slug_add_post : $slug_add_post,
                action : 'add_post'
            }, success : function(data) {
                $('#formAddPost .alert').html(data);
            }, error : function() {
                $('#formAddPost .alert').removeClass('hidden');
                $('#formAddPost .alert').html('Đã có lỗi xảy ra, hãy thử lại.');
            }
        });
    }
});

// Tìm kiếm bài viết
$('#formSearchPost button').on('click', function() {
    $kw_search_post = $('#kw_search_post').val();
 
    if ($kw_search_post != '') {
        $.ajax({
            url : '/basiclearn/Newspaper/admin/posts.php',
            type : 'POST',
            data : {
                kw_search_post : $kw_search_post,
                action : 'search_post'
            }, success : function(data) {
                $('#list_post').html(data);
                $('#paging_post').hide();
            }
        });
    }
});

// Tải chuyên mục vừa và nhỏ trong chỉnh sửa bài viết
$('#cate_post_1').on('change', function() {
    $parent_id = $(this).val();
 
    $.ajax({
        url :'/basiclearn/Newspaper/admin/posts.php',
        type : 'POST',
        data : {
            parent_id : $parent_id,
            action : 'load_cate_2'
        }, success : function(data) {
            $('#cate_post_2').html(data);
 
            // Sau khi tải xong chuyên mục vừa sẽ tải chuyên mục nhỏ 
            $parent_id = $('#cate_post_2').val();
 
            $.ajax({
                url : '/basiclearn/Newspaper/admin/posts.php',
                type : 'POST',
                data : {
                    parent_id : $parent_id,
                    action : 'load_cate_3'
                }, success : function(data) {
                    $('#cate_post_3').html(data);
                }
            });
        }
    });
});

// Chỉnh sửa bài viết
$('#formEditPost button').on('click', function() {
    $id_post = $('#formEditPost').attr('data-id');
    $stt_edit_post = $('#formEditPost input[name="stt_edit_post"]:radio:checked').val();
    $title_edit_post = $('#title_edit_post').val();
    $slug_edit_post = $('#slug_edit_post').val();
    $url_thumb_edit_post = $('#url_thumb_edit_post').val();
    $desc_edit_post = $('#desc_edit_post').val();
    $keywords_edit_post = $('#keywords_edit_post').val();
    $cate_1_edit_post = $('#cate_post_1').val();
    $cate_2_edit_post = $('#cate_post_2').val();
    $cate_3_edit_post = $('#cate_post_3').val();
    $body_edit_post = CKEDITOR.instances['body_edit_post'].getData();
 
    if ($stt_edit_post == '' || $title_edit_post == '' || $slug_edit_post == '' || $cate_1_edit_post == '' || $cate_2_edit_post == '' || $cate_3_edit_post == '' || $body_edit_post == '') 
    {
        $('#formEditPost .alert').removeClass('hidden');
        $('#formEditPost .alert').html('Vui lòng điền đầy đủ thông tin.');
    } 
    else
    {
        $.ajax({
            url : '/basiclearn/Newspaper/admin/posts.php',
            type : 'POST',
            data : {
                id_post : $id_post,
                stt_edit_post : $stt_edit_post,
                title_edit_post : $title_edit_post,
                slug_edit_post : $slug_edit_post,
                url_thumb_edit_post : $url_thumb_edit_post,
                keywords_edit_post : $keywords_edit_post,
                desc_edit_post : $desc_edit_post,
                cate_1_edit_post : $cate_1_edit_post,
                cate_2_edit_post : $cate_2_edit_post,
                cate_3_edit_post : $cate_3_edit_post,
                body_edit_post : $body_edit_post,
                action : 'edit_post'
            }, success : function(data) {
                $('#formEditPost .alert').removeClass('hidden');
                $('#formEditPost .alert').html(data);
            }, error : function() {
                $('#formEditPost .alert').removeClass('hidden');
                $('#formEditPost .alert').html('Đã có lỗi xảy ra, hãy thử lại sau.');
            }
        });
    }
});
 
// Tải chuyên mục nhỏ trong chỉnh sửa bài viết
$('#cate_post_2').on('change', function() {
    $parent_id = $(this).val();
 
    $.ajax({
        url :  '/basiclearn/Newspaper/admin/posts.phpposts.php',
        type : 'POST',
        data : {
            parent_id : $parent_id,
            action : 'load_cate_3'
        }, success : function(data) {
            $('#cate_post_3').html(data);
        }
    });
});

// Xoá nhiều bài viết cùng lúc
$('#del_post_list').on('click', function() {
    $confirm = confirm('Bạn có chắc chắn muốn xoá các bài viết đã chọn không?');
    if ($confirm == true)
    {
        $id_post = [];
 
        $('#list_post input[type="checkbox"]:checkbox:checked').each(function(i) {
            $id_post[i] = $(this).val();
        });
 
        if ($id_post.length === 0)
        {
            alert('Vui lòng chọn ít nhất một bài viết.');
        }
        else
        {
            $.ajax({
                url : '/basiclearn/Newspaper/admin/posts.php',
                type : 'POST',
                data : {
                    id_post : $id_post,
                    action : 'delete_post_list'
                },success : function(data) {
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

// Xoá bài viết chỉ định trong bảng danh sách
$('.del-post-list').on('click', function() {
    $confirm = confirm('Bạn có chắc chắn muốn xoá bài viết này không?');
    if ($confirm == true)
    {
        $id_post = $(this).attr('data-id');
 
        $.ajax({
            url : '/basiclearn/Newspaper/admin/posts.php',
            type : 'POST',
            data : {
                id_post : $id_post,
                action : 'delete_post'
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

// Xoá bài viết chỉ định trong trang chỉnh sửa
$('#del_post').on('click', function() {
    $confirm = confirm('Bạn có chắc chắn muốn xoá bài viết này không?');
    if ($confirm == true)
    {
        $id_post = $(this).attr('data-id');
 
        $.ajax({
            url : $_DOMAIN + 'posts.php',
            type : 'POST',
            data : {
                id_post : $id_post,
                action : 'delete_post'
            },
            success : function() {
                location.href = $_DOMAIN + 'posts/';
            }
        });
    }
    else
    {
        return false;
    }
});