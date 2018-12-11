<?php 
include('../config.php');
session_start();

$name = $_GET['name'];
$birthday=$_GET['birthday'];
$sex= $_GET['sex'];
$email=$_GET['email'];
$sdt=$_GET['phone'];
$id= $_SESSION['id_user'];
$idxa=$_GET['idxa'];
$sonha=$_GET['sonha'];

$sql="UPDATE user_profile SET NAME='{$name}',BIRTHDAY='{$birthday}',SEX='{$sex}',ID_ADDRESS='{$idxa}',SO_NHA='{$sonha}',PHONE='{$sdt}',EMAIL='{$email}' WHERE ID_USER='{$id}'";

	$result=mysqli_query($conn,$sql);
	
if(!$result)
{
	echo "có lỗi!! vui lòng thử lại";
}

 ?>


