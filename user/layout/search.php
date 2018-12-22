<?php
$majorname=$_GET['majorname'];
 include('../module/config.php');
  $sqlcourse="SELECT ID_COURSE, major.MAJOR_NAME,NAME, COURSE_START_DATE, COURSE_END_DATE, QUANTITY_STUDENT from course
inner join major on major.ID_MAJOR = course.ID_MAJOR
inner join tutor on tutor.ID_TUTOR = course.ID_TUTOR
inner join user_profile on tutor.ID_PROFILE= user_profile.ID_PROFILE
where course.COURSE_STATUS=1 and major.MAJOR_NAME='{$majorname}'
order by COURSE_START_DATE DESC" ;

 ?>
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
                     if(mysqli_num_rows($resultcourse)>0)
                     {
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
                     			value="<?php echo $rowcourse['ID_COURSE'] ?>">Xem</button>
                     		<button type="button" class="btn btn-outline-danger" id="btnsua<?php echo $rowcourse['ID_COURSE'] ?>"
                     			value="<?php echo $rowcourse['ID_COURSE'] ?>">Đăng kí</button>
                     	</td>
                     	</tr>
                     <?php
                     $stt++;
                     }
                 }
                 else
                 {
                   echo "<h4>Không có khóa học nào</h4>";
                 }
					 ?>
                 
					
				
			</tbody>
			
		</table>