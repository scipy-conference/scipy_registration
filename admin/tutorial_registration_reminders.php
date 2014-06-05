<?php

//===============================================
//  USER AUTHORIZATION                         //
//===============================================
session_start();
if(!isset($_SESSION['formusername'])){
header("location:login.php");
}

//===============================================
// IF SUCCESSFUL PAGE CONTENT                  //
//===============================================

include('../inc/db_conn.php');

$index = 0;

$registered_tutorials = "SELECT last_name, ";
$registered_tutorials .= "first_name, ";
$registered_tutorials .= "email, ";
$registered_tutorials .= "ordernumber, ";
$registered_tutorials .= "sha1(ordernumber), ";
$registered_tutorials .= "registered_sessions.id  ";
$registered_tutorials .= "FROM registered_sessions  ";
$registered_tutorials .= "LEFT JOIN registrations ON registration_id = registrations.id  ";
$registered_tutorials .= "LEFT JOIN participants ON participant_id = participants.id  ";
$registered_tutorials .= "LEFT JOIN registered_tutorials ON registered_session_id = registered_sessions.id ";
$registered_tutorials .= "WHERE session_id = 7 ";
$registered_tutorials .= "AND registered_tutorials.talk_id IS NULL ";

$result_registered_tutorials = @mysql_query($registered_tutorials, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

$total_found = @mysql_num_rows($result_registered_tutorials);
while($row = mysql_fetch_array($result_registered_tutorials))
{

$last_name = $row['last_name'];
$first_name = $row['first_name'];
$email = $row['email'];
$ordernumber = $row['ordernumber'];
$reg_code = $row['sha1(ordernumber)'];
$index = $index + 1;
$display_block .="<tr>
<td align=right>$index</td>
<td><a href=\"https://conference.scipy.org/scipy_registration/tutorial_select.php?reg_code=$reg_code\">$first_name&nbsp;$last_name</a></td>
<td><a href=\"mailto:$email?subject=SciPy2014 Tutorial Registration Reminder&body=Hi $first_name,%0A%0A

Just a reminder - you are now able to self-select the tutorials you would like to attend at the following URL%0A%0A

https://conference.scipy.org/scipy_registration/tutorial_select.php?reg_code=$reg_code%0A%0A

If you have any difficulty with the form - or any other issues with the website, please let me know.%0A%0A

Jim Ivanoff\">$email</a></td>
<td>$ordernumber</td>
<td>$reg_code</a></td></tr>";
}


?>

<!DOCTYPE html>
<html>
<?php $thisPage="Admin"; ?>
<head>
<?php include('../inc/force_ssl.php') ?>

<?php @ require_once ("../inc/second_level_header.php"); ?>

<link rel="shortcut icon" href="http://conference.scipy.org/scipy2013/favicon.ico" />
</head>

<body>

<div id="container">

<?php include('../inc/admin_page_headers.php') ?>

<section id="main-content">

<h1>2014 Conference Registration</h1>

<form id="formID" class="formular" method="post" action="tutorial_save.php">

<div class="form_row">
<h2>Registered for Tutorials <?php echo $total_found ?></h2>

<p>The following have registered for tutorials but have not made selections.</p>
<table class="schedule">
<tr>
  <td></td>
  <td><div style="width: 180px">&nbsp;</div></td>
  <td colspan=3></td>
</tr>
<?php echo $display_block ?>
</table>

</form>
</section>
<div style="clear:both;"></div>
<footer id="page_footer">
<?php include('inc/page_footer.php') ?>
</footer>
</div>
</body>

</html>