<?php

// Require database & thông tin chung
require_once 'core/init.php';

// Xoá session
$sql_check_offline = "UPDATE user_profile SET STATUS = '0' WHERE ID_USER = '$data_user[ID_USER]'";
$db->query($sql_check_offline);
$db->close();
$session->destroy();
new Redirect($_DOMAIN); // Trở về trang index

?>