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
    $birthday_update = $('#birthday_update').val();
    $address_update = $('#address_update').val();

    if ($name_update && $email_update && $phone_update && $birthday_update && $address_update) {
        $.ajax({
            url: $_DOMAIN + 'profile.php',
            type: 'POST',
            data: {
                name_update: $name_update,
                email_update: $email_update,
                phone_update: $phone_update,
                birthday_update: $birthday_update,
                address_update: $address_update,
                action: 'up_profile'
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
    $oldPwChange = $('#oldPwChange').val();
    $newPwChange = $('#newPwChange').val();
    $reNewPwChange = $('#reNewPwChange').val();

    if ($oldPwChange && $newPwChange && $reNewPwChange) {
        $.ajax({
            url: $_DOMAIN + 'profile.php',
            type: 'POST',
            data: {
                oldPwChange: $oldPwChange,
                newPwChange: $newPwChange,
                reNewPwChange: $reNewPwChange,
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
    $id_type_add_acc = $('#id_type_add_acc').val();
    if ($un_add_acc == '' || $pw_add_acc == '' || $repw_add_acc == '' || $id_type_add_acc == '') {
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
        $id_user = [];

        $('#list_acc input[type="checkbox"]:checkbox:checked').each(function (i) {
            $id_user[i] = $(this).val();
        });

        if ($id_user.length === 0) {
            alert('Vui lòng chọn ít nhất một tài khoản.');
        }
        else {
            $.ajax({
                url: $_DOMAIN + 'account.php',
                type: 'POST',
                data: {
                    id_user: $id_user,
                    action: 'del_acc_list'
                },
                success: function (data) {
                    $('#list_acc').html(data);
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
        $id_user = $(this).attr('data-id');

        $.ajax({
            url: $_DOMAIN + 'account.php',
            type: 'POST',
            data: {
                id_user: $id_user,
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
$('#major_add_course').on('click', function () {
    $id_major = $('#major_add_course').val();
    $.ajax({
        url: $_DOMAIN + 'course.php',
        type: 'POST',
        data: {
            id_major: $id_major,
            action: 'load_major'
        },
        success: function (data) {
            $('#tutor_add_course').html(data);
        }, error: function () {
            alert('Lỗi!');
        }
    });
});
// lấy địa chỉ
$('#city_add_course').on('click', function () {
    $matp = $('#city_add_course').val();
    $.ajax({
        url: $_DOMAIN + 'course.php',
        type: 'POST',
        data: {
            matp: $matp,
            action: 'load_city'
        },
        success: function (data) {
            $('#district_add_course').html(data);
        }, error: function () {
            alert('Lỗi!');
        }
    });
});
$('#district_add_course').on('click', function () {
    $maqh = $('#district_add_course').val();
    $.ajax({
        url: $_DOMAIN + 'course.php',
        type: 'POST',
        data: {
            maqh: $maqh,
            action: 'load_district'
        },
        success: function (data) {
            $('#commune_add_course').html(data);
        }, error: function () {
            alert('Lỗi!');
        }
    });
});
// thêm khóa học
$('#formAddCourse button').on('click', function () {
    $major_add_course = $('#major_add_course').val();
    $tutor_add_course = $('#tutor_add_course').val();
    $street_add_course = $('#street_add_course').val();
    $quantity_add_course = $('#quantity_add_course').val();
    $startdate_add_course = $('#startdate_add_course').val();
    $enddate_add_course = $('#enddate_add_course').val();
    $starttime_add_course = $('#starttime_add_course').val();
    $endtime_add_course = $('#endtime_add_course').val();
    if ($major_add_course == '' || $tutor_add_course == '' || $street_add_course == '' || $quantity_add_course == '' || $startdate_add_course == '' || $enddate_add_course == '' || $starttime_add_course == '' || $endtime_add_course == '') {
        $('#formAddCourse .alert').removeClass('hidden');
        $('#formAddCourse .alert').html('Vui lòng điền đầy đủ thông tin.');
    } else if ($startdate_add_course >= getDate()) {
        $('#formAddCourse .alert').removeClass('hidden');
        $('#formAddCourse .alert').html('Ngày bắt đầu phải lớn hơn hoặc bằng ngày hiện tại.');
    } else if ($enddate_add_course > $startdate_add_course) {
        $('#formAddCourse .alert').removeClass('hidden');
        $('#formAddCourse .alert').html('Ngày kết thúc phải lớn hơn ngày bắt đầu.');
    }
    else if ($endtime_add_course > $starttime_add_course) {
        $('#formAddCourse .alert').removeClass('hidden');
        $('#formAddCourse .alert').html('Giờ kết thúc phải lớn hơn giờ bắt đầu.');
    }
    else {
        $.ajax({
            url: $_DOMAIN + 'course.php',
            type: 'POST',
            data: {
                major_add_course: $major_add_course,
                tutor_add_course: $tutor_add_course,
                street_add_course: $street_add_course,
                quantity_add_course: $quantity_add_course,
                startdate_add_course: $startdate_add_course,
                enddate_add_course: $enddate_add_course,
                starttime_add_course: $starttime_add_course,
                endtime_add_course: $endtime_add_course,
                action: 'add_course'
            }, success: function (data) {
                $('#formAddCourse .alert').html(data);
            }, error: function () {
                $('#formAddCourse .alert').removeClass('hidden');
                $('#formAddCourse .alert').html('Đã xảy ra lỗi, vui lòng thử lại sau.');
            }
        });
    }
});
// duyệt bài viết
$('#review_topic').on('click', function () {
    $confirm = confirm('Bạn có muốn duyệt bài viết này không?');
    if ($confirm == true) {
        $news_id = $(this).attr('data-id');
        $.ajax({
            url: $_DOMAIN + 'topic.php',
            type: 'POST',
            data: {
                news_id: $news_id,
                action: 'review_topic'
            },
            success: function () {
                location.reload();
                alert('Duyệt thành công.');
            }, error: function () {
                alert('Không thể duyệt vào lúc này, vui lòng thử lại sau.');
            }
        });
    }
    else {
        return false;
    }
});

// duyệt khóa học
$('#review_course').on('click', function () {
    $confirm = confirm('Bạn có muốn duyệt khóa học này không?');
    if ($confirm == true) {
        $id_course = $(this).attr('data-id');
        $.ajax({
            url: $_DOMAIN + 'course.php',
            type: 'POST',
            data: {
                id_course: $id_course,
                action: 'review_course'
            },
            success: function () {
                location.reload();
                alert('Duyệt thành công.');
            }, error: function () {
                alert('Không thể duyệt vào lúc này, vui lòng thử lại sau.');
            }
        });
    }
    else {
        return false;
    }
});

// chi tiết khóa học
$('#course_detail').on('click', function () {
    $id_course = $(this).attr('data-id');
    $.ajax({
        url: $_DOMAIN + 'course.php',
        type: 'POST',
        data: {
            id_course: $id_course,
            action: 'detail_course'
        }, success: function (data) {
            $('#list_course').html(data);
        }
    });
});

// tìm kiếm 
$('#formSearchCourse button').on('click', function () {
    $kw_search_course = $('#kw_search_course').val();
    if ($kw_search_course != '') {
        $.ajax({
            url: $_DOMAIN + 'course.php',
            type: 'POST',
            data: {
                kw_search_course: $kw_search_course,
                action: 'search_course'
            }, success: function (data) {
                $('#list_course').html(data);
            }
        });
    }
});
$('#formSearchAcc button').on('click', function () {
    $kw_search_acc = $('#kw_search_acc').val();
    if ($kw_search_acc != '') {
        $.ajax({
            url: $_DOMAIN + 'account.php',
            type: 'POST',
            data: {
                kw_search_acc: $kw_search_acc,
                action: 'search_acc'
            }, success: function (data) {
                $('#list_acc').html(data);
            }
        });
    }
});
$('#formSearchTopic button').on('click', function () {
    $kw_search_topic = $('#kw_search_topic').val();
    if ($kw_search_topic != '') {
        $.ajax({
            url: $_DOMAIN + 'topic.php',
            type: 'POST',
            data: {
                kw_search_topic: $kw_search_topic,
                action: 'search_topic'
            }, success: function (data) {
                $('#list_topic').html(data);
            }
        });
    }
});

// tìm lịch theo ngày
$('#formSearchSchedule button').on('click', function () {
    $kw_search_schedule = $('#kw_search_schedule').val();
    if ($kw_search_schedule != '') {
        $.ajax({
            url: $_DOMAIN + 'schedule.php',
            type: 'POST',
            data: {
                kw_search_schedule: $kw_search_schedule,
                action: 'search_schedule'
            }, success: function (data) {
                $('#list_schedule').html(data);
            }
        });
    }
});

// thêm bài viết

$('#formAddTopic button').on('click', function () {
    $title_add_topic = $('#title_add_topic').val();
    $category_add_topic = $('#category_add_topic').val();
    $detail_add_topic = $('#detail_add_topic').val();
    if ($title_add_topic == '' || $detail_add_topic == '' || $category_add_topic == '') {
        $('#formAddTopic .alert').removeClass('hidden');
        $('#formAddTopic .alert').html('Vui lòng điền đầy đủ thông tin.');
    }
    else {
        $.ajax({
            url: $_DOMAIN + 'topic.php',
            type: 'POST',
            data: {
                title_add_topic: $title_add_topic,
                category_add_topic: $category_add_topic,
                detail_add_topic: $detail_add_topic,
                action: 'add_topic'
            }, success: function (data) {
                $('#formAddTopic .alert').html(data);
            }, error: function () {
                $('#formAddTopic .alert').removeClass('hidden');
                $('#formAddTopic .alert').html('Đã xảy ra lỗi, vui lòng thử lại sau.');
            }
        });
    }
});

// hủy khóa học và hủy bài viết
$('#cancel_course').on('click', function () {
    $confirm = confirm('Bạn có muốn hủy khóa học này không?');
    if ($confirm == true) {
        $id_course = $(this).attr('data-id');
        $.ajax({
            url: $_DOMAIN + 'course.php',
            type: 'POST',
            data: {
                id_course: $id_course,
                action: 'cancel_course'
            },
            success: function () {
                location.reload();
                alert('Hủy thành công.');
            }, error: function () {
                alert('Không thể hủy vào lúc này, vui lòng thử lại sau.');
            }
        });
    }
    else {
        return false;
    }
});

$('#cancel_topic').on('click', function () {
    $confirm = confirm('Bạn có muốn hủy bài viết này không?');
    if ($confirm == true) {
        $id_topic = $(this).attr('data-id');
        $.ajax({
            url: $_DOMAIN + 'topic.php',
            type: 'POST',
            data: {
                id_topic: $id_topic,
                action: 'cancel_topic'
            },
            success: function () {
                location.reload();
                alert('Hủy thành công.');
            }, error: function () {
                alert('Không thể hủy vào lúc này, vui lòng thử lại sau.');
            }
        });
    }
    else {
        return false;
    }
});