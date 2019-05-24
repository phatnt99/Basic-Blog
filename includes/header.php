<?php
 
$title_error_404 = 'Không tìm thấy trang';
 
// Url bài viết
if (isset($_GET['sp']) && isset($_GET['id'])) {
    $slug_post = trim(htmlspecialchars($_GET['sp']));
    $id_post = trim(htmlspecialchars($_GET['id']));
 
    // Kiểm tra bài viết tồn tại
    $sql_check_post = "SELECT id_post, slug, title FROM posts WHERE slug = '$slug_post' AND id_post = '$id_post'";
    if ($db->num_rows($sql_check_post)) {
        $data_post = $db->fetch_assoc($sql_check_post, 1);
 
        $title = $data_post['title'];
        // ...
    } else {
        $title = $title_error_404;
    }
// Url chuyên mục
} else if (isset($_GET['sc'])) {
    $slug_cate = trim(htmlspecialchars($_GET['sc']));
 
    // Kiểm tra chuyên mục tồn tại
    $sql_check_cate = "SELECT url, label FROM categories WHERE url = '$slug_cate'";
    if ($db->num_rows($sql_check_cate)) {
        $data_cate = $db->fetch_assoc($sql_check_cate, 1);
 
        $title = $data_cate['label'];
        // ...
    } else {
        $title = $title_error_404;
    }
} else {
    $title = $data_web['title'];
    // ...
}
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <!-- ... -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $_DOMAIN; ?>">Newspage</a>
        </div>
 
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                         
                        // Lấy danh sách chuyên mục cấp 1
                $sql_get_list_menu_1 = "SELECT * FROM categories WHERE type = '1' ORDER BY sort ASC";
                if ($db->num_rows($sql_get_list_menu_1)) {
                                // In chuyên mục cấp 1
                    foreach ($db->fetch_assoc($sql_get_list_menu_1, 0) as $data_menu_1) {
                                        // Lấy chuyên mục cấp 2 theo id cha (cấp 1)
                        $sql_get_list_menu_2 = "SELECT * FROM categories WHERE type = '2' AND parent_id = '$data_menu_1[id_cate]' ORDER BY sort ASC";
                        if ($db->num_rows($sql_get_list_menu_2)) {
                                                // In chuyên mục cấp 2
                            $sub_menu = '<ul class="dropdown-menu">';
                                foreach ($db->fetch_assoc($sql_get_list_menu_2, 0) as $data_menu_2) {
                                    $sub_menu .= '<li><a href="' . $_DOMAIN . 'category/' . $data_menu_2['url'] . '">' . $data_menu_2['label'] . '</a></li>';
                                }
                            $sub_menu .= '</ul>';
                            echo '
                                <li class="dropdown">
                                    <a href="' . $_DOMAIN . 'category/' . $data_menu_1['url'] . '" class="dropdown-toggle" data-toggle="dropdown">' . $data_menu_1['label'] . ' <span class="caret"></span></a>
                                    ' . $sub_menu . '
                                </li>
                            ';
                        } else {
                            $sub_menu = '';
                            echo '<li><a href="' . $_DOMAIN . 'category/' . $data_menu_1['url'] . '">' . $data_menu_1['label'] . '</a>' . $sub_menu . '</li>';
                        }
                    }
                }
 
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li data-toggle="modal" data-target="#boxSearch"><a href="#"><span class="glyphicon glyphicon-search"></span></a></li>
            </ul>
        </div>
    </div>
</nav>