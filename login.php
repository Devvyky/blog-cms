<?php require_once ("Include/DB.php"); ?>
<?php require_once ("Include/Sessions.php"); ?>
<?php require_once ("Include/Functions.php"); ?>


<?php
if (isset($_POST["Submit"])) {
  $Username=mysql_real_escape_string($_POST["Username"]);
  $Password=mysql_real_escape_string($_POST["Password"]);

if (empty($Username)||empty($Password)) {
    $_SESSION["ErrorMessage"]="All Fields Must Be Filled Out";
    Redirect_to("login.php");
}
else {
  $Found_Account=Login_Attempt($Username,$Password);
  if ($Found_Account) {
    $_SESSION["User_Id"]=$Found_Account["id"];
    $_SESSION["Username"]=$Found_Account["username"];
      if (isset($_POST["Remember"])) {
        $ExpireTime = time() + 60;
        setcookie("SettingEmail",$Username,$ExpireTime);
      }
    $_SESSION["SuccessMessage"]="Welcome Back {$_SESSION["Username"]} ";
    Redirect_to("Dashboard.php");
  }else {
    $_SESSION["ErrorMessage"]="Invalid Username Or Password Combination";
    Redirect_to("login.php");
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
  font-size: 1.2em;
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
        <br><br><br><br>
        <div><?php echo Message();
                  echo SuccessMessage();
        ?>
        </div>
        <h2>Welcome Back !</h2>

<div>   <!-- Starting Of Form Div-->
  <form action="login.php" method="post">
    <fieldset>
      <div class="form-group">
      <label for="Username"><span class="FieldInfo">Username:</span></label>
        <div class="input-group input-group-lg">
        <span class="input-group-addon">
          <span class="glyphicon glyphicon-user text-primary"></span>
        </span>
      <input class="form-control" type="text" name="Username" id="Username" placeholder="Username">
        </div>
      </div>

      <div class="form-group">
      <label for="Password"><span class="FieldInfo">Password:</span></label>
        <div class="input-group input-group-lg">
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-lock text-primary"></span>
          </span>
      <input class="form-control" type="password" name="Password" id="Password" placeholder="Password">
        </div>
      </div>

      <input type="checkbox" name="Remember"> <span class="FieldInfo">&nbsp;Remember Me </span>
      <br><br>
      <input class="btn btn-info btn-block" type="submit" name="Submit" value="Login">

      <br>
    </fieldset>


  </form>
</div>  <!-- Ending Of Form Div-->

      </div>  <!-- Ending  Of Main Area -->
    </div> <!-- Ending Of Row -->
  </div> <!-- Ending Of Container Fluid -->

</body>
</html>
