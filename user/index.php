<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="UTF-8">
	<title>Tutor</title>
	<link rel="stylesheet" type="text/css" href="../static/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../static/css/css.css">
	<link rel="stylesheet" type="text/css" href="userstyle/cssindex.css">
</head>
<body>
	<?php
	include('header.php');
	include('menutop.php');	
	include('left.php');
	?>
	<div class="col-sm-8 "> 
		 <?php 


		   
            if(isset($_GET['page']))
            {
            	$page=$_GET['page'];
            	include('layout/'.$page.'.php');
            }

            else
            	if(isset($_GET['category']))
            	{
            		$page="bangtintheoloai";
            	   include('layout/'.$page.'.php');
            	}
            	else
                 {
            	 $page="trangchu";
		         include('layout/'.$page.'.php');
                 }


		 ?>
	</div>
	<?php
	include('right.php');
	include('footer.php');
	?>
</body>
<script src="../static/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../static/vendor/jquery/jquery.min.js"></script>

</html>