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
            $name_add_acc = trim(htmlspecialchars(addslashes($_POST['name_add_acc'])));
            $email_add_acc = trim(htmlspecialchars(addslashes($_POST['email_add_acc'])));
            // Các biến xử lý thông báo
            $show_alert = '<script>$("#formAddAcc .alert").removeClass("hidden");</script>';
            $hide_alert = '<script>$("#formAddAcc .alert").addClass("hidden");</script>';
            $success = '<script>$("#formAddAcc .alert").attr("class", "alert alert-success");</script>';
            
            // Kiểm tra tên đăng nhập
            $sql_check_un_exist = "SELECT USER_NAME FROM user_account WHERE USER_NAME = '$un_add_acc'";
            // Kiểm tra email
            $sql_check_email_exist = "SELECT EMAIL FROM user_profile WHERE EMAIL = '$email_add_acc'";
            if ($un_add_acc == '' || $pw_add_acc == '' || $repw_add_acc == '' || $name_add_acc == '' || $email_add_acc == '') {
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
            } else if ($db->num_rows($sql_check_email_exist)) {
                echo $show_alert . 'Email đã tồn tại.';
            } else {
                $pw_add_acc = md5($pw_add_acc);
                $sql_add_user_account = "INSERT INTO user_account VALUES (
                '',
                '$un_add_acc',
                '$pw_add_acc',
                '$id_type_add_acc'
            )";
                $sql_add_user_profile = "INSERT INTO user_profile VALUES (
            '',
            '$name_add_acc',
            '',
            '',
            '',
            '',
            '$email_add_acc',
            '',
            '0',
            ''
        )";
                $db->query($sql_add_user_account);
                $db->query($sql_add_user_profile);
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
                    $sql_del_acc = "DELETE FROM user_acount UA, user_profile UP WHERE UA.ID_USER = '$id_user' AND UA.ID_USER = UP.ID_USER
                    
                    ";
                    $db->query($sql_del_acc);
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
        } else {
            new Redirect($_DOMAIN); // Trở về trang index
        }
    }
} else {
    new Redirect($_DOMAIN); // Trở về trang index
}