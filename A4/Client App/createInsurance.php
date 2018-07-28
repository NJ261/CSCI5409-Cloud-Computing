
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Take a New Insurance</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
<h2>CSCI 5409: Assignment 4</h2>
<div style="margin-top: 15px;">
  <a href="createInsurance.php">Take a New Insurance</a>
  <br>
  <a href="searchInsurance.php">Send your Insurance's details</a>
</div>

<p></p>
<div id="enter_details"><strong>Enter the details</strong></div>
    <p></p>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
        <label for ="insurance_id"> Insurance ID </label>
        <input type="text" name="insurance_id" id="insurance_id"
                           placeholder="Enter your Insurance ID" pattern="[0-9]{5}" required>
        <label for ="insurance_id"> (5 digit numbers are allowed i.e 12345) </label>
        </div>

        <div class="form-group">
        <label for ="insurance_name"> Insurance Name </label>
        <input type="text" name="insurance_name" id="insurance_name"
                           placeholder="Enter your name" maxlength="50" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$" required>
        <label>E.g. Nirav Jadeja (only letters)</label>
        </div>

        <div class="form-group">
        <label for ="insurance_value"> Insurance Value </label>
        <input type="text" name="insurance_value" id="insurance_value"
                           placeholder="Enter your occupation" maxlength="80" pattern="[0-9]{1,10}" required>
        <label>E.g. 12000 (only digits)</label>
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

if (isset($_POST["submit"])) {

      try {
        $insurance_id = $_POST["insurance_id"];
        $insurance_name = $_POST["insurance_name"];
        $insurance_value = $_POST["insurance_value"];

        $url = 'https://a4-insurance.herokuapp.com/insurance/';

        // curl initialization
        $ch = curl_init($url);

        // preparing the array
        $jsonData = array('insurance_id' => $insurance_id, 'insurance_name' => $insurance_name,
                          'insurance_value' => $insurance_value);

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

        // checking that employee id ealready exists or not
        if (strlen($obj->insurance_id) == 5){
          echo "<div style='color:blue; font-weight: bolder;'>Information Created!!</div>";
        }
        else{
          echo "<div style='color:red; font-weight: bolder;'>Insurance ID already exists,
                            please try again with other number!!</div>";
        }

      }

      catch ( Exception $e) {
          echo "<div style='color:blue; font-weight: bolder;'>Something went wrong, Please try again!</div>";}
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
