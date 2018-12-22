<?php 
 include('../module/config.php');
 $idtutor = $_GET['idtutor'];
 $sql= "SELECT up.NAME,up.BIRTHDAY,up.SEX,up.EMAIL,up.PHONE,up.URL_AVATAR, up.SO_NHA, xptt.name as XAA, qh.name as HUYEN,tp.name as TINH from tutor t 
    inner join user_profile up on t.ID_PROFILE = up.ID_PROFILE
    left join devvn_xaphuongthitran xptt ON up.ID_ADDRESS = xptt.xaid
    left join devvn_quanhuyen qh ON qh.maqh= xptt.maqh
    left join devvn_tinhthanhpho tp ON qh.matp = tp.matp 
    where t.ID_TUTOR='{$idtutor}'";
 $result= mysqli_query($conn,$sql);
 $row= mysqli_fetch_assoc($result);
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>
		thông tin cá nhân
	</title>
	<meta charset="UTF-8">
	<title>Tutor</title>
  <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.5.0/css/all.css' integrity='sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU' crossorigin='anonymous'>
	<link rel="stylesheet" type="text/css" href="../../static/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../userstyle/cssindex.css">
  <link rel="stylesheet" type="text/css" href="../userstyle/imageavatar.css">
</head>
<body>
   <div class="container">
   <nav class="navbar navbar-dark bg-primary">
   	 <a class="navbar-brand" id="logo" href="../index.php">TUTORY</a>
   </nav>
  	<div class="row content">
     <div class="col-sm-2">
     	
     </div>
   <div class="col-sm-3">
      <div class="avatar-upload">
        <div class="avatar-edit">
        
           
            <label for="imageUpload"></label>
        </div>
        <div class="avatar-preview">
            <div id="imagePreview" style="background-image: url('../../image/imageUSER/<?php echo $row["URL_AVATAR"] ?>');">
            </div>
        </div>
       
      
     </div>
     </div>
    
  <div class="col-sm-5" style="margin-left: 50px">
    <p>Tên: <?php echo $row["NAME"]; ?></p>
    <p> Ngày sinh:  <?php echo $row['BIRTHDAY']; ?></p>
  <p>Giới tính:  <?php echo  $row['SEX'] ?></p>  
  <p>Địa Chỉ: <?php echo $row['SO_NHA'].", ".$row['XAA']." , ".$row["HUYEN"]." , ".$row['TINH']; ?> </p>
  <p>Email: <?php echo $row['EMAIL'] ?></p>  
  <p>Số điện thoại: <?php echo $row['PHONE'] ?></p>
   
  </div>
  <hr> <hr>
  </div>
     <div id="footer"> 
    	Coppy right International School - ENERGY TEAM 2018
    </div>
    </div>
</body>
</html>
 