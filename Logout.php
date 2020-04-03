<?php require_once ("Include/Sessions.php"); ?>
<?php require_once ("Include/Functions.php"); ?>


<?php
$_SESSION["User_Id"]=null;
$ExpireTime = time()-60;
setcookie("SettingEmail",null, $ExpireTime);
session_destroy();
Redirect_to("login.php");

?>
