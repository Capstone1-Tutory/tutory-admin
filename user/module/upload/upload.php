<?php
session_start();
include("../config.php");
$iduser = $_SESSION['id_user'];

if(isset($_POST['btnchangeavata']))
{
$file = $_FILES['file'];
// lấy name file
$fileName= $_FILES['file']['name']; 
// lấy tpmname file
$fileTmpName= $_FILES["file"]["tmp_name"];
// lấy Size file kb
$fileSize= $_FILES['file']['size'];
// sự tồn tại erro =0
$fileError= $_FILES['file']['error'];

// loại file
$fileType= $_FILES['file']['type'];

// lấy cái full name file
$fileExt =explode('.',$fileName);

//giữ lại phần đuôi mở rộng sau dấu '.'
$fileActualExt =strtolower(end($fileExt));


// khởi tạo mảng chứa các đuôi file có thể upload
$allowed = array('jpg','png','jpeg','pdf');

if(in_array($fileActualExt,$allowed))
{
    if($fileError===0)
    {
        if($fileSize<5000000)
        {    // tạo tên file mới tránh trùng lặp
             $fileNewName= uniqid('',true).'.'.$fileActualExt;
             $sql= "UPDATE user_profile SET URL_AVATAR='{$fileNewName}' where ID_USER='{$iduser}'";
             $result= mysqli_query($conn,$sql);
              if($result)
              {
                 $fileDistination = '../../../image/imageUSER/'.$fileNewName;
                  move_uploaded_file($fileTmpName,$fileDistination);
                  echo "<script type='text/javascript'>alert('Thay đổi ảnh đại diện thành công');</script>";
                  header('Location: ../../layout/profile.php#');
              }
              else
              {

                 echo "<script type='text/javascript'>alert('có lỗi. vui lòng thử  lại');</script>";
                 header('Location: ../../layout/profile.php#');
              }
            

        }
        else
        {
            echo "<script type='text/javascript'>alert('Không thể upload file. file quá lớn');</script>";
             header('Location: ../../layout/profile.php#');
        }
    }
    else
    {
         echo "<script type='text/javascript'>alert('Không thể upload file ');</script>";
         header('Location: ../../layout/profile.php#');
    }

} 
else
{
     echo "<script type='text/javascript'>alert('Không thể upload file không đúng định dạng');</script>";
     header('Location: ../../layout/profile.php#');
}


}

 ?>
