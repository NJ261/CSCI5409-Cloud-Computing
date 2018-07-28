<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Application Status</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        table {
        border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>

<div class="container">
<h2>CSCI 5409: Assignment 4</h2>
<div style="margin-top: 15px;">
  <a href="createMortgage.php">Create a New Application</a>
  <br>
  <a href="searchMortgage.php">View Your Application Status</a>
</div>

<p></p>
<div id="enter_details"><strong>View Status</strong></div>
    <p></p>
    <form action="" method="post" enctype="multipart/form-data">
     <div class="form-group">
      <label for ="mortgage_id"> Application ID:  </label>
      <input type="text" name="mortgage_id" id="mortgage_id"
                         placeholder="Enter new application ID" pattern="[0-9]{3}" required>
      <label for ="mortgage_id"> (Max 3 digits are allowed) </label>

    </div>
      <input type="submit" name="submit" value="Submit" style="background-color: #4CAF50; /* Green */
          border: none;
          color: white;
          padding: 15px 32px;
          text-align: center;
          text-decoration: none;
          display: inline-block;
          font-size: 16px;">
    </form>


<?php
// when submit is pressed
if (isset($_POST["submit"])) {

  $mortgage_id = $_POST["mortgage_id"];

  // GET request - REST
  $url = 'https://a4-mortgage.herokuapp.com/mortgage/'.$mortgage_id.'/';

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL, $url);
  $result = curl_exec($ch);
  curl_close($ch);

  $obj = json_decode($result);

  // checking rows for response
  if ( strlen($obj->mortgage_id) == 3 ) {
      echo "<div style='margin-top: 30px;'>";
      echo "<table>
            <tr>
            <td width='25%' style='font-weight: bolder;'>Application ID</td>
            <td width='25%'>".$obj->mortgage_id."</td></tr>";

      echo "<tr>
            <td width='25%' style='font-weight: bolder;'>Applicant Name</td>
            <td width='25%'>".$obj->mortgage_name."</td></tr>";

      echo "<tr>
            <td width='25%' style='font-weight: bolder;'>Address</td>
            <td width='25%'>".$obj->mortgage_address."</td></tr>";

      echo "<tr>
            <td width='25%' style='font-weight: bolder;'>City</td>
            <td width='25%'>".$obj->mortgage_city."</td></tr>";

      echo "<tr>
            <td width='25%' style='font-weight: bolder;'>Province</td>
            <td width='25%'>".$obj->mortgage_province."</td></tr>";

      echo "<tr>
            <td width='25%' style='font-weight: bolder;'>Occupation</td>
            <td width='25%'>".$obj->mortgage_occupation."</td></tr>";

      echo "<tr>
            <td width='25%' style='font-weight: bolder;'>Contact Number</td>
            <td width='25%'>".$obj->mortgage_phoneNumber."</td></tr>";

      echo "<tr>
            <td width='25%' style='font-weight: bolder;'>Employee Details</td>
            <td width='25%'>".$obj->mortgage_companyName."</td></tr>";

      echo "<tr>
            <td width='25%' style='font-weight: bolder;'>Insurance Details</td>
            <td width='25%'>".$obj->mortgage_insuranceName."</td></tr>";

      echo "<tr>
            <td width='25%' style='font-weight: bolder;'>Application Status</td>
            <td width='25%'><i>Pending</i></td></tr>";

      echo "</tr></table></div>";}

  else {
      echo "<div style='color:red; font-weight: bolder;'>Record not found, please try again. </div>";}

}
?>

<footer style="margin-top: 20px;">
  <div>Developed by:</div>
  <div>Mr. Niravsinh Jadeja | B00789139 | <a href="mailto:nirav.jadeja@dal.ca">nirav.jadeja@dal.ca</a></div>
</footer>
</div>

</body>
</html>
