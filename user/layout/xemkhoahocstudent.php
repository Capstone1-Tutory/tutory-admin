<?php
session_start();
 $iduser=$_SESSION["id_user"]; 
 include("../module/config.php");
  $sqlmajor="SELECT ID_MAJOR, MAJOR_NAME FROM major";
  $sqlcourse="SELECT course.ID_COURSE,user_profile.NAME, major.MAJOR_NAME, COURSE_START_DATE, COURSE_END_DATE from course
inner join student_rela_course src on src.ID_COURSE = course.ID_COURSE
inner join major on major.ID_MAJOR = course.ID_MAJOR
inner join tutor on tutor.ID_TUTOR = course.ID_TUTOR
inner join user_profile on tutor.ID_PROFILE= user_profile.ID_PROFILE
inner join student on student.ID_STUDENT = src.ID_STUDENT
inner join user_profile up on student.ID_PROFILE= up.ID_PROFILE
where up.ID_USER='{$iduser}'";
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" type="text/css" href="../../static/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../static/css/css.css">
</head>
<body>
	
		<table class="table">
			<thead class="thead-dark" align="center">
				<tr>
					<th width="5%">#</th>
                    <th width="15%">Môn Học</th>
                    <th width="22%">Gia Sư</th>
                    <th width="24%">Thời Gian Bắt Đầu</th>
                    <th width="27%">Thời Gian Kết Thúc</th>
                    <th width="7%"></th>
                    
				</tr>
			</thead>
			<tbody>
				
					<?php 

                     $resultcourse=mysqli_query($conn,$sqlcourse);
                     $stt =1;
                     while ($rowcourse=mysqli_fetch_assoc($resultcourse)) 
                     {
                     ?>
                        <tr>
                     	<th scope="row"><?php echo $stt ?></th>
                     	<td align="center"><?php echo $rowcourse['MAJOR_NAME'] ?></td>
                        <td align="center"><?php echo $rowcourse['NAME'] ?></td>
                     	<td align="center"><?php echo $rowcourse['COURSE_START_DATE'] ?></td>
                     	<td align="center"><?php echo $rowcourse['COURSE_END_DATE'] ?></td>
                        <td>
                            <button type="button" class="btn btn-outline-info" id="btnxem<?php echo $rowcourse['ID_COURSE'] ?>"
                                value="<?php echo $rowcourse['ID_COURSE'] ?>">Xem</button>
                        </td>
                     	</tr>
                     <?php
                     $stt++;
                     }
					 ?>
					
				
			</tbody>
			
		</table>
        <br>
        <br>
        <br>
