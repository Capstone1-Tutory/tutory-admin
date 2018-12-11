<?php 
$idthread= $_GET['idthread'];
$message =$_GET['message'];
$idprofile=$_GET['idprofile'];
function callAPI($method, $url, $data){
   $curl = curl_init();

   switch ($method){
      case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
         break;
      default:
         if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
   }

   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'APIKEY: 111111111111111111111',
      'Content-Type: application/json',
   ));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   curl_close($curl);
   return $result;
}

function sendPOSTSMS($idprofile,$idThread,$message){

$data_array =  array( 
	"idProfile"=>$idprofile,
    "idThread"=>$idThread,
    "message"=> $message);
$make_call = callAPI('POST', 'https://tutory-api-develop.herokuapp.com/api/v1/thread/message/sending', json_encode($data_array));
$response = json_decode($make_call, true);
print_r($response);
}

sendPOSTSMS($idprofile,$idthread,$message);
 ?>