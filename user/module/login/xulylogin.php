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
        $_SESSION["login_username"]=$row['USER_NAME'];
        $_SESSION["id_user"]=$row["ID_USER"];
        $sqlonline= "update user_profile SET STATUS=1 where ID_USER='{$row["ID_USER"]}'";
        $resultonline=mysqli_query($conn,$sqlonline);
     }
    echo $count;

   
        
?>