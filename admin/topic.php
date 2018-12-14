<?php

// Kết nối database và thông tin chung
require_once 'core/init.php';

// Nếu đăng nhập
if ($user) {
    // Nếu tồn tại POST action
    if (isset($_POST['action'])) {
        // Xử lý POST action
        $action = trim(addslashes(htmlspecialchars($_POST['action'])));
        
        // Thêm tài khoản
        
    // duyệt bài viết
        if ($action == 'review_topic') {
            $news_id = trim(htmlspecialchars(addslashes($_POST['news_id'])));
            $sql_check_news_id_exist = "SELECT NEWS_ID FROM news WHERE NEWS_ID = '$news_id'";
            if ($db->num_rows($sql_check_news_id_exist)) {
                $sql_review_topic = "UPDATE news SET STATUS = '1' WHERE NEWS_ID = '$news_id'";
                $db->query($sql_review_topic);
                $db->close();
            }
        } else {
            new Redirect($_DOMAIN); // Trở về trang index
        }
    }
} else {
    new Redirect($_DOMAIN); // Trở về trang index
}