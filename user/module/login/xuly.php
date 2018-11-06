<?php include('../config.php') ;
 session_start();
 if(isset($_POST['btndangnhap']))
 {  
 	$myusername=$_POST['Login_username'];
    $mypassword=$_POST['Login_password'];
 	$sql="select * from user_account where USER_NAME='{$myusername}' and PASS_WORD='{$mypassword}'";
 	$result=mysqli_query($conn,$sql);
    $row= mysqli_fetch_assoc($result);
      
    $count = mysqli_num_rows($result);

    if($count==1)
    {
    	
    	$_SESSION['login_username']=$myusername;
    	header("location:../../index.php");
    }
    else
    {
    	$error="Sai tên đăng nhập hoặc mật khẩu";
    }
 }
?>
