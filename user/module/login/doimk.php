<?php 
session_start();
 include'../config.php';

 $pass=$_GET['ollpass'];
 $newpass= $_GET['newpass'];
  $iduser=$_SESSION['id_user'];
 $pass= md5($pass);
 $sql= "SELECT * from user_account where ID_USER='{$iduser}' and PASS_WORD='{$pass}'";
 $row= mysqli_num_rows(mysqli_query($conn,$sql));
 if($row==0)
   echo"Mật khẩu củ không đúng";
else 
{
    $newpass= md5($newpass);
	$sqlchange= "UPDATE user_account SET PASS_WORD='{$newpass}'";
	if(mysqli_query($conn,$sqlchange))
	{
		echo "Đổi mật khẩu thành công";
	}
	else
		echo "có lỗi xảy ra.Vui lòng thử lại";
}
 ?>