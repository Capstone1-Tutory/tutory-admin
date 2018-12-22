<?php

// Kết nối database và thông tin chung
require_once 'core/init.php';

// Nếu đăng nhập
if ($user) {
    // Nếu có file upload
    if (isset($_FILES['img_avt'])) {
        $dir = "../upload/";
        $name_img = stripslashes($_FILES['img_avt']['name']);
        $source_img = $_FILES['img_avt']['tmp_name'];
        
        // Lấy ngày, tháng, năm hiện tại
        $day_current = substr($date_current, 8, 2);
        $month_current = substr($date_current, 5, 2);
        $year_current = substr($date_current, 0, 4);
        
        // Tạo folder năm hiện tại
        if (!is_dir($dir . $year_current)) {
            mkdir($dir . $year_current . '/');
        } 
        
        // Tạo folder tháng hiện tại
        if (!is_dir($dir . $year_current . '/' . $month_current)) {
            mkdir($dir . $year_current . '/' . $month_current . '/');
        }   
        
        // Tạo folder ngày hiện tại
        if (!is_dir($dir . $year_current . '/' . $month_current . '/' . $day_current)) {
            mkdir($dir . $year_current . '/' . $month_current . '/' . $day_current . '/');
        }

        $path_img = $dir . $year_current . '/' . $month_current . '/' . $day_current . '/' . $name_img; // Đường dẫn thư mục chứa file
        move_uploaded_file($source_img, $path_img); // Upload file
        $url_img = substr($path_img, 3); // Đường dẫn file

        $sql_up_avt = "UPDATE user_profile SET URL_AVATAR = '$url_img' WHERE ID_PROFILE = '$data_user[ID_PROFILE]'";
        $db->query($sql_up_avt);
        echo 'Cập nhật thành công.';
        $db->close();
        new Redirect($_DOMAIN . 'profile');
    } 
    // Nếu tồn tại POST action
    else if (isset($_POST['action'])) {
        $action = trim(addslashes(htmlspecialchars($_POST['action'])));
        
        // Xoá ảnh đại diện
        if ($action == 'delete_avt') {
            if (file_exists('../' . $data_user['URL_AVATAR'])) {
                unlink('../' . $data_user['URL_AVATAR']);
            }

            $sql_delete_avt = "UPDATE user_profile SET URL_AVATAR = '' WHERE ID_PROFILE = '$data_user[ID_PROFILE]'";
            $db->query($sql_delete_avt);
            $db->close();
        }
        // Cập nhật các thông tin 
        else if ($action == 'up_profile') {
    // Xử lý các giả trị
            $name_update = trim(htmlspecialchars(addslashes($_POST['name_update'])));
            $email_update = trim(htmlspecialchars(addslashes($_POST['email_update'])));
            $phone_update = trim(htmlspecialchars(addslashes($_POST['phone_update'])));
            $birthday_update = trim(htmlspecialchars(addslashes($_POST['birthday_update'])));
            $address_update = trim(htmlspecialchars(addslashes($_POST['address_update'])));
        
    // Các biến xử lý thông báo
            $show_alert = '<script>$("#formUpdateInfo .alert").removeClass("hidden");</script>';
            $hide_alert = '<script>$("#formUpdateInfo .alert").addClass("hidden");</script>';
            $success = '<script>$("#formUpdateInfo .alert").attr("class", "alert alert-success");</script>';

            if ($name_update && $email_update && $phone_update && $birthday_update && $address_update) {
        // Kiểm tra tên hiển thị
                if (strlen($name_update) < 3 || strlen($name_update) > 50) {
                    echo $show_alert . 'Họ và tên phải từ 3 đến 50 ký tự.';
        // Kiểm tra email   
                } else if (filter_var($email_update, FILTER_VALIDATE_EMAIL) === false) {
                    echo $show_alert . 'Email không hợp lệ.';
        // Kiểm tra số điện thoại
                } else if ($phone_update && (strlen($phone_update) < 10 || strlen($phone_update) > 11 || preg_match('/^[0-9]+$/', $phone_update) == false)) {
                    echo $show_alert . strlen($phone_update) . 'Số điện thoại không đúng';
                } else if ($birthday_update >= getdate()) {
                    echo $show_alert . 'Ngày sinh không hợp lệ.';
                } else {
                    $sql_update_info = "UPDATE user_profile SET
                NAME = '$name_update',
                EMAIL = '$email_update',
                PHONE = '$phone_update',
                BIRTHDAY = '$birthday_update',
                SO_NHA = '$address_update'
                WHERE ID_PROFILE = '$data_user[ID_PROFILE]'
                ";
                    $db->query($sql_update_info);
                    $db->close();
                    echo $success . 'Cập nhật thành công';
                    new Redirect($_DOMAIN . 'profile');
                }
            } else {
                echo $show_alert . 'Vui lòng điền đẩy đủ thông tin.';
            }
        }
        // Đổi mật khẩu
        else if ($action == 'change_pw') {
        // Xử lý các giá trị
            $oldPwChange = md5($_POST['oldPwChange']);
            $newPwChange = trim(htmlspecialchars(addslashes($_POST['newPwChange'])));
            $reNewPwChange = trim(htmlspecialchars(addslashes($_POST['reNewPwChange'])));
        
        // Các biến xử lý thông báo
            $show_alert = '<script>$("#formChangePw .alert").removeClass("hidden");</script>';
            $hide_alert = '<script>$("#formChangePw .alert").addClass("hidden");</script>';
            $success = '<script>$("#formChangePw .alert").attr("class", "alert alert-success");</script>';

            if ($oldPwChange && $newPwChange && $reNewPwChange) {
        // Kiểm tra mật khẩu cũ chính xác
                if ($oldPwChange != $data_user['PASS_WORD']) {
                    echo $show_alert . 'Mật khẩu cũ không chính xác.';
        // Kiểm tra mật khẩu mới    
                } else if (strlen($newPwChange) < 6) {
                    echo $show_alert . 'Mật khẩu mới quá ngắn.';
        // Kiểm tra mật khẩu mới khớp với mật khẩu mới nhập lại 
                } else if ($oldPwChange == $newPwChange) {
                    echo $show_alert . 'Đây là mật khẩu cũ';
                } else if ($newPwChange != $reNewPwChange) {
                    echo $show_alert . 'Mật khẩu mới không trùng khớp.';
                } else {
                    $newPwChange = md5($newPwChange);
                    $sql_change_pw = "UPDATE user_account SET PASS_WORD = '$newPwChange' WHERE ID_USER = '$data_user[ID_USER]'";
                    $db->query($sql_change_pw);
                    $db->close();
                    echo $success . 'Đổi mật khẩu thành công';
                    new Redirect($_DOMAIN . 'profile');
                }
            } else {
                echo $show_alert . 'Vui lòng điền đầy đủ thông tin.';
            }
        }
    } else {
        new Redirect($_DOMAIN);
    }
}
// Ngược lại chưa đăng nhập
else {
    new Redirect($_DOMAIN); // Trở về trang index
}

?>
