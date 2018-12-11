<?php 
include('module/config.php');

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
if(mysqli_num_rows($result)>0)
{
	while ($row=mysqli_fetch_assoc($result))
	 {
	?>
     <li><a href=""><?php echo $row["NAME"] ?></a></li>
   <?php  
	}
 
}
else
echo "loi";
?>