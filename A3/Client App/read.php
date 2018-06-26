<?php
require_once "vendor/cloudinary/src/Cloudinary.php";
require_once "vendor/cloudinary/src/Api.php";
require_once "vendor/cloudinary/src/Api/Response.php";

// config file
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Read student's details</title>
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
<div id="enter_details">Read Student Details</div>
    <p></p>
    <form action="" method="post" enctype="multipart/form-data">
        <label for ="student_id"> Student ID </label>
        <input type="text" name="student_id" id="student_id" placeholder="Enter your student ID" pattern="[0-9]{3}" required>
        <label for ="student_id"> (Max 3 digits are allowed) </label>

        <p></p>
        <input type="submit" name="submit" value="Submit">
    </form>
</div>

<?php
// when submit is pressed
if (isset($_POST["submit"])) {

  // for image fetching from cloudinary
  $rows   = 0;
  $api    = new \Cloudinary\Api();
  $result = $api->resources();
  $rows   = count($result["resources"]);
  $student_id = $_POST["student_id"];

  // GET request - REST
  $url = 'https://a3-csci5409.herokuapp.com/Student/'.$student_id.'/';

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL, $url);
  $result = curl_exec($ch);
  curl_close($ch);

  $obj = json_decode($result);

  // checking rows for response
  if ( strlen($obj->student_id) == 3 ) {
      echo "<div style='margin-top: 30px;'>";
      echo "<table> <tr style='font-weight: bolder;'> <td width='10%'>Sr. No.</td>
                    <td width='20%'>Student ID</td>
                    <td width='20%'>Student Name</td> <td width='40%'>Preview</td><td width='10%'>Edit</td></tr>";
      $element=1;
      echo "<tr><td>".$element."</td>";   // Sr. no
      echo "<td>".$obj->student_id."</td>";   // Student ID
      echo "<td>".$obj->student_name."</td>";    // Student Name
      echo "<td>";  echo cl_image_tag($obj->image_id, array("transformation" => array("width" => 200, "crop" => "pad")));
                    echo "</td>";     // Image Preview
      echo "<td><a href=delete.php?public_id=".$obj->image_id.
                                  "&student_id=".$student_id."& alt='Delete this photo'>Delete</td></tr>";     // Delete details option
      echo "</tr></table></div>";}

  else {
      echo "<div style='color:red; font-weight: bolder;'>Record not found, please try again. </div>";}

}
?>

<footer style="margin-top: 20px;">
  <div>Developed by:</div>
  <div>Mr. Niravsinh Jadeja | B00789139 | <a href="mailto:nirav.jadeja@dal.ca">nirav.jadeja@dal.ca</a></div>
</footer>

</body>
</html>
