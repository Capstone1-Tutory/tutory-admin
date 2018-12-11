<?php 
session_start();
$kq="";
include('module/config.php');
$sqlcheck="SELECT ua.ID_USER FROM user_profile up INNER JOIN user_account ua ON ua.ID_USER=up.ID_USER INNER JOIN thread_messager tm ON tm.SENDER_IDPROFILE =up.ID_PROFILE WHERE tm.ID_THREAD=1";
$kqcheck=mysqli_query($conn,$sqlcheck);
$rowcheck=mysqli_fetch_assoc($kqcheck);
if ($rowcheck["ID_USER"]!=$_SESSION['id_user']) {
	$kq=1;
}
echo $kq;

 ?>