<?php

// Kết nối database và thông tin chung
require_once 'core/init.php';

// Nếu đăng nhập
if ($user) {
    // Nếu tồn tại POST action
    if (isset($_POST['action'])) {
        // Xử lý POST action
        $action = trim(addslashes(htmlspecialchars($_POST['action'])));
        
        // tìm kiếm lịch
        if ($action == 'search_schedule') {
            $kw_search_schedule = trim(htmlspecialchars(addslashes($_POST['kw_search_schedule'])));
            if ($kw_search_schedule != '') {
                $sql_search_schedule = "SELECT * FROM schedule S, course C, tutor T, user_profile UP, major M
                    WHERE S.ID_COURSE = C.ID_COURSE
                    AND C.ID_TUTOR = T.ID_TUTOR
                    AND T.ID_PROFILE = UP.ID_PROFILE
                    AND C.ID_MAJOR = M.ID_MAJOR
                    AND date(S.SCHEDULE_DATE) = '$kw_search_schedule'
                    ORDER BY S.SCHEDULE_START_TIME DESC";

                if ($db->num_rows($sql_search_schedule)) {
                    echo
                        '
                        <table class="table table-hover list">
                        <tr>
                        <th><strong>Thời gian</strong></th>
                        <th><strong>Địa điểm</strong></th>                  
                        <th><strong>Gia sư</strong></th>
                        <th><strong>Môn học</strong></th>
                        </tr>
                    ';
                    foreach ($db->fetch_assoc($sql_search_schedule, 0) as $key => $data_schedule) {
                        echo
                            '
                            <tr>
                            <th>' . $data_schedule['SCHEDULE_START_TIME'] . ' giờ - ' . $data_schedule['SCHEDULE_END_TIME'] . ' giờ</th>
                            <th>' . $data_schedule['PLACE'] . '</th>
                            <th>' . $data_schedule['NAME'] . '</th>
                            <th>' . $data_schedule['MAJOR_NAME'] . '</th>
                            </tr>
                            ';
                    }
                    echo
                        '
                    </table>
                     ';
                } else {
                    echo '<br><br><div class="alert alert-danger">Không có lớp học nào diễn ra trong ngày ' . $kw_search_schedule . '.</div>';
                }
            }
        } else {
            new Redirect($_DOMAIN); // Trở về trang index
        }
    }
} else {
    new Redirect($_DOMAIN); // Trở về trang index
}