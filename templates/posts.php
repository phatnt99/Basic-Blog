<?php
 
// Get tham số post
$sp = trim(htmlspecialchars(addslashes($_GET['sp'])));
$id = trim(htmlspecialchars(addslashes($_GET['id'])));
 
// Lấy thông tin bài viết
$sql_get_data_post = "SELECT * FROM posts WHERE id_post = '$id' AND slug ='$sp'";
if ($db->num_rows($sql_get_data_post)) {
    $data_post = $db->fetch_assoc($sql_get_data_post, 1);
} else {
    // Nếu không tồn tại 
    require 'templates/404.php';
    exit;
}
 
?>
<div class="container">
    <div class="row">
        <h1><?php echo $data_post['title']; ?></h1>
        <div class="body-post">
            <?php echo htmlspecialchars_decode($data_post['body']); ?>
        </div>
        <div class="cate-post">
            <?php 
 
            // In chuyên mục của bài viết
            for ($i = 1; $i <= 3; $i++) {
                $id_cate = $data_post['cate_' . $i . '_id'];
                if ($id_cate) {
                    $sql_get_data_cate = "SELECT label, url FROM categories WHERE id_cate = '$id_cate' AND type = '$i'";
                    if ($db->num_rows($sql_get_data_cate)) {
                        $data_cate = $db->fetch_assoc($sql_get_data_cate, 1);
 
                        echo '<a class="btn btn-primary btn-sm" href="' . $_DOMAIN . 'category/' . $data_cate['url'] . '">' . $data_cate['label'] . '</a> ';
                    }
                }
            }
 
            ?>
        </div>
    </div>
    <hr>
    <div class="row">
        <h3>Bài viết liên quan</h3>
        <?php
 
        // Hiển thị các bài viết liên quan theo chuyên mục của bài viết chỉ định
        $sql_get_invole_post = "SELECT DISTINCT * FROM posts WHERE (cate_1_id = '$data_post[cate_1_id]' OR cate_2_id = '$data_post[cate_2_id]' OR cate_3_id = '$data_post[cate_3_id]') AND status = '1' AND id_post != '$id'";
        // Nếu tồn tại các bài viết liên quan
        if ($db->num_rows($sql_get_invole_post)) {
            // In danh sách bài viết liên quan
            foreach ($db->fetch_assoc($sql_get_invole_post, 0) as $data_post) {
                echo '
                    <div class="col-md-3">
                        <div class="thumbnail">
                            <a href="' . $_DOMAIN . $data_post['slug'] . '-' . $data_post['id_post'] . '.html">
                                <img src="' . $data_post['url_thumb'] . '">
                            </a>
                            <div class="caption">
                                <h3><a href="' . $_DOMAIN . $data_post['slug'] . '-' . $data_post['id_post'] . '.html">' . $data_post['title'] . '</a></h3>
                                <p>' . $data_post['descr'] . '</p>
                            </div>
                        </div>
                    </div>
                ';
            }
        // Không tồn tại thì thông báo
        } else {
            echo '<div class="well well-lg">Không có bài viết liên quan nào.</div>';
        }
 
        ?>
    </div>
</div>