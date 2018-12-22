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
  include('sildeshow.php');
	include('menutop2.php');	
	include('left.php');
	?>
	<div class="col-sm-8 " id="rowcontent"> 
		 <?php 

            	if(isset($_GET['category']))
            	{
            		$page="bangtintheoloai";
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
<script type="text/javascript">
	$('#rowcontent').load('layout/trangchu.php');
  $("#linkgioithieu").click(function(event) {
  	$("#rowcontent").load("layout/gioithieu.php");
  });
  $("#linktrangchu").click(function(event) {
  	$("#rowcontent").load("layout/trangchu.php");
  });
  $("#linktintuc").click(function(event) {
  	$("#rowcontent").load("layout/tintucsukien.php");
  });
  $("#linkkhoahoc").click(function(event) {
  	$("#rowcontent").load("layout/khoahoc.php");
  });
  $("#linklienhe").click(function(event) {
  	$("#rowcontent").load("layout/lienhe.php");
  });
  function loadtintheoloai(idmajor){
  	 $.get('layout/bangtintheoloai.php',{category:idmajor}, function(data) {
  	 	$("#rowcontent").html(data);
  	 });
  }
</script>
<script type="text/javascript">
	$("#btnsearch").click(function(event) {
  	var majorname= $("#txtsearch").val();
    if(majorname=="")
    {
      alert(" vui lòng nhập môn học cần tìm");

    }
    else
    {
  	$.get('layout/search.php',{majorname:majorname}, function(data) {
       $("#rowcontent").html(data);
  	});
     }
  });
  
</script>
</html>