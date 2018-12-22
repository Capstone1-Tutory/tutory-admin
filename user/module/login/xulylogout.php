<?php 
     include('../config.php') ;
     session_start();
     $iduser=$_SESSION["id_user"];
     $sqlonline= "update user_profile SET STATUS=0 where ID_USER='{$iduser}'";
     $resultonline=mysqli_query($conn,$sqlonline);
 	  session_unset();
 	  header("location:../../index.php");
 	
?>

