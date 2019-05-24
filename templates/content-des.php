<?php
// Trang nội dung bài viết
if (isset($_GET['sp']) && isset($_GET['id'])) {
    require 'templates/posts.php';
// Trang chuyên mục
} else if (isset($_GET['sc'])) {
    require 'templates/categories.php';
// Trang tìm kiếm
} else if (isset($_GET['s'])) {
    require 'templates/search.php';
// Trang chủ
} else {
 // code
 require_once 'templates/lastest-news.php';

}
 
?>