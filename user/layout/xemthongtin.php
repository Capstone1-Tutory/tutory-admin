<link rel="stylesheet" type="text/css" href="../userstyle/imageavatar.css">

<?php 
  include('../module/config.php') ;
  session_start();
  $iduser=$_SESSION['id_user'];
  $sql= "SELECT up.NAME,up.BIRTHDAY,up.SEX,up.EMAIL,up.PHONE,up.URL_AVATAR, up.SO_NHA, xptt.name as XAA, qh.name as HUYEN,tp.name as TINH from user_profile up
    left join devvn_xaphuongthitran xptt ON up.ID_ADDRESS = xptt.xaid
    left join devvn_quanhuyen qh ON qh.maqh= xptt.maqh
    left join devvn_tinhthanhpho tp ON qh.matp = tp.matp 
    where up.ID_USER='{$iduser}'";
  $result = mysqli_query($conn,$sql);

  $row=mysqli_fetch_assoc($result);

 ?>
 <form action="../module/upload/upload.php" method="post" enctype="multipart/form-data">
 <div class="row content">
  
   <div class="col-sm-3">
      <div class="avatar-upload">
        <div class="avatar-edit">
        
            <input type='file' id="imageUpload" name="file"accept=".png, .jpg, .jpeg" />
            <label for="imageUpload"></label>
        </div>
        <div class="avatar-preview">
            <div id="imagePreview" style="background-image: url('../../image/imageUSER/<?php echo $row["URL_AVATAR"] ?>');">
            </div>
        </div>
        <button type="submit" id="btnchangeavata" name="btnchangeavata" class="avatar-btn btn btn-primary">Lưu ảnh</button>
      
     </div>
     </div>
    
  <div class="col-sm-8" style="margin-left: 50px">
    <p>Tên: <?php echo $row["NAME"]; ?></p>
    <p> Ngày sinh:  <?php echo $row['BIRTHDAY']; ?></p>
  <p>Giới tính:  <?php echo  $row['SEX'] ?></p>  
  <p>Địa Chỉ: <?php echo $row['SO_NHA'].", ".$row['XAA']." , ".$row["HUYEN"]." , ".$row['TINH']; ?> </p>
  <p>Email: <?php echo $row['EMAIL'] ?></p>  
  <p>Số điện thoại: <?php echo $row['PHONE'] ?></p>
     
    <button type="button" id="btnthaydoi" class="btn btn-primary"> Thay đổi thông tin</button>
   
  </div>
 </div>
  <hr> <hr>
</form>
 	
	
 <script src="../../static/vendor/jquery/jquery.min.js"></script>

 <script type="text/javascript">
 	
 	$("#btnthaydoi").click(function(event) {
 		$("#thongtin").load("thaydoithongtin.php");
 	});
  function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});

 </script>


