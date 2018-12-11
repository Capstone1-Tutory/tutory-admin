<?php include('module/config.php');
$idsender=$_GET['id_sender'];
$idreceiver=$_GET['id_receiver'];

$sql="SELECT * FROM message m INNER JOIN thread_messager tm ON tm.ID_THREAD= m.ID_THREAD where tm.SENDER_IDPROFILE='{$idsender}' AND tm.RECEIVER_IDPROFILE='{$idreceiver}'";

$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0)
{

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
  <link rel="stylesheet" type="text/css" href="../static/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../static/css/css.css">
  <link rel="stylesheet" type="text/css" href="../static/css/chatcss.css">

</head>
<body>
  <h2>Chat Messages</h2>

 

  <?php 

  while ($row=mysqli_fetch_assoc($result)) {
    ?>

    <label id="idthread" value="<?php echo $row["ID_THREAD"] ?>" style="display: none"><?php echo $row["ID_THREAD"] ?></label>
    <?php
        if($row["IS_SENDER"]==1)
        {
         ?>
         <div class="container">
         <img src="/w3images/bandmember.jpg" alt="Avatar" style="width:100%;">
        <p><?php ?></p>
        <span class="time-right">11:00</span>
        </div>
        <?php
        }
        else
        {
        ?>
          <div class="container darker">
          <img src="/w3images/avatar_g2.jpg" alt="Avatar" class="right" style="width:100%;">
           <p><?php echo $row["MESSAGECOL"]  ?></p>
          <span class="time-left">11:01</span>
         </div>

        <?php
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
</body>
</html>
<script src="../static/vendor/jquery/jquery.min.js"></script>
