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

$id = $_GET['id'];

//===========================
//  pull discount
//===========================

$sql_discount = "SELECT ";
$sql_discount .= "id, ";
$sql_discount .= "code, ";
$sql_discount .= "discount, ";
$sql_discount .= "description, ";
$sql_discount .= "promotion_name, ";
$sql_discount .= "active_date, ";
$sql_discount .= "exp_date ";
$sql_discount .= "FROM promotion_codes ";
$sql_discount .= "WHERE id = \"$id\"";

$total_result_discount = @mysql_query($sql_discount, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
while($row = mysql_fetch_array($total_result_discount))
{

$id = $row['id'];
$code = $row['code'];
$discount = $row['discount'];
$description = $row['description'];
$promotion_name = $row['promotion_name'];
$active_date = $row['active_date'];
$exp_date = $row['exp_date'];

}


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

<p>Promotion Code:</p>

<form id="form_1" method="post" action="promo_action.php" >
id: <?php echo $id ?><input type="hidden" name="id" value="<?php echo $id ?>" /><br />
code: <input type="text" name="code" value="<?php echo $code ?>" /><br />
discount: <input type="text" name="discount" value="<?php echo $discount ?>" /><br />
description: <input type="text" name="description" value="<?php echo $description ?>" /><br />
promotion_name: <input type="text" name="promotion_name" value="<?php echo $promotion_name ?>" /><br />
active_date: <input type="text" name="active_date" value="<?php echo $active_date ?>" /><br />
exp_date: <input type="text" name="exp_date" value="<?php echo $exp_date ?>" /><br />

<div align="center">
  <input type="submit" name="submit" value="Update" />
</div>

</form>
</section>



<div style="clear: both;"></div>
<footer id="page_footer">
<?php include('../inc/page_footer.php') ?>
</footer>
</div>
</body>

</html>