<?php 
include('../module/config.php') ;
 $idqh=$_POST['idhuyen'];
   ?>
   <option value="">---chọn xã-phường---</option>}
   option
   <?php
    $sqlxa="SELECT xaid,name from devvn_xaphuongthitran where maqh='{$idqh}'";
    $resulxa=mysqli_query($conn,$sqlxa);
    while ($rowhuyen=mysqli_fetch_assoc($resulxa)) {
     ?>
     <option value=<?php echo $rowhuyen['xaid'] ?>><?php echo $rowhuyen['name']; ?></option>
 <?php
    }
 ?>