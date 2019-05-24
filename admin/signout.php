<?php
 
// Require database & thông tin chung
require_once 'core/init.php';
 
// Xoá session
$session->destroy();
new Redirect('index.php'); // Trở về trang index
 
?>