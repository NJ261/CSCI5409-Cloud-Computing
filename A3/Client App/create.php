
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create a new Student</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<h2>CSCI 5409: Assignment 3</h2>
<div style="margin-top: 15px;">
    <a href="create.php">Create New Student</a>
    <br>
    <a href="update.php">Update existing student</a>
    <br>
    <a href="read.php">Read student's details</a>
</div>

<p></p>
<div id="enter_details">Enter the details</div>
    <p></p>
    <form action="" method="post" enctype="multipart/form-data">
        <label for ="student_id"> Student ID </label>
        <input type="text" name="student_id" id="student_id" placeholder="Enter your student ID" pattern="[0-9]{3}" required>
        <label for ="student_id"> (Max 3 digits are allowed) </label>

        <p></p>
        <label for ="student_name"> Student Name </label>
        <input type="text" name="student_name" id="student_name" placeholder="Enter your name" pattern="[A-Za-z]{6}" required>
        <label for ="student_id"> (6 alphabets are allowed i.e. jadeja) </label>

        <p></p>
        <label for ="student_name"> Student Image </label>
        <input type="file" name="files" id="files">

        <p></p>
        <input type="submit" name="submit" value="Submit">
    </form>
</div>

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
        if (!in_array($filetype,$fileExtensions)){
              echo "<script>alert('Invalid image format, Allowed formats are jpg, png, bmp. please try again.');
              location.href='create.php';</script>";
        }
        else{
          // size check, limit is 3MB
          if ($size > 3000000){
                echo "<script>alert('Opps large file size, size limit is 3MB. please try again.');
                location.href='create.php';</script>";
          }

          else{
                try {
                  $student_id = $_POST["student_id"];
                  $student_name = $_POST["student_name"];
                  $url = 'https://a3-csci5409.herokuapp.com/Student/';

                  // curl initialization
                  $ch = curl_init($url);

                  // preparing the array
                  $jsonData = array('student_id' => $student_id, 'student_name' => $student_name, 'image_id' => $name[0]);

                  // encode the data in JSON format
                  $jsonDataEncoded = json_encode($jsonData);

                  // 1 for post request
                  curl_setopt($ch, CURLOPT_POST, 1);

                  // encoded JSON data attached with curl post fields
                  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

                  //declaring application type as JSON.
                  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  //Execute the request
                  $result = curl_exec($ch);

                  curl_close($ch);

                  $obj = json_decode($result);

                  if (strlen($obj->student_id) == 3){
                    // uploading to the cloudinary
                    \Cloudinary\Uploader::upload($filename, array("public_id" => $name[0]));
                    echo "<div style='color:blue; font-weight: bolder;'>Uploading Done!!</div>";
                  }
                  else{
                    echo "<div style='color:red; font-weight: bolder;'>Student ID already exists,
                                      please try again with other number!!</div>";
                  }
                }

                catch ( Exception $e) {
                    echo "<div style='color:blue; font-weight: bolder;'>Something went wrong, Please try again!</div>";}
          }
        }
    }
    else {
        echo "<script>alert('Empty or invalid file or wrong file size (Max Size is 3MB). Please try again with image file.');
        location.href='create.php';</script>";}
}

/* References:
https://stackoverflow.com/questions/21271140/curl-and-php-how-can-i-pass-a-json-through-curl-by-put-post-get
http://thisinterestsme.com/sending-json-via-post-php/
https://stackoverflow.com/questions/29373887/django-db-utils-integrityerror-unique-constraint-failed-rango-category-new-sl
https://stackoverflow.com/questions/17865544/read-json-data-response-using-php
*/
?>

<footer style="margin-top: 20px;">
  <div>Developed by:</div>
  <div>Mr. Niravsinh Jadeja | B00789139 | <a href="mailto:nirav.jadeja@dal.ca">nirav.jadeja@dal.ca</a></div>
</footer>

</body>
</html>
