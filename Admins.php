<?php require_once ("Include/DB.php"); ?>
<?php require_once ("Include/Sessions.php"); ?>
<?php require_once ("Include/Functions.php"); ?>
<?php Confirm_Login(); ?>

<?php
if (isset($_POST["Submit"])) {
  $FirstName=mysql_real_escape_string($_POST["FirstName"]);
  $LastName=mysql_real_escape_string($_POST["LastName"]);
  $Username=mysql_real_escape_string($_POST["Username"]);
  $Email=mysql_real_escape_string($_POST["Email"]);
  $PhoneNumber=mysql_real_escape_string($_POST["PhoneNumber"]);
  $Password=mysql_real_escape_string($_POST["Password"]);
  $ConfirmPassword=mysql_real_escape_string($_POST["ConfirmPassword"]);
  $Token= bin2hex(openssl_random_pseudo_bytes(40));


  date_default_timezone_set("Africa/Lagos");
  $CurrentTime=time();
  $DateTime=strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);
  //$DateTime=strftime("%b-%m-%Y %H:%M:%S", $CurrentTime);
  //echo $DateTime;

$Admin=$_SESSION["Username"];

if (empty($Firstname)&&empty($Lastname)&&empty($Username)&&empty($Email)&&empty($PhoneNumber)&&
    empty($Password)&&empty($ConfirmPassword)) {
    $_SESSION["ErrorMessage"]="All Fields Must Be Filled Out";
    Redirect_to("Admins.php");
}elseif ($Password!==$ConfirmPassword) {
    $_SESSION["ErrorMessage"]="Passwords Do Not Match";
    Redirect_to("Admins.php");
}elseif (strlen($Password)<4) {
    $_SESSION["ErrorMessage"]="At Least 4 Characters For Password Are Required";
    Redirect_to("Admins.php");
}elseif (CheckIfEmailExistOrNot($Email)) {
    $_SESSION["ErrorMessage"]="Email Is Already In Use";
    Redirect_to("Admins.php");
}elseif (CheckIfUsernameExistOrNot($Username)) {
    $_SESSION["ErrorMessage"]="Username Is Already In Use, Choose Another Username";
    Redirect_to("Admins.php");
}
else {
    global $ConnectingDB;
    $Hashed_Password = Password_Encryption($Password);
    $Query="INSERT INTO registration(datetime,firstname,lastname,username,email,phone,password,addedby,token,active)
    VALUES('$DateTime','$FirstName','$LastName','$Username','$Email','$PhoneNumber','$Hashed_Password','$Admin','$Token','OFF')";
    $Execute=mysql_query($Query);
    if ($Execute) {
      $_SESSION["SuccessMessage"]="Admin Added Successully";
      Redirect_to("Admins.php");
    }else {
      $_SESSION["ErrorMessage"]="Failed To Register Admin, Try again.";
      Redirect_to("Admins.php");
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
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/adminstyles.css">

<style>
.FieldInfo{
  color: rgb(251, 174, 44);
  font-family: Bitter,Georgia,"Times New Roman",Times,serif;
  font-size: 1.2em;
}

</style>
</head>

<body>
  <?php require_once("Header.php"); ?>
    <div class="container-fluid"> <!-- Starting Of Container Fluid -->
      <div class="row"> <!-- Starting Of Row -->
        <div class="col-sm-2"> <!-- Starting Of Side Area -->
<br>
<!-- Starting Of Admin NavBar -->
          <ul id="side_menu" class="nav nav-pills nav-stacked">
            <li><a href="dashboard.php"><i class="fa fa-th"></i>&nbsp;Dashboard</a></li>
            <li><a href="addnewpost.php"><i class="fa fa-newspaper"></i>&nbsp;Add New Post</a></li>
            <li><a href="Categories.php"><i class="fa fa-tags"></i>&nbsp;Categories</a></li>
            <li class="active"><a href="Admins.php"><i class="fa fa-user"></i>&nbsp;Manage Admins</a></li>
            <li><a href="AdminMessages.php"><i class="fa fa-envelope"></i>&nbsp;Admin Messages</a></li>
            <li><a href="Comments.php"><i class="fa fa-comment-alt"></i>&nbsp;Comments
            <li><a href="blog.php?Page=1" target="_blank"><i class="fa fa-blog"></i>&nbsp;Live Blog</a></li>
            <li><a href="Logout.php"><i class="fa fa-sign-out-alt"></i>&nbsp;Logout</a></li>
          </ul>
<!-- Ending Of Admin NavBar -->
        </div> <!-- Ending Of Side Area -->

      <div class="col-sm-10"> <!-- Starting Of Main Area -->

        <h1>Manage Admin Access</h1>
        <div><?php echo Message();
                  echo SuccessMessage();
        ?>
      </div>

      <h3>Fill In The Form Below To Become An Admin</h3>

<div class="">   <!-- Starting Of Form Div-->
<form action="Admins.php" method="post">
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
<div class="table-responsive">
  <table class="table table-striped table-hover">
    <tr>
      <th>Sr No.</th>
      <th>Date & Time</th>
      <th>Admin Name</th>
      <th>Added By</th>
      <th>Action</th>
    </tr>
<?php
global $ConnectingDB;
$ViewQuery="SELECT * FROM registration ORDER BY id desc";
$Execute=mysql_query($ViewQuery);
$SrNo=0;
while ($DataRows=mysql_fetch_array($Execute)) {
  $Id=$DataRows["id"];
  $DateTime=$DataRows["datetime"];
  $Username=$DataRows["username"];
  $Admin=$DataRows["addedby"];
  $SrNo++;
?>

<tr>
  <td><?php echo $SrNo; ?></td>
  <td><?php echo $DateTime; ?></td>
  <td><?php echo $Username; ?></td>
  <td><?php echo $Admin; ?></td>
  <td><a href="DeleteAdmin.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a></td>
</tr>
<?php } ?>

</table>
</div>

      </div>  <!-- Ending  Of Main Area -->
    </div> <!-- Ending Of Row -->
  </div> <!-- Ending Of Container Fluid -->
<!-- Starting Of Footer -->
  <div id="footer">
    <hr><p>Theme By | Vyky Naija | &copy;2019 --- All Rights Reserved.</p>
    <a style="color: white; text-decoration: none; cursor: pointer; font-weight:bold;" href="http://vykynaija.com" target="_blank">
      <p>This site is a content of VykyNaija &trade;</p>
    </a>
  </div>
  <div style="height: 10px; background: #27AAE1;"></div>
</body>
</html>
