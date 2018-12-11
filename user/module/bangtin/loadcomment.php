s <?php 
   include'../config.php';
   $idnews=$_GET['idnews'];
   $sql="SELECT up.NAME, r.REPORTER_DESCRIPTION FROM reporter r INNER JOIN reporter_of_news rn ON rn.PARTY_ROLE_TYPE_ID_FROM= r.PARTY_ID INNER JOIN news n ON n.NEWS_ID = rn.THING_ROLE_TYPE_ID_TO INNER JOIN user_profile up ON up.ID_USER= r.ID_USER where n.NEWS_ID='{$idnews}'";

    $result =mysqli_query($conn,$sql);
    while ($row= mysqli_fetch_assoc($result))
    {
 ?>
     <div class="row">
     	<b style="padding-left: 100px;" class="row"> <?php echo $row['NAME']?>:</b> <p style="margin-left: 20px"><?php echo $row['REPORTER_DESCRIPTION']?></P>
     	
     </div>

 <?php	
    }
 ?>