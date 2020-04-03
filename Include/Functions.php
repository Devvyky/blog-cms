<?php require_once ("Include/DB.php"); ?>
<?php require_once ("Include/Sessions.php"); ?>

<?php

function Redirect_to($New_Location){
  header("Location:".$New_Location);
  exit;
}

function Login_Attempt($Username,$Password){
  $ConnectingDB;
  $Query="SELECT * FROM registration
  WHERE username='$Username'";
  $Execute=mysql_query($Query);
  if ($admin=mysql_fetch_assoc($Execute)) {
    if (Password_Check($Password,$admin["password"])) {
        return $admin;
    }else {
    return null;
    }
  }
}

function Login(){
  if (isset($_SESSION["User_Id"]) || isset($_COOKIE["SettingEmail"])) {
    return true;
  }
}
function Confirm_Login(){
  if (!Login()) {
    $_SESSION["ErrorMessage"]="Login Required!";
    Redirect_to("Login.php");
  }
}
function Password_Encryption($Password) {
  $BlowFish_Hash_Format = "$2y$10$";
  $Salt_Length = 22;
  $Salt = Generate_Salt($Salt_Length);
  $Formating_Blowfish_With_Salt = $BlowFish_Hash_Format . $Salt;
  $Hash = crypt($Password, $Formating_Blowfish_With_Salt);
    return $Hash;
}
function Generate_Salt($length) {
  $Unique_Random_String = md5(uniqid(mt_rand(), true));
  $Base64_String = base64_encode($Unique_Random_String);

  $Modified_Base64_String = str_replace('+', '.', $Base64_String);
  $Salt = substr($Modified_Base64_String, 0, $length);
    return $Salt;
}
function Password_Check($Password, $Existing_Hash) {
  $Hash = crypt($Password, $Existing_Hash);
  if ($Hash === $Existing_Hash) {
    return true;
  }
  else {
    return false;
  }
}

function CheckIfEmailExistOrNot($Email){
  global $ConnectingDB;
  $Query = "SELECT * FROM registration WHERE email='$Email'";
  $Execute = mysql_query($Query);
  if(mysql_num_rows($Execute)>0){
    return true;
  }else {
    return false;
  }
}
function CheckIfUsernameExistOrNot($Username){
  global $ConnectingDB;
  $Query = "SELECT * FROM registration WHERE username='$Username'";
  $Execute = mysql_query($Query);
  if(mysql_num_rows($Execute)>0){
    return true;
  }else {
    return false;
  }
}
?>
