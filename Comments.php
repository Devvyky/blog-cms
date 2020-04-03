<?php require_once ("Include/Sessions.php"); ?>
<?php require_once ("Include/Functions.php"); ?>
<?php require_once ("Include/DB.php"); ?>
<?php Confirm_Login(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/adminstyles.css"
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

        <a class="navbar-brand" href="blog.php"><img style="margin-top: -5px;" src="Images/logo.png" width="200"; height="30";></a>
      </div>
      <div class="collapse navbar-collapse" id="collapse">
        <ul class="nav navbar-nav">
          <li><a href="#">Home</a></li>
          <li class="active"><a href="blog.php" target="_blank">Blog</a></li>
          <li><a href="">About Us</a></li>
          <li><a href="">Services</a></li>
          <li><a href="">Contact Us</a></li>
          <li><a href="">Feature</a></li>
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

    <div class="container-fluid"> <!-- Starting Of Container Fluid -->
      <div class="row"> <!-- Starting Of Row -->
        <div class="col-sm-2"> <!-- Starting Of Side Area -->

<!-- Starting Of Admin NavBar -->
<br>
          <ul id="side_menu" class="nav nav-pills nav-stacked">
            <li><a href="dashboard.php"><i class="fa fa-th"></i>&nbsp;Dashboard</a></li>
            <li><a href="addnewpost.php"><i class="fa fa-newspaper"></i>&nbsp;Add New Post</a></li>
            <li><a href="Categories.php"><i class="fa fa-tags"></i>&nbsp;Categories</a></li>
            <li><a href="Admins.php"><i class="fa fa-user"></i>&nbsp;Manage Admins</a></li>
            <li><a href="AdminMessages.php"><i class="fa fa-envelope"></i>&nbsp;Admin Messages</a></li>
            <li class="active"><a href="Comments.php"><i class="fa fa-comment-alt"></i>&nbsp;Comments
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

<h1>Un-Approved Comments</h1> <!--Starting Of Un-Approved Comments-->

<div class="table table-responsive">
  <table class="table table-striped table-hover">
    <tr>
      <th>No.</th>
      <th>Name</th>
      <th>Date</th>
      <th>Comment</th>
      <th>Approve</th>
      <th>Delete Comment</th>
      <th>Details</th>
    </tr>
<?php
$ConnectingDB;
$Query="SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
$Execute=mysql_query($Query);
$SrNo=0;
while ($DataRows=mysql_fetch_array($Execute)) {
  $CommentId=$DataRows['id'];
  $DateOfComment=$DataRows['datetime'];
  $PersonName=$DataRows['name'];
  $PersonComment=$DataRows['comment'];
  $CommentedPostId=$DataRows['admin_panel_id'];
  $SrNo++;

  if (strlen($PersonName)>10) { $PersonName=substr($PersonName,0,10)."..."; }
?>

<tr>
  <td><?php echo htmlentities($SrNo); ?></td>
  <td style="color: #5e5eff;"><?php echo htmlentities($PersonName); ?></td>
  <td><?php echo htmlentities($DateOfComment); ?></td>
  <td><?php echo nl2br ($PersonComment); ?></td>
  <td><a href="ApproveComments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-success">Approve</span></a></td>
  <td><a href="DeleteComments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-danger">Delete</span></a></td>
  <td><a href="FullPost.php?id=<?php echo $CommentedPostId; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
</tr>

<?php } ?>

  </table>
</div>  <!--Ending Of Un-Approved Comments-->

<h1>Approved Comments</h1>  <!--Starting Of Approved Comments-->

<div class="table table-responsive">
  <table class="table table-striped table-hover">
    <tr>
      <th>No.</th>
      <th>Name</th>
      <th>Date</th>
      <th>Comment</th>
      <th>Approved By</th>
      <th>Revert Approve</th>
      <th>Delete Comment</th>
      <th>Details</th>
    </tr>
<?php
$ConnectingDB;
$Query="SELECT * FROM comments WHERE status='ON' ORDER BY id desc";
$Execute=mysql_query($Query);
$SrNo=0;
while ($DataRows=mysql_fetch_array($Execute)) {
  $CommentId=$DataRows['id'];
  $DateOfComment=$DataRows['datetime'];
  $PersonName=$DataRows['name'];
  $PersonComment=$DataRows['comment'];
  $ApprovedBy=$DataRows['approvedby'];
  $CommentedPostId=$DataRows['admin_panel_id'];
  $SrNo++;

if (strlen($PersonName)>10) { $PersonName=substr($PersonName,0,10)."..."; }

?>

<tr>
  <td><?php echo htmlentities($SrNo); ?></td>
  <td style="color: #5e5eff;"><?php echo htmlentities($PersonName); ?></td>
  <td><?php echo htmlentities($DateOfComment); ?></td>
  <td><?php echo nl2br ($PersonComment); ?></td>
  <td><?php echo htmlentities($ApprovedBy); ?></td>
  <td><a href="DisApproveComments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-warning">Dis-Approve</span></a></td>
  <td><a href="DeleteComments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-danger">Delete</span></a></td>
  <td><a href="FullPost.php?id=<?php echo $CommentedPostId; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
</tr>

<?php } ?>

  </table>
</div> <!--Ending of Approved Comments-->

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
