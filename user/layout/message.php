     	
    <link rel="stylesheet" type="text/css" href="../../static/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../static/css/css.css">
	<link rel="stylesheet" type="text/css" href="../userstyle/cssindex.css">
    <link rel="stylesheet" type="text/css" href="../../static/css/messcss.css">

<?php 
include('../module/config.php');

$iduser =$_GET['id_user'];
$sql="SELECT
    tm.*,
    up.NAME AS NAME,
    up.URL_AVATAR AS URL_AVATAR
FROM
    thread_messager AS tm
INNER JOIN
    user_profile AS up
    ON 
     tm.RECEIVER_IDPROFILE = up.ID_PROFILE
WHERE
        tm.SENDER_IDPROFILE = '{$iduser}'

UNION 
SELECT
    tm.*,
    up.NAME AS NAME,
    up.URL_AVATAR AS URL_AVATAR
FROM
    thread_messager AS tm
INNER JOIN
    user_profile AS up
    ON 
     tm.SENDER_IDPROFILE = up.ID_PROFILE
WHERE
     tm.RECEIVER_IDPROFILE ='{$iduser}'
  ";
$result=mysqli_query($conn,$sql);  
?>

	<div class="container">
		 <nav class="navbar navbar-dark bg-primary">
     	 <a class="navbar-brand" id="logo" href="../index.php">TUTORY</a>
         </nav>
         <div class="container-fluid">

     
         	<div class="row content">
         		 <div class="col-md-3 sidenav">
         		 	 <h4>MESSAGER</h4>
         		 	 <hr>
         		<ul class="nav nav-pills nav-stacked">
         		 <?php
         		 if(mysqli_num_rows($result)>0)
                   {
	                while ($row=mysqli_fetch_assoc($result))
	               {
	               ?>
        	      <li><a href="#" id="<?php echo $row["ID_THREAD"]?>" onclick="thread_click(<?php echo $row["ID_THREAD"]?>)"><?php echo $row["NAME"] ?></a></li>
        	      <br>
        	      <br>
        	      <?php  
	              }
 
                  }
                else
                  echo "loi";
                 ?>
             </ul>
                 </div>
                 <div id="mymessage1" class="col-md-9">
                 </div>
         	</div>
         	
         </div>
       

        <div id="footer"> 
    	 Coppy right International School - ENERGY TEAM 2018
        </div> 
		
	</div>

<script src="../../static/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../../static/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	
	function thread_click(data)
	{
     $("#mymessage1").load("../module/message/loadmessage.php?idthread="+data);
	};
</script>