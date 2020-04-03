<?php require_once ("Include/DB.php"); ?>
<?php require_once ("Include/Sessions.php"); ?>
<?php require_once ("Include/Functions.php"); ?>
<?php Confirm_Login(); ?>
<?php
if (isset($_POST["Submit"])) {
  $Category=mysql_real_escape_string($_POST["Category"]);

  date_default_timezone_set("Africa/Lagos");
  $CurrentTime=time();
  //$DateTime=strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);
  $DateTime=strftime("%b-%m-%Y %H:%M:%S", $CurrentTime);
  //echo "$DateTime";
$Admin=$_SESSION["Username"];
if (empty($Category)) {
    $_SESSION["ErrorMessage"]="All Fields Must Be Filled Out";
    //Redirect_to("Categories.php");
}elseif (strlen($Category)>99) {
    $_SESSION["ErrorMessage"]="Too Long Name For Category";
    //Redirect_to("Categories.php");
}else {
    global $ConnectingDB;
    $Query="INSERT INTO category(datetime,name,creatorname)
    VALUES('$DateTime','$Category','$Admin')";
    $Execute=mysql_query($Query);
    if ($Execute) {
      $_SESSION["SuccessMessage"]="Category Added Successully";
      //Redirect_to("Categories.php");
    }else {
      $_SESSION["ErrorMessage"]="Category Failed To Add";
      //Redirect_to("Categories.php");
    }
  }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Category</title>
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
            <li class="active"><a href="Categories.php"><i class="fa fa-tags"></i>&nbsp;Categories</a></li>
            <li><a href="Admins.php"><i class="fa fa-user"></i>&nbsp;Manage Admins</a></li>
            <li><a href="AdminMessages.php"><i class="fa fa-envelope"></i>&nbsp;Admin Messages</a></li>
            <li><a href="Comments.php"><i class="fa fa-comment-alt"></i>&nbsp;Comments
            <li><a href="blog.php?Page=1" target="_blank"><i class="fa fa-blog"></i>&nbsp;Live Blog</a></li>
            <li><a href="Logout.php"><i class="fa fa-sign-out-alt"></i>&nbsp;Logout</a></li>
          </ul>
<!-- Ending Of Admin NavBar -->
        </div> <!-- Ending Of Side Area -->

      <div class="col-sm-10"> <!-- Starting Of Main Area -->

        <h1>Manage Categories</h1>
        <div><?php echo Message();
                  echo SuccessMessage();
        ?>
      </div>
<div>
  <form action="Categories.php" method="post">
    <fieldset>
      <div class="form-group">
      <label for="categoryname"><span class="FieldInfo">Name:</span></label>
      <input class="form-control" type="text" name="Category" id="categoryname" placeholder="Name">
      </div>
      <br>
      <input class="btn btn-success btn-block" type="submit" name="Submit" value="Add New Category">
      <br>
    </fieldset>


  </form>
</div>

<div class="table-responsive">
  <table class="table table-striped table-hover">
    <tr>
      <th>Sr No.</th>
      <th>Date & Time</th>
      <th>Category Name</th>
      <th>Creator Name</th>
      <th>Action</th>
    </tr>
<?php
global $ConnectingDB;
$ViewQuery="SELECT * FROM category ORDER BY id desc";
$Execute=mysql_query($ViewQuery);
$SrNo=0;
while ($DataRows=mysql_fetch_array($Execute)) {
  $Id=$DataRows["id"];
  $DateTime=$DataRows["datetime"];
  $CategoryName=$DataRows["name"];
  $CreatorName=$DataRows["creatorname"];
  $SrNo++;
?>

<tr>
  <td><?php echo $SrNo; ?></td>
  <td><?php echo $DateTime; ?></td>
  <td><?php echo $CategoryName; ?></td>
  <td><?php echo $CreatorName; ?></td>
  <td><a href="DeleteCategory.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a></td>
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
