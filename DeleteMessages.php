<?php require_once ("Include/Sessions.php"); ?>
<?php require_once ("Include/Functions.php"); ?>
<?php require_once ("Include/DB.php"); ?>

<?php
if (isset($_GET["id"])) {
  $IdFromURL=$_GET["id"];
  $ConnectingDB;
  $Query="DELETE FROM contact_us WHERE id='$IdFromURL' ";
  $Execute=mysql_query($Query);
  if ($Execute) {
    $_SESSION["SuccessMessage"]="Message Deleted Successully";
    Redirect_to("AdminMessages.php");
  }else {
    $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again!";
    Redirect_to("AdminMessages.php");
  }
}
?>
