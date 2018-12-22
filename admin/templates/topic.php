<?php
  
// Nếu đăng nhập
if ($user) {
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
        // Trang thêm bài viết
        if ($ac == 'add_topic') {
            // Dãy nút của thêm bài viết
            echo '
                <h3>Thêm bài viết</h3>
                <p class="form-add-topic">
                <form method="POST" id="formAddTopic" onsubmit="return false;">
                <div class="form-group">
                <label>Tên đề tài</label>
                <input type="text" class="form-control title" id="title_add_topic">
                </div>
                <div class="form-group">
                <label>Lĩnh vực</label>
                <select class="form-control title" id="category_add_topic">
                ';
            $sql_get_category = "SELECT * FROM news_category_type
                        ";
            if ($db->num_rows($sql_get_category)) {
                foreach ($db->fetch_assoc($sql_get_category, 0) as $key => $data_category) {
                    echo '
                                    <option value="' . $data_category['NEWS_CATEGORY_TYPE_ID'] . '">' . $data_category['NEWS_CATEGORY_TYPE_NAME'] . '</option>
                                ';
                }
            }
            echo '
                </select>
                </div>
                <div class="form-group">
                <label>Nội dung</label>
                <textarea class="form-control" id="detail_add_topic" rows="3"></textarea>
                </div>
                <div class="form-group">
                <div class="form-inline">
                <a href="' . $_DOMAIN . 'topic" class="btn btn-default" style="color:red">
                <span class="glyphicon glyphicon-arrow-left" style="color:red"></span> Hủy
                </a>
                <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
                </div>
                <div class="alert alert-danger hidden"></div>
                </form>
                </p>
                ';
  
            // Content thêm bài viết

        } 
        // Trang chỉnh sửa bài viết
        else if ($ac == 'edit_topic') {

        }
    }
    // Ngược lại không có tham số ac
    // Trang danh sách bài viết
    else {
        // Dãy nút của danh sách bài viết
        echo
            '
            <h3>Bài viết</h3><hr>
            <form class="form-inline">
            <a href="' . $_DOMAIN . 'topic/add_topic" class="btn btn-default">
                <span class="glyphicon glyphicon-plus"></span> Thêm bài viết
            </a> 
            <a href="' . $_DOMAIN . 'topic" class="btn btn-default">
                <span class="glyphicon glyphicon-repeat"></span> Reload
            </a> 
            <a class="btn btn-danger" id="del_topic_list">
                <span class="glyphicon glyphicon-trash"></span> Hủy
            </a> 
            </form>          
        ';
        // Content danh sách bài viết
        $sql_get_topic = "SELECT * FROM news_category_type NCT, news_categories_of_new NCON, news N, editor_of_news EON                                                                                  
        WHERE NCT.NEWS_CATEGORY_TYPE_ID = NCON.NEWS_CATEGORY_TYPE_ID
        AND NCON.NEWS_ID = N.NEWS_ID
        AND N.NEWS_ID = EON.THING_ROLE_TYPE_ID_TO
        ORDER BY EON.FROM_DATE DESC
        ";

        if ($db->num_rows($sql_get_topic)) {
            //tìm kiếm bài viết
            echo '
            <p>
                <form method="POST" id="formSearchTopic" onsubmit="return false;">
                    <div class="input-group">         
                        <input type="text" class="form-control" id="kw_search_topic" placeholder="Nhập từ khóa ...">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </span>
                    </div>
                </form>
            </p>  
            ';
            echo '
                <div class="table-responsive"  id="list_topic">
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
            foreach ($db->fetch_assoc($sql_get_topic, 0) as $key => $data_topic) {
                if ($data_topic['STATUS'] == 0) {
                    $stt_topic = ' 
                    <a onclick="review_topic(' . $data_topic['NEWS_ID'] . ')" class="label label-warning" id="review_topic">
                    <span class="glyphicon glyphicon-ok"></span> Chưa duyệt</a>
                    ';
                } else if ($data_topic['STATUS'] == 1) {
                    $stt_topic = '<label class="label label-primary">Đã duyệt</label>
                    <a onclick="cancel_topic(' . $data_topic['NEWS_ID'] . ')" class="label label-danger" id="cancel_topic">
                    <span class="glyphicon glyphicon-remove-sign"></span> Hủy</a>
                    ';
                } else if ($data_topic['STATUS'] == 2) {
                    $stt_topic = '<label class="label label-danger">Đã hủy</label>';
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
            echo '</table>
                    </div>
            ';

        } else {
            echo '<br><br><div class="alert alert-info">Không có bài viết nào trong hệ thống.</div>';
        }
    }

}
// Ngược lại chưa đăng nhập
else {
    new Redirect($_DOMAIN); // Trở về trang index
}

?>