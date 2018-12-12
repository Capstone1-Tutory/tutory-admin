<?php

// Nếu đăng nhập
if ($user) {
    // Nếu tài khoản là tác giả
    if ($data_user['ID_TYPE'] != 'ad') {
        echo '<div class="alert alert-danger">Bạn không có đủ quyền để vào trang này.</div>';
    } 
    // Ngược lại tài khoản là admin
    else if ($data_user['ID_TYPE'] == 'ad') {
        // Lấy tham số ac
        if (isset($_GET['ac'])) {
            $ac = trim(addslashes(htmlspecialchars($_GET['ac'])));
        } else {
            $ac = '';
        }

        // Lấy tham số id
        if (isset($_GET['id'])) {
            $id = trim(addslashes(htmlspecialchars($_GET['id'])));
        } else {
            $id = '';
        }

        // Nếu có tham số ac
        if ($ac != '') {
            // Trang thêm tài khoản
            if ($ac == 'add_account') {
                echo
                    '
                <a href="' . $_DOMAIN . 'account" class="btn btn-default">
                <span class="glyphicon glyphicon-arrow-left"></span> Trở về
                </a> 
                ';
                // Content thêm tài khoản
                echo '
                <h3>Thêm tài khoản</h3>
                <p class="form-add-acc">
                <form method="POST" id="formAddAcc" onsubmit="return false;">
                <div class="form-group">
                <label>Tên tài khoản</label>
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
                <label>Họ và tên</label>
                <input type="text" class="form-control title" id="name_add_acc">
                </div>
                <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control title" id="email_add_acc">
                </div>
                <div class="form-group">
                <label>Chọn vai trò tài khoản</label>       
                <select  class="form-control title" name="id_type_add_acc">
                    <option value="ad">Quản trị viên</option>
                    <option value="user">Người dùng</option>
                </select>
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
        else {
            // Dãy nút của danh sách tài khoản
            echo
                '   
            <h3>Tài khoản</h3><hr>
            <form class="form-inline">
            <a href="' . $_DOMAIN . 'account/add_account" class="btn btn-default">
            <span class="glyphicon glyphicon-plus"></span> Thêm tài khoản
            </a>
            <a href="' . $_DOMAIN . 'account" class="btn btn-default">
            <span class="glyphicon glyphicon-repeat"></span> Tải lại
            </a>
            <a class="btn btn-danger" id="del_acc_list">
            <span class="glyphicon glyphicon-trash"></span> Xóa
            </a>              
            <input class="form-control mr-sm-2" type="search" placeholder="Nhập từ khóa .." aria-label="Search">
            <button class="btn btn-success my-2 my-sm-0" type="submit">Tìm kiếm</button>
            </form>
            ';

            // Content danh sách tài khoản
            $sql_get_list_acc = "SELECT * FROM user_account UA, user_profile UP
            WHERE UA.ID_USER = UP.ID_USER
            ORDER BY UP.STATUS DESC, UA.ID_TYPE ASC";

            // Nếu có tài khoản
            if ($db->num_rows($sql_get_list_acc)) {
                echo
                    '
                <br><br>
                <div class="table-responsive">
                <table class="table table-hover list" id="list_acc">
                <tr>
                <th><input type="checkbox" id="selectAll"></th>
                <th><strong>Tên tài khoản</strong></th>
                <th><strong>Địa chỉ Email</strong></th>
                <th><strong>Vai trò</strong></th>                  
                <th><strong>Trạng thái</strong></th>
                </tr>
                ';

            // In danh sách tài khoản
                foreach ($db->fetch_assoc($sql_get_list_acc, 0) as $key => $data_acc) {

                    if ($data_acc['ID_TYPE'] == 'ad') {
                        $role_acc = '<label class="label label-primary">Quản trị viên</label>';
                    } else if ($data_acc['ID_TYPE'] == 'user') {
                        if ($db->num_rows("SELECT ID_PROFILE FROM tutor WHERE ID_PROFILE = $data_acc[ID_PROFILE]")) {
                            $role_acc = '<label class="label label-warning">Gia sư</label>';
                        } else if ($db->num_rows("SELECT ID_PROFILE FROM student WHERE ID_PROFILE = $data_acc[ID_PROFILE]")) {
                            $role_acc = '<label class="label label-info">Học viên</label>';
                        } else {
                            $role_acc = '<label class="label label-default">Người dùng</label>';
                        }
                    }
                    
                
                    
                    
                    
                // Trạng thái tài khoản
                    if ($data_acc['STATUS'] == 0) {
                        $stt_acc = '<label class="label label-default">Ngoại tuyến</label>';
                    } else if ($data_acc['STATUS'] == 1) {
                        $stt_acc = '<label class="label label-success">Trực tuyến</label>';
                    }


                    echo
                        '
                    <tr>
                    <th><input type="checkbox" name="ID_USER[]" value="' . $data_acc['ID_USER'] . '"></th>
                    <th>' . $data_acc['USER_NAME'] . '</th>
                    <th>' . $data_acc['EMAIL'] . '</th>
                    <th>' . $role_acc . '</th>
                    <th>' . $stt_acc . '</th>
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
            else {
                echo '<br><br><div class="alert alert-info">Không có tài khoản nào trong hệ thống.</div>';
            }
        }
    }
}



// Ngược lại chưa đăng nhập
else {
    new Redirect($_DOMAIN); // Trở về trang index
}

?>
<script type="text/javascript">
    $('#selectAll').click(function(e){
        var table= $(e.target).closest('table');
        $('th input:checkbox',table).prop('checked',this.checked);
    });
// Print selected rows

</script>