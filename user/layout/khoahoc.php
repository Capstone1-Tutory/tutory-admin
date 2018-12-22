<?php
session_start();
$user="" ;
if(isset($_SESSION['id_user']))
{
$user=$_SESSION['id_user'];
}
$idstudent="";
include('../module/config.php');
  $sqlcourse="SELECT ID_COURSE, major.MAJOR_NAME,NAME, COURSE_START_DATE, COURSE_END_DATE, QUANTITY_STUDENT from course
inner join major on major.ID_MAJOR = course.ID_MAJOR
inner join tutor on tutor.ID_TUTOR = course.ID_TUTOR
inner join user_profile on tutor.ID_PROFILE= user_profile.ID_PROFILE
where course.COURSE_STATUS=1 
order by COURSE_START_DATE DESC" ;
  $sqlidprofile="SELECT user_profile.ID_PROFILE from user_profile where ID_USER='{$user}'";
  $rowprofile=mysqli_fetch_assoc(mysqli_query($conn,$sqlidprofile));
  $idprofile= $rowprofile['ID_PROFILE'];
  $sqlstudent="SELECT student.ID_STUDENT  from student , user_profile
  where  student.ID_PROFILE= user_profile.ID_PROFILE and user_profile.ID_USER='{$user}'";
  $resultstudent=mysqli_query($conn,$sqlstudent);
  if(mysqli_num_rows($resultstudent))
  {
   $student=mysqli_fetch_assoc($resultstudent);
   $idstudent= $student['ID_STUDENT'];
  }

 ?>
 <input type="text" id="txtuser" value="<?php echo $user ?>" style="display: none" >
 <input type="text" id="txtidstudent" value="<?php echo $idstudent ?>" style="display: none">
 <input type="text" id="txtidprofile" value="<?php echo $idprofile ?>" style="display: none">
 <button type="button" class="btn btn-primary" id="btndangkistudent">Đăng kí làm học sinh</button>
 <table class="table">
			<thead class="thead-dark">
				<tr>
					<th width="5%">#</th>
                    <th width="15%">Môn Học</th>
                    <th width="10">Gia Sư</th>
                    <th width="20%">Thời Gian Bắt Đầu</th>
                    <th width="20%">Thời Gian Kết Thúc</th>
                    <th width="10%">Số HV</th>
                    <th width="20%"></th>
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
                     	<td align="center"><?php echo $rowcourse['QUANTITY_STUDENT'] ?></td>
                     	<td>
                     		<button type="button" class="btn btn-outline-info" id="btnxem<?php echo $rowcourse['ID_COURSE'] ?>"
                     			value="<?php echo $rowcourse['ID_COURSE'] ?>" onclick="xemkhoahoc()">Xem</button>
                     		<button type="button" class="btn btn-outline-danger" id="btndangki<?php echo $rowcourse['ID_COURSE'] ?>"
                     			value="<?php echo $rowcourse['ID_COURSE'] ?>" onclick="dangkikhoahoc(<?php echo $rowcourse['ID_COURSE'] ?>)">Đăng kí</button>
                     	</td>
                     	</tr>
                         
                     <?php
                     $stt++;
                     }
					 ?>
					
				
			</tbody>
			
		</table>
<script src="../../static/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../../static/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
    if($("#txtidstudent").val()!=""||$("#txtuser").val()=="")
    {
        $("#btndangkistudent").hide();
    }
    else
    {
         $("#btndangkistudent").show();
    }
    $("#btndangkistudent").click(function(event) {
        var idprofile= $("#txtidprofile").val();
        $.get('module/course/dangkistudent.php',{id_profile:idprofile}, function(data) {
            var answer= confirm(data);
            if(answer==true)
            {
                location.reload();
            }
        });
    });
   function xemkhoahoc()
   {
        var user= $("#txtuser").val();
        if(user=="")
         {
           alert("Bạn phải đăng nhập mới có thể thực hiện chức năng này");
                              
         }
         if($("#txtidstudent").val()=="")
         {
            alert("bạn phải đăng kí trở thành học sinh để thực hiện chức năng này");
         }

    }
  function dangkikhoahoc(idcourse)
  {
        var user= $("#txtuser").val();
        var idstudent=$("#txtidstudent").val();
        if(user=="")
         {
           alert("Bạn phải đăng nhập mới có thể thực hiện chức năng này");
                              
          }
          else
          if($("#txtidstudent").val()=="")
         {
            alert("bạn phải đăng kí trở thành học sinh để thực hiện chức năng này");
         }
         else
         {
           $.get('module/course/studentdangkikhoahoc.php',{id_course:idcourse,id_student:idstudent}, function(data) {
               alert(data);
           });
         }
 }
 </script>