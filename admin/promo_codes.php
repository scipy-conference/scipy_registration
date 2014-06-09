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
//  pull discount
//===========================

$sql_discount = "SELECT ";
$sql_discount .= "id, ";
$sql_discount .= "code, ";
$sql_discount .= "discount, ";
$sql_discount .= "description, ";
$sql_discount .= "promotion_name, ";
$sql_discount .= "DATE_FORMAT(active_date, '%b %d') AS active, ";
$sql_discount .= "DATE_FORMAT(exp_date, '%b %d') AS expires ";
$sql_discount .= "FROM promotion_codes ";
$sql_discount .= "WHERE conference_id = 3";

$total_result_discount = @mysql_query($sql_discount, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_discounts = @mysql_num_rows($total_result_discount);
$row_color=($row_count%2)?$row_1:$row_2;

do {
  if ($row['promotion_name'] != '')
  {

$display_promotions .="<tr class=$row_color>
    <td><a href=\"promo_info.php?id=" . $row['id'] . "\">" . $row['promotion_name'] . "</a></td>
    <td>" . $row['code'] . "</td>
    <td align=\"right\"> " . $row['discount'] . "</td>
    <td>" . $row['description'] . "</td>
    <td>" . $row['active'] . "</td>
    <td>" . $row['expires'] . "</td>
  </tr>";
  }

$row_color=($row_count%2)?$row_1:$row_2;
$row_count++;

}
while($row = mysql_fetch_array($total_result_discount));


?>

<!DOCTYPE html>
<html>
<?php $thisPage="Admin"; ?>
<head>

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

<p>Promotion Codes:</p>

<table class="schedule" width="600">
<tr>
  <th width="75">Name</th>
  <th>Code</th>
  <th>Discount</th>
  <th>Description</th>
  <th>Active</th>
  <th>Expires</th>
</tr>
<?php echo $display_promotions ?>
</table>


</section>



<div style="clear: both;"></div>
<footer id="page_footer">
<?php include('../inc/page_footer.php') ?>
</footer>
</div>
</body>

</html>