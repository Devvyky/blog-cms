<?php require_once ("Include/DB.php"); ?>
<?php require_once ("Include/Sessions.php"); ?>
<?php require_once ("Include/Functions.php"); ?>

<?php
if (isset($_POST["Submit"])) {
  $Name=mysql_real_escape_string($_POST["Name"]);
  $Email=mysql_real_escape_string($_POST["Email"]);
  $Subject=mysql_real_escape_string($_POST["Subject"]);
  $Message=mysql_real_escape_string($_POST["Message"]);

//datetime
  date_default_timezone_set("Africa/Lagos");
  $CurrentTime=time();
  //$DateTime=strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);
  $DateTime=strftime("%b-%m-%Y %H:%M:%S", $CurrentTime);

if (empty($Name)||empty($Email)||empty($Subject)||empty($Message)) {
    $_SESSION["ErrorMessage"]="All Fields Must Be Filled Out";
    Redirect_to("ContactUs.php");
}
else {
  global $ConnectingDB;
  $Query="INSERT INTO contact_us(datetime,name,email,subject,message,status)
  VALUES('$DateTime','$Name','$Email','$Subject','$Message','OFF')";
  $Execute=mysql_query($Query);

  if ($Execute) {
    $_SESSION["SuccessMessage"]="Your Message Has Been Sent Successully And it's Being Reviewed";
    Redirect_to("ContactUs.php");
  }else {
    $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again!";
    Redirect_to("ContactUs.php");
  }
}

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-145666245-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-145666245-1');
</script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contant Us</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/adminstyles.css">
    <link rel="stylesheet" href="css/publicstyles.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

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

        <a class="navbar-brand" href="Index.php?Page=1"><img style="margin-top: -5px;" src="Images/logo.png" width="200"; height="30";></a>
      </div>
      <div class="collapse navbar-collapse" id="collapse">
        <ul class="nav navbar-nav">
          <li><a href="Index.php?Page=1">Home <i class="fa fa-home"></i></a></li>
          <li><a href="Blog.php?Page=1">Blog <i class="fa fa-globe"></i></a></li>
          <li><a href="">Services <i class="fa fa-users"></i></a></li>
          <li><a href="AboutUs.php">About Us <i class="fa fa-address-card"></i></a></li>
          <li class="active"><a href="ContactUs.php">Contact Us <i class="fa fa-id-card"></i></a></li>
        </ul>

        <form action="Blog.php" class="navbar-form  navbar-right">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Search" name="Search">
          </div>
          <button class="btn btn-default" name="SearchButton">Search</button>
        </form>
      </div>
    </div>
  </nav>
  <div class="Line" style="height: 10px; background: #27aae1;"></div>
<!-- Ending Of Nav Bar-->

    <div class="container-fluid"> <!-- Starting Of Container Fluid -->
      <div class="row"> <!-- Starting Of Row -->


      <div class="col-sm-offset-4 col-sm-4"> <!-- Starting Of Main Area -->
        <br><br><br><br>
        <div><?php echo Message();
                  echo SuccessMessage();
        ?>
        </div>
        <h1 id="heading" class="contact">Contact Us</h1>
<br>

<div>   <!-- Starting Of Form Div-->
  <form action="ContactUs.php" method="post" enctype="multipart/form-data">
    <fieldset>
      <div class="form-group">
        <input class="form-control" type="text" name="Name" id="Name" placeholder="Name">
      </div>

      <div class="form-group">
        <input class="form-control" type="email" name="Email" id="Email" placeholder="Work Email">
      </div>

      <div class="form-group">
        <select class="form-control" name="Subject">
          <option  hidden >What's This About</option>
          <option>Pricing/Sales</option>
          <option>Billing</option>
          <option>Marketing</option>
          <option>Partnership</option>
          <option>Employment</option>
        </select>
      </div>

      <div class="form-group">
        <textarea class="form-control" name="Message" id="postarea" rows="10" cols="80" placeholder="Go ahead, we're listening"></textarea>
      </div>

      <br>
      <input class="btn btn-info btn-block" type="submit" name="Submit" value="Submit">
      <br>
    </fieldset>

  </form>
  <br><br>
</div>  <!-- Ending Of Form Div-->

      </div>  <!-- Ending  Of Main Area -->
    </div> <!-- Ending Of Row -->
  </div> <!-- Ending Of Container Fluid -->

  <div id="footer">
    <hr><p>Theme By | Vyky Naija | &copy;2019 --- All Rights Reserved.</p>
    <a style="color: white; text-decoration: none; cursor: pointer; font-weight:bold;" href="http://vykynaija.com" target="_blank">
      <p>This site is a content of VykyNaija &trade;</p>
    </a>
  </div>

  <div style="height: 10px; background: #27AAE1;"></div>
</body>
</html>
