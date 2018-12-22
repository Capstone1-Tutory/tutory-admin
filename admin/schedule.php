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
                        <div class="table-responsive">
                        <table class="table table-hover list">
                        <tr>
                        <th><strong>Thời gian</strong></th>
                        <th><strong>Địa điểm</strong></th>                  
                        <th><strong>Gia sư</strong></th>
                        <th><strong>Môn học</strong></th>
                        <th><strong>Tình trạng</strong></th>
                        </tr>
                     ';
                    foreach ($db->fetch_assoc($sql_search_schedule, 0) as $key => $data_schedule) {
                        if ($data_schedule['SCHEDULE_STATUS'] == 1) {
                            $today = date("Y-m-d");
                            if (strtotime($data_schedule['SCHEDULE_DATE']) < strtotime($today)) {
                                $stt_schedule = '<label class="label label-default">Đã kết thúc</label>
                        ';
                            } else if (strtotime($data_schedule['SCHEDULE_DATE']) > strtotime($today)) {
                                $stt_schedule = '<label class="label label-info">Sắp diễn ra</label>
                                <a class="label label-warning" id="cancel_schedule" onclick="cancel_schedule (' . $data_schedule['ID_SCHEDULE'] . ')">
                        <span class="glyphicon glyphicon-remove-sign"></span> Hủy</a>
                        ';
                            } else {
                                $stt_schedule = '
                        <a class="label label-warning" id="cancel_schedule" onclick="cancel_schedule (' . $data_schedule['ID_SCHEDULE'] . ')">
                        <span class="glyphicon glyphicon-remove-sign"></span> Hủy</a>
                        ';
                            }
                        } else if ($data_schedule['SCHEDULE_STATUS'] == 2) {
                            $stt_schedule = '<label class="label label-danger">Đã hủy</label>
                        ';
                        }
                        echo
                            '
                             <tr>
                             <th>' . $data_schedule['SCHEDULE_START_TIME'] . ' giờ - ' . $data_schedule['SCHEDULE_END_TIME'] . ' giờ</th>
                             <th>' . $data_schedule['PLACE'] . '</th>
                             <th>' . $data_schedule['NAME'] . '</th>
                             <th>' . $data_schedule['MAJOR_NAME'] . '</th>
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
                    echo '<br><br><div class="alert alert-danger">Không có lớp học nào diễn ra trong ngày.</div>';
                     //echo '<br><br><div class="alert alert-danger">Không có lớp học nào diễn ra trong ngày.' . $kw_search_schedule . '</div>';
                }
            }
        } else if ($action == 'cancel_schedule') {
            $id_schedule = trim(htmlspecialchars(addslashes($_POST['id_schedule'])));
            $sql_check_schedule_id_exist = "SELECT ID_SCHEDULE FROM schedule WHERE ID_SCHEDULE = '$id_schedule'";
            if ($db->num_rows($sql_check_schedule_id_exist)) {
                $sql_cancel_schedule = "UPDATE schedule SET SCHEDULE_STATUS = '2' WHERE ID_SCHEDULE = '$id_schedule'";
                $db->query($sql_cancel_schedule);
                $db->close();
            }
        }
        //
        else {
            new Redirect($_DOMAIN); // Trở về trang index
        }
    }
} else {
    new Redirect($_DOMAIN); // Trở về trang index
}