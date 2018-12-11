<?php 
 include('../config.php');
 session_start();
 $iduser= $_SESSION['id_user'];
 $sqlidtutor="SELECT ID_TUTOR from  tutor, user_profile
where tutor.ID_PROFILE = user_profile.ID_PROFILE and user_profile.ID_USER='{$iduser}'";
$rowidtutor = mysqli_fetch_assoc(mysqli_query($conn,$sqlidtutor));
$idtutor= $rowidtutor['ID_TUTOR'];
$datestart= $_GET['datestart'];
$dateend= $_GET['dateend'];
$soluong =$_GET['soluong'];
$idmajor=$_GET['idmajor'];

$sqladdcourse = "INSERT INTO course (ID_TUTOR,COURSE_STATUS,COURSE_START_DATE,COURSE_END_DATE,QUANTITY_STUDENT,ID_MAJOR) 
                 VALUES('{$idtutor}',0,'{$datestart}','{$dateend}','{$soluong}','{$idmajor}')";
$resutl= mysqli_query($conn,$sqladdcourse);
if(!$resutl)
{
	echo "có lỗi!! vui lòng thử lại";
}

 ?>

