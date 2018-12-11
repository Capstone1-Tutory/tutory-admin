
<?php
include ('module/config.php');
 $sql="SELECT up.NAME ,t.ID_TUTOR FROM user_profile up INNER join tutor t ON t.ID_PROFILE = up.ID_PROFILE";
 $result =mysqli_query($conn,$sql);
?>
<div class="col-sm-2 sidenav">
  <div class=well>
     <h4>Danh Sách Giảng Viên</h4> 
  </div>
<?php
 while($row = mysqli_fetch_assoc($result))
 {
  ?>
    <div class="well">
      <a href=""><?php echo $row['NAME'] ?></a>
        <hr>
        </div>

  <?php
 }

?>

</div>
</div>