<?php

//$error = $_POST['error'];
$error = "The information entered was not valid, please try again. Fields are case sensitive.";

// Connect to server and select databse.
include('../inc/db_conn.php');
if ("none_required"=="none_required") {

$tbl_name = "admins";

// username and password sent from form 
$formusername=$_POST['username']; 
$formpassword=sha1($_POST['password']);


// To protect MySQL injection (more detail about MySQL injection)
$formusername = stripslashes($formusername);
$formpassword = stripslashes($formpassword);

$formusername = mysql_real_escape_string($formusername);
$formpassword = mysql_real_escape_string($formpassword);

// Search for user credentials
$sql="SELECT id, username FROM $tbl_name WHERE username='$formusername' and password='$formpassword'";
$result=mysql_query($sql);

while ($row = mysql_fetch_array($result)) {

$id=$row['id'];
$username=$row['username'];
}

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);
// If result matched $myusername and $mypassword, table row must be 1 row

if($count==1){
// Register $formusername, $formpassword
session_start();
$_SESSION['validate'] = "validated";
$_SESSION['formusername'] = $formusername;
$_SESSION['formpassword"'] = $formpassword;
setcookie("username",$username,0);

$sql_update ="UPDATE $tbl_name SET last_login=NOW() WHERE id=\"$id\"";

$result_update = @mysql_query($sql_update, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

// and redirect to appropriate page
if ($requested_url != "") 
{
header("Location:$requested_url");
}
else
{
header("Location:index.php");
}

}

else
{

session_start();
$_SESSION['errormessage'] = $error;

header("location:login.php");

}

}
?>