$_DOMAIN = 'http://localhost/tutory-admin/admin/';

// Đăng nhập
$('#formSignin button').on('click', function () {
    $this = $('#formSignin button');
    $this.html('Đang tải ...');

    // Gán các giá trị trong các biến
    $user_signin = $('#formSignin #user_signin').val();
    $pass_signin = $('#formSignin #pass_signin').val();

    // Nếu các giá trị rỗng
    if ($user_signin == '' || $pass_signin == '') {
        $('#formSignin .alert').removeClass('hidden');
        $('#formSignin .alert').html('Vui lòng điền đẩy đủ thông tin.');
        $this.html('Đăng nhập');
    }
    // Ngược lại
    else {
        $.ajax({
            url: $_DOMAIN + 'signin.php',
            type: 'POST',
            data: {
                user_signin: $user_signin,
                pass_signin: $pass_signin
            }, success: function (data) {
                $('#formSignin .alert').removeClass('hidden');
                $('#formSignin .alert').html(data);
                $this.html('Đăng nhập');
            }, error: function () {
                $('#formSignin .alert').removeClass('hidden');
                $('#formSignin .alert').html('Đã xảy ra lỗi, vui lòng thử lại sau.');
                $this.html('Đăng nhập');
            }
        });
    }
});
// Đăng xuất
$('#logout').on('click', function () {
    $confirm = confirm('Bạn có muốn đăng xuất?');
    if ($confirm == true) {
        $.ajax({
            url: $_DOMAIN,
            type: 'POST',
            data: {
                action: 'sigout'
            }, success: function () {
                location.reload();
            }, error: function () {
                alert('Không thể đăng xuất vào lúc này, vui lòng thử lại sau.');
            }
        });
    }
    else {
        return false;
    }
});

// Xem ảnh avatar trước
function preUpAvt() {
    img_avt = $('#img_avt').val();
    $('#formUpAvt .box-pre-img').html('<p><strong>Xem trước</strong></p>');
    $('#formUpAvt .box-pre-img').removeClass('hidden');

    // Nếu đã chọn ảnh
    if (img_avt != '') {
        $('#formUpAvt .box-pre-img').html('<p><strong>Xem trước</strong></p>');
        $('#formUpAvt .box-pre-img').removeClass('hidden');
        $('#formUpAvt .box-pre-img').append('<img src="' + URL.createObjectURL(event.target.files[0]) + '" style="border: 1px solid #ddd; width: 50px; height: 50px; margin-right: 5px; margin-bottom: 5px;"/>');
    }
    // Ngược lại chưa chọn ảnh
    else {
        $('#formUpAvt .box-pre-img').html('');
        $('#formUpAvt .box-pre-img').addClass('hidden');
    }
}
// Upload ảnh đại diện
$('#formUpAvt').submit(function (e) {
    img_avt = $('#img_avt').val();
    $('#formUpAvt button[type=submit]').html('Đang tải ...');

    // Nếu có chọn ảnh
    if (img_avt) {
        size_img_avt = $('#img_avt')[0].files[0].size;
        type_img_avt = $('#img_avt')[0].files[0].type;

        e.preventDefault();
        // Nếu lỗi về size ảnh
        if (size_img_avt > 5242880) { // 5242880 byte = 5MB 
            $('#formUpAvt button[type=submit]').html('Upload');
            $('#formUpAvt .alert-danger').removeClass('hidden');
            $('#formUpAvt .alert-danger').html('Chọn ảnh có kích thước nhỏ hơn 5MB.');
            // Nếu lỗi về định dạng ảnh
        } else if (type_img_avt != 'image/jpeg' && type_img_avt != 'image/png' && type_img_avt != 'image/gif') {
            $('#formUpAvt button[type=submit]').html('Upload');
            $('#formUpAvt .alert-danger').removeClass('hidden');
            $('#formUpAvt .alert-danger').html('Chọn ảnh có định dạng .jpg, .png, .gif');
        } else {
            $(this).ajaxSubmit({
                beforeSubmit: function () {
                    target: '#formUpAvt .alert-danger',
                        $("#formUpAvt .box-progress-bar").removeClass('hidden');
                    $("#formUpAvt .progress-bar").width('0%');
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    $("#formUpAvt .progress-bar").animate({ width: percentComplete + '%' });
                    $("#formUpAvt .progress-bar").html(percentComplete + '%');
                },
                success: function (data) {
                    $('#formUpAvt button[type=submit]').html('Upload');
                    $('#formUpAvt .alert-danger').attr('class', 'alert alert-success');
                    $('#formUpAvt .alert-success').html(data);
                },
                error: function () {
                    $('#formUpAvt button[type=submit]').html('Upload');
                    $('#formUpAvt .alert-danger').removeClass('hidden');
                    $('#formUpAvt .alert-danger').html('Không thể tải ảnh vào lúc này,vui lòng thử lại sau.');
                },
                resetForm: true
            });
            return false;
        }
        // Ngược lại không chọn ảnh
    } else {
        $('#formUpAvt button[type=submit]').html('Upload');
        $('#formUpAvt .alert-danger').removeClass('hidden');
        $('#formUpAvt .alert-danger').html('Vui lòng chọn tệp hình ảnh.');
    }
});
// Xoá ảnh đại diện
$('#del_avt').on('click', function () {
    $confirm = confirm('Bạn có muốn xóa ảnh hiện tại?');
    if ($confirm == true) {
        $.ajax({
            url: $_DOMAIN + 'profile.php',
            type: 'POST',
            data: {
                action: 'delete_avt'
            }, success: function () {
                location.reload();
            }, error: function () {
                alert('Không thể xóa vào lúc này, vui lòng thử lại sau.');
            }
        });
    }
    else {
        return false;
    }
});


