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
$sql_registrants .= "participants.id, ";
$sql_registrants .= "last_name, ";
$sql_registrants .= "first_name, ";
$sql_registrants .= "type, ";
$sql_registrants .= "ordernumber, ";
$sql_registrants .= "SUM(IF(session = \"Conference\",1,0)) AS conference, ";
$sql_registrants .= "SUM(IF(session = \"Tutorials\",1,0)) AS tutorials, ";
$sql_registrants .= "SUM(IF(session = \"Sprints\",1,0)) AS sprints, ";
$sql_registrants .= "SUM(IF(session = \"Women in Scientific Computing Luncheon\",1,0)) AS luncheon, ";
$sql_registrants .= "SUM(amt_paid) AS amt_paid, ";
$sql_registrants .= "type_abbr, ";
$sql_registrants .= "size, ";
$sql_registrants .= "DATE_FORMAT(registrations.created_at, '%b %d') AS `order date` ";
$sql_registrants .= "FROM registrations ";
$sql_registrants .= "LEFT JOIN participants ";
$sql_registrants .= "ON participant_id = participants.id ";
$sql_registrants .= "LEFT JOIN participant_types ";
$sql_registrants .= "ON participant_type_id = participant_types.id ";
$sql_registrants .= "LEFT JOIN tshirt_types ";
$sql_registrants .= "ON tshirt_type_id = tshirt_types.id ";
$sql_registrants .= "LEFT JOIN tshirt_sizes ";
$sql_registrants .= "ON tshirt_size_id = tshirt_sizes.id ";
$sql_registrants .= "LEFT JOIN registered_sessions ";
$sql_registrants .= "ON registration_id = registrations.id ";
$sql_registrants .= "LEFT JOIN sessions ";
$sql_registrants .= "ON session_id = sessions.id ";
$sql_registrants .= "WHERE registrations.conference_id = 3 ";
$sql_registrants .= "GROUP BY participants.id ";
$sql_registrants .= "ORDER BY registrations.created_at ASC";

$total_registrants = @mysql_query($sql_registrants, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_registrants = @mysql_num_rows($total_registrants);
$row_color=($row_count%2)?$row_1:$row_2;

do {
  if ($row['last_name'] != '')
  {

$display_registrants .="<tr class=$row_color>
    <td><a href=\"registrant_info.php?id=" . $row['id'] . "\">" . $row['last_name'] . ", " . $row['first_name'] . "</a></td>
    <td>" . $row['type'] . "<br />" . $row['ordernumber'] . "</td>";
    if ($row['conference'] == 1)
      {
        $display_registrants .="<td align=\"center\">&#x2713;</td>";
      }
      else
      {
        $display_registrants .="<td align=\"center\">&nbsp;</td>";
      }
    if ($row['tutorials'] == 1)
      {
        $display_registrants .="<td align=\"center\">&#x2713;</td>";
      }
      else
      {
        $display_registrants .="<td align=\"center\">&nbsp;</td>";
      }
    if ($row['sprints'] == 1)
      {
        $display_registrants .="<td align=\"center\">&#x2713;</td>";
      }
      else
      {
        $display_registrants .="<td align=\"center\">&nbsp;</td>";
      }
    if ($row['luncheon'] == 1)
      {
        $display_registrants .="<td align=\"center\">&#x2713;</td>";
      }
      else
      {
        $display_registrants .="<td align=\"center\">&nbsp;</td>";
      }
$display_registrants .="    <td align=\"right\">$&nbsp;" . $row['amt_paid'] . "</td>
    <td>" . $row['size'] . " " . $row['type_abbr'] . "</td>
    <td>" . $row['order date'] . "</td>
  </tr>";
  }

$row_color=($row_count%2)?$row_1:$row_2;
$row_count++;

$conf_sum = $conf_sum + $row['conference'];
$tut_sum = $tut_sum + $row['tutorials'];
$sprt_sum = $sprt_sum + $row['sprints'];
$wscl_sum = $wscl_sum + $row['luncheon'];
$amt_paid_sum = $amt_paid_sum + $row['amt_paid'];

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

<p>Registrants:</p>

<div align="right">
<p><a href="registrants_csv.php">Export to CSV (for Excel)</a></p>
</div>

<table id="registrants_table" class="schedule" width="650">
<tr>
  <th width="150">Participant Name</th>
  <th>Type / Ord #</th>
  <th>Conf</th>
  <th>Ttrls</th>
  <th>Sprnt</th>
  <th>WSCL</th>
  <th>Amt Paid</th>
  <th>Size</th>
  <th>Date</th>
</tr>
<?php echo $display_registrants ?>
<tr>
  <td colspan="2"><span class="bold">Totals</span></td>
  <td align="right"><span class="bold"><?php echo $conf_sum ?></span></td>
  <td align="right"><span class="bold"><?php echo $tut_sum ?></span></td>
  <td align="right"><span class="bold"><?php echo $sprt_sum ?></span></td>
  <td align="right"><span class="bold"><?php echo $wscl_sum ?></span></td>
  <td align="right"><span class="bold">$&nbsp;<?php echo number_format($amt_paid_sum,2) ?></span></td>
  <td colspan="2">&nbsp;</td>
</tr>
</table>


</section>



<div style="clear: both;"></div>
<footer id="page_footer">
<?php include('../inc/page_footer.php') ?>
</footer>
</div>
</body>

</html>