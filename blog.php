<?php require_once ("Include/DB.php"); ?>
<?php require_once ("Include/Sessions.php"); ?>
<?php require_once ("Include/Functions.php"); ?>
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
    <meta name="keywords" content="">
    <meta name="author" content="Dev Vyky">
    <meta name="description" content="">
    <meta http-equiv="refresh" content="120">
    <title>Dev Vyky || Rule Your World With Latest Tech News, Celebrity News, School News, Entertainment And Many More </title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/publicstyles.css">
    <style>

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
            <li class="active"><a href="Blog.php?Page=1">Blog <i class="fa fa-globe"></i></a></li>
            <li><a href="">Services <i class="fa fa-users"></i></a></li>
            <li><a href="">About Us <i class="fa fa-address-card"></i></a></li>
            <li><a href="ContactUs.php">Contact Us <i class="fa fa-id-card"></i></a></li>
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

<div class="container"> <!-- Container Starting-->
  <div class="blog-header">
    <h1>Dev Vyky Blog</h1>
    <p class="lead">Dev Vyky | Where Development Takes Place</p>
  </div>

  <div class="row"> <!-- Row Starting-->
    <div class="col-sm-8"> <!-- Main Area Starting-->
      <?php
        global $ConnectingDB;
        //Query When Search Button is Clicked

        if (isset($_GET["SearchButton"])) {
          $Search=$_GET["Search"];
          $ViewQuery="SELECT * FROM admin_panel
          WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%'
          OR category LIKE '%$Search%' OR post LIKE '%$Search%' ORDER BY id desc";
        }
//Query For When Category Is Active
        elseif (isset($_GET["Category"])) {
          $Category=$_GET["Category"];
          $ViewQuery="SELECT * FROM admin_panel WHERE category='$Category' ORDER BY id desc";

        }
        //Query When Pagination is active i.e Blog.php?Page=1

        elseif(isset($_GET["Page"])) {
          $Page=$_GET["Page"];
          if ($Page==0||$Page<1){
            $ShowPostFrom=0;
          }else{
          $ShowPostFrom=($Page*5)-5;
          }
          $ViewQuery="SELECT * FROM admin_panel ORDER BY id desc LIMIT $ShowPostFrom,5";
        }
        //Default Query to extract Post From Database

        else {
        $ViewQuery="SELECT * FROM admin_panel ORDER BY id desc LIMIT 0,5"; }
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
        <img class="img-responsive img-rounded pull-left" src="Upload/<?php echo $Image; ?>" width="170px" height="170px">
        <div class="caption">
          <h1 id="heading"><?php echo htmlentities($Title); ?></h1>
          <p class="description">Category: <?php echo htmlentities($Category); ?> Published On <?php echo htmlentities($DateTime); ?>
            <?php
            $ConnectingDB;
            $QueryApproved="SELECT COUNT(*) FROM comments WHERE admin_panel_id='$PostId' AND status='ON'";
            $ExecuteApproved=mysql_query($QueryApproved);
            $RowsApproved=mysql_fetch_array($ExecuteApproved);
            $TotalApproved=array_shift($RowsApproved);
            if($TotalApproved>0){
            ?>
            <span class="badge pull-right">
            <span class="fa fa-comments"></span> &nbsp;Comments: <?php echo $TotalApproved; ?>
            </span>
            <?php } ?>
          </p>
          <p class="post"><?php
            if (strlen($Post)>150) {
              $Post=substr($Post,0,150).'...';
            }
          echo nl2br ($Post); ?> </p>
        </div>
        <a href="fullpost.php?id=<?php echo $PostId; ?>"><span class="btn btn-info">Read More &rsaquo;&rsaquo;</span></a>
      </div>
    <?php } ?>

    <!-- Pagination Code Starts Here-->

    <nav>
      <ul class="pagination pull-left pagination-lg">
        <!-- Backward Pagination button -->
        <?php
        if(isset($Page)){
          if ($Page>1) {
            ?>
            <li><a href="Blog.php?Page=<?php echo $Page-1; ?>">&laquo;</a></li>
          <?php }
        } ?>
    <?php
    global $ConnectingDB;
    $QueryPagination="SELECT COUNT(*) FROM admin_panel";
    $ExecutePagination=mysql_query($QueryPagination);
    $RowPagination=mysql_fetch_array($ExecutePagination);
    $TotalPosts=array_shift($RowPagination);
    //echo $TotalPosts;
    $PostPagination=$TotalPosts/5;
    $PostPagination=ceil($PostPagination);
    //echo $PostPerPage;

  for ($i=1; $i<=$PostPagination ; $i++) {
    if(isset($Page)){
      if($i==$Page){
    ?>
    <li class="active"><a href="Blog.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
      <?php
      }else { ?>
  <li><a href="Blog.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
  <?php
      }
  }
} ?>

<!-- Forward Pagination button -->
<?php
if(isset($Page)){
  if ($Page+1<=$PostPagination) {
    ?>
    <li><a href="Blog.php?Page=<?php echo $Page+1; ?>">&raquo;</a></li>
  <?php }
} ?>
      </ul>
    </nav>

<!-- Pagination Code Stops Here-->

    </div> <!-- Main Area Ending-->

  <div class="col-sm-offset-1 col-sm-3"> <!-- Side Area Starting-->
  <!-- Banner Ad Starts Here -->
    <!-- Start cutadlink banner code -->
<a href="https://cutadlink.com/FreakyVyky" target="_blank"><img src="//cutadlink.com/banner.png" title="Make short links and earn the biggest money" /></a>
<!-- End cutadlink banner code -->
    <br>
    <br>
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
    <a href="Blog.php?Category=<?php echo $Category; ?>">
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
<br>
<br>
    <h2>About Me</h2>
      <br>
      <img class="img-responsive img-circle imageicon" src="Images/VykyNaija.jpg" >
        <p>
          My name is Chibuikem Victor (AKA Vyky) and I am a full-time freelance web developer who specializes in creating dynamic and beautiful web pages. I have been in the field for nearly 4 years, and have been loving every minute of it. I am a blogger, entrepreneur, designer, developer, and overall thinker. Check out some of the links below to see what I’ve been up to lately.
        </p>

    </div> <!-- Side Area Ending-->
  </div> <!-- Row Ending-->

</div> <!-- Container Ending-->

<div id="footer">
  <hr><p>Theme By | Dev Vyky | &copy;2019 --- All Rights Reserved.</p>
  <a style="color: white; text-decoration: none; cursor: pointer; font-weight:bold;" href="http://vykynaija.com" target="_blank">
    <p>This site is a content of VykyNaija &trade;</p>
  </a>
</div>
<div style="height: 10px; background: #27AAE1;"></div>
</body>
</html>
