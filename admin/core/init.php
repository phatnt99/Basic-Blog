<?php
require_once 'classes/myDB.php';
require_once 'classes/session.php';
require_once 'classes/common.php';

$db = new DB();

$db->connectDB();

$session = new Session();

$session->start();

$user = $session->get();

date_default_timezone_set('Asia/Ho_Chi_Minh');

$date_current = date("Y-m-d H:i:s");

if($user)
{
    $query_get_user = "SELECT * FROM accounts WHERE username = '$user'";
    $data_user = $db->fetch_assoc($query_get_user, 1);
}

?>