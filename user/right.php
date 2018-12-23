
<?php
include ('module/config.php');
 $sql="SELECT up.NAME ,t.ID_TUTOR ,up.URL_AVATAR FROM user_profile up INNER join tutor t ON t.ID_PROFILE = up.ID_PROFILE";
 $result =mysqli_query($conn,$sql);
?>
<style type="text/css" media="screen">
	.infor
	{
		height: 40px;
		position: relative;
		padding: 4px 0;
		line-height: 32px;
		display: block;
	}
	.anh
	{
		border-radius: 50%;
        box-shadow: inset 0 0 1px rgba(0, 0, 0, .2);
        content: '';
        display: inline-block;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
        
	}
	.ten
	{
		overflow: hidden;
        padding-left: 8px;
        text-overflow: ellipsis;
        white-space: nowrap;
	}
</style>
<div class="col-sm-2 sidenav">
  <div class="well">
     <h4>Danh Sách Giảng Viên</h4> 
  </div>
  <hr>
<?php
 while($row = mysqli_fetch_assoc($result))
 {
  ?>
   <div class="well">
   	<div class="infor">  
      	<img class="anh" src="../image/imageUSER/<?php if($row['URL_AVATAR']!="")echo $row['URL_AVATAR'];else echo "avatar.jpg";?>"alt="" width="40px" height="40px">
      	 <a class="ten" href="layout/viewprofile.php?idtutor=<?php echo $row["ID_TUTOR"] ?>" ><?php echo $row['NAME'] ?></a>  
     </div>
   </div>
   <br>
    

  <?php
 }

?>

</div>
</div>