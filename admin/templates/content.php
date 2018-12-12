	<div class="col-md-9 content">
        <?php
        
    // Phân trang content
    // Lấy tham số tab
        if (isset($_GET['tab'])) {
            $tab = trim(addslashes(htmlspecialchars($_GET['tab'])));
        } else {
            $tab = '';
        }
        
    // Nếu có tham số tab
        if ($tab != '') {
        // Hiển thị template chức năng theo tham số tab
            if ($tab == 'profile') {
            // Hiển thị template hồ sơ cá nhân
                require_once 'templates/profile.php';
            } else if ($tab == 'account') {
            // Hiển thị template tài khoản
                require_once 'templates/account.php';
            } else if ($tab == 'course') {
            // Hiển thị template khóa học
                require_once 'templates/course.php';
            } else if ($tab == 'topic') {
            // Hiển thị template bài viết
                require_once 'templates/topic.php';
            } else if ($tab == 'schedule') {
            // Hiển thị template lịch giảng dạy
                require_once 'templates/schedule.php';
            }
        }
    // Ngược lại không có tham số tab
        else {
        // Hiển thị template bảng điều khiển
            require_once 'templates/dashboard.php';
        }

        ?>
</div><!-- div.content -->