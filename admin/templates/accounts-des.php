<?php
  
// Nếu đăng nhập
if ($user)
{
    // Nếu tài khoản là tác giả
    if ($data_user['position'] == 0)
    {
        echo '<div class="alert alert-danger">Bạn không có đủ quyền để vào trang này.</div>';
    } 
    // Ngược lại tài khoản là admin
    else if ($data_user['position'] == 1) 
    {
        echo '<h3>Tài khoản</h3>';
        // Lấy tham số ac
        if (isset($_GET['ac']))
        {
            $ac = trim(addslashes(htmlspecialchars($_GET['ac'])));
        }
        else
        {
            $ac = '';
        }
      
        // Lấy tham số id
        if (isset($_GET['id']))
        {
            $id = trim(addslashes(htmlspecialchars($_GET['id'])));
        }
        else
        {
            $id = '';
        }
      
        // Nếu có tham số ac
        if ($ac != '') 
        {
            // Trang thêm tài khoản
            if ($ac == 'add')
            {
                // Dãy nút của thêm tài khoản
                echo
                '
                    <a href="/basiclearn/Newspaper/admin/accounts" class="btn btn-default">
                        <span class="glyphicon glyphicon-arrow-left"></span> Trở về
                    </a> 
                ';
      
                // Content thêm tài khoản
                echo '
    <p class="form-add-acc">
        <form method="POST" id="formAddAcc" onsubmit="return false;">
            <div class="form-group">
                <label>Tên đăng nhập</label>
                <input type="text" class="form-control title" id="un_add_acc">
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" class="form-control title" id="pw_add_acc">
            </div>
            <div class="form-group">
                <label>Nhập lại mật khẩu</label>
                <input type="password" class="form-control title" id="repw_add_acc">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Thêm</button>
            </div>
            <div class="alert alert-danger hidden"></div>
        </form>
    </p>
';
            }         
        }
        // Ngược lại không có tham số ac
        // Trang danh sách tài khoản
        else
        {
            // Dãy nút của danh sách tài khoản
            echo
            '
                <a href="/basiclearn/Newspaper/admin/accounts/add" class="btn btn-default">
                    <span class="glyphicon glyphicon-plus"></span> Thêm
                </a> 
                <a href="/basiclearn/Newspaper/admin/accounts" class="btn btn-default">
                    <span class="glyphicon glyphicon-repeat"></span> Reload
                </a>
                <a class="btn btn-warning" id="lock_acc_list">
                    <span class="glyphicon glyphicon-lock"></span> khoá
                </a>
                <a class="btn btn-success" id="unlock_acc_list">
                    <span class="glyphicon glyphicon-lock"></span> Mở khoá
                </a> 
                <a class="btn btn-danger" id="del_acc_list">
                    <span class="glyphicon glyphicon-trash"></span> Xoá
                </a> 
            ';
      
            // Content danh sách tài khoản
            $sql_get_list_acc = "SELECT * FROM accounts ORDER BY id_acc DESC";
// Nếu có tài khoản
if ($db->num_rows($sql_get_list_acc))
{
    echo
    '
        <br><br>
        <div class="table-responsive">
            <table class="table table-striped list" id="list_acc">
                <tr>
                    <td><input type="checkbox"></td>
                    <td><strong>ID</strong></td>
                    <td><strong>Tên đăng nhập</strong></td>
                    <td><strong>Trạng thái</strong></td>
                    <td><strong>Tools</strong></td>
                </tr>
    ';
 
    // In danh sách tài khoản
    foreach ($db->fetch_assoc($sql_get_list_acc, 0) as $key => $data_acc)
    {
        // Trạng thái tài khoản
        if ($data_acc['status'] == 0) {
            $stt_acc = '<label class="label label-success">Hoạt động</label>';
        } else if ($data_acc['status'] == 1) {
            $stt_acc = '<label class="label label-warning">Khoá</label>';
        }
 
        echo
        '
            <tr>
                <td><input type="checkbox" name="id_acc[]" value="' . $data_acc['id_acc'] .'"></td>
                <td>' . $data_acc['id_acc'] .'</td>
                <td>' . $data_acc['username'] . '</td>
                <td>' . $stt_acc . '</td>
                <td>
                    <a data-id="' . $data_acc['id_acc'] . '" class="btn btn-sm btn-warning lock-acc-list">
                        <span class="glyphicon glyphicon-lock"></span>
                    </a>
                    <a data-id="' . $data_acc['id_acc'] . '" class="btn btn-sm btn-success unlock-acc-list">
                        <span class="glyphicon glyphicon-lock"></span>
                    </a>
                    <a data-id="' . $data_acc['id_acc'] . '" class="btn btn-sm btn-danger del-acc-list">
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                </td>
            </tr>
        ';
    }
 
    echo
    '
            </table>
        </div>
    ';
}
// Nếu không có tài khoản
else
{
    echo '<br><br><div class="alert alert-info">Chưa có tài khoản nào.</div>';
}
        }
    }
}
// Ngược lại chưa đăng nhập
else
{
    new Redirect('index.php'); // Trở về trang index
}
  
?>