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
        if ($action == 'review_course') {
            $id_course = trim(htmlspecialchars(addslashes($_POST['id_course'])));
            $sql_check_course_id_exist = "SELECT ID_COURSE FROM course WHERE ID_COURSE = '$id_course'";
            if ($db->num_rows($sql_check_course_id_exist)) {
                $sql_review_course = "UPDATE course SET COURSE_STATUS = '1' WHERE ID_COURSE = '$id_course'";
                $db->query($sql_review_course);
                $db->close();
            }
        }
        if ($ac == 'list_schedule_in_course') {
            $id_course = trim(htmlspecialchars(addslashes($_POST['id_course'])));
            $sql_get_list_schedule = "SELECT * FROM schedule WHERE ID_COURSE = '$id_course'";
            if ($db->num_rows($sql_get_list_schedule)) {
                echo
                    '       
                    <div id="list_schedule_in_course" class="modal fade" role="dialog">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3>Chi tiết khóa học</h3>
                            </div>
                            <div class="modal-body">
                                                <div class="table-responsive">
                                                        <table class="table table-hover list" id="table_schedule">
                                                        <tr>
                                                        <th><strong>Ngày</strong></th>
                                                        <th><strong>Giờ bắt đầu</strong></th>
                                                        <th><strong>Giờ kết thúc</strong></th>                  
                                                        <th><strong>Địa điểm</strong></th>
                                                        <th><strong>Tình trạng</strong></th>
                                                        </tr>                                                        
                            ';
                // lấy chi tiết khóa học từ bảng thời khóa biểu
                foreach ($db->fetch_assoc($sql_get_list_schedule, 0) as $key => $data_schedule) {
                    if ($data_schedule['SCHEDULE_STATUS'] == 0) {
                        $stt_schedule = '<label class="label label-warning">Đang diễn ra</label>';
                    } else if ($data_schedule['SCHEDULE_STATUS'] == 1) {
                        $stt_schedule = '<label class="label label-info">Đang hoạt động</label>';
                    } else if ($data_schedule['SCHEDULE_STATUS'] == 2) {
                        $stt_schedule = '<label class="label label-default">Đã kết thúc</label>';
                    } else if ($data_schedule['SCHEDULE_STATUS'] == 3) {
                        $stt_schedule = '<label class="label label-danger">Đã hủy</label>';
                    }
                        // in ra dữ liệu
                    echo '
                                        <tr>
                                            <th>' . $data_schedule['SCHEDULE_DATE'] . '</th>
                                            <th>' . $data_schedule['SCHEDULE_START_TIME'] . ' giờ</th>
                                            <th>' . $data_schedule['SCHEDULE_END_TIME'] . ' giờ</th>                  
                                             <th>' . $data_schedule['PLACE'] . '</th>
                                            <th>' . $stt_schedule . '</th>
                                        </tr>
                                        </table>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    ';
                }
            } else {
                echo '<br><br><div class="alert alert-info">Chưa có lịch học cho khóa học này.</div>';
            }
        }
    }
} else {
    new Redirect($_DOMAIN); // Trở về trang index
}
