<?php
date_default_timezone_set("Africa/Lagos");
$CurrentTime=time();
//$DateTime=strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);
$DateTime=strftime("%b-%m-%Y %H:%M:%S", $CurrentTime);
echo $DateTime;
?>
<br />
<br />
<?php
date_default_timezone_set("Africa/Lagos");
echo date("h:i:sa");
?>
<br />

<?php
date_default_timezone_set("Africa/Lagos");
$Time=date("h:i:sa");
echo $Time;

?>
<br />
<br />

<?php
date_default_timezone_set("Africa/Lagos");

echo "<p>" . date("M d, Y h:i a") . "</p>";
?>
