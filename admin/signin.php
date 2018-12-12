<?php
 
// Kết nối database và thông tin chung
require_once 'core/init.php';
 
// Nếu có tồn tại phương thức post
if (isset($_POST['user_signin']) && isset($_POST['pass_signin']))
{
    // Xử lý các giá trị 
    $user_signin = trim(htmlspecialchars(addslashes($_POST['user_signin'])));
    $pass_signin = trim(htmlspecialchars(addslashes($_POST['pass_signin'])));
 
    // Các biến xử lý thông báo
    $show_alert = '<script>$("#formSignin .alert").removeClass("hidden");</script>';
    $hide_alert = '<script>$("#formSignin .alert").addClass("hidden");</script>';
    $success = '<script>$("#formSignin .alert").attr("class", "alert alert-success");</script>';
 
    // Nếu giá trị rỗng
    if ($user_signin == '' || $pass_signin == '')
    {
        echo $show_alert.'Vui lòng nhập đầy đủ thông tin.';
    }
    // Ngược lại
    else
    {
        $sql_check_user_exist = "SELECT USER_NAME FROM user_account WHERE USER_NAME = '$user_signin'";
        // Nếu tồn tại username
        if ($db->num_rows($sql_check_user_exist))
        {
            $pass_signin = md5($pass_signin);
            $sql_check_signin = "SELECT USER_NAME, PASS_WORD FROM user_account WHERE USER_NAME = '$user_signin' AND PASS_WORD = '$pass_signin'";
            if ($db->num_rows($sql_check_signin))
            {
                $sql_check_stt = "SELECT USER_NAME, PASS_WORD FROM user_account WHERE USER_NAME = '$user_signin' AND PASS_WORD = '$pass_signin' AND ID_TYPE = 'ad'";
                // Nếu username và password khớp 
                if ($db->num_rows($sql_check_stt))
                {
                    // Lưu session
                    $session->send($user_signin);
                    echo $show_alert.$success.'Đăng nhâp thành công.';
                    new Redirect($_DOMAIN); // Trở về trang index

                }
                else
                {
                    echo $show_alert.'Tài khoản không phải quản trị viên, bạn không có quyền truy cập vào trang này.';
                }
            }
            else
            {
                echo $show_alert.'Bạn đã nhập sai mật khẩu.';
            }
        }
        // Ngược lại không tồn tại username
        else
        {
            echo $show_alert.'Tên tài khoản không tồn tại.';
        }
    }
}
// Ngược lại không tồn tại phương thức post
else
{
    new Redirect($_DOMAIN); // Trở về trang index
}
 
?>