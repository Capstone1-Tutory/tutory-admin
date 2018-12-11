 <option value="">--chọn gia sư--</option>}
 option
<?php 
 include("../module/config.php");
 $idmajor= $_GET['idmajor'];
 $sql="SELECT tutor.ID_TUTOR, user_profile.NAME from user_profile 
inner join tutor ON tutor.ID_PROFILE= user_profile.ID_PROFILE
inner join tutor_rela_major ON tutor_rela_major.ID_TUTOR = tutor.ID_TUTOR
where tutor_rela_major.ID_MAJOR='{$idmajor}'";
$result= mysqli_query($conn,$sql);
while ($row= mysqli_fetch_assoc($result)) {
	?>

	<option value="<?php echo $row["ID_TUTOR"] ?>"><?php echo $row["NAME"] ?></option>}
	<?php
	
}
 ?>