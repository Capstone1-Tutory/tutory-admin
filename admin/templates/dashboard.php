<h3>Tài khoản</h3><hr>
<div class="row">
  <?php

  // Lấy tổng tài khoản
  $sql_get_count_acc = "SELECT ID_USER FROM user_account";
  $count_acc = $db->num_rows($sql_get_count_acc);
  $sql_get_count_acc_online = "SELECT ID_USER FROM user_profile WHERE STATUS = '1'";
  $count_acc_online = $db->num_rows($sql_get_count_acc_online);
  echo
    '
  <div class="col-md-3">
  <div class="alert alert-success">
  <h1>' . $count_acc . '</h1>
  <p><i>Tổng tài khoản(' . $count_acc_online . ' trực tuyến)</i></p>
  </div>
  </div>
  ';
  // Lấy số tài khoản quản trị
  $sql_get_count_acc_admin = "SELECT ID_USER FROM user_account WHERE ID_TYPE = 'ad'";
  $count_acc_admin = $db->num_rows($sql_get_count_acc_admin);
  echo
    '
  <div class="col-md-3">
  <div class="alert alert-info">
  <h1>' . $count_acc_admin . '</h1>
  <p><i>Quản trị viên</i></p>
  </div>
  </div>
  ';
  // Lấy số tài khoản gia sư
  $sql_get_count_acc_tutor = "SELECT ID_TUTOR FROM tutor";
  $count_acc_tutor = $db->num_rows($sql_get_count_acc_tutor);

  echo
    '
  <div class="col-md-3">
  <div class="alert alert-warning">
  <h1>' . $count_acc_tutor . '</h1>
  <p><i>Gia sư</i></p>
  </div>
  </div>
  ';
  // Lấy số tài khoản học viên
  $sql_get_count_acc_user = "SELECT ID_STUDENT FROM student";
  $count_acc_student = $db->num_rows($sql_get_count_acc_user);

  echo
    '
  <div class="col-md-3">
  <div class="alert alert-danger">
  <h1>' . $count_acc_student . '</h1>
  <p><i>Học viên</i></p>
  </div>
  </div>
  ';

  ?>
</div>

<h3>Khóa học</h3><hr>
<div class="row">
<?php
// lấy tổng số khóa học
$sql_get_course = "SELECT * FROM course WHERE COURSE_STATUS = '1'";
$count_course = $db->num_rows($sql_get_course);
echo
  '
  <div class="col-md-3">
  <div class="alert alert-success">
  <h1>' . $count_course . '</h1>
  <p><i>Khóa học đang hoạt động</i></p>
  </div>
  </div>
  ';
  //lấy khóa học đã kết thúc
$sql_end_course = "SELECT * FROM course WHERE date(COURSE_END_DATE)  < date(now())";
$count_end = $db->num_rows($sql_end_course);
echo
  '
  <div class="col-md-3">
  <div class="alert alert-info">
  <h1>' . $count_end . '</h1>
  <p><i>Khóa học đã kết thúc</i></p>
  </div>
  </div>
  ';
  //lấy khóa học chưa duyệt
$sql_review_course = "SELECT * FROM course WHERE COURSE_STATUS = '0'";
$count_review = $db->num_rows($sql_review_course);
echo
  '
  <div class="col-md-3">
  <div class="alert alert-warning">
  <h1>' . $count_review . '</h1>
  <p><i>Khóa học đợi duyệt</i></p>
  </div>
  </div>
  ';
  // lấy khóa học đã hủy
$sql_cancel_course = "SELECT * FROM course WHERE COURSE_STATUS = '2'";
$count_cancel = $db->num_rows($sql_cancel_course);
echo
  '
  <div class="col-md-3">
  <div class="alert alert-danger">
  <h1>' . $count_cancel . '</h1>
  <p><i>Khóa học đã hủy</i></p>
  </div>
  </div>
  ';
?>
</div>

<h3>Bài viết</h3><hr>
<div class="row">
<?php
// lấy tổng bài viết
$sql_total_topic = "SELECT * FROM news";
$count_total = $db->num_rows($sql_total_topic);
echo
  '
  <div class="col-md-3">
  <div class="alert alert-success">
  <h1>' . $count_total . '</h1>
  <p><i>Tổng số bài viết</i></p>
  </div>
  </div>
  ';
//lấy bài viết đẫ duyệt
$sql_get_topic = "SELECT * FROM news WHERE STATUS = '1'";
$count_topic = $db->num_rows($sql_get_topic);
echo
  '
  <div class="col-md-3">
  <div class="alert alert-info">
  <h1>' . $count_topic . '</h1>
  <p><i>Bài viết đã duyệt</i></p>
  </div>
  </div>
  ';
  //lấy bài viết chưa duyệt
$sql_review_topic = "SELECT * FROM news WHERE STATUS = '0'";
$count_review_topic = $db->num_rows($sql_review_topic);
echo
  '
  <div class="col-md-3">
  <div class="alert alert-warning">
  <h1>' . $count_review_topic . '</h1>
  <p><i>Bài viết đợi duyệt</i></p>
  </div>
  </div>
  ';
  // lấy bài viết đã hủy
$sql_cancel_topic = "SELECT * FROM news WHERE STATUS = '2'";
$count_cancel_topic = $db->num_rows($sql_cancel_topic);
echo
  '
  <div class="col-md-3">
  <div class="alert alert-danger">
  <h1>' . $count_cancel_topic . '</h1>
  <p><i>Bài viết đã hủy</i></p>
  </div>
  </div>
  ';
?>
</div>