<?php

require_once "vendor/cloudinary/src/Cloudinary.php";
require_once "vendor/cloudinary/src/Uploader.php";
require_once "vendor/cloudinary/src/Api.php";
require_once "vendor/cloudinary/src/Error.php";

// config file
require_once 'config.php';

// allowed extension array
$fileExtensions = ['image/jpeg','image/jpg','image/png', 'image/bmp'];

if (isset($_POST["submit"])) {

    if ($_FILES['files']['size'] > 0) {
        $filename = $_FILES["files"]["tmp_name"];
        $name = $_FILES["files"]["name"];
        $filetype = $_FILES["files"]["type"];
        $size = $_FILES["files"]["size"];

        $name = explode(".", $name);

        // file extension check, allowed are jpeg, jpg, png, bmp
        if (!in_array($filetype,$fileExtensions)) {
              echo "<script>alert('Invalid image format, Allowed formats are jpg, png, bmp. please try again.');
              location.href='upload.php';</script>";
        }

        // size check, limit is 3MB
        if ($_FILES['files']['size'] > 3000000){
              echo "<script>alert('Opps large file size, size limit is 3MB. please try again.');
              location.href='upload.php';</script>";
        }

        else{
              try {
                  // uploading to the cloud
                  \Cloudinary\Uploader::upload($filename, array("public_id" => $name[0]));
                  echo "<div style='color:blue; font-weight: bolder;'>Uploading Done!!</div>";}

              catch ( Exception $e) {
                  echo "<div style='color:blue; font-weight: bolder;'>Something went wrong, Please try again!</div>";}
        }
    }
    else {
        echo "<script>alert('Empty or invalid file. Please try again with image file.');
        location.href='upload.php';</script>";}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload a new photo</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<h2>CSCI 5409: Assignment 2</h2>
<div style="margin-top: 15px;">
    <a href="browse.php">List Photos</a>
    <br>
    <a href="upload.php">Upload a new photo</a>
</div>

<div style="margin-top: 30px;">
<div id="select_photo">Select your photo :</div>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="files">
        <p></p>
        <input type="submit" name="submit" value="Upload your photo">
    </form>
</div>

<footer style="margin-top: 20px;">
  <div>Developed by:</div>
  <div>Mr. Niravsinh Jadeja | B00789139 | <a href="mailto:nirav.jadeja@dal.ca">nirav.jadeja@dal.ca</a></div>
</footer>

</body>
</html>
