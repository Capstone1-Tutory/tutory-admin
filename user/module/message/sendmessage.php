<?php 
include('../config.php');
$idthread= $_GET['id_thread'];
$message =$_GET['message'];
$issender=$_GET['issender'];

$date= date('Y-m-d H:i:s');
$sql="INSERT INTO message (ID_THREAD,MESSAGECOL,IS_SENDER,READER,TIME_READ) values ('{$idthread}','{$message}','{$issender}',0,'{$date}')";

$result=mysqli_query($conn,$sql);
if(!$result)
{
	echo "loi";
}
else
echo "ok";

 ?>