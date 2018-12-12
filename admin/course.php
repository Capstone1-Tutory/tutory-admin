<?php

// Kết nối database và thông tin chung
require_once 'core/init.php';

// Nếu đăng nhập
if ($user) {
    // Nếu tồn tại POST action
    if (isset($_POST['action'])) {
        // Xử lý POST action
        $action = trim(addslashes(htmlspecialchars($_POST['action'])));
        // load major
        if ($action == 'load_major') {
            // Xử lý giá trị
            $id_major = trim(addslashes(htmlspecialchars($_POST['id_major'])));
            $sql_name_tutor = "SELECT * FROM tutor T, user_profile UP ,tutor_rela_major TRM
                WHERE T.ID_TUTOR = TRM.ID_TUTOR
                AND T.ID_PROFILE = UP.ID_PROFILE
                AND TRM.ID_MAJOR = '$id_major'
                ";
            if ($db->num_rows($sql_name_tutor)) {
                foreach ($db->fetch_assoc($sql_name_tutor, 0) as $key => $name_tutor)

                    echo '
                        <option value="' . $name_tutor['ID_TUTOR'] . '">' . $name_tutor['NAME'] . '></option>
                        ';
            }
        }
        // Thêm khóa học
        if ($action == 'add_course') {
            // Xử lý các giá trị
            
            
            // Các biến xử lý thông báo





            echo $show_alert . $success . 'Thêm khóa học thành công.';
            new Redirect($_DOMAIN . 'course'); // Trở về trang danh sách tài khoản
        }

    }

} else {
    new Redirect($_DOMAIN); // Trở về trang index
}
