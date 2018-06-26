<?php
require_once "vendor/cloudinary/src/Cloudinary.php";
require_once "vendor/cloudinary/src/Api.php";
require_once "vendor/cloudinary/src/Api/Response.php";

// config file
require_once 'config.php';

// cloudinary API
$api  = new \Cloudinary\Api();

// deleting the photo
$deleting_photo = $api->delete_resources(array($_GET["public_id"]));

// deleting the info on web service
// DELETE request - REST
$student_id = $_GET["student_id"];
$url = 'https://a3-csci5409.herokuapp.com/Student/'.$student_id.'/';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($ch, CURLOPT_POSTFIELDS);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response  = curl_exec($ch);
curl_close($ch);

// redirecting to read file
header("location:read.php");

?>
