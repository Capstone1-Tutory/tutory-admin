 <?php 
     

    include('../config.php') ;


    $username=$_POST['username'];
    $password=$_POST['password'];
    $epassword=$_POST['enterpassword'];

    if($username ==""|| $password==""||$epassword=="")
        echo "nhập đầy đủ thông tin";  
    else 
       
            if(mysqli_num_rows(mysqli_query($conn,"SELECT * from user_account where USER_NAME='{$username}'"))>0)
           
                echo "Tên tài khoản này đã có người sử dụng";
           
            else
         
                if($password<>$epassword)
               
                   echo "mật khẩu không trùng khớp";
                
                else
                {   
                  $password=md5($password);
                  $sql= "INSERT INTO user_account(USER_NAME,PASS_WORD,ID_TYPE) values('{$username}','{$password}','user')";
                  $result=mysqli_query($conn,$sql);
                 if($result)
                 
                  echo "đăng kí thành công  <a href='javascript:history.back(-1)'>Quay lại trang trước</a>";
                 
                 else
                 
                  echo "có lỗi xảy ra khi đăng kí'); window.location:../../index.php</script>";
                 
                }
            
        
 
?>