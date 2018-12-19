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
                <select  class="form-control title" id="id_type_add_acc">
                    <option value="">Chọn vai trò tài khoản</option>
                    <option value="ad">Quản trị viên</option>
                    <option value="user">Người dùng</option>
                </select>
                </div>
                <div class="form-group">
                <div class="form-inline">
                <a href="' . $_DOMAIN . 'account" class="btn btn-default" style="color:red">
                <span class="glyphicon glyphicon-arrow-left" style="color:red"></span> Hủy
                </a>
                <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
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
            </form>     
            ';

            // Content danh sách tài khoản
            $sql_get_list_acc = "SELECT * FROM user_account UA, user_profile UP
            WHERE UA.ID_USER = UP.ID_USER
            ORDER BY UP.STATUS DESC, UA.ID_TYPE ASC";

            // Nếu có tài khoản
            if ($db->num_rows($sql_get_list_acc)) {
                //tìm kiếm tài khoản
                echo '
                <p>
                <form method="POST" id="formSearchAcc" onsubmit="return false;">
                    <div class="input-group">         
                        <input type="text" class="form-control" id="kw_search_acc" placeholder="Nhập từ khóa ...">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </span>
                    </div>
                </form>
                </p>
                ';
                echo
                    '
                <div class="table-responsive" id="list_acc">
                <table class="table table-hover list">
                <tr>
                <th><input type="checkbox" id="selectAllAccount"></th>
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
                    } else {
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
    $('#selectAllAccount').click(function(e){
        var table= $(e.target).closest('table');
        $('th input:checkbox',table).prop('checked',this.checked);
    });
// Print selected rows

</script>