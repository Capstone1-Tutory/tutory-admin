<?php

// Nếu đăng nhập
if ($user) {
    // URL ảnh đại diện tài khoản
    if ($data_user['URL_AVATAR'] == '') {
        $data_user['URL_AVATAR'] = $_DOMAIN . 'images/profile.png';
    } else {
        $data_user['URL_AVATAR'] = str_replace('admin/', '', $_DOMAIN) . $data_user['URL_AVATAR'];
    }
    // Form thông tin chung
    // lấy địa chỉ user
    $sql_get_address = "SELECT TP.name
    FROM devvn_tinhthanhpho TP, devvn_quanhuyen QH, devvn_xaphuongthitran XA
    WHERE XA.xaid = $data_user[ID_ADDRESS]
    AND XA.maqh = QH.maqh
    AND QH.matp = TP.matp
    ";
    if ($db->num_rows($sql_get_address)) {
        $name_address = $db->fetch_assoc($sql_get_address, 1);
    }
    echo
        '
    <div class="panel panel-default">
    <div class="panel-heading">Hồ sơ cá nhân</div>
    <div class="panel-body">
    <form method="POST" onsubmit="return false;" id="formProfile">
    <a class="pull-left">
    <img src="' . $data_user['URL_AVATAR'] . '" width="200" height="200"></a>
    <label>Họ và tên: ' . $data_user['NAME'] . '</label>
    </br>
    <label>Ngày sinh: ' . $data_user['BIRTHDAY'] . '</label>
    </br>
    <label>Giới tính: ' . $data_user['SEX'] . '</label>
    </br>
    <label>Địa chỉ: ' . $data_user['SO_NHA'] . ' - ' . $name_address['name'] . '</label>
    </br>
    <label>Số điện thoại: ' . $data_user['PHONE'] . '</label>
    </br>
    <label>Email: ' . $data_user['EMAIL'] . '</label>
    <div class="row-md-3">
    <div class="btn-group btn-group-justified">
    <a href="#" onclick="change_avatar()" class="btn btn-primary">Đổi ảnh đại diện</a>
    <a href="#" onclick="update_info()" class="btn btn-primary">Cập nhật thông tin</a>
    <a href="#" onclick="change_pw()" class="btn btn-primary">Đổi mật khẩu</a>
    </div>
    </div>
    </form>
    </div>
    </div>
    ';
    // Form Upload ảnh đại diện
    echo
        '   
    <div class="panel panel-default" id="change_avatar"  style="display:none;">
    <div class="panel-heading">Đổi ảnh đại diện</div>
    <div class="panel-body">
    <form action="' . $_DOMAIN . 'profile.php" method="POST" onsubmit="return false;" id="formUpAvt" enctype="multipart/form-data">
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
    <div class="form-group btn-group">
    <button class="btn btn-primary pull-left " type="submit"><span class="glyphicon glyphicon-upload"></span> Tải lên</button>
    <a class="btn btn-danger pull-center" id="del_avt"><span class="glyphicon glyphicon-trash"></span> Xóa ảnh</a>
    </div>
    <div class="clearfix"></div><br>
    <div class="alert alert-danger hidden"></div>
    </form>
    </div>
    </div>
    ';
    
    // Form Cập nhật các thông tin còn lại
    echo
        '
    <div class="panel panel-default" id="update_info" style="display:none;">
    <div class="panel-heading">Cập nhật thông tin</div>
    <div class="panel-body">
    <form method="POST" onsubmit="return false;" id="formUpdateInfo">
    <div class="form-group">
    <label>Họ và tên</label>
    <input type="text" class="form-control" id="dn_update" value="' . $data_user['NAME'] . '">
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
    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
    </div>
    <div class="alert alert-danger hidden"></div>
    </form>
    </div>
    </div>
    ';
    
    // Form đổi mật khẩu
    echo
        '
    <div class="panel panel-default" id="change_pw"  style="display:none;">
    <div class="panel-heading">Đổi mật khẩu</div>
    <div class="panel-body">
    <form method="POST" id="formChangePw" onsubmit="return false;">
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
    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
    </div>
    <div class="alert alert-danger hidden"></div>
    </form>
    </div>
    </div>
    ';
}
// Ngược lại chưa đăng nhập
else {
    new Redirect($_DOMAIN); // Trở về trang index
}

?>

<script type="text/javascript">

    function change_avatar() {
        var x = document.getElementById("change_avatar");
        var y = document.getElementById("update_info");
        var z = document.getElementById("change_pw");
        if (x.style.display === "none") {
            x.style.display = "block";
            y.style.display = "none";
            z.style.display = "none";
        } else {
            x.style.display = "none";
        }
    }

    function update_info() {
        var x = document.getElementById("change_avatar");
        var y = document.getElementById("update_info");
        var z = document.getElementById("change_pw");
        if (y.style.display === "none") {
            y.style.display = "block";
            x.style.display = "none";
            z.style.display = "none";
        } else {
            y.style.display = "none";
        }
    }
    function change_pw() {
        var x = document.getElementById("change_avatar");
        var y = document.getElementById("update_info");
        var z = document.getElementById("change_pw");
        if (z.style.display === "none") {
            z.style.display = "block";
            x.style.display = "none";
            y.style.display = "none";
        } else {
            z.style.display = "none";
        }
    }
</script>