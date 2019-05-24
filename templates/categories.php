<?php
 
// Nhận giá trị slug của chuyên mục
$sc = trim(htmlspecialchars(addslashes($_GET['sc'])));
 
// Lấy id của chuyên mụcs
$sql_get_id_cate = "SELECT id_cate, url FROM categories WHERE url = '$sc'";
 
// Chuyên mục tồnta5i
if ($db->num_rows($sql_get_id_cate)) {
    $id_cate = $db->fetch_assoc($sql_get_id_cate, 1)['id_cate'];
 
?>
<div class="container">
    <div class="row">
    <?php
 
    // Lấy số hàng trong table
    $sqlGetCountPost = "SELECT id_post FROM posts WHERE cate_1_id = '$id_cate' OR cate_2_id = '$id_cate' OR cate_3_id = '$id_cate' AND status = '1'";
    $countPost = $db->num_rows($sqlGetCountPost);
 
    // Lấy tham số trang
    if (isset($_GET['p'])) {
      $page = trim(htmlspecialchars(addslashes($_GET['p'])));
 
      if (preg_match('/\d/', $page)) {
        $page = $page;
      } else {
        $page = 1;
      }
    } else {
      $page = 1;
    }
 
    $limit = 20; // Giới hạn số bài viết hiển thị trong 1 trang
    $totalPage = ceil($countPost / $limit); // Tổng số trang sau khi tính toán
         
    // Validate tham số page    
    if ($page > $totalPage) {
      $page = $totalPage;
    } else if ($page < 1) {
      $page = 1;
    }
       
    $start = ($page - 1) * $limit;
 
    $sql_get_latest_news = "SELECT * FROM posts WHERE status = '1' AND cate_1_id = '$id_cate' OR cate_2_id = '$id_cate' OR cate_3_id = '$id_cate' ORDER BY id_post DESC LIMIT $start, $limit";
    if ($db->num_rows($sql_get_latest_news)) {
        foreach ($db->fetch_assoc($sql_get_latest_news, 0) as $data_post) {
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
 
        echo '</div>';
 
        echo '
            <div class="btn-toolbar" role="toolbar">
                <div class="btn-group">
        ';
 
        # Pagination button
        if ($page > 1 && $totalPage > 1) {
            echo '
                <a href="' . $_DOMAIN . ($page - 1 ) . '" class="btn btn-default">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
            ';
        }
        
        for ($i = 1; $i <= $totalPage; $i++) {
            if ($i == $page){
                echo '<a class="btn btn-primary">' . $i . '</a>';
            } else {
                echo '
                    <a href="' . $_DOMAIN . $i . '" class="btn btn-default">
                        ' . $i . '
                    </a>
                ';
            }
        }
        
        if ($page < $totalPage && $totalPage > 1) {
            echo '
                <a href="' . $_DOMAIN . ($page + 1 ) . '" class="btn btn-default">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            ';
        }
 
        echo '
                </div>
            </div>
        ';
    } else {
        echo '<div class="well well-lg">Chưa có bài viết nào cho chuyên mục này.</div>';
    }
 
    ?>
</div>
<?php
 
// Chuyên mục không tồn tại
} else {
    require 'templates/404.php';
}
 
?>