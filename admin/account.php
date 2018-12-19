<?php

// Kết nối database và thông tin chung
require_once 'core/init.php';

// Nếu đăng nhập
if ($user) {
    // Nếu tồn tại POST action
    if (isset($_POST['action'])) {
        // Xử lý POST action
        $action = trim(addslashes(htmlspecialchars($_POST['action'])));
        
        // Thêm tài khoản
        if ($action == 'add_acc') {
            // Xử lý các giá trị
            $un_add_acc = trim(htmlspecialchars(addslashes($_POST['un_add_acc'])));
            $pw_add_acc = trim(htmlspecialchars(addslashes($_POST['pw_add_acc'])));
            $repw_add_acc = trim(htmlspecialchars(addslashes($_POST['repw_add_acc'])));
            $id_type_add_acc = trim(htmlspecialchars(addslashes($_POST['id_type_add_acc'])));
            // Các biến xử lý thông báo
            $show_alert = '<script>$("#formAddAcc .alert").removeClass("hidden");</script>';
            $hide_alert = '<script>$("#formAddAcc .alert").addClass("hidden");</script>';
            $success = '<script>$("#formAddAcc .alert").attr("class", "alert alert-success");</script>';
            
            // Kiểm tra tên đăng nhập
            $sql_check_un_exist = "SELECT USER_NAME FROM user_account WHERE USER_NAME = '$un_add_acc'";
            if ($un_add_acc == '' || $pw_add_acc == '' || $repw_add_acc == '' || $id_type_add_acc == '') {
                echo $show_alert . 'Vui lòng điền đầy đủ thông tin.';
            } else if (strlen($un_add_acc) < 6 || strlen($un_add_acc) > 32) {
                echo $show_alert . 'Tên đăng nhập nằm trong khoảng 6-32 ký tự.';
            } else if (preg_match('/\W/', $un_add_acc)) {
                echo $show_alert . 'Tên đăng nhập không chứa kí tự đậc biệt và khoảng trắng.';
            } else if ($db->num_rows($sql_check_un_exist)) {
                echo $show_alert . 'Tên đăng nhập đã tồn tại.';
            } else if (strlen($pw_add_acc) < 6) {
                echo $show_alert . 'Mật khẩu quá ngắn.';
            } else if ($pw_add_acc != $repw_add_acc) {
                echo $show_alert . 'Mật khẩu nhập lại không khớp.';
            } else {
                $pw_add_acc = md5($pw_add_acc);
                $sql_add_user_account = "INSERT INTO user_account VALUES (
                '',
                '$un_add_acc',
                '$pw_add_acc',
                '$id_type_add_acc'
            )";
                $db->query($sql_add_user_account);
                // tạo 1 profle trống có id_user trùng với user vừa tạo
                $max_id = $db->query("SELECT MAX(ID_USER) FROM user_account");
                $db->query("INSERT INTO user_profile VALUES(
                '','','','','','','','',
                '$max_id','0','',''
                )");
                $db->close();

                echo $show_alert . $success . 'Thêm tài khoản thành công.';
                new Redirect($_DOMAIN . 'account'); // Trở về trang danh sách tài khoản
            }
        }
        // Xoá tài khoản
        // Xoá nhiều tài khoản cùng lúc     
        else if ($action == 'del_acc_list') {
            foreach ($_POST['id_user'] as $key => $id_user) {
                $sql_check_ID_USER_exist = "SELECT ID_USER FROM user_acount UA, user_profile UP WHERE UA.ID_USER = '$id_user' AND UA.ID_USER = UP.ID_USER";
                if ($db->num_rows($sql_check_ID_USER_exist)) {
                    $sql_del_acc = "DELETE FROM user_profile WHERE ID_USER = '$id_user'";
                    $db->query($sql_del_acc);
                    $sql_del_account = "DELETE FROM user_acount WHERE ID_USER = '$id_user'";
                    $db->query($sql_del_account);
                }
            }
            $db->close();
        }
    // Xoá 1 tài khoản
        else if ($action == 'del_acc') {
            $id_user = trim(htmlspecialchars(addslashes($_POST['id_user'])));
            $sql_check_ID_USER_exist = "SELECT ID_USER FROM user_acount UA, user_profile UP WHERE UA.ID_USER = '$id_user' AND UA.ID_USER = UP.ID_USER";
            if ($db->num_rows($sql_check_ID_USER_exist)) {
                $sql_del_acc = "DELETE FROM user_acount UA, user_profile UP WHERE UA.ID_USER = '$id_user' AND UA.ID_USER = UP.ID_USER";
                $db->query($sql_del_acc);
                $db->close();
            }
        } 
        //tìm kiếm tài khoản
        else if ($action == 'search_acc') {
            $kw_search_acc = trim(htmlspecialchars(addslashes($_POST['kw_search_acc'])));
            if ($kw_search_acc != '') {
                $sql_search_acc = "SELECT * FROM user_account UA, user_profile UP
                WHERE UA.ID_USER = UP.ID_USER
                AND (UA.ID_TYPE LIKE '%$kw_search_acc%'
                OR UP.NAME LIKE '%$kw_search_acc%'
                OR UP.EMAIL LIKE '%$kw_search_acc%'
                OR UA.USER_NAME LIKE '%$kw_search_acc%')
                ORDER BY UP.STATUS DESC, UA.ID_TYPE ASC";

                if ($db->num_rows($sql_search_acc)) {
                    echo
                        '
                <table class="table table-hover list">
                <tr>
                <th><input type="checkbox" id="selectAllAccount"></th>
                <th><strong>Tên tài khoản</strong></th>
                <th><strong>Địa chỉ Email</strong></th>
                <th><strong>Vai trò</strong></th>                  
                <th><strong>Trạng thái</strong></th>
                </tr>
                ';
                    foreach ($db->fetch_assoc($sql_search_acc, 0) as $key => $data_acc) {

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
                ';
                }
// Nếu không có tài khoản
                else {
                    echo '<br><br><div class="alert alert-info">Không tìm thấy tài khoản nào.</div>';
                }
            } else {
                echo '<br><br><div class="alert alert-info">Vui lòng nhập từ khóa.</div>';
            }
        } else {
            new Redirect($_DOMAIN); // Trở về trang index
        }
    }
} else {
    new Redirect($_DOMAIN); // Trở về trang index
}