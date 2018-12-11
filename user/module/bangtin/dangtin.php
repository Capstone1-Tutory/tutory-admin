<?php 
   session_start();
  include '../config.php';
  $taitel= $_GET['taitel'];
  $detail=$_GET['detail'];
  $type=$_GET['type'];
  $date= $_GET['date'];
  $iduser=$_SESSION['id_user'];
  $sqlinsertnews= "INSERT INTO `news`(`NEWS_TITLE`, `DETAILS`, `COVER_NEWS`, `NEWS_IMAGE`) values ('{$taitel}','{$detail}','nothing','nothing')";

  $result=mysqli_query($conn,$sqlinsertnews);
  if($result)
  {
  	$sqlinsertype= "INSERT INTO `news_categories_of_new`(`NEWS_ID`, `NEWS_CATEGORY_TYPE_ID`, `NEWS_CATEGORIES_OF_NEWS_DESCRIPTION`) values ((SELECT max(NEWS_ID) as id FROM news),'{$type}','nothing')";
  	if(mysqli_query($conn,$sqlinsertype))
  	{
  		$sqlinserteditor = "INSERT INTO `editor`(`ID_USER`) values ('{$iduser}')";

  		if(mysqli_query($conn,$sqlinserteditor))
  		{
  			$sqlinserteditorofnews= "INSERT INTO `editor_of_news`(`PARTY_ROLE_TYPE_ID_FROM`, `THING_ROLE_TYPE_ID_TO`, `FROM_DATE`) VALUES	((SELECT max(PARTY_ID) FROM editor),(SELECT max(NEWS_ID) as id FROM news),'{$date}')";
  			if(mysqli_query($conn,$sqlinserteditorofnews))
  			{
  				echo "đăng tin thành công";
  			}
  			else
  			{
  				echo "lỗi editor of news";
  			}
  		}
  		else 
  			echo "lỗi editor";
  	}
  	else
  		echo "loi news type";

  }
  else
  	echo "lỗi news";
 ?>