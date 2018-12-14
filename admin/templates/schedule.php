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
            // Trang thêm lịch
            if ($ac == 'add_schedule') {
                // code giao diện
            }
        } 
        // không có tham số ac
        // trang danh sách khóa học
        else {
                // Dãy nút của trang thời khóa biểu

            $date = getdate();
            if ($date['wday'] == 1) {
                echo "Thứ hai ";
            } else if ($date['wday'] == 2) {
                echo "Thứ ba, ";
            } else if ($date['wday'] == 3) {
                echo "Thứ tư, ";
            } else if ($date['wday'] == 4) {
                echo "Thứ năm, ";
            } else if ($date['wday'] == 5) {
                echo "Thứ sáu, ";
            } else if ($date['wday'] == 6) {
                echo "Thứ bảy, ";
            } else if ($date['wday'] == 0) {
                echo "Chủ nhật, ";
            }
            echo ' ngày ' . $date['mday'];
            echo ' tháng ' . $date['mon'];
            echo ' năm ' . $date['year'];
            
    // Content danh sách lịch trong ngày
            $sql_get_schedule_in_date_current = "SELECT * FROM schedule S, course C, tutor T, user_profile UP
                    WHERE S.ID_COURSE = C.ID_COURSE
                    AND C.ID_TUTOR = T.ID_TUTOR
                    AND T.ID_PROFILE = UP.ID_PROFILE
                    AND date(S.SCHEDULE_DATE) = date(now())
                    ORDER BY S.SCHEDULE_START_TIME ASC";

            if ($db->num_rows($sql_get_schedule_in_date_current)) {
                echo
                    '
                        <div class="table-responsive"  id="list_schedule">
                        <table class="table table-hover list">
                        <tr>
                        <th><strong>Thời gian</strong></th>
                        <th><strong>Địa điểm</strong></th>                  
                        <th><strong>Gia sư</strong></th>
                        <th><strong>Tình trạng buổi học</strong></th>
                        </tr>
                    ';
                foreach ($db->fetch_assoc($sql_get_schedule_in_date_current, 0) as $key => $data_schedule) {

                    if ($data_schedule['SCHEDULE_STATUS'] == 0) {
                        $stt_schedule = '<label class="label label-danger">Đã hủy</label>';
                    } else if ($data_schedule['SCHEDULE_STATUS'] == 1) {
                        $stt_schedule = '<label class="label label-success">Đã hoạt động</label>';
                    }
                    echo
                        '
            <tr>
            <th>' . $data_schedule['SCHEDULE_START_TIME'] . ' giờ - ' . $data_schedule['SCHEDULE_END_TIME'] . ' giờ</th>
            <th>' . $data_schedule['PLACE'] . '</th>
            <th>' . $data_schedule['NAME'] . '</th>
            <th>' . $stt_schedule . '</th>
            </tr>
            ';
                }

                echo
                    '
        </table>
        </div>
        ';
            } else {
                echo '<br><br><div class="alert alert-info">Không có lớp học nào diễn ra trong ngày.</div>';
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
            $(function () {
                $('#datetimepicker1').datetimepicker();
        }
        );
            </script>