<?php require_once ("Include/DB.php"); ?>
<?php require_once ("Include/Sessions.php"); ?>
<?php require_once ("Include/Functions.php"); ?>
<?php Confirm_Login(); ?>
<?php
if (isset($_POST["Submit"])) {
  $Title=mysql_real_escape_string($_POST["Title"]);
  $Category=mysql_real_escape_string($_POST["Category"]);
  $Post=mysql_real_escape_string($_POST["Post"]);


  date_default_timezone_set("Africa/Lagos");
  $CurrentTime=time();
  //$DateTime=strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);
  $DateTime=strftime("%b-%m-%Y %H:%M:%S", $CurrentTime);
  echo "$DateTime";

$Admin="Vyky";
$Image=$_FILES["Image"]["name"];
$Target="Upload/".basename($_FILES["Image"]["name"]);

    global $ConnectingDB;
    $DeleteFromUrl=$_GET['Delete'];
    $Query="DELETE FROM admin_panel WHERE id='$DeleteFromUrl'";

    $Execute=mysql_query($Query);
    move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
    if ($Execute) {
      $_SESSION["SuccessMessage"]="Post Deleted Successully";
      Redirect_to("Dashboard.php");
    }else {
      $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again!";
      Redirect_to("Dashboard.php");
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Post</title>
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
    <div class="container-fluid"> <!-- Starting Of Container Fluid -->
      <div class="row"> <!-- Starting Of Row -->
        <div class="col-sm-2"> <!-- Starting Of Side Area -->

<!-- Starting Of Admin NavBar -->
          <ul id="side_menu" class="nav nav-pills nav-stacked">
            <li><a href="dashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a></li>
            <li class="active"><a href="addnewpost.php"><span class="glyphicon glyphicon-list-alt">&nbsp;Add New Post</a></li>
            <li><a href="Categories.php"><span class="glyphicon glyphicon-tags">&nbsp;Categories</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-user">&nbsp;Manage Admins</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-comment">&nbsp;Comments</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-equalizer">&nbsp;Live Blog</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-log-out">&nbsp;Logout</a></li>
          </ul>
<!-- Ending Of Admin NavBar -->
        </div> <!-- Ending Of Side Area -->

      <div class="col-sm-10"> <!-- Starting Of Main Area -->

        <h1>Delete Post</h1>
        <div><?php echo Message();
                  echo SuccessMessage();
        ?>
      </div>
<div>
    <?php
      $SearchQueryParameter=$_GET['Delete'];
      $ConnectingDB;
      $Query="SELECT * FROM admin_panel WHERE id='$SearchQueryParameter' ";
      $ExecuteQuery=mysql_query($Query);
      while ($DataRows=mysql_fetch_array($ExecuteQuery)) {
        $TitleToBeUpdated=$DataRows['title'];
        $CategoryToBeUpdated=$DataRows['category'];
        $ImageToBeUpdated=$DataRows['image'];
        $PostToBeUpdated=$DataRows['post'];
      }
    ?>
  <form action="DeletePost.php?Delete=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
    <fieldset>

      <div class="form-group">
      <label for="Title"><span class="FieldInfo">Title:</span></label>
      <input disabled value="<?php echo $TitleToBeUpdated; ?>" class="form-control" type="text" name="Title" id="title" placeholder="Title">
      </div>

      <div class="form-group">
        <span class="FieldInfo">Existing Category:</span>
        <?php echo $CategoryToBeUpdated; ?> <br />
      <label for="categoryselect"><span class="FieldInfo">Category:</span></label>
      <select disabled class="form-control" id="categoryselect" name="Category">
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
        <span class="FieldInfo">Existing Image:</span>
        <img src="Upload/<?php echo $ImageToBeUpdated; ?>" width="150px" height="60px" > <br />
        <label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
        <input disabled type="file" class="form-control" name="Image" id="imageselect">
      </div>

      <div class="form-group">
        <label for="postarea"><span class="FieldInfo">Post:</span></label>
        <textarea disabled class="form-control" name="Post" id="postarea"><?php echo $PostToBeUpdated; ?></textarea>
      </div>

      <br>
      <input class="btn btn-danger btn-block" type="submit" name="Submit" value="Delete Post">
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
    <a style="color: white; text-decoration: none; cursor: pointer; font-weight:bold;" href="http://vykynaija.com" target="_blank">
      <p>This site is a content of VykyNaija &trade;</p>
    </a>
  </div>
  <div style="height: 10px; background: #27AAE1;"></div>
</body>
</html>
