<?php

// Nếu đăng nhập
if ($user) {
    // Nếu tài khoản là tác giả
    if ($data_user['ID_TYPE'] != 'ad') {
        echo '<div class="alert alert-danger">Bạn không có đủ quyền để vào trang này.</div>';
    } 
    // Ngược lại tài khoản là admin
    else if ($data_user['ID_TYPE'] == 'ad') {// URL ảnh đại diện tài khoản
        if ($data_user['URL_AVATAR'] == '') {
            $data_user['URL_AVATAR'] = $_DOMAIN . 'images/profile.png';
        } else {
        //link đường dẫn hình ảnh
            $data_user['URL_AVATAR'] = 'http://localhost/tutory-admin/' . $data_user['URL_AVATAR'];
        }
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
            // Trang thêm tài khoản
            if ($ac == 'up_avt') {
                echo
                    '   
                        <form action="' . $_DOMAIN . 'profile.php" method="POST" onsubmit="return false;" id="formUpAvt" enctype="multipart/form-data">
                        <div class="form-group">
                        <h3>Đổi ảnh đại diện</h3>
                        </div>
                        <div class="form-group box-current-img">
                        <p><strong>Ảnh hiện tại</strong></p>
                        <img src="' . $data_user['URL_AVATAR'] . '" alt="Avatar of ' . $data_user['NAME'] . '" width="200" height="200">
                        </div>
                        <div class="form-group">
                        <label>Chọn ảnh</label>
                        <div class="alert alert-info">Vui lòng chọn file ảnh có đuôi .jpg, .png, .gif và có dung lượng dưới 5MB.</div>
                        <input type="file" class="form-control" id="img_avt" name="img_avt" onchange="preUpAvt();">
                        </div>
                        <div class="form-group box-pre-img hidden">
                        <p><strong>Xem trước</strong></p>
                        </div>            
                        <div class="form-group hidden box-progress-bar">
                        <div class="progress">
                        <div class="progress-bar" role="progressbar"></div>
                        </div>
                        </div>
                        <div class="form-group">
                        <button class="btn btn-primary " type="submit"><span class="glyphicon glyphicon-upload"></span> Tải lên</button>
                        <a class="btn btn-danger" id="del_avt"><span class="glyphicon glyphicon-trash"></span> Xóa ảnh</a>
                        <a href="' . $_DOMAIN . 'profile" class="btn btn-default" style="color:red">
                        <span class="glyphicon glyphicon-arrow-left" style="color:red"></span> Hủy
                        </a>
                        </div>
                        <div class="clearfix"></div><br>
                        <div class="alert alert-danger hidden"></div>
                        </form>
                        ';
            } else if ($ac == 'up_profile') {
                echo
                    '
                        <form method="POST" onsubmit="return false;" id="formUpdateInfo">
                        <div class="form-group">
                        <h3>Cập nhật thông tin</h3>
                        </div>
                        <div class="form-group">
                        <label>Họ và tên</label>
                        <input type="text" class="form-control" id="name_update" value="' . $data_user['NAME'] . '">
                        </div>
                        <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" id="email_update" value="' . $data_user['EMAIL'] . '">
                        </div>
                        <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" class="form-control" id="phone_update" value="' . $data_user['PHONE'] . '">
                        </div>
                        <div class="form-group">
                        <label>Ngày sinh</label>
                        <input type="date" class="form-control" id="birthday_update" value="' . $data_user['BIRTHDAY'] . '">
                        </div>
                        <div class="form-group">
                <label>Địa điểm</label>
                <div class="form-inline">
                    <select class="form-control title" id="city_update" style="width:324px">
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
                    <select class="form-control title" id="district_update" style="width:324px">
                    <option value="">Quận/Huyện</option>
                    </select>
                    <select class="form-control title" id="commune_update" style="width:324px">
                    <option value="">Xã/Phường</option>
                    </select>
                </div>
                </div>
                <div class="form-group">
                <input type="text" class="form-control title" id="street_update" value="' . $data_user['SO_NHA'] . '">
                </div>
                        <br>
                        <div class="form-group">
                        <div class="form-inline">
                        <a href="' . $_DOMAIN . 'profile" class="btn btn-default" style="color:red">
                        <span class="glyphicon glyphicon-arrow-left" style="color:red"></span> Hủy
                        </a>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                        </div>
                        <div class="alert alert-danger hidden"></div>
                        </form>
                        ';
            } else if ($ac == 'change_pw') {
                echo
                    '
                    <form method="POST" id="formChangePw" onsubmit="return false;">
                    <div class="form-group">
                    <h3>Đổi mật khẩu</h3>
                    </div>
                    <div class="form-group">
                    <label>Mật khẩu cũ</label>
                    <input type="password" class="form-control" id="oldPwChange">
                    </div>
                    <div class="form-group">
                    <label>Mật khẩu mới</label>
                    <input type="password" class="form-control" id="newPwChange">
                    </div>
                    <div class="form-group">
                    <label>Nhập lại mật khẩu mới</label>
                    <input type="password" class="form-control" id="reNewPwChange">
                    </div>
                    <div class="form-group">
                    <div class="form-inline">
                    <a href="' . $_DOMAIN . 'profile" class="btn btn-default" style="color:red">
                    <span class="glyphicon glyphicon-arrow-left" style="color:red"></span> Hủy
                    </a>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                    </div>
                    <div class="alert alert-danger hidden"></div>
                    </form>
                    ';
            }
        } 
        // Ngược lại không có tham số ac
        else {
            $sql_address_commune = $db->query("SELECT name FROM devvn_xaphuongthitran
                WHERE xaid = $data_user[ID_ADDRESS]
                ");
            echo
                '
                    <div class="panel panel-default">
                    <div class="panel-heading">Hồ sơ cá nhân</div>
                    <div class="panel-body">
                    <a class="pull-left">
                    <img src="' . $data_user['URL_AVATAR'] . '" width="200" height="200"></a>&nbsp;
                    <label >Họ và tên: ' . $data_user['NAME'] . '</label>
                    </br>&nbsp;
                    <label>Ngày sinh: ' . $data_user['BIRTHDAY'] . '</label>
                    </br>&nbsp;
                    <label>Giới tính: ' . $data_user['SEX'] . '</label>
                    </br>&nbsp;
                    <label>Địa chỉ: ' . $data_user['SO_NHA'] . ' ' . $sql_address_commune . '</label>
                    </br>&nbsp;
                    <label>Số điện thoại: ' . $data_user['PHONE'] . '</label>
                    </br>&nbsp;
                    <label>Email: ' . $data_user['EMAIL'] . '</label>
                    <div class="row-md-3">
                    <form class="form-inline">&nbsp;
                    <a href="' . $_DOMAIN . 'profile/up_avt" class="btn btn-default">
                    <span class="glyphicon glyphicon-cog"></span> Đổi ảnh đại diện
                    </a>
                    <a href="' . $_DOMAIN . 'profile/up_profile" class="btn btn-default">
                    <span class="glyphicon glyphicon-cog"></span> Cập nhật thông tin
                    </a>
                    <a href="' . $_DOMAIN . 'profile/change_pw" class="btn btn-default">
                    <span class="glyphicon glyphicon-cog"></span> Đổi mật khẩu
                    </a>              
                    </form>
                    </div>
                    </div>
                    </div>
                    ';
        }

    }
}
// Ngược lại chưa đăng nhập
else {
    new Redirect($_DOMAIN); // Trở về trang index
}

?>
