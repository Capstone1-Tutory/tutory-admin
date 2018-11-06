<?php

    include('../config.php') ;
    session_start();
  
 	$myusername=$_POST['myusername'];
    $mypassword=$_POST['mypassword'];
    $mypassword=md5($mypassword);
    $sql="select * from user_account where USER_NAME='{$myusername}' and PASS_WORD='{$mypassword}'";
    $result=mysqli_query($conn,$sql);
    $row= mysqli_fetch_assoc($result);
    $count = mysqli_num_rows($result);
     if($count>0)
     {
        $_SESSION['login_username']=$myusername;
     }
    echo $count;

   
        
?>