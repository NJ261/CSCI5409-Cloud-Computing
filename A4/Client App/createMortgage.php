
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create a new mortgage application</title>
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
    <a href="createMortgage.php">Create a New Application</a>
    <br>
    <a href="searchMortgage.php">View Your Application Status</a>
</div>

<p></p>

<div id="enter_details"> <strong>Enter the details</strong></div>
    <p></p>
    <form action="" method="post" enctype="multipart/form-data">

      <div class="form-group">
        <label for ="mortgage_id"> Application ID:  </label>
        <input type="text" name="mortgage_id" id="mortgage_id"
                           placeholder="Enter new application ID" pattern="[0-9]{3}" required>
        <label for ="mortgage_id"> (Max 3 digits are allowed) </label>
      </div>

      <div class="form-group">
        <label for ="mortgage_name"> Full Name:  </label>
        <input type="text" name="mortgage_name" id="mortgage_name"
                           placeholder="Enter your full name" maxlength="100" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$" required>
        <label>E.g. Nirav Jadeja (Only Letters)</label>
      </div>

      <div class="form-group">
        <label for ="mortgage_address"> Address:  </label>
        <input type="text" name="mortgage_address" id="mortgage_address"
                           placeholder="Enter your address" maxlength="200" pattern="^\d+\s[A-z]+\s[A-z]+" required>
        <label>E.g. 123 abcd sdf</label>
      </div>

      <div class="form-group">
        <label for ="mortgage_city"> City:  </label>
        <input type="text" name="mortgage_city" id="mortgage_city"
                           placeholder="Enter your city name" maxlength="20" pattern="^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$" required>
      </div>

      <div class="form-group">
         <label for ="mortgage_province"> Province:  </label>
         <input type="text" name="mortgage_province" id="mortgage_province"
                            placeholder="Enter your province name" maxlength="20" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$" required>
       </div>

       <div class="form-group">
         <label for ="mortgage_occupation"> Occupation:  </label>
         <input type="text" name="mortgage_occupation" id="mortgage_occupation"
                            placeholder="Enter your occupation" maxlength="100" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$" required>
         <label>E.g. Data Scientist</label>

       </div>

       <div class="form-group">
         <label for ="mortgage_phoneNumber"> Phone number:  </label>
         <input type="text" name="mortgage_phoneNumber" id="mortgage_phoneNumber"
                            placeholder="Enter your contact details" maxlength="14" pattern="^\([0-9]{3}\)[0-9]{3}-[0-9]{4}$" required>
          <label for ="mortgage_id"> E.g. (777)888-9999 </label>
        </div>

        <div class="form-group">
          <label for ="mortgage_companyName"> Employee Name:  </label>
          <input type="text" name="mortgage_companyName" id="mortgage_companyName"
                             placeholder="Enter your employee name" maxlength="150" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$" required>
          <label>E.g. Google Inc</label>
        </div>

        <div class="form-group">
          <label for ="mortgage_insuranceName"> Insurance Provide Name:  </label>
          <input type="text" name="mortgage_insuranceName" id="mortgage_insuranceName"
                             placeholder="Enter your insurance company name" maxlength="150" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$" required>
          <label>E.g. abcd insurance</label>
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
        $mortgage_id = $_POST["mortgage_id"];
        $mortgage_name = $_POST["mortgage_name"];
        $mortgage_address = $_POST["mortgage_address"];
        $mortgage_city = $_POST["mortgage_city"];
        $mortgage_province = $_POST["mortgage_province"];
        $mortgage_occupation = $_POST["mortgage_occupation"];
        $mortgage_phoneNumber = $_POST["mortgage_phoneNumber"];
        $mortgage_companyName = $_POST["mortgage_companyName"];
        $mortgage_insuranceName = $_POST["mortgage_insuranceName"];

        $url = 'https://a4-mortgage.herokuapp.com/mortgage/';

        // curl initialization
        $ch = curl_init($url);

        // preparing the array
        $jsonData = array('mortgage_id' => $mortgage_id,
                          'mortgage_name' => $mortgage_name,
                          '$mortgage_address' => $mortgage_address,
                          'mortgage_city' => $mortgage_city,
                          'mortgage_province' => $mortgage_province ,
                          'mortgage_occupation' => $mortgage_occupation ,
                          'mortgage_phoneNumber' => $mortgage_phoneNumber,
                          'mortgage_companyName' => $mortgage_companyName,
                          'mortgage_insuranceName' => $mortgage_insuranceName );

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

        // closing the connection
        curl_close($ch);

        $obj = json_decode($result);

        // checking that mortgage id already exists or not
        if (strlen($obj->mortgage_id) == 3){
          echo "<div style='color:blue; font-weight: bolder;'>Information Created!!</div>";
        }
        else{
          echo "<div style='color:red; font-weight: bolder;'>Application ID already exists,
                            please try again with other number!!</div>";
        }

      }

      catch ( Exception $e) {
          echo "<div style='color:blue; font-weight: bolder;'>Something went wrong, Please try again!</div>";}
          }
?>

<!-- Footer -->
<footer style="margin-top: 20px;">
  <div>Developed by:</div>
  <div>Mr. Niravsinh Jadeja | B00789139 | <a href="mailto:nirav.jadeja@dal.ca">nirav.jadeja@dal.ca</a></div>
</footer>
</div>
</body>
</html>
