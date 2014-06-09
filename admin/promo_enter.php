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

code: <input type="text" name="code" value="" placeholder="e.g. SciPy-OReilly" /><br />
discount: <input type="text" name="discount" value="" placeholder="0.85 - for 15% Discount" /><br />
description: <input type="text" name="description" value="" placeholder="e.g. O'Reilly 15% Discount" /><br />
promotion_name: <input type="text" name="promotion_name" value="" placeholder="e.g. O'Reilly" /><br />
active_date: <input type="text" name="active_date" value="" placeholder="2014-06-15" /><br />
exp_date: <input type="text" name="exp_date" value="" placeholder="2014-06-22" /><br />

<div align="center">
  <input type="submit" name="submit" value="Enter" />
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