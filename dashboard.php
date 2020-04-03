<?php require_once ("Include/Sessions.php"); ?>
<?php require_once ("Include/Functions.php"); ?>
<?php require_once ("Include/DB.php"); ?>
<?php Confirm_Login(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta name="author" content="Dev Vyky">
    <meta name="description" content="">
    <meta http-equiv="refresh" content="120">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/adminstyles.css"
</head>

<body>
  <!-- Navigation Menu Starts Here-->
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

        <a class="navbar-brand" href="blog.php?Page=1" target="_blank"><img style="margin-top: -5px;" src="Images/logo.png" width="200"; height="30";></a>
      </div>
      <div class="collapse navbar-collapse" id="collapse">
        <ul class="nav navbar-nav">
          <li><a href="index.php?Page=1" target="_blank">Home <i class="fa fa-home"></i></a></li>
          <li class="active"><a href="blog.php?Page=1" target="_blank" >Blog <i class="fa fa-globe"></i></a></li>
          <li><a href="" target="_blank">Services <i class="fa fa-users"></i></a></li>
          <li><a href="" target="_blank">About Us <i class="fa fa-address-card"></i></a></li>
          <li><a href="ContactUs.php" target="_blank">Contact Us <i class="fa fa-id-card"></i></a></li>
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

<!-- Navigation Menu Stops Here-->

    <div class="container-fluid"> <!-- Starting Of Container Fluid -->
      <div class="row"> <!-- Starting Of Row -->
        <div class="col-sm-2"> <!-- Starting Of Side Area -->

<!-- Starting Of Admin NavBar -->
<br>
          <ul id="side_menu" class="nav nav-pills nav-stacked">
            <li class="active"><a href="dashboard.php"><i class="fa fa-th"></i>&nbsp;Dashboard</a></li>
            <li><a href="addnewpost.php"><i class="fa fa-newspaper"></i>&nbsp;Add New Post</a></li>
            <li><a href="Categories.php"><i class="fa fa-tags"></i>&nbsp;Categories</a></li>
            <li><a href="Admins.php"><i class="fa fa-user"></i>&nbsp;Manage Admins</a></li>
            <li><a href="AdminMessages.php"><i class="fa fa-envelope"></i>&nbsp;Admin Messages
              <?php
              $ConnectingDB;
              $QueryTotalUnRead="SELECT COUNT(*) FROM contact_us WHERE status='OFF'";
              $ExecuteTotalUnRead=mysql_query($QueryTotalUnRead);
              $RowsTotalUnRead=mysql_fetch_array($ExecuteTotalUnRead);
              $Total=array_shift($RowsTotalUnRead);
              if($Total>0){
              ?>
              <span class="label pull-right label-warning">
              <?php echo $Total; ?>
              </span>
              <?php } ?>
            </a></li>
            <li><a href="Comments.php"><i class="fa fa-comment-alt"></i>&nbsp;Comments
              <?php
              $ConnectingDB;
              $QueryTotalUnApproved="SELECT COUNT(*) FROM comments WHERE status='OFF'";
              $ExecuteTotalUnApproved=mysql_query($QueryTotalUnApproved);
              $RowsTotalUnApproved=mysql_fetch_array($ExecuteTotalUnApproved);
              $Total=array_shift($RowsTotalUnApproved);
              if($Total>0){
              ?>
              <span class="label pull-right label-warning">
              <?php echo $Total; ?>
              </span>
              <?php } ?>

            </a></li>
            <li><a href="blog.php?Page=1" target="_blank"><i class="fa fa-blog"></i>&nbsp;Live Blog</a></li>
            <li><a href="Logout.php"><i class="fa fa-sign-out-alt"></i>&nbsp;Logout</a></li>
          </ul>
<!-- Ending Of Admin NavBar -->
        </div> <!-- Ending Of Side Area -->

      <div class="col-sm-10"> <!-- Starting Of Main Area -->
<br>
        <div><?php echo Message();
                  echo SuccessMessage();
        ?>
      </div>

      <h1>Admin Dashboard</h1>

<div class="table-responsive">    <!-- Table To Extract Contents From The Database -->
  <table class="table table-striped table-hover">
          <tr>
            <th>No</th>
            <th>Post Title</th>
            <th>Date & Time</th>
            <th>Author</th>
            <th>Category</th>
            <th>Banner</th>
            <th>Comments</th>
            <th>Action</th>
            <th>Details</th>
          </tr>
<?php
$ConnectingDB;
$ViewQuery="SELECT * FROM admin_panel ORDER BY id desc;";
$Execute=mysql_query($ViewQuery);
$SrNo=0;
while ($DataRows=mysql_fetch_array($Execute)) {
  $Id=$DataRows["id"];
  $DateTime=$DataRows["datetime"];
  $Title=$DataRows["title"];
  $Category=$DataRows["category"];
  $Admin=$DataRows["author"];
  $Image=$DataRows["image"];
  $Post=$DataRows["post"];
  $Id=$DataRows["id"];
  $SrNo++;
?>
  <tr>
    <td><?php echo $SrNo; ?></td>
    <td style="color: #5e5eff;"><?php
    if (strlen($Title)>30) {
      $Title=substr($Title,0,30)."..." ;
    }
    echo $Title;
    ?></td>
    <td><?php
    if (strlen($DateTime)>11) {
      $DateTime=substr($DateTime,0,11)."...";
    }
    echo $DateTime;
    ?></td>
    <td><?php
    if (strlen($Admin)>7) {
      $Admin=substr($Admin,0,7)."..." ;
    }
    echo $Admin;
    ?></td>
    <td><?php
    if (strlen($Category)>8) {
      $Category=substr($Admin,0,8)."..." ;
    }
    echo $Category;
    ?></td>
    <td><img src="Upload/<?php echo $Image; ?>" width="150px" height="60"></td>
    <td>
      <?php
      $ConnectingDB;
      $QueryApproved="SELECT COUNT(*) FROM comments WHERE admin_panel_id='$Id' AND status='ON'";
      $ExecuteApproved=mysql_query($QueryApproved);
      $RowsApproved=mysql_fetch_array($ExecuteApproved);
      $TotalApproved=array_shift($RowsApproved);
      if($TotalApproved>0){
      ?>
      <span class="label pull-right label-success">
      <?php echo $TotalApproved; ?>
      </span>
    <?php } ?>

    <?php
    $ConnectingDB;
    $QueryUnApproved="SELECT COUNT(*) FROM comments WHERE admin_panel_id='$Id' AND status='OFF'";
    $ExecuteUnApproved=mysql_query($QueryUnApproved);
    $RowsUnApproved=mysql_fetch_array($ExecuteUnApproved);
    $TotalUnApproved=array_shift($RowsUnApproved);
    if($TotalUnApproved>0){
    ?>
    <span class="label label-danger">
    <?php echo $TotalUnApproved; ?>
    </span>
    <?php } ?>

    </td>
    <td>
      <a href="EditPost.php?Edit=<?php echo $Id; ?>"><span class="btn btn-warning">Edit</span></a>
      <a href="DeletePost.php?Delete=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a></td>
    <td><a href="Fullpost.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
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
