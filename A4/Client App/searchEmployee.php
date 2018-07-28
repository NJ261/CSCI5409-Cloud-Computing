
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Send employee's details</title>
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
  <a href="createEmployee.php">Create New Employee</a>
  <br>
  <a href="searchEmployee.php">Send your Employee's details</a>
</div>

<p></p>
<div id="enter_details">Read Employee Details</div>
    <p></p>
    <form action="" method="post" enctype="multipart/form-data">
      <div class="form-group">
      <label for ="employee_id"> Employee ID </label>
      <input type="text" name="employee_id" id="employee_id" placeholder="Enter your employee ID" pattern="[0-9]{3}" required>
      <label for ="employee_id"> (Max 3 digits are allowed) </label>
      </div>
        <p></p>
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

// when submit button is pressed
if (isset($_POST["submit"])) {

  $employee_id = $_POST["employee_id"];

  // GET Method
  $url = 'https://a4-employer.herokuapp.com/employees/'.$employee_id.'/';

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL, $url);
  $result = curl_exec($ch);
  curl_close($ch);

  $obj = json_decode($result);

  // row check for response
  if ( strlen($obj->employee_id) == 3 ) {
      echo "<div style='margin-top: 30px;'>";
      echo "<table>
                    <tr style='font-weight: bolder;'>
                    <td width='10%'>Sr. No.</td>
                    <td width='10%'>Employee ID</td>
                    <td width='15%'>Employee Name</td>
                    <td width='15%'>Employee Occupation</td>
                    <td width='20%'>Employee Salary</td>
                    <td width='15%'>I agree to send details</td>
                    <td width='15%'>Send Details</td></tr>";
      $element = 1;
      echo "<tr><td>".$element."</td>";   // Sr. no
      echo "<td>".$obj->employee_id."</td>";   // employee ID
      echo "<td>".$obj->employee_name."</td>";    // employee Name
      echo "<td>".$obj->employee_occupation."</td>";    // employee occupation
      echo "<td>".$obj->employee_salary."</td>";    // employee salary
      echo "<td>"; echo "<form action='/action_page.php' method='get'>";
                   echo "  <input type='checkbox' name='consent' value='iagree'> I agree";
                   echo "</td>"; // checkbox
      echo "<td><a href='#'>Send Details</td></tr>"; // send button
      echo "</tr></table></div>";}

  else {
      echo "<div style='color:red; font-weight: bolder;'>Record not found, please try again. </div>";}

}
?>

<!-- footer -->
<footer style="margin-top: 20px;">
  <div>Developed by:</div>
  <div>Mr. Niravsinh Jadeja | B00789139 | <a href="mailto:nirav.jadeja@dal.ca">nirav.jadeja@dal.ca</a></div>
</footer>

</div> <!-- container div end -->

</body>
</html>
