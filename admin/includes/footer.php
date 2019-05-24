<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script src="js/sigin.js"></script>
<script src="/basiclearn/Newspaper/admin/js/categories.js"></script>
<script src="/basiclearn/Newspaper/admin/js/posts.js"></script>
<script src="/basiclearn/Newspaper/admin/js/upload.js"></script>
<script src="/basiclearn/Newspaper/admin/js/settings.js"></script>
<script src="/basiclearn/Newspaper/admin/js/accounts.js"></script>
<script src="/basiclearn/Newspaper/admin/js/profiles.js"></script>
<!-- Liên kết thư viện CKEditor -->
<script src="//cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
<?php
 
// Active sidebar
// Lấy tham số tab
if (isset($_GET['tab']))
{
    $tab = trim(addslashes(htmlspecialchars($_GET['tab'])));
}
else
{
    $tab = '';
}
 
// Nếu có tham số tab
if ($tab != '')
{
    // Tháo active của Bảng điều khiển
    echo '<script>$(".sidebar ul a:eq(1)").removeClass("active");</script>';
    // Active theo giá trị của tham số tab
    if ($tab == 'profile')
    {
        echo '<script>$(".sidebar ul a:eq(2)").addClass("active");</script>';
    }
    else if ($tab == 'posts')
    {
        echo '<script>$(".sidebar ul a:eq(3)").addClass("active");</script>';
        if ($ac == 'edit') {
            if ($id) {
                $sql_check_id_post_exist = "SELECT id_post FROM posts WHERE id_post = '$id'";
                if ($db->num_rows($sql_check_id_post_exist)) {
                    echo
                    '
                        <script>
                            config = {};
                            config.entities_latin = false;
                            config.language = "vi";
                            CKEDITOR.replace("body_edit_post", config);
                        </script>     
                    ';
                }
            }
        }
    }
    else if ($tab == 'photos')
    {
        echo '<script>$(".sidebar ul a:eq(4)").addClass("active");</script>';

    }
    else if ($tab == 'categories')
    {
        echo '<script>$(".sidebar ul a:eq(5)").addClass("active");</script>';
    }
    else if ($tab == 'setting')
    {
        echo '<script>$(".sidebar ul a:eq(6)").addClass("active");</script>';
    }
    else if ($tab == 'accounts')
{
    echo '<script>$(".sidebar ul a:eq(3)").addClass("active");</script>';
}
}
 
?>
</body>
</html>