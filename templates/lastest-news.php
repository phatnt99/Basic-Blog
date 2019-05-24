<div class="container">
    <div class="row">
    <?php
 
    // Lấy số hàng trong table
    $sqlGetCountPost = "SELECT id_post FROM posts";
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
 
    $sql_get_latest_news = "SELECT * FROM posts WHERE status = '1' ORDER BY id_post DESC LIMIT $start, $limit";
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
    }
    else {
        echo '<div class="well well-lg">Chưa có bài viết nào.</div>';
    }
 
    ?>
</div>