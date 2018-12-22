<?php 
 $idcourse=$_GET['id_course'];
 $idstudent=$_GET['id_student'];
 include('../config.php');
 
$sqlcheck ="SELECT * from student_rela_course where ID_STUDENT='{$idstudent}' and ID_COURSE='{$idcourse}'";
if(mysqli_num_rows(mysqli_query($conn,$sqlcheck))>0)
{
	echo "Bạn đã đăng kí khóa học này";
}
else
{
 $sql= "INSERT INTO student_rela_course (ID_STUDENT,ID_COURSE,DESCRIPTION) values('{$idstudent}','{$idcourse}',null)";
 $result=mysqli_query($conn,$sql);
 if($result)
 {
 	echo "Đăng kí thành công";
 }
 else
 {
 	echo "Đăng kí không thành công";
 }
}
 ?>