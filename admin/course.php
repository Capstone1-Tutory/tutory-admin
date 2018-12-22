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
                foreach ($db->fetch_assoc($sql_name_tutor, 0) as $key => $name_tutor) {
                    echo '
                        <option value="' . $name_tutor['ID_TUTOR'] . '">' . $name_tutor['NAME'] . '</option>
                        ';
                }
            }
        } 
        // load huyện
        else if ($action == 'load_city') {
            // Xử lý giá trị
            $matp = trim(addslashes(htmlspecialchars($_POST['matp'])));
            $sql_name_district = "SELECT * FROM devvn_quanhuyen
                WHERE matp = '$matp'
                ";
            if ($db->num_rows($sql_name_district)) {
                foreach ($db->fetch_assoc($sql_name_district, 0) as $key => $name_district)

                    echo '
                        <option value="' . $name_district['maqh'] . '">' . $name_district['name'] . '</option>
                        ';
            }
        } 
        // load xã
        else if ($action == 'load_district') {
            // Xử lý giá trị
            $maqh = trim(addslashes(htmlspecialchars($_POST['maqh'])));
            $sql_name_commune = "SELECT * FROM devvn_xaphuongthitran
                WHERE maqh = '$maqh'
                ";
            if ($db->num_rows($sql_name_commune)) {
                foreach ($db->fetch_assoc($sql_name_commune, 0) as $key => $name_commune)

                    echo '
                        <option value="' . $name_commune['xaid'] . '">' . $name_commune['name'] . '</option>
                        ';
            }
        }
        // Thêm khóa học
        else if ($action == 'add_course') {
            $major_add_course = trim(htmlspecialchars(addslashes($_POST['major_add_course'])));
            $tutor_add_course = trim(htmlspecialchars(addslashes($_POST['tutor_add_course'])));
            $street_add_course = trim(htmlspecialchars(addslashes($_POST['street_add_course'])));
            $quantity_add_course = trim(htmlspecialchars(addslashes($_POST['quantitty_add_course'])));
            $startdate_add_course = trim(htmlspecialchars(addslashes($_POST['startdate_add_course'])));
            $enddate_add_course = trim(htmlspecialchars(addslashes($_POST['enddate_add_course'])));
            $starttime_add_course = trim(htmlspecialchars(addslashes($_POST['starttime_add_course'])));
            $endtime_add_course = trim(htmlspecialchars(addslashes($_POST['endtime_add_course'])));
             // Các biến xử lý thông báo
            $show_alert = '<script>$("#formAddCourse .alert").removeClass("hidden");</script>';
            $hide_alert = '<script>$("#formAddCourse .alert").addClass("hidden");</script>';
            $success = '<script>$("#formAddCourse .alert").attr("class", "alert alert-success");</script>';
            // nếu gia sư đó chưa từng dạy lớp nào
            //$sql_check_tutor = "SELECT ID_TUTOR FROM course";
            if ($major_add_course == '' || $tutor_add_course == '' || $street_add_course == '' || $quantity_add_course == ''
                || $startdate_add_course == '' || $enddate_add_course == '' || $starttime_add_course == '' || $endtime_add_course == '') {
                echo $show_alert . 'Vui lòng điền đầy đủ thông tin.';
            } else if ($quantity_add_course <= 0 && $quantity_add_course > 10) {
                echo $show_alert . 'Số lượng học viên không đúng';
            } else {

                $sql_add_course = "INSERT INTO course VALUES(
                    '',
                    '$tutor_add_course',
                    '0',
                    '$startdate_add_course',
                    '$enddate_add_course',
                    '$quantity_add_course',
                    '$major_add_course'
                )";
                $db->query($sql_add_course);
                $db->close();
                echo $show_alert . $success . 'Thêm khóa học thành công.';
                new Redirect($_DOMAIN . 'course'); // Trở về trang danh sách tài khoản
            }
        } 
        // duyệt khóa học
        else if ($action == 'review_course') {
            $id_course = trim(htmlspecialchars(addslashes($_POST['id_course'])));
            $sql_check_course_id_exist = "SELECT ID_COURSE FROM course WHERE ID_COURSE = '$id_course'";
            if ($db->num_rows($sql_check_course_id_exist)) {
                $sql_review_course = "UPDATE course SET COURSE_STATUS = '1' WHERE ID_COURSE = '$id_course'";
                $db->query($sql_review_course);
                $db->close();
            }
        } 
        // chi tiết từng khóa học
        else if ($action == 'detail_course') {
            $id_course = trim(htmlspecialchars(addslashes($_POST['id_course'])));
            $sql_get_list_schedule = "SELECT * FROM schedule WHERE ID_COURSE = '$id_course'";
            echo '<div class="form-group">
                    <div class="form-inline">
                    <a href="' . $_DOMAIN . 'course" class="btn btn-default" style="color:red">
                    <span class="glyphicon glyphicon-arrow-left" style="color:red"></span> Trở về
                    </a>
                    <label>Chi tiết khóa học</label>
                    </div>';
            if ($db->num_rows($sql_get_list_schedule)) {
                echo
                    ' 
                    </div>
                                                        <table class="table table-hover list">
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
                        if ($data_schedule['SCHEDULE_DATE'] == getdate()) {
                            if ($data_schedule['SCHEDULE_START_TIME'] > getdate(['hours'])) {
                                $stt_schedule = '<label class="label label-warning">Sắp diễn ra</label>';
                            } else if ($data_schedule['SCHEDULE_END_TIME'] < getdate(['hours'])) {
                                $stt_schedule = '<label class="label label-default">Đã kết thúc</label>';
                            } else {
                                $stt_schedule = '<label class="label label-info">Đang diễn ra</label>';
                            }
                        } else if ($data_schedule['SCHEDULE_DATE'] > getdate()) {
                            $stt_schedule = '<label class="label label-warning">Sắp diễn ra</label>';
                        } else {
                            $stt_schedule = '<label class="label label-default">Đã kết thúc</label>';
                        }
                    } else if ($data_schedule['SCHEDULE_STATUS'] == 1) {
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
                                    ';
                }
                echo '</table>';
            } else {
                echo '<br><br><div class="alert alert-danger">Chưa có lịch ở khóa học này.</div>';
            }
        }
        // tìm kiếm khóa học
        else if ($action == 'search_course') {
            $kw_search_course = trim(htmlspecialchars(addslashes($_POST['kw_search_course'])));
            if ($kw_search_course != '') {
                $sql_search_course = "SELECT * FROM course C, tutor T, user_profile UP, major M, tutor_rela_major TRM
                WHERE C.ID_TUTOR = T.ID_TUTOR
                AND T.ID_PROFILE = UP.ID_PROFILE
                AND TRM.ID_TUTOR = T.ID_TUTOR
                AND TRM.ID_MAJOR = M.ID_MAJOR
                AND (UP.NAME LIKE '%$kw_search_course%'
                OR M.MAJOR_NAME LIKE '%$kw_search_course%'
                OR C.COURSE_START_DATE LIKE '%$kw_search_course%'
                OR C.COURSE_END_DATE LIKE '%$kw_search_course%')
                ORDER BY COURSE_START_DATE ASC
            ";
                if ($db->num_rows($sql_search_course)) {
                    echo
                        '
                <table class="table table-hover list">
                <tr>
                <th><input type="checkbox" id="selectAllCourse"></th>
                <th></th>
                <th><strong>Tên gia sư</strong></th>
                <th><strong>Nghề nghiệp</strong></th>
                <th><strong>Chuyên ngành</strong></th>
                <th><strong>Trung tâm</strong></th>                  
                <th><strong>Ngày bắt đầu</strong></th>
                <th><strong>Ngày kết thúc</strong></th>
                <th><strong>Số lượng</strong></th>
                <th><strong>Tình trạng</strong></th>
                </tr>
                ';
                    foreach ($db->fetch_assoc($sql_search_course, 0) as $key => $data_course) {
                    // đếm học viên của khóa học
                        $count_student = $db->num_rows("SELECT ID_STUDENT FROM student_rela_course WHERE ID_COURSE = $data_course[ID_COURSE]");          
                    //trạng thái khóa học
                        if ($data_course['COURSE_STATUS'] == 0) {
                            $stt_course = '
                        <a data-id="' . $data_course['ID_COURSE'] . '" class="label label-warning" id="review_course">
                        <span class="glyphicon glyphicon-ok"></span> Chưa duyệt</a>';
                        } else if ($data_course['COURSE_STATUS'] == 2) {
                            $stt_course = '<label class="label label-danger">Đã hủy</label>';
                        } else if ($data_course['COURSE_STATUS'] == 1) {
                            $today = date("Y-m-d");
                            if (strtotime($data_course['COURSE_START_DATE']) > strtotime($today)) {
                                $stt_course = '<label class="label label-warning">Sắp diễn ra</label>';
                            } else if (strtotime($data_course['COURSE_END_DATE']) < strtotime($today)) {
                                $stt_course = '<label class="label label-default">Đã kết thúc</label>';
                            } else {
                                $stt_course = '<label class="label label-info">Đang diễn ra</label>';
                            }
                        }
                        echo
                            '
                    <tr>
                    <th><input type="checkbox" name="ID_COURSE[]" value="' . $data_course['ID_COURSE'] . '"></th>
                    <th><a data-id="' . $data_course['ID_COURSE'] . '"  id="course_detail" data-toggle="modal" data-target="#list_schedule_in_course">
                        <span class="glyphicon glyphicon-zoom-in"></span></a>
                    </th>
                    <th>' . $data_course['NAME'] . '</th>
                    <th>' . $data_course['JOB'] . '</th>
                    <th>' . $data_course['MAJOR_NAME'] . '</th>
                    <th>' . $data_course['CENTER_NAME'] . '</th>
                    <th>' . $data_course['COURSE_START_DATE'] . '</th>
                    <th>' . $data_course['COURSE_END_DATE'] . '</th>
                    <th>' . $count_student . '/' . $data_course['QUANTITY_STUDENT'] . '</th>
                    <th>' . $stt_course . '</th>
                    </tr>
                    ';
                    }
                    echo '</table>';
                } else {
                    echo '<br><br><div class="alert alert-danger">Không tìm thấy khóa học nào.</div>';
                }
            } else {
                echo '<br><br><div class="alert alert-danger">Vui lòng nhập từ khóa.</div>';
            }
        } 
        // hủy khóa học
        else if ($action == 'cancel_course') {
            $id_course = trim(htmlspecialchars(addslashes($_POST['id_course'])));
            $sql_check_course_id_exist = "SELECT ID_COURSE FROM course WHERE ID_COURSE = '$id_course'";
            if ($db->num_rows($sql_check_course_id_exist)) {
                $sql_cancel_course = "UPDATE course SET COURSE_STATUS = '2' WHERE ID_COURSE = '$id_course'";
                $db->query($sql_cancel_course);
                $db->close();
            }
        } 
        //
        else {
            new Redirect($_DOMAIN); // Trở về trang index
        }
    }
} 
//
else {
    new Redirect($_DOMAIN); // Trở về trang index
}
