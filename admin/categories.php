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
 
        // Tải chuyên mục cha trong chức năng thêm chuyên mục
        if ($action == 'load_add_parent_cate')
        {
            // Xử lý giá trị
            $type_add_cate = trim(addslashes(htmlspecialchars($_POST['type_add_cate'])));
 
            // Nếu type đúng dạng số
            if (!preg_match('/\D/', $type_add_cate)) 
            {
                $type_add_parent_cate = $type_add_cate - 1; // Lấy type parent
                $sql_get_cate = "SELECT * FROM categories WHERE type = '$type_add_parent_cate'";
                if ($db->num_rows($sql_get_cate))
                {
                    // In danh sách các chuyên mục cha theo type parent
                    foreach ($db->fetch_assoc($sql_get_cate, 0) as $key => $data_cate)
                    {
                        echo '<option value="' . $data_cate['id_cate'] . '">' . $data_cate['label'] . '</option>';
                    }
                }
                else
                {
                    echo '<option value="0">Hiện chưa có chuyên mục cha nào</option>';
                }
            }
        }
        // Tạo chuyên mục
        else if ($action == 'add_cate')
        {
            // Xử lý các giá trị
            $label_add_cate = trim(addslashes(htmlspecialchars($_POST['label_add_cate'])));
            $url_add_cate = trim(addslashes(htmlspecialchars($_POST['url_add_cate'])));
            $type_add_cate = trim(addslashes(htmlspecialchars($_POST['type_add_cate'])));
            $parent_add_cate = trim(addslashes(htmlspecialchars($_POST['parent_add_cate'])));
            $sort_add_cate = trim(addslashes(htmlspecialchars($_POST['sort_add_cate'])));
 
 
            // Các biến xử lý thông báo
            $show_alert = '<script>$("#formAddCate .alert").removeClass("hidden");</script>';
            $hide_alert = '<script>$("#formAddCate .alert").addClass("hidden");</script>';
            $success = '<script>$("#formAddCate .alert").attr("class", "alert alert-success");</script>';
 
            // Nếu các giá trị rỗng
            if ($label_add_cate == '' || $url_add_cate == '' || $type_add_cate == '' || $sort_add_cate == '')
            {
                echo $show_alert.'Vui lòng điền đầy đủ thông tin';
            }
            // Ngược lại
            else
            {
                // Nếu type chuyên mục không phải số
                if (preg_match('/\D/', $type_add_cate))
                {
                    echo $show_alert.'Đã có lỗi xảy ra, hãy thử lại sau.';
                }
                // Nếu sort chuyên mục không phải số nguyên dương
                else if (preg_match('/\D/', $sort_add_cate) || $sort_add_cate < 1)
                {
                    echo $show_alert.'Sort chuyên mục phải là một số nguyên dương.';
                }
                // Nếu id parent chuyên mục không phải số
                else if (preg_match('/\D/', $parent_add_cate))
                {
                    echo $show_alert.'Đã có lỗi xảy ra, hãy thử lại sau.1';
                }
                // Nếu đúng 
                else
                {
                    // Thực thi tạo chuyên mục
                    $sql_add_cate = "INSERT INTO categories VALUES (
                        '',
                        '$label_add_cate',
                        '$url_add_cate',
                        '$type_add_cate',
                        '$sort_add_cate',
                        '$parent_add_cate',
                        '$date_current'
                    )";
                    $db->query($sql_add_cate);
                    echo $show_alert.$success.'Tạo chuyên mục thành công.';
                    $db->disconnectDB(); // Giải phóng
                    new Redirect('../categories'); // Trở về trang danh sách chuyên mục
                }
            }
        }
        // Tải chuyên mục cha trong chức năng chinh sửa chuyên mục
        else if ($action == 'load_edit_parent_cate')
{
    // Xử lý giá trị
    $type_edit_cate = trim(addslashes(htmlspecialchars($_POST['type_edit_cate'])));
    $id_edit_cate = trim(addslashes(htmlspecialchars($_POST['id_edit_cate'])));
 
    // Nếu type đúng dạng số
    if (!preg_match('/\D/', $type_edit_cate)) 
    {
        $type_edit_parent_cate = $type_edit_cate - 1; // Lấy type parent
        $sql_get_cate = "SELECT * FROM categories WHERE type = '$type_edit_parent_cate'";
        if ($db->num_rows($sql_get_cate))
        {
            // In danh sách các chuyên mục cha theo type parent
            foreach ($db->fetch_assoc($sql_get_cate, 0) as $key => $data_cate)
            {
                if ($id_edit_cate != $data_cate['id_cate']) {
                    echo '<option value="' . $data_cate['id_cate'] . '">' . $data_cate['label'] . '</option>';
 
                }
            }
        }
        else
        {
            echo '<option value="0">Hiện chưa có chuyên mục cha nào' . $type_edit_cate .'</option>';
        }
    }
}
        // Chỉnh sửa chuyên mục
        else if ($action == 'edit_cate') 
{
    // Xử lý các giá trị
    $label_edit_cate = trim(addslashes(htmlspecialchars($_POST['label_edit_cate'])));
    $url_edit_cate = trim(addslashes(htmlspecialchars($_POST['url_edit_cate'])));
    $type_edit_cate = trim(addslashes(htmlspecialchars($_POST['type_edit_cate'])));
    $parent_edit_cate = trim(addslashes(htmlspecialchars($_POST['parent_edit_cate'])));
    $sort_edit_cate = trim(addslashes(htmlspecialchars($_POST['sort_edit_cate'])));
    $id_edit_cate = trim(addslashes(htmlspecialchars($_POST['id_edit_cate'])));
 
    // Các biến xử lý thông báo
    $show_alert = '<script>$("#formEditCate .alert").removeClass("hidden");</script>';
    $hide_alert = '<script>$("#formEditCate .alert").addClass("hidden");</script>';
    $success = '<script>$("#formEditCate .alert").attr("class", "alert alert-success");</script>';
 
    // Nếu các giá trị rỗng
    if ($label_edit_cate == '' || $url_edit_cate == '' || $type_edit_cate == '' || $sort_edit_cate == '')
    {
        echo $show_alert.'Vui lòng điền đầy đủ thông tin';
    }
    // Ngược lại
    else
    {
        // Nếu type chuyên mục không phải số
        if (preg_match('/\D/', $type_edit_cate))
        {
            echo $show_alert.'Đã có lỗi xảy ra, hãy thử lại sau.';
        }
        // Nếu sort chuyên mục không phải số nguyên dương
        else if (preg_match('/\D/', $sort_edit_cate) || $sort_edit_cate < 1)
        {
            echo $show_alert.'Sort chuyên mục phải là một số nguyên dương.';
        }
        // Nếu id parent chuyên mục không phải số
        else if (preg_match('/\D/', $parent_edit_cate))
        {
            echo $show_alert.'Đã có lỗi xảy ra, hãy thử lại sau';
        }
        // Nếu đúng 
        else
        {
            // Thực thi chỉnh sửa chuyên mục
            $sql_edit_cate = "UPDATE categories SET 
                label = '$label_edit_cate',
                url = '$url_edit_cate',
                type = '$type_edit_cate',
                parent_id = '$parent_edit_cate',
                sort = '$sort_edit_cate'
                WHERE id_cate = '$id_edit_cate'
            ";
            $db->query($sql_edit_cate);
            echo $show_alert.$success.'Tạo chuyên mục thành công.';
            $db->disconnectDB(); // Giải phóng
            new Redirect('/basiclearn/Newspaper/admin/categories'); // Trở về trang danh sách chuyên mục
        }
    }
}
// Xoá nhiều chuyên mục cùng lúc
else if ($action == 'delete_cate_list')
{
    foreach ($_POST['id_cate'] as $key => $id_cate)
    {
        $sql_check_id_cate_exist = "SELECT id_cate FROM categories WHERE id_cate = '$id_cate'";
        if ($db->num_rows($sql_check_id_cate_exist))
        {
            $sql_delete_cate = "DELETE FROM categories WHERE id_cate = '$id_cate'";
            $db->query($sql_delete_cate);
        }
    }   
    $db->disconnectDB();
}
// Xoá 1 chuyên mục
else if ($action == 'delete_cate')
{       
    $id_cate = trim(htmlspecialchars(addslashes($_POST['id_cate'])));
    $sql_check_id_cate_exist = "SELECT id_cate FROM categories WHERE id_cate = '$id_cate'";
    if ($db->num_rows($sql_check_id_cate_exist))
    {
        $sql_delete_cate = "DELETE FROM categories WHERE id_cate = '$id_cate'";
        $db->query($sql_delete_cate);
        $db->disconnectDB();
    }       
}
    }
    // Ngược lại không tồn tại POST action
    else
    {
        new Redirect('../');
    }
}
// Nếu không đăng nhập
else
{
    new Redirect('../');
}
 
?>