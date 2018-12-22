<?php
 include('module/config.php');
?>
<div class="container-fluid text-center">  
  <div class="row content">
    <div class="col-sm-2 sidenav list-group">
        <h4>Danh Sách Môn Học</h4>
    	<?php
         $sql="SELECT * FROM news_category_type";
         $result= mysqli_query($conn,$sql);
         if(mysqli_num_rows($result)>0)
         {
         	while ($row=mysqli_fetch_assoc($result)) 
         	{
         ?>
         <p><a class="list-group-item" style="background-color:#EEEEEE " href="#" onclick="loadtintheoloai(<?php echo $row["NEWS_CATEGORY_TYPE_ID"]?>)"><?php echo $row["NEWS_CATEGORY_TYPE_NAME"]?></a></p>
        <?php	         	
            }
         }
         else{
         	echo "loi";
         }
         mysqli_close($conn);

    	?>
    </div>