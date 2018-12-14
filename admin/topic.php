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
        } 
        //tìm kiếm bài viết
        else if ($action == 'search_topic') {
            $kw_search_topic = trim(htmlspecialchars(addslashes($_POST['kw_search_topic'])));
            if ($kw_search_topic != '') {
                $sql_search_topic = "SELECT * FROM news_category_type NCT, news_categories_of_new NCON, news N, editor_of_news EON                                                                                  
                WHERE NCT.NEWS_CATEGORY_TYPE_ID = NCON.NEWS_CATEGORY_TYPE_ID
                AND NCON.NEWS_ID = N.NEWS_ID
                AND N.NEWS_ID = EON.THING_ROLE_TYPE_ID_TO
                OR N.NEWS_TITLE LIKE '%$kw_search_topic%'
                OR N.COVER_NEWS LIKE '%$kw_search_topic%'
                OR NCT.NEWS_CATEGORY_TYPE_NAME LIKE '%$kw_search_topic%'
                ORDER BY EON.FROM_DATE ASC
                ";

                if ($db->num_rows($sql_search_topic)) {
                    echo
                        '
                <table class="table table-hover list">
                <tr>
                <th><input type="checkbox" id="selectAllTopic"></th>
                <th><strong>Đề tài</strong></th>
                <th><strong>Lĩnh vực</strong></th>
                <th><strong>Tác giả</strong></th>
                <th><strong>Vài trò</strong></th>
                <th><strong>Ngày viết</strong></th>                 
                <th><strong>Trạng thái</strong></th>
                </tr>
                ';
                    foreach ($db->fetch_assoc($sql_search_topic, 0) as $key => $data_topic) {

                        if ($data_topic['STATUS'] == 0) {
                            $stt_topic = ' 
                    <a data-id="' . $data_topic['NEWS_ID'] . '" class="label label-warning" id="review_topic">
                    <span class="glyphicon glyphicon-ok"></span> Chưa duyệt</a>
                    ';
                        } else if ($data_topic['STATUS'] == 1) {
                            $stt_topic = '<label class="label label-primary">Đã duyệt</label>';
                        } else if ($data_topic['STATUS'] == 2) {
                            $stt_topic = '<label class="label label-default">Đã hủy</label>';
                        }
                        $sql_get_editor = "SELECT * FROM editor E, user_account UA, user_profile UP, type_user TU
                    WHERE $data_topic[PARTY_ROLE_TYPE_ID_FROM] = E.PARTY_ID
                    AND E.ID_USER = UA.ID_USER
                    AND UA.ID_USER = UP.ID_USER
                    AND UA.ID_TYPE = TU.ID_TYPE
                    ";
                        foreach ($db->fetch_assoc($sql_get_editor, 0) as $key => $data_editor) {

                        }
                        if ($data_editor['ID_TYPE'] == 'ad') {
                            $role_acc = '<label class="label label-primary">Quản trị viên</label>';
                        } else {
                            if ($db->num_rows("SELECT ID_PROFILE FROM tutor WHERE ID_PROFILE = $data_editor[ID_PROFILE]")) {
                                $role_acc = '<label class="label label-warning">Gia sư</label>';
                            } else if ($db->num_rows("SELECT ID_PROFILE FROM student WHERE ID_PROFILE = $data_editor[ID_PROFILE]")) {
                                $role_acc = '<label class="label label-info">Học viên</label>';
                            } else {
                                $role_acc = '<label class="label label-default">Người dùng</label>';
                            }
                        }
                        echo
                            '
                    <tr>
                    <th><input type="checkbox" name="NEWS_ID[]" value="' . $data_topic['NEWS_ID'] . '"></th>
                    <th>' . $data_topic['NEWS_TITLE'] . '</th>
                    <th>' . $data_topic['NEWS_CATEGORY_TYPE_NAME'] . '</th>
                    <th>' . $data_editor['NAME'] . '</th>
                    <th>' . $role_acc . '</th>
                    <th>' . $data_topic['FROM_DATE'] . '</th>
                    <th>' . $stt_topic . '</th>
                    </tr>
                    ';
                    }
                }
// Nếu không có bài viết
                else {
                    echo '<br><br><div class="alert alert-info">Không tìm thấy bài viết nào.</div>';
                }
            } else {
                echo '<br><br><div class="alert alert-info">Vui lòng nhập từ khóa.</div>';
            }
        } else {
            new Redirect($_DOMAIN); // Trở về trang index
        }
    }
} else {
    new Redirect($_DOMAIN); // Trở về trang index
}