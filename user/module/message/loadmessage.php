<?php 
session_start();
include('../config.php');
$idthread=$_GET['idthread'];
$sql="SELECT * FROM message m INNER JOIN thread_messager tm ON tm.ID_THREAD= m.ID_THREAD where tm.ID_THREAD='{$idthread}'";

$result = mysqli_query($conn,$sql);
$kq=1;
$idprofile="";
$sqlcheck="SELECT ua.ID_USER,up.ID_PROFILE FROM user_profile up INNER JOIN user_account ua ON ua.ID_USER=up.ID_USER INNER JOIN thread_messager tm ON tm.SENDER_IDPROFILE =up.ID_PROFILE WHERE tm.ID_THREAD='{$idthread}'";
$kqcheck=mysqli_query($conn,$sqlcheck);
$rowcheck=mysqli_fetch_assoc($kqcheck);
if ($rowcheck["ID_USER"]!=$_SESSION['id_user']) {
	$kq=0;
}
$iduser=$_SESSION['id_user'];
$getprofile= mysqli_fetch_assoc(mysqli_query($conn,"SELECT ID_PROFILE FROM user_profile where ID_USER='{$iduser}'"));
 $idprofile=$getprofile["ID_PROFILE"];
if(mysqli_num_rows($result)>0)
{

?> 
<link rel="stylesheet" type="text/css" href="../../../static/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../../../static/css/css.css">
<link rel="stylesheet" type="text/css" href="../../../static/css/messcss.css">
<div id="body_chat">
	
	<input type="text" id="kq" style="display: none" value="<?php echo $kq?>">
  <input type="text" id="idprofile" style="display: none" value="<?php echo $idprofile?>">

<?php 

  while ($row=mysqli_fetch_assoc($result)) 
  {
    ?>
     <input type="text" id="idthread"value="<?php echo $row["ID_THREAD"] ?>" style="display: none" >
   
    <?php
     if($kq==1)
     {
        if($row["IS_SENDER"]==1)
        {
         ?>
        <div class="noidung send">
        <p><?php  echo $row["MESSAGECOL"]  ?></p>
        <span class="time-right">11:00</span>
        
        </div>
        <?php
        }
        else
        {
        ?>
          <div class="noidung darker">
           <p><?php echo $row["MESSAGECOL"]  ?></p>
          <span class="time-left">11:01</span>

         </div>

        <?php
        }
    }
    else
    {
       if($row["IS_SENDER"]==0)
        {
         ?>
        <div class="noidung send">
        <p><?php  echo $row["MESSAGECOL"]  ?></p>
        <span class="time-right">11:00</span>
        
        </div>
        <?php
        }
        else
        {
        ?>
          <div class="noidung darker">
           <p><?php echo $row["MESSAGECOL"]  ?></p>
          <span class="time-left">11:01</span>

         </div>
   <?php
    }
  }
}
}
else
{
  echo "loi";
}
 ?>

<div class="input-group">
  <input type="text" class="form-control" id="txtmessage" placeholder="........." >
  <button type="button" class="btn-primary" id="btnsendmessage">Gửi</button>
</div>
</div>
</html>
<script src="../../../static/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$("#btnsendmessage").click(function(event) {
		var idthread=$("#idthread").val();
		var idprofile=$("#idprofile").val();
		var message =$("#txtmessage").val();
			$.get('../module/message/apimess.php',{idthread:idthread,message:message,idprofile:idprofile}, function(data) {
        alert(data);
      });
		
	});
</script>
