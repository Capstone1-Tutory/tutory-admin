<?php 
include('../module/config.php') ;
 $idtp=$_POST['idtinh'];
   ?>
   <option value="">---chọn quận-huyện---</option>}
   option
   <?php
    $sqlhuyen="SELECT maqh,name from devvn_quanhuyen where matp='{$idtp}'";
    $resulthuyen=mysqli_query($conn,$sqlhuyen);
    while ($rowhuyen=mysqli_fetch_assoc($resulthuyen)) {
     ?>
     <option value=<?php echo $rowhuyen['maqh'] ?>><?php echo $rowhuyen['name']; ?></option>
 <?php
    }
 ?>