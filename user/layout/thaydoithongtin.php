<?php 
include('../module/config.php') ;
   session_start();
  $iduser=$_SESSION['id_user'];
  $sql= "SELECT up.NAME,up.BIRTHDAY,up.SEX,up.EMAIL,up.PHONE, up.SO_NHA, xptt.name as XAA, qh.name as HUYEN,tp.name as TINH from user_profile up
    left join devvn_xaphuongthitran xptt ON up.ID_ADDRESS = xptt.xaid
    left join devvn_quanhuyen qh ON qh.maqh= xptt.maqh
    left join devvn_tinhthanhpho tp ON qh.matp = tp.matp 
    where up.ID_USER='{$iduser}'";
  $result = mysqli_query($conn,$sql);

  $row=mysqli_fetch_assoc($result);

 ?>	
 <div class="row content">
  <div class="col" style="width:30%">
   <p>Tên: </p>
  <input class="form-control" type="text" id="txtname" name="name" value="<?php echo $row["NAME"]; ?>">
  <p> Ngày sinh:  </p>
  <input class="form-control"  type="date" id="txtdate" name="birthday" value="<?php echo $row["BIRTHDAY"]; ?>">
  <p>Giới tính:</p>
  <select id="slsex" class="form-control col-sm-4" name="sex" >   
    <option value="Nam">Nam</option>
    <option value="Nữ">Nữ</option>     
   </select>
  </div>
  <div class="col" style=" width:70%">
  
      <p>Địa Chỉ</p>
      <input class="form-control"  type="text" id="txtsonha" value="<?php echo $row["SO_NHA"] ?>">
      <br>
      <div class="row" style="margin-left: 4px">
        <select class="form-control"  id="sltinhtp" name="sltinhtp">
      <option value="">--chọn tỉnh,thành phố---</option>
   <?php 
     $sqltinhtp= "SELECT matp,name from devvn_tinhthanhpho";
     $resulttinhtp=mysqli_query($conn,$sqltinhtp);
     while ( $rowtinhtp= mysqli_fetch_assoc($resulttinhtp)) 
     {
      ?>  
      <option value=<?php echo $rowtinhtp['matp']?>><?php echo $rowtinhtp['name'] ?></option>
      <?php
      }
    ?>
    
   </select>
   <select class="form-control "  id="slhuyen" name="slhuyen">
    <option value="">--chưa chọn tỉnh,thành phố--</option>   
   </select>
   <select class="form-control"  name="slxa" id="slxa" name="idxa">
     <option value="">--chưa chọn quận,huyện--</option>
   </select>
      </div>
      
  <p>Email:</p> 
  <input class="form-control"  type="email" id="txtemail" name="email" value=" <?php echo $row['EMAIL'] ?>" required> 
  <p>Số điện thoại:</p>
  <input class="form-control" type="text" id="txtphone" name="phone"value=" <?php echo $row['PHONE'] ?>">
     <br>
     <p id="thongbao" style="color:red"></p>
     <br>
    
  </div>
   
 </div>
	<button type="button" id="btnluuthaydoi" class="btn btn-success"> lưu thay đổi</button>
    <hr> <hr>
 <script src="../../static/vendor/jquery/jquery.min.js"></script>

 <script type="text/javascript">
  $(document).ready(function() {
    $("#btnluuthaydoi").click(function(event) {
     var name= $("#txtname").val();
     var birthday= $("#txtdate").val();
     var sex= $("#slsex").val();
     var email= $("#txtemail").val();
     var sdt= $("#txtphone").val();
     var idxa= $("#slxa").val();
     var sonha= $("#txtsonha").val();
     if(name==""||email==""||sdt==""|| idxa=="")
     {
      $("#thongbao").html("Vui lòng nhập đủ thông tin");
     }
     else
     {
       $.get('../module/profile/suathongtin.php',{name:name, birthday:birthday,sex:sex,email:email,phone:sdt,idxa:idxa,sonha:sonha}, function(data) {
        if(data=="")
        {
           $("#thongbao").html(data);
        }
        else
         { 
          alert("Thay đổi thông tin thành công");
          $("#thongtin").load("xemthongtin.php");
         }

       });
     }

   });
 
  });
   
 </script>
 <script type="text/javascript">
     $("#sltinhtp").change(function(event) {
        var idtinh = $("#sltinhtp").val();
        $.post('huyen.php', {idtinh:idtinh}, function(data) {
          $("#slhuyen").html(data);   
        });
      });
       $("#slhuyen").change(function(event) {
       var idhuyen= $("#slhuyen").val();
       $.post('xa.php', {idhuyen:idhuyen}, function(data) {
         $("#slxa").html(data);
       });
     });
 </script>
 