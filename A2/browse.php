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
    <title>Browse your photos</title>
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

<?php
$rows   = 0;
$api    = new \Cloudinary\Api();
$result = $api->resources();
$rows   = count($result["resources"]);

// checking rows for response
if ( $rows > 0 ) {
    echo "<div style='margin-top: 30px;'>";
    echo "<table> <tr style='font-weight: bolder;'> <td width='10%'>Sr. No.</td>
                  <td width='20%'>Name</td> <td width='40%'>Preview</td><td width='10%'>Edit</td></tr>";
    $element=1;
    foreach ( $result["resources"] as $row) {
        echo "<tr><td>".$element."</td>";   // Sr. no
        echo "<td><a href=".$row["url"].">".$row["public_id"]."</td>";    // hyperlinked name of the stored file
        echo "<td>";  echo cl_image_tag($row["public_id"], array("transformation" => array("width" => 100, "crop" => "pad")));
                      echo "</td>";     // preview of the image
        echo "<td><a href=delete.php?public_id=".$row["public_id"].
              "& alt='Delete this photo'>Delete</td></tr>";     // delete option
        $element++;}
    echo "</tr></table></div>";}

else {
    echo "<div style='color:red; font-weight: bolder;'>Empty directory, please upload few photos first. </div>";}

?>

<footer style="margin-top: 20px;">
  <div>Developed by:</div>
  <div>Mr. Niravsinh Jadeja | B00789139 | <a href="mailto:nirav.jadeja@dal.ca">nirav.jadeja@dal.ca</a></div>
</footer>

</body>
</html>
