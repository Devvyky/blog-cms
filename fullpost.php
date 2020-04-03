<?php require_once ("Include/DB.php"); ?>
<?php require_once ("Include/Sessions.php"); ?>
<?php require_once ("Include/Functions.php"); ?>

<?php
if (isset($_POST["Submit"])) {
  $Name=mysql_real_escape_string($_POST["Name"]);
  $Email=mysql_real_escape_string($_POST["Email"]);
  $Comment=mysql_real_escape_string($_POST["Comment"]);


  date_default_timezone_set("Africa/Lagos");
  $CurrentTime=time();
  //$DateTime=strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);
  $DateTime=strftime("%b-%m-%Y %H:%M:%S", $CurrentTime);
  echo "$DateTime";

$PostId=$_GET["id"];

if (empty($Name)||empty($Email)||empty($Comment)) {
    $_SESSION["ErrorMessage"]="All Fields Are Required";

}elseif (strlen($Comment)>500) {
    $_SESSION["ErrorMessage"]="Only 500 Characters Allowed In Comments";

}else {
    global $ConnectingDB;
    $PostIdFromURL=$_GET['id'];
    $Query="INSERT into comments(datetime,name,email,comment,status,admin_panel_id)
    VALUES ('$DateTime','$Name','$Email','$Comment','OFF','$PostIdFromURL')";
    $Execute=mysql_query($Query);

    if ($Execute) {
      $_SESSION["SuccessMessage"]="Comment Submitted Successully";
      Redirect_to("fullpost.php?id={$PostId}");
    }else {
      $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again!";
      Redirect_to("fullpost.php?id={$PostId}");
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
    <meta name="keywords" content="<?php
    $PostIdFromURL=$_GET["id"];
    global $ConnectingDB;
    $TitleQuery="SELECT * FROM admin_panel WHERE id='$PostIdFromURL'
    ORDER BY datetime desc";
    $Execute=mysql_query($TitleQuery);
    while ($DataRows=mysql_fetch_array($Execute)) {
      $PostId=$DataRows["id"];
      $DateTime=$DataRows["datetime"];
      $Title=$DataRows["title"];
      $Tags=$DataRows["tags"];
      $Description=$DataRows["description"];
      $Category=$DataRows["category"];
      $Admin=$DataRows["author"];
      $Image=$DataRows["image"];
      $Post=$DataRows["post"];
    ?>
    <?php echo nl2br($Tags); ?>
  <?php } ?>" >
    <meta name="author" content="Dev Vyky">
    <meta name="description" content="<?php
    $PostIdFromURL=$_GET["id"];
    global $ConnectingDB;
    $TitleQuery="SELECT * FROM admin_panel WHERE id='$PostIdFromURL'
    ORDER BY datetime desc";
    $Execute=mysql_query($TitleQuery);
    while ($DataRows=mysql_fetch_array($Execute)) {
      $PostId=$DataRows["id"];
      $DateTime=$DataRows["datetime"];
      $Title=$DataRows["title"];
      $Tags=$DataRows["tags"];
      $Description=$DataRows["description"];
      $Category=$DataRows["category"];
      $Admin=$DataRows["author"];
      $Image=$DataRows["image"];
      $Post=$DataRows["post"];
    ?>
    <?php echo nl2br($Description); ?>
  <?php } ?>">
    <meta http-equiv="refresh" content="120">
    <title>
      <?php
      $PostIdFromURL=$_GET["id"];
      global $ConnectingDB;
      $TitleQuery="SELECT * FROM admin_panel WHERE id='$PostIdFromURL'
      ORDER BY datetime desc";
      $Execute=mysql_query($TitleQuery);
      while ($DataRows=mysql_fetch_array($Execute)) {
        $PostId=$DataRows["id"];
        $DateTime=$DataRows["datetime"];
        $Title=$DataRows["title"];
        $Category=$DataRows["category"];
        $Admin=$DataRows["author"];
        $Image=$DataRows["image"];
        $Post=$DataRows["post"];
      ?>
      <?php echo nl2br($Title); ?>
    <?php } ?>
      </title>

    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/publicstyles.css">
    <style>
      .FieldInfo{
        color: rgb(251, 174, 44);
        font-family: Bitter,Georgia,"Times New Roman",Times,serif;
        font-size: 1.2em;
      }
      .CommentBlock{
        background-color: #F6F7F9;
      }
      .Comment-info{
        color: #365899;
        font-size: 1.1em;
        font-weight: bold;
        padding-top: 10px;
      }
      .Comment{
        margin-top: -2px;
        padding-bottom: 10px;
        font-size: 1.1em;
      }
    </style>
</head>

<body>
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

          <a class="navbar-brand" href="index.php?Page=1"><img style="margin-top: -5px;" src="Images/logo.png" width="200"; height="30";></a>
        </div>
        <div class="collapse navbar-collapse" id="collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php?Page=1">Home <i class="fa fa-home"></i></a></li>
            <li class="active"><a href="blog.php?Page=1">Blog <i class="fa fa-globe"></i></a></li>
            <li><a href="">Services <i class="fa fa-users"></i></a></li>
            <li><a href="">About Us <i class="fa fa-address-card"></i></a></li>
            <li><a href="ContactUs.php">Contact Us <i class="fa fa-id-card"></i></a></li>
          </ul>

          <form action="blog.php" class="navbar-form  navbar-right">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Search" name="Search">
            </div>
            <button class="btn btn-default" name="SearchButton">Search</button>
          </form>
          </div>
      </div>
    </nav>

<div class="Line" style="height: 10px; background: #27aae1;"></div>

<div class="container"> <!-- Container Starting-->
  <div class="blog-header">
    <h1>Dev Vyky Blog</h1>
    <p class="lead">Dev Vyky | Where Development Takes Place</p>
  </div>

  <div class="row"> <!-- Row Starting-->
    <div class="col-sm-8"> <!-- Main Area Starting-->
      <?php
        global $ConnectingDB;
        if (isset($_GET["SearchButton"])) {
          $Search=$_GET["Search"];
          $ViewQuery="SELECT * FROM admin_panel
          WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%'
          OR category LIKE '%$Search%' OR post LIKE '%$Search%'";
        }else {
            $PostIdFromURL=$_GET["id"];
        $ViewQuery="SELECT * FROM admin_panel WHERE id='$PostIdFromURL'
        ORDER BY datetime desc"; }
        $Execute=mysql_query($ViewQuery);
        while ($DataRows=mysql_fetch_array($Execute)) {
            $PostId=$DataRows["id"];
            $DateTime=$DataRows["datetime"];
            $Title=$DataRows["title"];
            $Category=$DataRows["category"];
            $Admin=$DataRows["author"];
            $Image=$DataRows["image"];
            $Post=$DataRows["post"];
      ?>
      <div class="blogpost thumbnail">
        <img class="img-responsive img-rounded" src="Upload/<?php echo $Image; ?>" width="700px">
        <div class="caption">
          <h1 id="heading"><?php echo htmlentities($Title); ?></h1>
          <p class="description">Category: <?php echo htmlentities($Category); ?> Published On <?php echo htmlentities($DateTime); ?> </p>
          <p class="post"><?php echo nl2br ($Post); ?></p>
        </div>

      </div>
    <?php } ?>

<br><br>
<br><br>
<!-- Comment Code Starts Here -->
<div><?php echo Message();
          echo SuccessMessage();
?>
</div>
<span class="FieldInfo">Comments</span>
<br><br>
<?php
$ConnectingDB;
$PostIdForComments=$_GET['id'];
$ExtractingCommentsQuery="SELECT * FROM comments WHERE admin_panel_id='$PostIdForComments' AND status='ON'";
$Execute=mysql_query($ExtractingCommentsQuery);
while ($DataRows=mysql_fetch_array($Execute)) {
  $CommentDate=$DataRows["datetime"];
  $Commentername=$DataRows["name"];
  $Comments=$DataRows["comment"];

?>
<div class="CommentBlock">
  <img style="margin-left: 10px;" class="pull-left" src="Images/comment.png" width="70px"; height="70px";>
  <p style="margin-left: 90px;" class="Comment-info"><?php echo $Commentername; ?></p>
  <p style="margin-left: 90px;" class="description"><?php echo $CommentDate; ?></p>
  <p style="margin-left: 90px;" class="Comment"><?php echo nl2br ($Comments); ?></p>
</div>
<hr>
<?php } ?>

<br>
<span class="FieldInfo">Share Your Thoughts About This Post</span>

  <div>
      <form action="fullpost.php?id=<?php echo $PostId; ?>" method="post" enctype="multipart/form-data">
        <fieldset>

          <div class="form-group">
          <label for="Name"><span class="FieldInfo">Name:</span></label>
          <input class="form-control" type="text" name="Name" id="Name" placeholder="Name">
          </div>

          <div class="form-group">
          <label for="Email"><span class="FieldInfo">Email:</span></label>
          <input class="form-control" type="email" name="Email" id="title" placeholder="Email">
          </div>

          <div class="form-group">
            <label for="commentarea"><span class="FieldInfo">Comment</span></label>
            <textarea class="form-control" name="Comment" id="commentarea"></textarea>
          </div>

          <br>
          <input class="btn btn-primary" type="submit" name="Submit" value="Submit">
          <br>

        </fieldset>


      </form>
  </div>
<!-- Comment Code Ends Here -->

    </div> <!-- Main Area Ending-->

    <div class="col-sm-offset-1 col-sm-3"> <!-- Side Area Starting-->
    <!-- Start cutadlink banner code -->
<a href="https://cutadlink.com/ref/devvyky" target="_blank"><img src="//cutadlink.com/banner.png" title="Make short links and earn the biggest money" /></a>
<!-- End cutadlink banner code -->
      <br>
      <br>

      <div class="panel panel-primary">
        <div class="panel-heading">
          <h2 class="panel-title">Categories</h2>
        </div>
        <div class="panel-body">
          <?php
            global $ConnectingDB;
            $ViewQuery="SELECT * FROM category ORDER BY id desc ";
            $Execute=mysql_query($ViewQuery);
            while ($DataRows=mysql_fetch_array($Execute)) {
              $Id=$DataRows['id'];
              $Category=$DataRows['name'];
          ?>
          <a href="blog.php?Category=<?php echo $Category; ?>">
            <span id="heading"><?php echo $Category."<br>"; ?></span>
          </a>
          <?php } ?>
        </div>
        <div class="panel-footer">

        </div>
      </div>

      <div class="panel panel-primary">
        <div class="panel-heading">
          <h2 class="panel-title">Recent Post</h2>
        </div>
        <div class="panel-body background">
          <?php
            $ConnectingDB;
            $ViewQuery="SELECT * FROM admin_panel ORDER BY id desc LIMIT 0,5 ";
            $Execute=mysql_query($ViewQuery);
            while ($DataRows=mysql_fetch_array($Execute)) {
              $Id=$DataRows["id"];
              $Title=$DataRows['title'];
              $DateTime=$DataRows["datetime"];
              $Image=$DataRows["image"];
              if(strlen($DateTime)>11) {
                $DateTime=substr($DateTime,0,11);
              }
          ?>
        <div>
          <img class="pull-left" style="margin-top: 10px; margin-left:10px;" src="Upload/<?php echo htmlentities($Image); ?>" width="70"; height="70";>
        <a href="fullpost.php?id=<?php echo $Id; ?> ">
          <p id="heading" style="margin-left:90px;"><?php echo htmlentities($Title); ?></p>
          </a>
          <p class="description" style="margin-left:90px;"><?php echo htmlentities($DateTime); ?></p>
        <hr>
        </div>

          <?php } ?>

          </div>
          <div class="panel-footer">

          </div>
        </div>
<br /><br />
        <!-- About Me Starts Here -->
              <h2>About Me</h2>
              <img class="img-responsive img-circle imageicon" src="Images/VykyNaija.jpg" >
              <p>
                My name is Chibuikem Victor (AKA Vyky) and I am a full-time freelance web developer who specializes in creating dynamic and beautiful web pages. I have been in the field for nearly 4 years, and have been loving every minute of it. I am a blogger, entrepreneur, designer, developer, and overall thinker. Check out some of the links below to see what I’ve been up to lately.
              </p>
        <!-- About Me Stops Here -->

    </div> <!-- Side Area Ending-->
  </div> <!-- Row Ending-->

</div> <!-- Container Ending-->
<br>
<div id="footer">
  <hr><p>Theme By | Dev Vyky | &copy;2019 --- All Rights Reserved.</p>
  <a style="color: white; text-decoration: none; cursor: pointer; font-weight:bold;" href="http://vykynaija.com" target="_blank">
    <p>This site is a content of VykyNaija &trade;</p>
  </a>
</div>
<div style="height: 10px; background: #27AAE1;"></div>
</body>
</html>
