<?php require_once ("Include/DB.php"); ?>
<?php require_once ("Include/Sessions.php"); ?>
<?php require_once ("Include/Functions.php"); ?>
<?php Confirm_Login(); ?>

<?php
if (isset($_POST["Submit"])) {
  $Title=mysql_real_escape_string($_POST["Title"]);
  $Tags=mysql_real_escape_string($_POST["Tags"]);
  $Description=mysql_real_escape_string($_POST["Description"]);
  $Category=mysql_real_escape_string($_POST["Category"]);
  $Post=mysql_real_escape_string($_POST["Post"]);

  date_default_timezone_set("Africa/Lagos");
  $CurrentTime=time();
  //$DateTime=strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);
  $DateTime=strftime("%b-%m-%Y %H:%M:%S", $CurrentTime);
  //echo "$DateTime";

$Admin=$_SESSION["Username"];
$Image=$_FILES["Image"]["name"];
$Target="Upload/".basename($_FILES["Image"]["name"]);

if (empty($Title)) {
    $_SESSION["ErrorMessage"]="Title Can't Be Empty";
    //Redirect_to("addnewpost.php");
}elseif (strlen($Title)<2) {
    $_SESSION["ErrorMessage"]="Title Should Be At Least 2 Characters";
    //Redirect_to("addnewpost.php");
}else {
    global $ConnectingDB;
    $Query="INSERT INTO admin_panel(datetime,title,tags,description,category,author,image,post)
    VALUES('$DateTime','$Title','$Tags','$Description','$Category','$Admin','$Image','$Post')";
    $Execute=mysql_query($Query);
    move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
    if ($Execute) {
      $_SESSION["SuccessMessage"]="Post Added Successully";
      //Redirect_to("addnewpost.php");
    }else {
      $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again!";
      //Redirect_to("addnewpost.php");
    }
  }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Post</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/adminstyles.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!--<script src="js/ckeditor.js"></script>-->
    <script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>

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
            <li class="active"><a href="addnewpost.php"><i class="fa fa-newspaper"></i>&nbsp;Add New Post</a></li>
            <li><a href="Categories.php"><i class="fa fa-tags"></i>&nbsp;Categories</a></li>
            <li><a href="Admins.php"><i class="fa fa-user"></i>&nbsp;Manage Admins</a></li>
            <li><a href="AdminMessages.php"><i class="fa fa-envelope"></i>&nbsp;Admin Messages</a></li>
            <li><a href="Comments.php"><i class="fa fa-comment-alt"></i>&nbsp;Comments
            <li><a href="blog.php?Page=1" target="_blank"><i class="fa fa-blog"></i>&nbsp;Live Blog</a></li>
            <li><a href="Logout.php"><i class="fa fa-sign-out-alt"></i>&nbsp;Logout</a></li>
          </ul>
<!-- Ending Of Admin NavBar -->
        </div> <!-- Ending Of Side Area -->

      <div class="col-sm-10"> <!-- Starting Of Main Area -->

        <h1>Add New Post</h1>
        <div><?php echo Message();
                  echo SuccessMessage();
        ?>
      </div>
<div>
  <form action="addnewpost.php" method="post" enctype="multipart/form-data">
    <fieldset>

      <div class="form-group">
      <label for="Title"><span class="FieldInfo">Title:</span></label>
      <input class="form-control" type="text" name="Title" id="title" placeholder="Title">
      </div>

      <div class="form-group">
      <label for="Tags"><span class="FieldInfo">Tags:</span></label>
      <input class="form-control" type="text" name="Tags" id="Tags" placeholder="Tags">
      </div>

      <div class="form-group">
      <label for="Description"><span class="FieldInfo">Description:</span></label>
      <input class="form-control" type="text" name="Description" id="Description" placeholder="Description">
      </div>

      <div class="form-group">
      <label for="categoryselect"><span class="FieldInfo">Category:</span></label>
      <select class="form-control" id="categoryselect" name="Category">
        <?php
        global $ConnectingDB;
        $ViewQuery="SELECT * FROM category ORDER BY datetime desc";
        $Execute=mysql_query($ViewQuery);
        while ($DataRows=mysql_fetch_array($Execute)) {
          $Id=$DataRows["id"];
          $CategoryName=$DataRows["name"];
        ?>
          <option><?php echo $CategoryName; ?></option>
        <?php } ?>
      </select>
      </div>

      <div class="form-group">
        <label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
        <input type="file" class="form-control" name="Image" id="imageselect">
      </div>

      <div class="form-group">
        <label for="postarea"><span class="FieldInfo">Post:</span></label>

        <textarea class="form-control" name="Post" id="postarea" rows="10" cols="80"></textarea>
        <script>
                        CKEDITOR.replace( 'postarea' );
        </script>
      </div>
      <br>
      <input class="btn btn-success btn-block" type="submit" name="Submit" value="Add New Post">
      <br>
    </fieldset>


  </form>
</div>



      </div>  <!-- Ending  Of Main Area -->
    </div> <!-- Ending Of Row -->
  </div> <!-- Ending Of Container Fluid -->
<!-- Starting Of Footer -->
  <div id="footer">
    <hr><p>Theme By | Vyky Naija | &copy;2019 --- All Rights Reserved.</p>
    <a style="color: white; text-decoration: none; cursor: pointer; font-weight:bold;" href="https://devvyky.com" target="_blank">
      <p>This site is a content of Dev Vyky &trade;</p>
    </a>
  </div>
  <div style="height: 10px; background: #27AAE1;"></div>
</body>
</html>
