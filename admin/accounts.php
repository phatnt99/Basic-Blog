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
 
        // Thêm tài khoản
        if ($action == 'add_acc') 
        {
            // Xử lý các giá trị
            $un_add_acc = trim(htmlspecialchars(addslashes($_POST['un_add_acc'])));
            $pw_add_acc = trim(htmlspecialchars(addslashes($_POST['pw_add_acc'])));
            $repw_add_acc = trim(htmlspecialchars(addslashes($_POST['repw_add_acc'])));
 
            // Các biến xử lý thông báo
            $show_alert = '<script>$("#formAddAcc .alert").removeClass("hidden");</script>';
            $hide_alert = '<script>$("#formAddAcc .alert").addClass("hidden");</script>';
            $success = '<script>$("#formAddAcc .alert").attr("class", "alert alert-success");</script>';
 
            // Kiểm tra tên đăng nhập
            $sql_check_un_exist = "SELECT username FROM accounts WHERE username = '$un_add_acc'";
 
            if ($un_add_acc == '' || $pw_add_acc == '' || $repw_add_acc == '') {
                echo $show_alert.'Vui lòng điền đầy đủ thông tin.';
            } else if (strlen($un_add_acc) < 6 || strlen($un_add_acc) > 32) {
                echo $show_alert.'Tên đăng nhập nằm trong khoảng 6-32 ký tự.';
            } else if (preg_match('/\W/', $un_add_acc)) {
                echo $show_alert.'Tên đăng nhập không chứa kí tự đậc biệt và khoảng trắng.';
            } else if ($db->num_rows($sql_check_un_exist)) {
                echo $show_alert.'Tên đăng nhập đã tồn tại.';
            } else if (strlen($pw_add_acc) < 6) {
                echo $show_alert.'Mật khẩu quá ngắn.';
            } else if ($pw_add_acc != $repw_add_acc) {
                echo $show_alert.'Mật khẩu nhập lại không khớp.';
            } else {
                $pw_add_acc = md5($pw_add_acc);
                $sql_add_acc = "INSERT INTO accounts VALUES (
                    '',
                    '$un_add_acc',
                    '$pw_add_acc',
                    '',
                    '',
                    '0',
                    '0',
                    '$date_current',
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''
                )";
                $db->query($sql_add_acc);
                $db->disconnectDB();
 
                echo $show_alert.$success.'Thêm tài khoản thành công.';
                new Redirect('/basiclearn/Newspaper/admin/accounts'); // Trở về trang danh sách tài khoản
            }
        }
        // Mở tài khoản
        // Mở khoá nhiều tài khoản cùng lúc     
else if ($action == 'unlock_acc_list')
{
    foreach ($_POST['id_acc'] as $key => $id_acc)
    {
        $sql_check_id_acc_exist = "SELECT id_acc FROM accounts WHERE id_acc = '$id_acc'";
        if ($db->num_rows($sql_check_id_acc_exist))
        {
            $sql_unlock_acc = "UPDATE accounts SET status = '0' WHERE id_acc = '$id_acc'";
            $db->query($sql_unlock_acc);
        }
    }   
    $db->disconnectDB();
}
// Mở khoá 1 tài khoản
else if ($action == 'unlock_acc')
{       
    $id_acc = trim(htmlspecialchars(addslashes($_POST['id_acc'])));
    $sql_check_id_acc_exist = "SELECT id_acc FROM accounts WHERE id_acc = '$id_acc'";
    if ($db->num_rows($sql_check_id_acc_exist))
    {
        $sql_unlock_acc = "UPDATE accounts SET status = '0' WHERE id_acc = '$id_acc'";
        $db->query($sql_unlock_acc);
        $db->disconnectDB();
    }       
}
        // Khoá tài khoản
        // Khoá nhiều tài khoản cùng lúc        
else if ($action == 'lock_acc_list')
{
    foreach ($_POST['id_acc'] as $key => $id_acc)
    {
        $sql_check_id_acc_exist = "SELECT id_acc FROM accounts WHERE id_acc = '$id_acc'";
        if ($db->num_rows($sql_check_id_acc_exist))
        {
            $sql_lock_acc = "UPDATE accounts SET status = '1' WHERE id_acc = '$id_acc'";
            $db->query($sql_lock_acc);
        }
    }   
    $db->disconnectDB();
}
// Khoá 1 tài khoản
else if ($action == 'lock_acc')
{       
    $id_acc = trim(htmlspecialchars(addslashes($_POST['id_acc'])));
    $sql_check_id_acc_exist = "SELECT id_acc FROM accounts WHERE id_acc = '$id_acc'";
    if ($db->num_rows($sql_check_id_acc_exist))
    {
        $sql_lock_acc = "UPDATE accounts SET status = '1' WHERE id_acc = '$id_acc'";
        $db->query($sql_lock_acc);
        $db->disconnectDB();
    }       
}
        // Xoá tài khoản
        // Xoá nhiều tài khoản cùng lúc     
else if ($action == 'del_acc_list')
{
    foreach ($_POST['id_acc'] as $key => $id_acc)
    {
        $sql_check_id_acc_exist = "SELECT id_acc FROM accounts WHERE id_acc = '$id_acc'";
        if ($db->num_rows($sql_check_id_acc_exist))
        {
            $sql_del_acc = "DELETE FROM accounts WHERE id_acc = '$id_acc'";
            $db->query($sql_del_acc);
        }
    }   
    $db->disconnectDB();
}
// Xoá 1 tài khoản
else if ($action == 'del_acc')
{       
    $id_acc = trim(htmlspecialchars(addslashes($_POST['id_acc'])));
    $sql_check_id_acc_exist = "SELECT id_acc FROM accounts WHERE id_acc = '$id_acc'";
    if ($db->num_rows($sql_check_id_acc_exist))
    {
        $sql_del_acc = "DELETE FROM accounts WHERE id_acc = '$id_acc'";
        $db->query($sql_del_acc);
        $db->disconnectDB();
    }       
}  
    }
    else
    {
        new Redirect('/basiclearn/Newspaper/admin/accounts'); // Trở về trang index
    }
}
else
{
    new Redirect($_DOMAIN); // Trở về trang index
}