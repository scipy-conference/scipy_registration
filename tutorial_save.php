<?php 

$registered_session_id = $_POST['registered_session_id'];

include('inc/db_conn.php');

//==========================
// Check for already registered
//==========================

$sql_check = "SELECT id ";
$sql_check .= "FROM registered_tutorials ";
$sql_check .= "WHERE registered_session_id = \"$registered_session_id\"";

$total_check = @mysql_query($sql_check, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_check = @mysql_num_rows($total_check);

if ($total_found_check > 0)

	{
	$display_block .="<p>You have already registered for tuotrials. If you would like to change your selection(s) please call (512) 536-1057.</p>";
	}
else
    {

//==========================
// record registered tutorials
//==========================


$tutorial_0706_AM = $_POST['tutorial_0706_AM'];
$tutorial_0706_PM = $_POST['tutorial_0706_PM'];
$tutorial_0707_AM = $_POST['tutorial_0707_AM'];
$tutorial_0707_PM = $_POST['tutorial_0707_PM'];

if ($tutorial_0706_AM != "")
  {
    $selected_tutorials[0] = $tutorial_0706_AM;
  }
if ($tutorial_0706_PM != "")
  {
    $selected_tutorials[1] = $tutorial_0706_PM;
  }
if ($tutorial_0707_AM != "")
  {
    $selected_tutorials[2] = $tutorial_0707_AM;
  }
if ($tutorial_0707_PM != "")
  {
    $selected_tutorials[3] = $tutorial_0707_PM;
  }

foreach ($selected_tutorials as $key =>$value)

{
$sql_register_tutorials = "INSERT INTO registered_tutorials ";
$sql_register_tutorials .= "(registered_session_id, ";
$sql_register_tutorials .= "talk_id, ";
$sql_register_tutorials .= "created_at, ";
$sql_register_tutorials .= "updated_at) ";
$sql_register_tutorials .= "VALUES ";
$sql_register_tutorials .= "(\"$registered_session_id\", ";
$sql_register_tutorials .= "\"$value\", ";
$sql_register_tutorials .= "NOW(), ";
$sql_register_tutorials .= "NOW())";

$result_register_tutorials = @mysql_query($sql_register_tutorials, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
}

$display_block .="<p>The following tutorials have been recorded.</p>
<ul>";

$sql_registered_tutorials = "SELECT ";
$sql_registered_tutorials .= "title, ";
$sql_registered_tutorials .= "track, ";
$sql_registered_tutorials .= "DATE_FORMAT(start_time, '%W - %b %D %h:%i %p' ) AS date_time ";
$sql_registered_tutorials .= "FROM registered_tutorials ";
$sql_registered_tutorials .= "LEFT JOIN talks ON registered_tutorials.talk_id = talks.id ";
$sql_registered_tutorials .= "LEFT JOIN schedules ON schedules.talk_id = talks.id ";
$sql_registered_tutorials .= "WHERE registered_session_id = \"$registered_session_id\"";

$total_registered_tutorials = @mysql_query($sql_registered_tutorials, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
do {
if ($row['title'] != '')
  {
$display_block .="<li>" . $row['track'] . " - <strong>" . $row['title'] . "</strong> | <em>" . $row['date_time'] .  "</em></li>";
}
}
while($row = mysql_fetch_array($total_registered_tutorials));
$display_block .="</ul><br />
<p>Look forward to seeing you there!</p>";


}

?>

<!DOCTYPE html>
<html>
<?php $thisPage="Register"; ?>
<head>

<?php include('inc/force_ssl.php') ?>


</script>

<?php include('inc/header.php') ?>

</head>

<body>

<div id="container">

<?php include('inc/page_headers.php') ?>

<section id="sidebar">
&nbsp;
</section>


<section id="main-content">

<h1>2014 Conference Registration</h1>

<form id="formID" class="formular" method="post" action="tutorial_save.php">

<div class="form_row">
<h2>Tutorial Selection</h2>

<?php echo $display_block ?>


</form>
</section>
<div style="clear:both;"></div>
<footer id="page_footer">
<?php include('inc/page_footer.php') ?>
</footer>
</div>
</body>

</html>