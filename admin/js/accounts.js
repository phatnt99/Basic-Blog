// Thêm tài khoản
$('#formAddAcc button').on('click', function() {
    $un_add_acc = $('#un_add_acc').val();
    $pw_add_acc = $('#pw_add_acc').val();
    $repw_add_acc = $('#repw_add_acc').val();
 
    if ($un_add_acc == '' || $pw_add_acc == '' || $repw_add_acc == '')
    {
        $('#formAddAcc .alert').removeClass('hidden');
        $('#formAddAcc .alert').html('Vui lòng điền đầy đủ thông tin.');
    }
    else
    {
        $.ajax({
            url : '/basiclearn/Newspaper/admin/accounts.php',
            type : 'POST',
            data : {
                un_add_acc: $un_add_acc,
                pw_add_acc : $pw_add_acc,
                repw_add_acc : $repw_add_acc,
                action : 'add_acc'
            }, success : function(data) {
                $('#formAddAcc .alert').html(data);
            }, error : function() {
                $('#formAddAcc .alert').removeClass('hidden');
                $('#formAddAcc .alert').html('Đã có lỗi xảy ra, hãy thử lại.');
            }  
        });
    }
});

// Khoá nhiều tài khoản cùng lúc
$('#lock_acc_list').on('click', function() {
    $confirm = confirm('Bạn có chắc chắn muốn khoá các tài khoản đã chọn không?');
    if ($confirm == true)
    {
        $id_acc = [];
 
        $('#list_acc input[type="checkbox"]:checkbox:checked').each(function(i) {
            $id_acc[i] = $(this).val();
        });
 
        if ($id_acc.length === 0)
        {
            alert('Vui lòng chọn ít nhất một tài khoản.');
        }
        else
        {
            $.ajax({
                url :'/basiclearn/Newspaper/admin/accounts.php',
                type : 'POST',
                data : {
                    id_acc : $id_acc,
                    action : 'lock_acc_list'
                },
                success : function(data) {
                    location.reload();
                }, error : function() {
                    alert('Đã có lỗi xảy ra, hãy thử lại.');
                }
            });
        }
    }
    else
    {
        return false;
    }
});

// Khoá tài khoản chỉ định trong bảng danh sách
$('.lock-acc-list').on('click', function() {
    $confirm = confirm('Bạn có chắc chắn muốn khoá tài khoản này không?');
    if ($confirm == true)
    {
        $id_acc = $(this).attr('data-id');
 
        $.ajax({
            url :'/basiclearn/Newspaper/admin/accounts.php',
            type : 'POST',
            data : {
                id_acc : $id_acc,
                action : 'lock_acc'
            },
            success : function() {
                location.reload();
            }
        });
    }
    else
    {
        return false;
    }
});

// Mở khoá nhiều tài khoản cùng lúc
$('#unlock_acc_list').on('click', function() {
    $confirm = confirm('Bạn có chắc chắn muốn mở khoá các tài khoản đã chọn không?');
    if ($confirm == true)
    {
        $id_acc = [];
 
        $('#list_acc input[type="checkbox"]:checkbox:checked').each(function(i) {
            $id_acc[i] = $(this).val();
        });
 
        if ($id_acc.length === 0)
        {
            alert('Vui lòng chọn ít nhất một tài khoản.');
        }
        else
        {
            $.ajax({
                url : '/basiclearn/Newspaper/admin/accounts.php',
                type : 'POST',
                data : {
                    id_acc : $id_acc,
                    action : 'unlock_acc_list'
                },
                success : function(data) {
                    location.reload();
                }, error : function() {
                    alert('Đã có lỗi xảy ra, hãy thử lại.');
                }
            });
        }
    }
    else
    {
        return false;
    }
});

// Mở tài khoản chỉ định trong bảng danh sách
$('.unlock-acc-list').on('click', function() {
    $confirm = confirm('Bạn có chắc chắn muốn mở khoá tài khoản này không?');
    if ($confirm == true)
    {
        $id_acc = $(this).attr('data-id');
 
        $.ajax({
            url : '/basiclearn/Newspaper/admin/accounts.php',
            type : 'POST',
            data : {
                id_acc : $id_acc,
                action : 'unlock_acc'
            },
            success : function() {
                location.reload();
            }
        });
    }
    else
    {
        return false;
    }
});

// Xoá nhiều tài khoản cùng lúc
$('#del_acc_list').on('click', function() {
    $confirm = confirm('Bạn có chắc chắn muốn xoá các tài khoản đã chọn không?');
    if ($confirm == true)
    {
        $id_acc = [];
 
        $('#list_acc input[type="checkbox"]:checkbox:checked').each(function(i) {
            $id_acc[i] = $(this).val();
        });
 
        if ($id_acc.length === 0)
        {
            alert('Vui lòng chọn ít nhất một tài khoản.');
        }
        else
        {
            $.ajax({
                url : '/basiclearn/Newspaper/admin/accounts.php',
                type : 'POST',
                data : {
                    id_acc : $id_acc,
                    action : 'del_acc_list'
                },
                success : function(data) {
                    location.reload();
                }, error : function() {
                    alert('Đã có lỗi xảy ra, hãy thử lại.');
                }
            });
        }
    }
    else
    {
        return false;
    }
});

// Xoá tài khoản chỉ định trong bảng danh sách
$('.del-acc-list').on('click', function() {
    $confirm = confirm('Bạn có chắc chắn muốn xoá tài khoản này không?');
    if ($confirm == true)
    {
        $id_acc = $(this).attr('data-id');
 
        $.ajax({
            url : '/basiclearn/Newspaper/admin/accounts.php',
            type : 'POST',
            data : {
                id_acc : $id_acc,
                action : 'del_acc'
            },
            success : function() {
                location.reload();
            }
        });
    }
    else
    {
        return false;
    }
})