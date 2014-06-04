<?php
session_start();

$promotion_id = $_GET['promotion_id'];
$today = date("Y")."-".date("m")."-".date("d");

include('inc/db_conn.php');

//===========================
//  pull discount
//===========================

$sql_discount = "SELECT ";
$sql_discount .= "id, ";
$sql_discount .= "discount, ";
$sql_discount .= "promotion_name ";
$sql_discount .= "FROM promotion_codes ";
$sql_discount .= "WHERE code = \"$promotion_id\" ";
$sql_discount .= "AND active_date <= \"$today\" ";
$sql_discount .= "AND exp_date >= \"$today\"";

$total_result_discount = @mysql_query($sql_discount, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
while($row = mysql_fetch_array($total_result_discount))
{

$promotion_name = $row['promotion_name'];
$discount = $row['discount'];
$advtzd_discount = 100* (1 - $discount);
}



//===========================
//  pull sessions
//===========================

$sql_sessions = "SELECT ";
$sql_sessions .= "pricing.id AS price_id, ";
$sql_sessions .= "session, ";
$sql_sessions .= "session_id, ";
$sql_sessions .= "CONCAT(DATE_FORMAT(start_date, '%M %D'), \" - \", DATE_FORMAT(end_date, '%D')) AS `Dates`, ";
$sql_sessions .= "SUM(IF(type = \"Standard\", price,0)) AS Standard, ";
$sql_sessions .= "SUM(IF(type = \"Academic\", price,0)) AS Academic, ";
$sql_sessions .= "SUM(IF(type = \"Student\", price,0)) AS Student ";
$sql_sessions .= "FROM pricing ";
$sql_sessions .= "LEFT JOIN participant_types ";
$sql_sessions .= "ON participant_type_id = participant_types.id ";
$sql_sessions .= "LEFT JOIN sessions ON session_id = sessions.id ";
$sql_sessions .= "WHERE pricing.conference_id = 3 ";
// Do not display luncheon in with other sessions 
$sql_sessions .= "AND session_id != 10 ";
$sql_sessions .= "GROUP BY session ";
$sql_sessions .= "ORDER BY sessions.id ASC";

$total_result_sessions = @mysql_query($sql_sessions, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_sessions = @mysql_num_rows($total_result_sessions);

do {
  if ($row['session'] != '')
  {

$display_sessions .=    "
  <tr>
    <td><input name=\"session_id_" . $row['session_id'] . "\" type=\"checkbox\" ";
      if ($row['session'] == "Conference")
        {
        $display_sessions .="checked";
        }
      if ($row['session'] == "Tutorials")
        {
        $display_sessions .="onClick=\"tutorialDisplay()\"";
        }
$display_sessions .=" /></td>
    <td>" . $row['session'] . "";
      if ($row['session'] == "Sprints")
        {
        $display_sessions .="*";
        }
$display_sessions .="</td>
    <td>" . $row['Dates'] . "</td>";
      if ($row['session'] == "Conference" && $discount != "")
        {
          $display_sessions .="    <td align=\"right\"> $ " . $row['Standard']*$discount . "</td>
    <td align=\"right\"> $ " . $row['Academic']*$discount . "</td>
    <td align=\"right\"> $ " . $row['Student']*$discount . "</td>";
        }
    else 
            {
          $display_sessions .="    <td align=\"right\"> $ " . $row['Standard'] . "</td>
    <td align=\"right\"> $ " . $row['Academic'] . "</td>
    <td align=\"right\"> $ " . $row['Student'] . "</td>";
        }
$display_sessions .=" </tr>";
  }
}
while($row = mysql_fetch_array($total_result_sessions));

//===========================
//  pull participant types
//===========================

$sql_participants = "SELECT ";
$sql_participants .= "id, ";
$sql_participants .= "type ";
$sql_participants .= "FROM participant_types ";
$sql_participants .= "WHERE id IN (1,3,2) ";
$sql_participants .= "ORDER BY Field(id,1,3,2)";

$total_result_participants = @mysql_query($sql_participants, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_participants = @mysql_num_rows($total_result_participants);

do {
  if ($row['type'] != '')
  {

$display_participants .=    "
  <tr>
    <td><span><input class=\"validate[required] radio\" name=\"participant_type\" id=\"participant_type\" type=\"radio\" value=\"" . $row['id'] . "\" ";
$display_participants .="/></span></td>
    <td>" . $row['type'] . "</td>
  </tr>";
  }
}
while($row = mysql_fetch_array($total_result_participants));

//===========================
//  pull tshirt type
//===========================

$sql_types = "SELECT ";
$sql_types .= "id, ";
$sql_types .= "description ";
$sql_types .= "FROM tshirt_types ";
$sql_types .= "ORDER BY id ASC";

$total_result_types = @mysql_query($sql_types, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_types = @mysql_num_rows($total_result_types);

do {
  if ($row['description'] != '')
  {

if ($row['id'] == 1)
  {
    $display_type = "womens/fitted";
  }
if ($row['id'] == 2)
  {
    $display_type = "mens/unisex";
  }

$display_types .=    "

    <td><input class=\"validate[required] radio\" name=\"tshirt_type\" id=\"tshirt_type\" type=\"radio\" value=\"" . $row['id'] . "\"  ";
      if ($_POST['tshirt_type'] == $row['description'])
        {
          $display_types .="checked ";
        }
        
$display_types .="/>  $display_type  </td>
";
  }
}
while($row = mysql_fetch_array($total_result_types));


//===========================
//  pull tshirt sizes
//===========================

$sql_sizes = "SELECT ";
$sql_sizes .= "id, ";
$sql_sizes .= "size ";
$sql_sizes .= "FROM tshirt_sizes ";
$sql_sizes .= "ORDER BY id DESC";

$total_result_sizes = @mysql_query($sql_sizes, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_sizes = @mysql_num_rows($total_result_sizes);

do {
  if ($row['size'] != '')
  {

$display_sizes .=    "
  <tr>
    <td><input class=\"validate[required] radio\" name=\"tshirt_size\" id=\"tshirt_size\" type=\"radio\" value=\"" . $row['id'] . "\"  ";
      if ($_POST['tshirt_size'] == $row['size'])
        {
          $display_sizes .="checked ";
        }
        
$display_sizes .="/></td>
    <td>" . $row['size'] . "</td>
  </tr>";
  }
}
while($row = mysql_fetch_array($total_result_sizes));

//===========================
// Tutorials
//===========================

$sql_presenters = "SELECT ";
$sql_presenters .= "presenters.id AS presenter_id, ";
$sql_presenters .= "talks.id AS talk_id, ";
$sql_presenters .= "schedules.id AS schedule_id, ";
$sql_presenters .= "talks.presenter_id AS pi, ";
$sql_presenters .= "last_name, ";
$sql_presenters .= "first_name, ";
$sql_presenters .= "affiliation, ";
$sql_presenters .= "bio, ";
$sql_presenters .= "title, ";
$sql_presenters .= "track, ";
$sql_presenters .= "authors, ";
$sql_presenters .= "talks.description, ";
$sql_presenters .= "location_id, ";
$sql_presenters .= "start_time, ";
$sql_presenters .= "name, ";
$sql_presenters .= "DATE_FORMAT(start_time, '%h:%i %p') AS start_time_f, ";
$sql_presenters .= "DATE_FORMAT(end_time, '%h:%i %p') AS end_time_f, ";
$sql_presenters .= "DATE_FORMAT(start_time, '%W - %b %D') AS schedule_day, ";
$sql_presenters .= "DATE_FORMAT(start_time, '%m%d_%p') AS radio_attribute ";

$sql_presenters .= "FROM schedules ";

$sql_presenters .= "LEFT JOIN talks ";
$sql_presenters .= "ON schedules.talk_id = talks.id ";

$sql_presenters .= "LEFT JOIN locations ";
$sql_presenters .= "ON schedules.location_id = locations.id ";

$sql_presenters .= "LEFT JOIN presenters ";
$sql_presenters .= "ON presenter_id = presenters.id ";

$sql_presenters .= "LEFT JOIN license_types ";
$sql_presenters .= "ON license_type_id = license_types.id ";

$sql_presenters .= "WHERE talks.conference_id = 3 ";
$sql_presenters .= "AND track IN ('Introductory','Intermediate','Advanced','Topics') ";
$sql_presenters .= "ORDER BY start_time, FIELD(track,'Introductory','Intermediate','Advanced','Topics')";


$total_presenters = @mysql_query($sql_presenters, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_presenters_2 = @mysql_query($sql_presenters, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$last_start_time = '';
$last_schedule_day = '';

do {

if ($row['title'] != '')
  {
//
if ($row['schedule_day'] != $last_schedule_day) 
{
$display_block .="
<tr>
  <th colspan=\"5\">" . $row['schedule_day'] . "</th>
</tr>
  <tr>
    <th width=\"13%\">Time</th>
    <th width=\"22%\" style=\"background: #cadbeb;\">Introductory</th>
    <th width=\"22%\" style=\"background: #9fbdeb;\">Intermediate</th>
    <th width=\"22%\" style=\"background: #4f82c8;\">Advanced</th>
    <th width=\"22%\" style=\"background: #316fc6;\">Topics</th>
  </tr>";
$last_schedule_day = $row['schedule_day'];
}
//

  if ($row['start_time'] != $last_start_time) 
     {
       $display_block .="  <tr>
        <td>" . $row['start_time_f'] . " - " . $row['end_time_f'] . "</td>";
     }

    if ($row['track'] == 'Introductory')
      { 
//      if($row['talk_id'] == '109')
//        {
//        $display_block .="
//        <td>" . $row['title'] . " <span class=\"highlight\"><strong><em>- FULL&nbsp;</em></strong></span></td>";
//        $last_start_time = $row['start_time'];
//        }
//        else
//        {
        $display_block .="
        <td class=\"tutorial_selection\"><input class=\"validate[required] radio\" name=\"tutorial_" . $row['radio_attribute'] . "\" id=\"tutorial_" . $row['radio_attribute'] . "\" type=\"radio\" value=\"" . $row['talk_id'] . "\" />" . $row['title'] . "</td>";
        $last_start_time = $row['start_time'];
//        }
      }
   elseif ($row['track'] == 'Intermediate')
     { 
//      if($row['talk_id'] == '107')
//        {
//        $display_block .="
//        <td>" . $row['title'] . " <span class=\"highlight\"><strong><em>- FULL&nbsp;</em></strong></span></td>";
//        $last_start_time = $row['start_time'];
//        }
//        else
//        {
        $display_block .="
        <td class=\"tutorial_selection\"><input class=\"validate[required] radio\" name=\"tutorial_" . $row['radio_attribute'] . "\" id=\"tutorial_" . $row['radio_attribute'] . "\" type=\"radio\" value=\"" . $row['talk_id'] . "\" />" . $row['title'] . "</td>";
        $last_start_time = $row['start_time'];
//        }
   }
 elseif ($row['track'] == 'Advanced')
   { 
      if($row['talk_id'] == '102')
        {
        $display_block .="
        <td>" . $row['title'] . " <span class=\"highlight\"><strong><em>- FULL&nbsp;</em></strong></span></td>";
        $last_start_time = $row['start_time'];
        }
        else
        {
        $display_block .="
        <td class=\"tutorial_selection\"><input class=\"validate[required] radio\" name=\"tutorial_" . $row['radio_attribute'] . "\" id=\"tutorial_" . $row['radio_attribute'] . "\" type=\"radio\" value=\"" . $row['talk_id'] . "\" />" . $row['title'] . "</td>";
        $last_start_time = $row['start_time'];
        }
   }
 elseif ($row['track'] == 'Topics')
   { 
        $display_block .="
        <td class=\"tutorial_selection\"><input class=\"validate[required] radio\" name=\"tutorial_" . $row['radio_attribute'] . "\" id=\"tutorial_" . $row['radio_attribute'] . "\" type=\"radio\" value=\"" . $row['talk_id'] . "\" />" . $row['title'] . "</td>";
        $last_start_time = $row['start_time'];
   }
  else 
   {
$display_block .="
<td>---</td>";

   }
}
}

while ($row = mysql_fetch_array($total_presenters));

?>

<!DOCTYPE html>
<html>
<?php $thisPage="Register"; ?>
<head>

<?php include('inc/force_ssl.php') ?>


        <link rel="stylesheet" href="inc/validationEngine.jquery.css" type="text/css"/>
        <!-- <link rel="stylesheet" href="inc/template.css" type="text/css"/> -->
        <script src="inc/jquery-1.6.min.js" type="text/javascript">
        </script>
        <script src="inc/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8">
        </script>
        <script src="inc/jquery.validationEngine.js" type="text/javascript" charset="utf-8">
        </script>
        <script>
            jQuery(document).ready(function(){
                // binds form submission and fields to the validation engine
                jQuery("#formID").validationEngine();
            });
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

<p class="left">Register online using the form below. You may also register via phone at (512)536-1057. </p>

<form id="formID" class="formular" method="post" action="reg_p2.php">

<div class="form_row">
<h2> Session Selection</h2>

<?php 
  if ($promotion_name != "" && $promotion_id != "")
    {
      echo "<p class=\"highlight\">Conference pricing below reflects your $advtzd_discount% - $promotion_name promotional discount.</p>";
    }
  elseif ($promotion_name == "" && $promotion_id != "")
    {
      echo "<p class=\"highlight\">The discount code `$promotion_id` has expired.</p>";
    }

?>

<table class="schedule">
  <tr>
    <th colspan="2">Session </th>
    <th>Dates</th>
    <th><div align="right">Standard<br />Price</div></th>
    <th><div align="right">Academic<br />Price</div></th>
    <th><div align="right">Student<br />Price</div></th>
  </tr><?php echo $display_sessions ?>
  <tr>
    <td colspan="6"><p class="asterisk_text">*SciPy 2014 Sprints will be free of cost to everyone. However, for catering purposes, we would like to know whether you plan on attending.</p>
    <p class="asterisk_text">Refund Policy: 100% refund until Sunday, June 9th.  Effective Monday, June 10th we provide 50% and after Friday, June 21st there are no refunds.</p>
    </td>
</table>
</div>

<div id="tutorial_display">
<p>You have elected to attend tutorials, please indicate the tutorials you would like to attend</p>
<table  class="schedule">
<?php echo $display_block ?>
</table>
</div>

<div class="row">
<div class="cell">
<h2> Participant Level </h2>
<table align="center" width="250"  class="schedule">
<tr><th colspan="2">Level:</th></tr>
    <?php echo $display_participants ?>
</table>
<hr />
<h2> Women in Scientific Computing Luncheon </h2>
<div class="row">
  <div class="cell" style="width: 40%; padding: 0 0 0 0;">Speaker TBA</div>
  <div class="cell" style="width: 30%; float: right; padding: 0 0 0 0; text-align: right;">$ 10.00</div>
</div>
<div class="row">
  <div class="cell" style="width: 100%; font-size: 0.85em; padding: 0 0 0 0;">12:00PM Wed - July 9th,  El Mercado Restaurant</div>
</div>

<div style="clear: both; text-align: center;"><input name="session_id_10" type="checkbox">Yes</div>
</div>
<div class="cell">

<h2>T-Shirt Preference</h2>

<table align="center" width="250" class="schedule">
<tr><th colspan="2">Type:</th></tr>
    <?php echo $display_types ?>
</table>

<table align="center" width="250" class="schedule">
<tr><th colspan="2">Size:</th></tr>
    <?php echo $display_sizes ?>
</table>
<?php 
  if ($promotion_id != "")
    {
      echo "<input type=\"hidden\" name=\"promotion_id\" value=\"$promotion_id\" />";
    }
?>
</div>
</div>
<div style="clear:both;"></div>
<br />

<div align="center">
  <input type="submit" name="submit" value="next >>"/>
</div>


</form>
</section>
<div style="clear:both;"></div>
<footer id="page_footer">
<?php include('inc/page_footer.php') ?>
</footer>
</div>
</body>

</html>