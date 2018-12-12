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
            echo
                '
                <a href="' . $_DOMAIN . 'topic" class="btn btn-default">
                    <span class="glyphicon glyphicon-arrow-left"></span> Trở về
                </a> 
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
            <a href="' . $_DOMAIN . 'posts/add_topic" class="btn btn-default">
                <span class="glyphicon glyphicon-plus"></span> Thêm bài viết
            </a> 
            <a href="' . $_DOMAIN . 'topic" class="btn btn-default">
                <span class="glyphicon glyphicon-repeat"></span> Reload
            </a> 
            <a class="btn btn-danger" id="del_topic_list">
                <span class="glyphicon glyphicon-trash"></span> Xoá
            </a> 
            <input class="form-control mr-sm-2" type="search" placeholder="Nhập từ khóa .." aria-label="Search">
            <button class="btn btn-success my-2 my-sm-0" type="submit">Tìm kiếm</button>
            </form>
        ';
        // Content danh sách bài viết
        $sql_get_topic = "SELECT * FROM news_category_type NCT, news_categories_of_new NCON, news N,
                                                                                                        , editor_of_news EON, editor E
        WHERE NCT.NEWS_CATEGORY_TYPE_ID = NCON.NEWS_CATEGORY_TYPE_ID
        AND NCON.NEWS_ID = N.NEWS_ID
        AND N.NEWS_ID = 
        ";
        if ($db->num_rows($sql_get_topic)) {
            echo '
            <br><br>
                <div class="table-responsive">
                <table class="table table-hover list" id="list_topic">
                <tr>
                <th><input type="checkbox" id="selectAllTopic"></th>
                <th><strong>Đề tài</strong></th>
                <th><strong>Mô tả</strong></th>
                <th><strong>Tác giả</strong></th>
                <th><strong>Ngày viết</strong></th>                 
                <th><strong>Trạng thái</strong></th>
                </tr>
            ';
            foreach ($db->fetch_assoc($sql_get_topic, 0) as $key => $data_topic) {
                if ($data_topic['STATUS'] = '0') {
                    $stt_topic = '<a id="review_topic">Chưa duyệt</a>';
                } else if ($data_topic['STATUS'] = '1') {
                    $stt_topic = '<label class="label label-primary">Đã duyệt</label>';
                } else if ($data_topic['STATUS'] = '2') {
                    $stt_topic = '<label class="label label-default">Đã hủy</label>';
                }
                echo
                    '
                    
                    <tr>
                    <th><input type="checkbox" name="NEWS_ID[]" value="' . $data_topic['NEWS_ID'] . '"></th>
                    <th>' . $data_topic['NEWS_TITLE'] . '</th>
                    <th>' . $data_topic['DETAILS'] . '</th>
                    <th>' . $data_topic[''] . '</th>
                    <th>' . $data_topic[''] . '</th>
                    <th>' . $stt_topic . '</th>
                    </tr>
                    ';
            }
            echo '</table>';

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