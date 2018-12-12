<?php

// Require database & thông tin chung
require_once 'core/init.php';

// Require header
require_once 'includes/header.php';
// Nếu đã đăng nhập
if ($user)
{
	$sql_check_online = "UPDATE user_profile SET STATUS = '1' WHERE ID_USER = '$data_user[ID_USER]'";
	$db->query($sql_check_online);
 // Hiển thị sidebar
	require_once 'templates/sidebar.php';
	
// Hiển thị content
	require_once 'templates/content.php';
}	
// Nếu không đăng nhập
else
{
    // Hiển thị form đăng nhập
	require_once 'templates/signin.php';
}

// Require footer
require_once 'includes/footer.php';

?>