<?php
 
// Kết nối database và thông tin chung
require_once 'core/init.php';
 
// Nếu đăng nhập
if ($user) 
{
    // Nếu tồn tại POST action
    if (isset($_POST['action']))
    {
        // Xử lý POST action
        $action = trim(addslashes(htmlspecialchars($_POST['action'])));
 
        // Thêm bài viết
        if ($action == 'add_post')
        {
            // Xử lý các giá trị
            $title_add_post = trim(addslashes(htmlspecialchars($_POST['title_add_post'])));
            $slug_add_post = trim(addslashes(htmlspecialchars($_POST['slug_add_post'])));
 
            // Các biến xử lý thông báo
            $show_alert = '<script>$("#formAddPost .alert").removeClass("hidden");</script>';
            $hide_alert = '<script>$("#formAddPost .alert").addClass("hidden");</script>';
            $success = '<script>$("#formAddPost .alert").attr("class", "alert alert-success");</script>';
 
            // Nếu các giá trị rỗng
            if ($title_add_post == '' || $slug_add_post == '')
            {
                echo $show_alert.'Vui lòng điền đầy đủ thông tin';
            }
            // Ngược lại
            else
            {
                // Kiểm tra bài viết tồn tại 
                $sql_check_post_exist = "SELECT title, slug FROM posts WHERE title = '$title_add_post' OR slug = '$slug_add_post'";
                // Nếu bài viết tồn tại
                if ($db->num_rows($sql_check_post_exist))
                {
                    echo $show_alert.'Bài viết có tiêu đề hoặc slug đã tồn tại.';
                }
                else
                {
                    // Thực thi thêm bài viết
                    $sql_add_post = "INSERT INTO posts VALUES (
                        '',
                        '$title_add_post',
                        '',
                        '',
                        '$slug_add_post',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '$data_user[id_acc]',
                        '0',
                        '0',
                        '$date_current'
                    )";
                    $db->query($sql_add_post);
                    echo $show_alert.$success.'Thêm bài viết thành công.';
                    $db->disconnectDB(); // Giải phóng
                    new Redirect('/basiclearn/Newspaper/admin/posts'); // Trở về trang danh sách bài viết
                }
            }
        }
 
        // Tải chuyên mục trong chỉnh sửa bài viết
        // Chuyên mục vừa
else if ($action == 'load_cate_2')
{
    $parent_id = trim(htmlspecialchars(addslashes($_POST['parent_id'])));
 
    $sql_get_cate_2 = "SELECT id_cate, label FROM categories WHERE type = '2' AND parent_id = '$parent_id'";
    if ($db->num_rows($sql_get_cate_2)) {
        foreach ($db->fetch_assoc($sql_get_cate_2, 0) as $key => $data_cate_2) {
            echo '<option value="' . $data_cate_2['id_cate'] . '">' . $data_cate_2['label'] . '</option>';
        }
    } else {
        echo '<option value="">Chưa có chuyên mục vừa nào</option>';
    }
}
// Chuyên mục nhỏ
else if ($action == 'load_cate_3')
{
    $parent_id = trim(htmlspecialchars(addslashes($_POST['parent_id'])));
 
    $sql_get_cate_3 = "SELECT id_cate, label FROM categories WHERE type = '3' AND parent_id = '$parent_id'";
    if ($db->num_rows($sql_get_cate_3)) {
        foreach ($db->fetch_assoc($sql_get_cate_3, 0) as $key => $data_cate_3) {
            echo '<option value="' . $data_cate_3['id_cate'] . '">' . $data_cate_3['label'] . '</option>';
        }
    } else {
        echo '<option value="">Chưa có chuyên mục nhỏ nào</option>';
    }
}
 
// Chỉnh sửa bài viết
else if ($action == 'edit_post')
{
    // Xử lý các giá trị
    $id_post = trim(htmlspecialchars(addslashes($_POST['id_post'])));
    $stt_edit_post = trim(htmlspecialchars(addslashes($_POST['stt_edit_post'])));
    $title_edit_post = trim(htmlspecialchars(addslashes($_POST['title_edit_post'])));
    $slug_edit_post = trim(htmlspecialchars(addslashes($_POST['slug_edit_post'])));
    $url_thumb_edit_post = trim(htmlspecialchars(addslashes($_POST['url_thumb_edit_post'])));
    $desc_edit_post = trim(htmlspecialchars(addslashes($_POST['desc_edit_post'])));
    $keywords_edit_post = trim(htmlspecialchars(addslashes($_POST['keywords_edit_post'])));
    $cate_1_edit_post = trim(htmlspecialchars(addslashes($_POST['cate_1_edit_post'])));
    $cate_2_edit_post = trim(htmlspecialchars(addslashes($_POST['cate_2_edit_post'])));
    $cate_3_edit_post = trim(htmlspecialchars(addslashes($_POST['cate_3_edit_post'])));
    $body_edit_post = trim(htmlspecialchars(addslashes($_POST['body_edit_post'])));
 
    // Các biến xử lý thông báo
    $show_alert = '<script>$("#formEditPost .alert").removeClass("hidden");</script>';
    $hide_alert = '<script>$("#formEditPost .alert").addClass("hidden");</script>';
    $success = '<script>$("#formEditPost .alert").attr("class", "alert alert-success");</script>';
 
    // Kiểm tra id bài viết
    $sql_check_id_post = "SELECT id_post FROM posts WHERE id_post = '$id_post'";
 
    // Nếu các giá trị rỗng
    if ($stt_edit_post == '' || $title_edit_post == '' || $slug_edit_post == '' || $cate_1_edit_post == '' || $cate_2_edit_post == '' || $cate_3_edit_post == '' || $body_edit_post == '') 
    {
        echo $show_alert.'Vui lòng điền đầy đủ thông tin.';
    } 
    else if (!$db->num_rows($sql_check_id_post))
    {
        echo $show_alert.'Đã có lỗi xảy ra, vui lòng thử lại.';
    }
    // Kiểm tra url ảnh
    else if ($url_thumb_edit_post != '' && filter_var($url_thumb_edit_post, FILTER_VALIDATE_URL) === false)
    {
        echo $show_alert.'Vui lòng nhập url thumbnail hợp lệ.';
    }
    else
    {
        // Sửa bài viết
        $sql_edit_post = "UPDATE posts SET
            status = '$stt_edit_post',
            title = '$title_edit_post',
            slug = '$slug_edit_post',
            url_thumb = '$url_thumb_edit_post',
            descr = '$desc_edit_post',
            keywords = '$keywords_edit_post',
            cate_1_id = '$cate_1_edit_post',
            cate_2_id = '$cate_2_edit_post',
            cate_3_id = '$cate_3_edit_post',
            body = '$body_edit_post'
            WHERE id_post = '$id_post';
        ";
        $db->query($sql_edit_post);
        $db->disconnectDB();
        echo $show_alert.$success.'Chỉnh sửa bài viết thành công.';
        new Redirect('/basiclearn/Newspaper/admin/posts/edit/'.$id_post);
    }
}
 
// Xoá bài viết
// Xoá nhiều bài viết cùng lúc
else if ($action == 'delete_post_list')
{
    foreach ($_POST['id_post'] as $key => $id_post)
    {
        $sql_check_id_post_exist = "SELECT id_post FROM posts WHERE id_post = '$id_post'";
        if ($db->num_rows($sql_check_id_post_exist))
        {
            $sql_delete_post = "DELETE FROM posts WHERE id_post = '$id_post'";
            $db->query($sql_delete_post);
        }
    }   
    $db->disconnectDB();
}
// Xoá 1 chuyên mục
else if ($action == 'delete_post')
{       
    $id_post = trim(htmlspecialchars(addslashes($_POST['id_post'])));
    $sql_check_id_post_exist = "SELECT id_post FROM posts WHERE id_post = '$id_post'";
    if ($db->num_rows($sql_check_id_post_exist))
    {
        $sql_delete_post = "DELETE FROM posts WHERE id_post = '$id_post'";
        $db->query($sql_delete_post);
        $db->disconnectDB();
    }       
}
        // Tìm kiếm bài viết
else if ($action == 'search_post')
{
    $kw_search_post = trim(htmlspecialchars(addslashes($_POST['kw_search_post'])));
 
    if ($kw_search_post != '')
    {
        $sql_search_post = "SELECT * FROM posts WHERE 
            id_post LIKE '%$kw_search_post%' OR
            title LIKE '%$kw_search_post%' OR
            slug LIKE '%$kw_search_post%'
            ORDER BY id_post DESC
        ";
 
        // Nếu có kết quả
        if ($db->num_rows($sql_search_post)) 
        {
            echo
            '
                <table class="table table-striped list">
                    <tr>
                        <td><input type="checkbox"></td>
                        <td><strong>ID</strong></td>
                        <td><strong>Tiêu đề</strong></td>
                        <td><strong>Trạng thái</strong></td>
                        <td><strong>Chuyên mục</strong></td>
                        <td><strong>Lượt xem</strong></td>
            ';
 
            // Nếu tài khoản là admin
            if ($data_user['position'] == '1') {
                echo '<td><strong>Tác giả</strong></td>';
            }
 
            echo '
                            <td><strong>Tools</strong></td>
                        </tr>
            ';
 
            // In danh sách kết quả bài viết
            foreach ($db->fetch_assoc($sql_search_post, 0) as $key => $data_post) 
            {
                // Trạng thái bài viết
                if ($data_post['status'] == 0) {
                    $stt_post = '<label class="label label-warning">Ẩn</label>';
                } else if ($data_post['status'] == 1) {
                    $stt_post = '<label class="label label-success">Xuấn bản</label>';
                }
 
                // Chuyên mục bài viết
                $cate_post = '';
                $sql_check_id_cate_1 = "SELECT label, id_cate FROM categories WHERE id_cate = '$data_post[cate_1_id]' AND type = '1'";
                if ($db->num_rows($sql_check_id_cate_1)) {
                    $data_cate_1 = $db->fetch_assoc($sql_check_id_cate_1, 1);
                    $cate_post .= $data_cate_1['label'];
                } else {
                    $cate_post .= '<span class="text-danger">Lỗi</span>';
                }
 
                $sql_check_id_cate_2 = "SELECT label, id_cate FROM categories WHERE id_cate = '$data_post[cate_2_id]' AND type = '2'";
                if ($db->num_rows($sql_check_id_cate_2)) {
                    $data_cate_2 = $db->fetch_assoc($sql_check_id_cate_2, 1);
                    $cate_post .= ', ' . $data_cate_2['label'];
                } else {
                    $cate_post .= ', <span class="text-danger">Lỗi</span>';
                }
 
                $sql_check_id_cate_3 = "SELECT label, id_cate FROM categories WHERE id_cate = '$data_post[cate_3_id]' AND type = '3'";
                if ($db->num_rows($sql_check_id_cate_3)) {
                    $data_cate_3 = $db->fetch_assoc($sql_check_id_cate_3, 1);
                    $cate_post .= ', ' . $data_cate_3['label'];
                } else {
                    $cate_post .= ', <span class="text-danger">Lỗi</span>';
                }
 
                // Tác giả bài viết
                $sql_get_author = "SELECT display_name FROM accounts WHERE id_acc = '$data_post[author_id]'";
                if ($db->num_rows($sql_get_author)) {
                    $data_author = $db->fetch_assoc($sql_get_author, 1);
                    $author_post = $data_author['display_name'];
                } else {
                    $author_post = '<span class="text-danger">Lỗi</span>';
                }
 
                echo
                '
                    <tr>
                        <td><input type="checkbox" name="id_post[]" value="' . $data_post['id_post'] .'"></td>
                        <td>' . $data_post['id_post'] . '</td>
                        <td style="width: 30%;"><a href="/basiclearn/Newspaper/admin/posts/edit/' . $data_post['id_post'] . '">' . $data_post['title'] . '</a></td>
                        <td>' . $stt_post . '</td>
                        <td>' . $cate_post . '</td>
                        <td>' . $data_post['view'] . '</td>
                ';
 
                // Tác giả bài viết
                if ($data_user['position'] == '1') {
                    echo '<td>' . $author_post . '</td>';
                }
 
                echo '
                        <td>
                            <a href="/basiclearn/Newspaper/admin/posts/edit/' . $data_post['id_post'] .'" class="btn btn-primary btn-sm">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>
                            <a class="btn btn-danger btn-sm del-post-list" data-id="' . $data_post['id_post'] . '">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                        </td>
                    </tr>
                ';
            }
            echo '</table>';
        } 
        // Ngược lại không có kết quả
        else
        {
            echo '<div class="alert alert-info">Không tìm thấy kết quả nào cho từ khoá <strong>' . $kw_search_post . '</strong>.</div>';
        }
    }
}
    }
    // Ngược lại không tồn tại POST action
    else
    {
        new Redirect("/basiclearn/Newspaper/admin/posts");
    }
}
// Nếu không đăng nhập
else
{
    new Redirect('index.php');
}
 
?>