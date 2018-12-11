
<?php 
session_start() ;
$iduser=$_SESSION['id_user'];
include('../module/config.php');
$sql="SELECT ID_TUTOR FROM tutor
inner join user_profile on tutor.ID_PROFILE = user_profile.ID_PROFILE
where user_profile.ID_USER='{$iduser}'";
$result= mysqli_query($conn,$sql);
$row= mysqli_num_rows($result);
$istutor=0;
if($row>0)
{
  $istutor=1;
} 

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
</head>
<body>
   <div class="container">
   <nav class="navbar navbar-dark bg-primary">
   	 <a class="navbar-brand" id="logo" href="../index.php">TUTORY</a>
   </nav>
   <div class="container-fluid">
   	<div class="row content">
   	<div class="col-sm-3 sidebarprofile">
      
   		<div class="list-group"> 
        <input type="text" id="txtistutor" value="<?php echo $istutor ?>" style="display: none">
   			<a class="list-group-item" id="xemthongtin" href="#"><i class="fas fa-user-circle" style="font-size:20px; margin-right:10px"></i>Thông tin cá nhân</a>
   			<a class="list-group-item" id="khoahoc" href="#"><i class="fas fa-chalkboard-teacher" style="font-size:20px; margin-right:10px"></i>Xem khóa học</a>
   			<a class="list-group-item" id="lichcanhan" href="#"><i class="fas fa-calendar-alt" style="font-size:20px; margin-right:10px"></i>Lịch cá nhân</a>
   		</div>
   		
   	</div>
    <div class="col-sm-8" style="padding-top: 50px">
    	<div id="thongtin">
    		
    	</div>
   	 
   </div>
   </div>
   </div>
   
   
   	<div id="footer"> 
    	Coppy right International School - ENERGY TEAM 2018
    </div> 
   </div>
</body>
<script src="../../static/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../../static/vendor/jquery/jquery.min.js"></script>
</html>
<script type="text/javascript">
  $("#thongtin").load("xemthongtin.php");
	$("#xemthongtin").click(function(event) {
		$("#thongtin").load("xemthongtin.php");
	});
	$("#khoahoc").click(function(event) {
    {
      var istutor= $("#txtistutor").val();
      if(istutor==1)
	      {
          $("#thongtin").load("xemkhoahoc.php");
         }
         else
         {
          $("#thongtin").load("xemkhoahocstudent.php");
         }

    }
	});
	$("#lichcanhan").click(function(event) {
		$("#thongtin").load("lichcanhan.php");
	});
  
</script>