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
 
        // Trạng thái website
        if ($action == 'stt_web') 
        {
            $stt_web = trim(htmlspecialchars(addslashes($_POST['stt_web'])));
            $sql_stt_web = "UPDATE website SET status = '$stt_web'";
            $db->query($sql_stt_web);
            $db->disconnectDB();
        }
        // Chỉnh sửa thông tin website
        else if ($action == 'info_web') 
{
    $title_web = trim(htmlspecialchars(addslashes($_POST['title_web'])));
    $descr_web = trim(htmlspecialchars(addslashes($_POST['descr_web'])));
    $keywords_web = trim(htmlspecialchars(addslashes($_POST['keywords_web'])));
 
    $sql_info_web = "UPDATE website SET 
        title = '$title_web',
        descr = '$descr_web',
        keywords = '$keywords_web'
    ";
    $db->query($sql_info_web);
    $db->disconnectDB();
}
    }
    else
    {
        new Redirect('index.php'); // Trở về trang index
    }
}
else
{
    new Redirect('index.php'); // Trở về trang index
}