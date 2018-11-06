<?php 
   
     session_start();
    
 	 unset($_SESSION["login_username"]);
 	 header("location:../../index.php");
?>

