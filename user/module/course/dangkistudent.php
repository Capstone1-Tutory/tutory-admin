<?php 
 include('../config.php');
 $idprofile=$_GET['id_profile'];
 $sql="INSERT into student (ID_PROFILE,JOB,STUDENT_DESCRIPTION) values('{$idprofile}',null,null)";
 $result= mysqli_query($conn,$sql);
 if($result)
 {
 	echo "đăng kí thành công";
 }
 else
 {
 	echo "đăng kí không thành công";
 }

 ?>