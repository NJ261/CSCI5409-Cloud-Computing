<?php
require_once "vendor/cloudinary/src/Cloudinary.php";
require_once "vendor/cloudinary/src/Api.php";
require_once "vendor/cloudinary/src/Api/Response.php";

// config file
require_once 'config.php';

$api  = new \Cloudinary\Api();

$deleting_photo = $api->delete_resources(array($_GET["public_id"]));
header("location:browse.php");
?>
