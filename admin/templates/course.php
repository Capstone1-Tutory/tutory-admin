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
            // Trang thêm khóa học
            if ($ac == 'add_course') {
                echo
                    '
                    <h3>Thêm khóa học</h3>
                
                
                ';
                
                // Content thêm khóa học 
                echo '
                
                <p class="form-add-course">
                <form method="POST" id="formAddCourse" onsubmit="return false;">
                <div class="form-group">
                <label>Chuyên ngành</label>
                <select class="form-control title" id="major_add_course">
                <option>Vui lòng chọn chuyện ngành</option>
                ';
                $sql_get_major = "SELECT * FROM major M
                    ";
                if ($db->num_rows($sql_get_major)) {
                    foreach ($db->fetch_assoc($sql_get_major, 0) as $key => $data_major) {
                        echo '
                                <option value="' . $data_major['ID_MAJOR'] . '">' . $data_major['MAJOR_NAME'] . '</option>
                            ';
                    }
                }
                echo '
                </select>
                </div>
                <div class="form-group">
                <label>Tên gia sư</label>
                <select class="form-control title" id="tutor_add_course">
                <option>Vui lòng chọn gia sư</option>
              
                </select>
                </div>
                <div class="form-group">
                <label>Địa điểm</label>
                <div class="form-inline">
                    <select class="form-control title" id="tinh">
                    <option value="">Tỉnh/Thành phố</option>
                    </select>
                    <select class="form-control title" id="huyen">
                    <option value="">Quận/Huyện</option>
                    </select>
                    <select class="form-control title" id="xa">
                    <option value="">Xã/Phường</option>
                    </select>
                </div>
                </div>
                <div class="form-group">
                <input type="text" class="form-control title" id="street" placeholder="Nhập tên đường ..">
                </div>
                <div class="form-group">
                <label>Số lượng học viên</label>
                <select class="form-control title" id="quantity_add_course">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                </div>
                <div class="form-group">
                <label>Chọn ngày:</label>
                <label> Từ</label>
                <input type="date" class="form-control-inline title" id="start_day_add_course">
                
                <label> Đến</label>
                
                <input type="date" class="form-control-inline title" id="end_day_add_course">
                </div>
                <div class="form-group">
                <label>Chọn thứ trong tuần: </label>
                <label class="radio-inline"><input type="radio" id="monday" value="1">Thứ hai</label>
                <label class="radio-inline"><input type="radio" id="tuesday" value="2">Thứ ba</label>
                <label class="radio-inline"><input type="radio" id="wednesday" value="3">Thứ tư</label>
                <label class="radio-inline"><input type="radio" id="thursday" value="4">Thứ năm</label>
                <label class="radio-inline"><input type="radio" id="friday" value="5">Thứ sáu</label>
                <label class="radio-inline"><input type="radio" id="saturday" value="6">Thứ bảy</label>
                <label class="radio-inline"><input type="radio" id="sunday" value="0">Chủ nhật</label>
                </div>
                
                <div class="form-group">
                <label>Chọn khung giờ:</label>
                <label> Từ</label>
                <input type="time" class="form-control-inline title" id="start_time_add_course">
                <label> Đến</label>
                <input type="time" class="form-control-inline title" id="end_time_add_course">
                </div>
                <div class="form-group">
                <div class="form-inline">
                <a href="' . $_DOMAIN . 'course" class="btn btn-default" style="color:red">
                <span class="glyphicon glyphicon-arrow-left" style="color:red"></span> Hủy
                </a>
                
                <a class="btn btn-primary">Xác nhận</a> 
                </div>
                </div>
                <div class="alert alert-danger hidden"></div>
                </form>
                </p>
                ';

            }

        }
        // Ngược lại không có tham số ac
        // Trang danh sách khóa học
        else {
            // Dãy nút của danh sách khóa học
            echo
                '   
            <h3>Khóa học</h3><hr>
            <form class="form-inline">
            <a href="' . $_DOMAIN . 'course/add_course" class="btn btn-default">
            <span class="glyphicon glyphicon-plus"></span> Thêm khóa học
            </a>
            <a href="' . $_DOMAIN . 'course" class="btn btn-default">
            <span class="glyphicon glyphicon-repeat"></span> Tải lại
            </a>
            <a class="btn btn-danger" id="del_course_list">
            <span class="glyphicon glyphicon-trash"></span> Xóa
            </a>              
            <input class="form-control mr-sm-2" type="search" placeholder="Nhập từ khóa .." aria-label="Search">
            <button class="btn btn-success my-2 my-sm-0" type="submit">Tìm kiếm</button>
            </form>
            ';


            // Content danh sách khóa học
            $sql_get_list_course = "SELECT * FROM course C, tutor T, user_profile UP, major M, tutor_rela_major TRM
            WHERE C.ID_TUTOR = T.ID_TUTOR
            AND T.ID_PROFILE = UP.ID_PROFILE
            AND TRM.ID_TUTOR = T.ID_TUTOR
            AND TRM.ID_MAJOR = M.ID_MAJOR
            ORDER BY COURSE_START_DATE ASC";
           //nếu có khóa học
            if ($db->num_rows($sql_get_list_course)) {
                echo
                    '
                <br><br>
                <div class="table-responsive">
                <table class="table table-hover list" id="list_course">
                <tr>
                <th><input type="checkbox" id="selectAll"></th>
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
                

            // In danh sách khóa học
                foreach ($db->fetch_assoc($sql_get_list_course, 0) as $key => $data_course) {
                    // đếm học viên của khóa học
                    $count_student = $db->num_rows("SELECT ID_STUDENT FROM student_rela_course WHERE ID_COURSE = $data_course[ID_COURSE]");          
                    //trạng thái khóa học
                    if ($data_course['COURSE_STATUS'] == 0) {
                        $stt_course = '<a id="review_course">Chưa duyệt</a>';

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
                    <th><button data-toggle="modal" data-target="#modal_course_detail" 
                    value="' . $data_course['ID_COURSE'] . '"  id="course_detail">
                        <span class="glyphicon glyphicon-zoom-in"></span></button>
                    ';
                    
                    // in ra dữ liệu của khóa học
                    echo '
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
                
                // lấy chi tiết khóa học từ bảng thời khóa biểu
                $sql_get_list_schedule = "SELECT * FROM schedule WHERE ID_COURSE = $data_course[ID_COURSE]";
                if ($db->num_rows($sql_get_list_schedule)) {


                    echo
                        '
                            
                            <!-- Chi tiết khóa học --!>
                                <div id="modal_course_detail" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title"><strong>Chi tiết khóa học</strong></h4>                                           
                                                <div class="table-responsive">
                                                        <table class="table table-hover list" id="course_detail">
                                                        <tr>
                                                        <th><strong>Ngày</strong></th>
                                                        <th><strong>Giờ bắt đầu</strong></th>
                                                        <th><strong>Giờ kết thúc</strong></th>                  
                                                        <th><strong>Địa điểm</strong></th>
                                                        <th><strong>Tình trạng</strong></th>
                                                        </tr>
                                                        
                                                        
                            ';


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
                                    ';
                        echo '
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    ';


                    }
                }

                echo '
                    </div>
                ';


            }
                // Nếu không có khóa học
            else {
                echo '<br><br><div class="alert alert-info">Không có khóa học nào trong hệ thống.</div>';
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
    $('#selectAll').click(function(e){
        var table= $(e.target).closest('table');
        $('th input:checkbox',table).prop('checked',this.checked);
    });
// Print selected rows
</script>

