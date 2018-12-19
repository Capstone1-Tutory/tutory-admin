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
                $sql_get_major = "SELECT * FROM major
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
                    <select class="form-control title" id="city_add_course" style="width:324px">
                    <option value="">Tỉnh/Thành phố</option>
                    ';
                $sql_get_city = "SELECT * FROM devvn_tinhthanhpho
                    ";
                if ($db->num_rows($sql_get_city)) {
                    foreach ($db->fetch_assoc($sql_get_city, 0) as $key => $data_city) {
                        echo '
                                <option value="' . $data_city['matp'] . '">' . $data_city['name'] . '</option>
                            ';
                    }
                }
                echo '
                    </select>
                    <select class="form-control title" id="district_add_course" style="width:324px">
                    <option value="">Quận/Huyện</option>
                    </select>
                    <select class="form-control title" id="commune_add_course" style="width:324px">
                    <option value="">Xã/Phường</option>
                    </select>
                </div>
                </div>
                <div class="form-group">
                <input type="text" class="form-control title" id="street_add_course" placeholder="Nhập tên đường ..">
                </div>
                <div class="form-group">
                <label>Số lượng học viên</label>
                <input type="text" class="form-control title" id="quantity_add_course">
                </div>
                <div class="form-group">
                <label>Chọn thời gian</label>
                <div class="form-inline">
                <label>Từ ngày</label>
                <input type="date" class="form-control title" id="startdate_add_course" style="width:425px">
                <label>Đến ngày</label>
                <input type="date" class="form-control title" id="enddate_add_course" style="width:425px">
                </div>
                </div>
                <div class="form-group" id="dayweek_add_course">
                <label>Chọn thứ trong tuần: </label>
                <label class="radio-inline"><input type="radio" name="day" value="1">Thứ hai</label>
                <label class="radio-inline"><input type="radio" name="day" value="2">Thứ ba</label>
                <label class="radio-inline"><input type="radio" name="day" value="3">Thứ tư</label>
                <label class="radio-inline"><input type="radio" name="day" value="4">Thứ năm</label>
                <label class="radio-inline"><input type="radio" name="day" value="5">Thứ sáu</label>
                <label class="radio-inline"><input type="radio" name="day" value="6">Thứ bảy</label>
                <label class="radio-inline"><input type="radio" name="day" value="0">Chủ nhật</label>
                </div>
                
                <div class="form-group">
                <label>Chọn khung giờ</label>
                <div class="form-inline">
                <label>Giờ bắt đầu</label>
                <input type="text" class="form-control title" id="starttime_add_course" style="width:403px" placeholder="Nhập giờ theo định dạng 24 tiếng">
                <label>Giờ kết thúc</label>
                <input type="text" class="form-control title" id="endtime_add_course" style="width:403px" placeholder="Nhập giờ theo định dạng 24 tiếng">
                </div>
                </div>
                <div class="form-group">
                <div class="form-inline">
                <a href="' . $_DOMAIN . 'course" class="btn btn-default" style="color:red">
                <span class="glyphicon glyphicon-arrow-left" style="color:red"></span> Hủy
                </a>
                <button type="submit" class="btn btn-primary">Thêm</button>
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
                // form tìm kiếm khóa học
                echo '
                <p>
                <form method="POST" id="formSearchCourse" onsubmit="return false;">
                    <div class="input-group">         
                        <input type="text" class="form-control" id="kw_search_course" placeholder="Nhập từ khóa ...">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </span>
                    </div>
                </form>
                </p>
                ';
                echo
                    '
                <div class="table-responsive"  id="list_course">
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
                

            // In danh sách khóa học
                foreach ($db->fetch_assoc($sql_get_list_course, 0) as $key => $data_course) {
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
                            $stt_course = '<label class="label label-warning">Sắp diễn ra</label>
                            <a data-id="' . $data_course['ID_COURSE'] . '" class="label label-danger" id="cancel_course">
                            <span class="glyphicon glyphicon-remove-sign"></span> Hủy</a>
                            ';
                        } else if (strtotime($data_course['COURSE_END_DATE']) < strtotime($today)) {
                            $stt_course = '<label class="label label-default">Đã kết thúc</label>';
                        } else {
                            $stt_course = '<label class="label label-info">Đang diễn ra</label>
                            <a data-id="' . $data_course['ID_COURSE'] . '" class="label label-danger" id="cancel_course">
                            <span class="glyphicon glyphicon-remove-sign"></span> Hủy</a>
                            ';
                        }
                    }
                    echo
                        '
                    <tr>
                    <th><input type="checkbox" name="ID_COURSE[]" value="' . $data_course['ID_COURSE'] . '"></th>
                    <th><button data-id="' . $data_course['ID_COURSE'] . '"  id="course_detail" type="submit">
                        <i class="glyphicon glyphicon-zoom-in"></i></button>
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
    $('#selectAllCourse').click(function(e){
        var table= $(e.target).closest('table');
        $('th input:checkbox',table).prop('checked',this.checked);
    });
// Print selected rows
</script>

