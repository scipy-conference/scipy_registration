<?php

if ($_SERVER['SERVER_NAME'] == "localhost")
{
  $db_name = "scipy";
  $connection = @mysql_connect("127.0.0.1","jri","tensai14") or die("Couldn't Connect.");
}
else
{
// TEST SITE
  $db_name = "polarbea_scipy";
  $connection = @mysql_connect("localhost","polarbea_web","tensai14") or die("Couldn't Connect.");
}

$db = @mysql_select_db($db_name, $connection) or die("Couldn't select database.");

?>