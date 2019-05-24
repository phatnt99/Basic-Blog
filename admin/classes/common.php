<?php
// Hàm điều hướng trang
class Redirect {
    public function Redirect($url = null) {
        if ($url)
        {
            echo '<script>location.href="'.$url.'";</script>';
        }
    }
}
 
?>