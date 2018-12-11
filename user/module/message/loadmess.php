<?php 
session_start();
include('../config.php');
$idthread=$_GET['idthread'];
$sql="SELECT * FROM message m INNER JOIN thread_messager tm ON tm.ID_THREAD= m.ID_THREAD where tm.ID_THREAD='{$idthread}'";

$result = mysqli_query($conn,$sql);
$kq=1;
$sqlcheck="SELECT ua.ID_USER FROM user_profile up INNER JOIN user_account ua ON ua.ID_USER=up.ID_USER INNER JOIN thread_messager tm ON tm.SENDER_IDPROFILE =up.ID_PROFILE WHERE tm.ID_THREAD='{$idthread}'";
$kqcheck=mysqli_query($conn,$sqlcheck);
$rowcheck=mysqli_fetch_assoc($kqcheck);
if ($rowcheck["ID_USER"]!=$_SESSION['id_user']) {
	$kq=0;
}
if(mysqli_num_rows($result)>0)
{

?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../../../static/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../../../static/css/css.css">
<link rel="stylesheet" type="text/css" href="../../../static/css/messcss.css">
<div id="body_chat">
	
	<input type="text" id="kq" style="display: none" value="<?php echo $kq?>">

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
  <button type="button" class="btn-primary" id="btnsendmessage"><i class="material-icons" style="font-size:36px"></i></button>
</div>
</div>
</html>
<script src="../../../static/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$("#btnsendmessage").click(function(event) {
		var idthread=$("#idthread").val();
		var kq=$("#kq").val();
		var message =$("#txtmessage").val();
		if(kq==1)
		{
			$.get('../module/message/sendmessage.php',{id_thread:idthread,message:message,issender:1}, function(data) {
				alert("gửi với is sender 1");
			});
		}
		else
		{
			$.get('../module/message/sendmessage.php',{id_thread:idthread,message:message,issender:0}, function(data) {
				alert("gửi với is sender 0");
			});
		}
		
	});
</script>
