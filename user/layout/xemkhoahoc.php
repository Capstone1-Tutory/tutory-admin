<?php
session_start();
 $iduser=$_SESSION["id_user"]; 
 include("../module/config.php");
  $sqlmajor="SELECT ID_MAJOR, MAJOR_NAME FROM major";
  $sqlcourse="SELECT ID_COURSE, major.MAJOR_NAME, COURSE_START_DATE, COURSE_END_DATE, QUANTITY_STUDENT from course
inner join major on major.ID_MAJOR = course.ID_MAJOR
inner join tutor on tutor.ID_TUTOR = course.ID_TUTOR
inner join user_profile on tutor.ID_PROFILE= user_profile.ID_PROFILE
where user_profile.ID_USER='{$iduser}' and course.COURSE_STATUS=1";
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
	
		<button type="button" class="btn btn-primary" id="btnaddcourse" data-toggle="modal" data-target="#modaladdcourse"><i class="fa far-"></i>Đăng kí khóa học</button>
        <br>
        <br>
		<table class="table">
			<thead class="thead-dark">
				<tr>
					<th width="5%">#</th>
                    <th width="15%">Môn Học</th>
                    <th width="24%">Thời Gian Bắt Đầu</th>
                    <th width="24%">Thời Gian Kết Thúc</th>
                    <th width="12%">Số HV</th>
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
                     	<td align="center"><?php echo $rowcourse['COURSE_START_DATE'] ?></td>
                     	<td align="center"><?php echo $rowcourse['COURSE_END_DATE'] ?></td>
                     	<td align="center"><?php echo $rowcourse['QUANTITY_STUDENT'] ?></td>
                     	<td>
                     		<button type="button" class="btn btn-outline-info" id="btnxem<?php echo $rowcourse['ID_COURSE'] ?>"
                     			value="<?php echo $rowcourse['ID_COURSE'] ?>">Xem</button>
                     		<button type="button" class="btn btn-outline-danger" id="btnsua<?php echo $rowcourse['ID_COURSE'] ?>"
                     			value="<?php echo $rowcourse['ID_COURSE'] ?>">Sửa</button>
                     	</td>
                     	</tr>
                     <?php
                     $stt++;
                     }
					 ?>
					
				
			</tbody>
			
		</table>

    
<div class="modal face" id="modaladdcourse" role="addcourse">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4> Đăng Kí Khóa Học</h4>
			</div>
			<div class="modal-body">
			  <div class="form-group">
                <label>Chuyên ngành</label>
                <select class="form-control title" id="slmajor">
                <option value="">--Vui lòng chọn chuyện ngành--</option>
                <?php 
                   $resultmajor= mysqli_query($conn,$sqlmajor);
                   while ($row=mysqli_fetch_assoc($resultmajor)) {
                      ?>
                       <option value="<?php echo $row["ID_MAJOR"] ?>"><?php echo $row["MAJOR_NAME"] ?></option>
                      <?php
                   }
                 ?>
                
                </select>
                </div>

                <div class="form-group">
                <label>Số lượng học viên:</label>
                <input type="number" id="txtsoluong" min="1" max="30" placeholder="1-30" required>
                </div>
                <div class="form-group">
                
                <label>Chọn ngày:</label>
                <label> Từ</label>
                <input type="date" class="form-control-inline title" id="txtstartday">
                
                <label> Đến</label>
                
                <input type="date" class="form-control-inline title" id="txtendate">
                </div>
                <p id="response" style="color: red"></p>
                <p id="responseRIGHT" style="color: green"></p>
              
			</div>
			<div class="modal-footer">
				<div class="form-group">
                <div class="form-inline">
                <a href="" class="btn btn-default" style="color:red">
                <span class="glyphicon glyphicon-arrow-left" style="color:red"></span> Hủy
                </a>
                
                <a class="btn btn-primary" id="btndangkikhoahoc">Xác nhận</a> 
                </div>
                </div>
				
			</div>
		</div>
	</div>
	
</div>




</body>
<script src="../../static/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../../static/vendor/jquery/jquery.min.js"></script>
</html>

<script type="text/javascript">
	$("#btndangkikhoahoc").click(function(event) {
		var soluong= $("#txtsoluong").val();
		var startdate = $("#txtstartday").val();
		var enddate=  $("#txtendate").val();
		var idmajor=$("#slmajor").val();
		if(soluong==""||idmajor==""||enddate==""||startdate=="")
		{
			 $("#response").html("vui lòng nhập đầy đủ dữ liệu");

		}
		else
		if(enddate<startdate)
		{
			  $("#response").html("Ngày kết thúc khóa học không hợp lệ. vui lòng kiểm tra lại");
		}
		else
		if(soluong>30 ||soluong<1)
		{
          $("#response").html("Vui lòng nhập đúng số lượng học sinh. Từ 1 -> 30")
		}
		else
		{
			$.get('../module/course/dangkikhoahoc.php',{datestart:startdate, dateend:enddate,soluong:soluong,idmajor:idmajor}, function(data) {
				if(data=="")
				{
				 $("#response").html(data);
				}
				else
				{
				  alert("đăng kí thành công");
				   window.history.back(-2);
				}
			});
		}
	});
</script>

