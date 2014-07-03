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

//===========================
//  variables for totals
//===========================

$conf_sum = 0;
$tut_sum = 0;
$sprt_sum = 0;
$amt_paid_sum = 0;

$row_1="odd";
$row_2="even";
$row_count=1;

//===========================
//  pull total registered
//===========================


$sql_registrants = "SELECT ";
$sql_registrants .= "participant_id,  ";
$sql_registrants .= "first_name,  ";
$sql_registrants .= "last_name,  ";
$sql_registrants .= "email,  ";
$sql_registrants .= "title  ";
$sql_registrants .= "FROM registered_tutorials  ";
$sql_registrants .= "LEFT JOIN registered_sessions ON registered_session_id = registered_sessions.id  ";
$sql_registrants .= "LEFT JOIN registrations ON  registration_id = registrations.id  ";
$sql_registrants .= "LEFT JOIN sessions ON session_id = sessions.id  ";
$sql_registrants .= "LEFT JOIN participants ON participant_id = participants.id  ";
$sql_registrants .= "LEFT JOIN talks ON talk_id = talks.id  ";
$sql_registrants .= "WHERE registrations.conference_id = 3  ";
$sql_registrants .= "AND registered_sessions.session_id = 7  ";
$sql_registrants .= "ORDER BY title, last_name, first_name";


$total_registrants = @mysql_query($sql_registrants, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_registrants = @mysql_num_rows($total_registrants);
$row_color=($row_count%2)?$row_1:$row_2;
$index = 0;
$last_title = "";

do {
  if ($row['last_name'] != '')
  {
     if ($row['title'] != $last_title )
     {
$display_registrants .="<tr><th colspan=\"3\">" . $row['title'] . "</td></tr>";
$index = 1;
     }

$display_registrants .="<tr class=$row_color>
    <td> " . $index . "
    <td><a href=\"registrant_info.php?id=" . $row['id'] . "\">" . $row['last_name'] . ", " . $row['first_name'] ."</td>
    <td>" . $row['email'] . "</td>
  </tr>";
  }
$index = $index + 1;
$row_color=($row_count%2)?$row_1:$row_2;
$row_count++;
$last_title = $row['title'];

}
while($row = mysql_fetch_array($total_registrants));


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

<section id="sidebar">
  <?php include("../inc/sponsors.php") ?>
</section>

<section id="main-content">

<h1>Admin</h1>

<p>Tutorial Registrants:</p>

<div align="right">
<p><a href="tutotrial_registrants_csv.php">Export to CSV (for Excel)</a></p>
</div>

<table id="registrants_table" class="schedule" width="650">
<tr>
  <th width="150" colspan = "2">Participant Name</th>
  <th>email</th>
</tr>
<?php echo $display_registrants ?>
</table>


</section>



<div style="clear: both;"></div>
<footer id="page_footer">
<?php include('../inc/page_footer.php') ?>
</footer>
</div>
</body>

</html>