// Cập nhật thông tin khác
$('#formUpdateInfo button').on('click', function () {
    $('#formUpdateInfo button').html('Đang tải ...');
    $name_update = $('#name_update').val();
    $email_update = $('#email_update').val();
    $phone_update = $('#phone_update').val();

    if ($name_update && $email_update) {
        $.ajax({
            url: $_DOMAIN + 'profile.php',
            type: 'POST',
            data: {
                name_update: $name_update,
                email_update: $email_update,
                phone_update: $phone_update,
                action: 'update_info'
            }, success: function (data) {
                $('#formUpdateInfo .alert').removeClass('hidden');
                $('#formUpdateInfo .alert').html(data);
            }, error: function () {
                $('#formUpdateInfo .alert').removeClass('hidden');
                $('#formUpdateInfo .alert').html('Đã xảy ra lỗi, vui lòng thử lại sau.');
            }
        });
        $('#formUpdateInfo button').html('Lưu thay đổi');
    } else {
        $('#formUpdateInfo button').html('Lưu thay đổi');
        $('#formUpdateInfo .alert').removeClass('hidden');
        $('#formUpdateInfo .alert').html('Vui lòng điền đẩy đủ thông tin.');
    }
});
// Đổi mật khẩu
$('#formChangePw button').on('click', function () {
    $('#formChangePw button').html('Đang tải ...');
    $old_pw_change = $('#old_pw_change').val();
    $new_pw_change = $('#new_pw_change').val();
    $re_new_pw_change = $('#re_new_pw_change').val();

    if ($old_pw_change && $new_pw_change && $re_new_pw_change) {
        $.ajax({
            url: $_DOMAIN + 'profile.php',
            type: 'POST',
            data: {
                old_pw_change: $old_pw_change,
                new_pw_change: $new_pw_change,
                re_new_pw_change: $re_new_pw_change,
                action: 'change_pw'
            }, success: function (data) {
                $('#formChangePw .alert').removeClass('hidden');
                $('#formChangePw .alert').html(data);
            }, error: function () {
                $('#formChangePw .alert').removeClass('hidden');
                $('#formChangePw .alert').html('Đã xảy ra lỗi, vui lòng thử lại sau.');
            }
        });
        $('#formChangePw button').html('Lưu thay đổi');
    } else {
        $('#formChangePw button').html('Lưu thay đổi');
        $('#formChangePw .alert').removeClass('hidden');
        $('#formChangePw .alert').html('Vui lòng điền đẩy đủ thông tin.');
    }
});
// Thêm tài khoản
$('#formAddAcc button').on('click', function () {
    $un_add_acc = $('#un_add_acc').val();
    $pw_add_acc = $('#pw_add_acc').val();
    $repw_add_acc = $('#repw_add_acc').val();
    $name_add_acc = $('#name_add_acc').val();
    $email_add_acc = $('#email_add_acc').val();
    $id_type_add_acc = $('#id_type_add_acc').val();

    if ($un_add_acc == '' || $pw_add_acc == '' || $repw_add_acc == '' || $name_add_acc == '' || $email_add_acc == '' || $id_type_add_acc == '') {
        $('#formAddAcc .alert').removeClass('hidden');
        $('#formAddAcc .alert').html('Vui lòng điền đầy đủ thông tin.');
    }
    else {
        $.ajax({
            url: $_DOMAIN + 'account.php',
            type: 'POST',
            data: {
                un_add_acc: $un_add_acc,
                pw_add_acc: $pw_add_acc,
                repw_add_acc: $repw_add_acc,
                name_add_acc: $name_add_acc,
                email_add_acc: $email_add_acc,
                id_type_add_acc: $id_type_add_acc,
                action: 'add_acc'
            }, success: function (data) {
                $('#formAddAcc .alert').html(data);
            }, error: function () {
                $('#formAddAcc .alert').removeClass('hidden');
                $('#formAddAcc .alert').html('Đã xảy ra lỗi, vui lòng thử lại sau.');
            }
        });
    }
});

// Xoá nhiều tài khoản cùng lúc
$('#del_acc_list').on('click', function () {
    $confirm = confirm('Bạn có chắc chắn muốn xoá các tài khoản đã chọn không?');
    if ($confirm == true) {
        $ID_USER = [];

        $('#list_acc input[type="checkbox"]:checkbox:checked').each(function (i) {
            $ID_USER[i] = $(this).val();
        });

        if ($ID_USER.length === 0) {
            alert('Vui lòng chọn ít nhất một tài khoản.');
        }
        else {
            $.ajax({
                url: $_DOMAIN + 'account.php',
                type: 'POST',
                data: {
                    id_user: $ID_USER,
                    action: 'del_acc_list'
                },
                success: function (data) {
                    location.reload();
                }, error: function () {
                    alert('Đã có lỗi xảy ra, hãy thử lại.');
                }
            });
        }
    }
    else {
        return false;
    }
});
// Xoá tài khoản chỉ định trong bảng danh sách
$('.del-acc').on('click', function () {
    $confirm = confirm('Bạn có chắc chắn muốn xoá tài khoản này không?');
    if ($confirm == true) {
        $ID_USER = $(this).attr('data-id');

        $.ajax({
            url: $_DOMAIN + 'account.php',
            type: 'POST',
            data: {
                id_user: $ID_USER,
                action: 'del_acc'
            },
            success: function () {
                location.reload();
            }
        });
    }
    else {
        return false;
    }
});
// lấy id chuyên ngành để đổ ra gia sư
$(document).ready(function () {
    $('#major_add_course').change(function () {
        $id_major = $('#major_add_course').val();
        alert(id_major);
    })
});



