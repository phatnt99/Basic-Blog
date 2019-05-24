<?php
  
// Nếu đăng nhập
if ($user)
{
   
    echo '<h3>Hình ảnh</h3>';
    // Lấy tham số ac
    if (isset($_GET['ac']))
    {
        $ac = trim(addslashes(htmlspecialchars($_GET['ac'])));
    }
    else
    {
        $ac = '';
    }
  
  
    // Nếu có tham số ac
    if ($ac != '') 
    {
        // Trang upload hình ảnh
        if ($ac == 'add')
        {
            // Dãy nút của upload hình ảnh
            echo
            '
                <a href="/basiclearn/Newspaper/admin/photos" class="btn btn-default">
                    <span class="glyphicon glyphicon-arrow-left"></span> Trở về
                </a> 
            ';
  
            // Content upload hình ảnh
            echo
'
    <p class="form-up-img">
        <div class="alert alert-info">Mỗi lần upload tối đa 20 file ảnh. Mỗi file có dung lượng không vượt quá 5MB và có đuôi định dạng là .jpg, .png.gif., </div>
        <form action="/basiclearn/Newspaper/admin/photos.php"method="POST" id="formUpImg" enctype="multipart/form-data" onsubmit="return false;">
            <div class="form-group">
                <label>Chọn hình ảnh</label>
                <input type="file" class="form-control" accept="image/*" name="img_up[]" multiple="true" id="img_up" onchange="preUpImg();">
            </div>
            <div class="form-group box-pre-img hidden">
                <p><strong>Ảnh xem trước</strong></p>
            </div>
            <div class="form-group hidden box-progress-bar">
                <div class="progress">
                    <div class="progress-bar" role="progressbar"></div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Upload</button>
                <button class="btn btn-default" type="reset">Chọn lại</button>
            </div>
            <div class="alert alert-danger hidden"></div>
        </form>
    </p>
';
 
        } 
         
    }
    // Ngược lại không có tham số ac
    // Trang danh sách hình ảnh
    
    else
    {
        // Dãy nút của danh sách hình ảnh
        echo
        '
            <a href="/basiclearn/Newspaper/admin/photos/add" class="btn btn-default">
                <span class="glyphicon glyphicon-plus"></span> Thêm
            </a> 
            <a href="/basiclearn/Newspaper/admin/photos" class="btn btn-default">
                <span class="glyphicon glyphicon-repeat"></span> Reload
            </a> 
            <a class="btn btn-danger" id="del_img_list">
                <span class="glyphicon glyphicon-trash"></span> Xoá
            </a> 
        ';
  
        // Content danh sách hình ảnh
        $sql_get_img = "SELECT * FROM images ORDER BY id_img DESC";
if ($db->num_rows($sql_get_img))
{
    echo '
        <div class="row list" id="list_img">
            <div class="col-md-12">
                <div class="checkbox"><label><input type="checkbox"> Chọn/Bỏ chọn tất cả</label></div>
            </div>
    ';
    foreach($db->fetch_assoc($sql_get_img, 0) as $key => $data_img) 
    {
        // Trạng thái ảnh
        if (file_exists('../'.$data_img['url'])) {
            $status_img = '<label class="label label-success">Tồn tại</label>';
        }
        else
        {
            $status_img = '<label class="label label-danger">Hỏng</label>';
        }
 
        // Dung lượng ảnh
        if ($data_img['size'] < 1024) {
            $size_img = $data_img['size'] . 'B';
        } else if ($data_img['size'] < 1048576) {
            $size_img = round($data_img['size'] / 1024) . 'KB';               
        } else if ($data_img['size'] > 1048576) {
            $size_img = round($data_img['size'] / 1024 / 1024) . 'MB';
        }
 
        echo
        '    
            <div class="col-md-3">
                <div class="thumbnail">
                    <a href="' . str_replace('admin/', '', '/basiclearn/Newspaper/admin/') . $data_img['url'] . '">
                        <img src="' . str_replace('admin/', '', '/basiclearn/Newspaper/admin/') . $data_img['url'] . '" style="height: 150px;">
                    </a>
                    <div class="caption">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <input type="checkbox" name="id_img[]" value="' . $data_img['id_img'] . '">
                            </span>
                            <input type="text" class="form-control" value="' . str_replace('admin/', '', '/basiclearn/Newspaper/admin/')  . $data_img['url'] . '" disabled>
                            <span class="input-group-btn">
                                <button class="btn btn-danger del-img" data-id="' . $data_img['id_img'] . '">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </button>
                            </span>
                        </div>
                        <p>Trạng thái: ' . $status_img . '</p>
                        <p>Dung lượng: ' . $size_img . '</p>
                        <p>Định dạng: ' . strtoupper($data_img['type']) . '</p>
                    </div>
                </div>
            </div>   
        ';
    }
    echo '</div>';
}   
else
{
    echo '<br><br><div class="alert alert-info">Chưa có hình ảnh nào.</div>';
}
    }
}
// Ngược lại chưa đăng nhập
else
{
    new Redirect('index.php'); // Trở về trang index
}
  
?>