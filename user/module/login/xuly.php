<?php 
include('../config.php') 
 $myusername=$_POST['username'];
 $mypassword=$_POST['password'];
 session_start();

 if(isset($_POST['btndangnhap']))
 {
 	$sql="select * from user_account where USER_NAME='$myusername' and PASS_WORD='$mypassword'";
 	$result=mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $active = $row['active'];
      
    $count = mysqli_num_rows($result);
    header("location:../../index.php");
    if($count==1)
    {
    	session_register("username");
    	$_SESSION['login_username']=$myusername;
    	header("location:../../index.php");
    }
    else
    {
    	$error="Sai tên đăng nhập hoặc mật khẩu";
    }
 }
?>
