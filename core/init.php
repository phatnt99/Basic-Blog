<?php
 
// Require các thư viện PHP
require_once 'admin/classes/myDB.php';
require_once 'admin/classes/session.php';
require_once 'admin/classes/common.php';
 
// Kết nối database
$db = new DB();
$db->connectDB();


$_DOMAIN = 'http://localhost:8080/basiclearn/Newspaper/';
// Lấy thông tin website
$sql_get_data_web = "SELECT * FROM website";
if ($db->num_rows($sql_get_data_web)) {
    $data_web = $db->fetch_assoc($sql_get_data_web, 1);
}
 
?>