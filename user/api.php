<?php 
 $url='https://tutory-api-develop.herokuapp.com/api/v1/thread/message/sending';
 $data = json_decode('POST',file_get_contents($url),true);
 print_r($data);
 //echo $data['posts'][0]  
?>

