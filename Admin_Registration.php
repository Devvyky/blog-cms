<?php require_once ("Include/Sessions.php"); ?>
<?php require_once ("Include/Functions.php"); ?>
<?php require_once ("Include/DB.php"); ?>

<?php
if (isset($_POST["Submit"])) {
  $FirstName=mysql_real_escape_string($_POST["FirstName"]);
  $LastName=mysql_real_escape_string($_POST["LastName"]);
  $Username=mysql_real_escape_string($_POST["Username"]);
  $Email=mysql_real_escape_string($_POST["Email"]);
  $PhoneNumber=mysql_real_escape_string($_POST["PhoneNumber"]);
  $Password=mysql_real_escape_string($_POST["Password"]);
  $ConfirmPassword=mysql_real_escape_string($_POST["ConfirmPassword"]);

  date_default_timezone_set("Africa/Lagos");
  $CurrentTime=time();
  $DateTime=strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);
  //$DateTime=strftime("%b-%m-%Y %H:%M:%S", $CurrentTime);
  //echo $DateTime;

$Admin=$_SESSION["Username"];

if (empty($Firstname)&&empty($Lastname)&&empty($Username)&&empty($Email)&&empty($PhoneNumber)&&empty($Password)&&empty($ConfirmPassword)) {
    $_SESSION["ErrorMessage"]="All Fields Must Be Filled Out";
    Redirect_to("Admin_Registration.php");
}elseif ($Password!==$ConfirmPassword) {
    $_SESSION["ErrorMessage"]="Passwords Do Not Match";
    Redirect_to("Admin_Registration.php");
}elseif (strlen($Password)<4) {
    $_SESSION["ErrorMessage"]="At Least 4 Characters For Password Are Required";
    Redirect_to("Admin_Registration.php");
}elseif (CheckIfEmailExistOrNot($Email)) {
    $_SESSION["ErrorMessage"]="Email Is Already In Use";
    Redirect_to("Admin_Registration.php");
}
else {
    global $ConnectingDB;
    $Hashed_Password = Password_Encryption($Password);
    $Query="INSERT INTO registration(datetime,firstname,lastname,username,email,phone,password,addedby)
    VALUES('$DateTime','$FirstName','$LastName','$Username','$Email','$PhoneNumber','$Hashed_Password','$Admin')";
    $Execute=mysql_query($Query);
    if ($Execute) {
      $_SESSION["SuccessMessage"]="Admin Added Successully";
      Redirect_to("Admin_Registration.php");
    }else {
      $_SESSION["ErrorMessage"]="Failed To Register Admin, Try again.";
      Redirect_to("Admin_Registration.php");
    }
  }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/adminstyles.css">

<style>
.FieldInfo{
  color: rgb(251, 174, 44);
  font-family: Bitter,Georgia,"Times New Roman",Times,serif;
  font-size: 1.1em;
}
body{
  background-color: #ffffff;
}
</style>
</head>

<body>

  <!-- Starting Of Nav Bar-->
  <div style="height: 10px; background: #27aae1;"></div>
  <nav class="navbar navbar-inverse" role="navigation">
    <div class="container">
      <div class="navbar-header">

      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
        <span class="sr-only">Toggle Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

        <a class="navbar-brand" href="Blog.php"><img style="margin-top: -5px;" src="Images/logo.png" width="200"; height="30";></a>
      </div>
      <div class="collapse navbar-collapse" id="collapse"></div>
    </div>
  </nav>
<!-- Ending Of Nav Bar-->

    <div class="container-fluid"> <!-- Starting Of Container Fluid -->
      <div class="row"> <!-- Starting Of Row -->


      <div class="col-sm-offset-4 col-sm-4"> <!-- Starting Of Main Area -->
        <br>
        <div><?php echo Message();
                  echo SuccessMessage();
        ?>
        </div>
        <h3>Fill In The Form Below To Become An Admin</h3>

<div class="center_page">   <!-- Starting Of Form Div-->
  <form action="Admin_Registration.php" method="post">
    <fieldset>

      <div class="form-group">
      <label for="Username"><span class="FieldInfo">First Name:</span></label>
        <div class="input-group input-group-sm">
        <span class="input-group-addon">
          <span class="glyphicon glyphicon-user text-primary"></span>
        </span>
      <input class="form-control" type="text" name="FirstName" id="FirstName" placeholder="First Name">
        </div>
      </div>

      <div class="form-group">
      <label for="Username"><span class="FieldInfo">Last Name:</span></label>
        <div class="input-group input-group-sm">
        <span class="input-group-addon">
          <span class="glyphicon glyphicon-user text-primary"></span>
        </span>
      <input class="form-control" type="text" name="LastName" id="LastName" placeholder="LastName">
        </div>
      </div>

      <div class="form-group">
      <label for="Username"><span class="FieldInfo">Username:</span></label>
        <div class="input-group input-group-sm">
        <span class="input-group-addon">
          <span class="glyphicon glyphicon-user text-primary"></span>
        </span>
      <input class="form-control" type="text" name="Username" id="Username" placeholder="Username">
        </div>
      </div>

      <div class="form-group">
      <label for="Password"><span class="FieldInfo">Email:</span></label>
        <div class="input-group input-group-sm">
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-envelope text-primary"></span>
          </span>
      <input class="form-control" type="email" name="Email" id="Email" placeholder="Email">
        </div>
      </div>

      <div class="form-group">
      <label for="Password"><span class="FieldInfo">Phone Number:</span></label>
        <div class="input-group input-group-sm">
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-phone text-primary"></span>
          </span>
      <input class="form-control" type="number" name="PhoneNumber" id="PhoneNumber" placeholder="Phone Number">
        </div>
      </div>

      <div class="form-group">
      <label for="Password"><span class="FieldInfo">Password:</span></label>
        <div class="input-group input-group-sm">
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-lock text-primary"></span>
          </span>
      <input class="form-control" type="password" name="Password" id="Password" placeholder="Password">
        </div>
      </div>

      <div class="form-group">
      <label for="Password"><span class="FieldInfo">Confirm Password:</span></label>
        <div class="input-group input-group-sm">
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-lock text-primary"></span>
          </span>
      <input class="form-control" type="password" name="ConfirmPassword" id="Password" placeholder="Password">
        </div>
      </div>

      <br>
      <input class="btn btn-info btn-block" type="submit" name="Submit" value="Register">
      <br>
    </fieldset>
  </form>

</div>  <!-- Ending Of Form Div-->

<br><br>

      </div>  <!-- Ending  Of Main Area -->
    </div> <!-- Ending Of Row -->
  </div> <!-- Ending Of Container Fluid -->

</body>
</html>
