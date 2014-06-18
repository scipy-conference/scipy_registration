<?php
session_start();

include('inc/db_conn.php');

$tutorials_selected = 0;

$reg_code = $_GET['reg_code'];

$sql_participant = "SELECT ";
$sql_participant .= "last_name, ";
$sql_participant .= "first_name, ";
$sql_participant .= "participant_id, ";
$sql_participant .= "registered_sessions.id AS 'registered_session_id'";
$sql_participant .= "FROM registered_sessions ";
$sql_participant .= "LEFT JOIN registrations ON registration_id = registrations.id ";
$sql_participant .= "LEFT JOIN participants ON participant_id = participants.id ";
$sql_participant .= "WHERE sha1(ordernumber) = \"$reg_code\" ";
$sql_participant .= "AND session_id = 7";

$total_participant = @mysql_query($sql_participant, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
while($row = mysql_fetch_array($total_participant))
{

$participant_id = $row['participant_id'];
$last_name = $row['last_name'];
$first_name = $row['first_name'];
$registered_session_id = $row['registered_session_id'];
}

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
$sql_presenters .= "locations.description, ";
$sql_presenters .= "location_id, ";
$sql_presenters .= "start_time, ";
$sql_presenters .= "name, ";
$sql_presenters .= "COUNT(registered_tutorials.talk_id) AS `qty`, ";
$sql_presenters .= "DATE_FORMAT(start_time, '%h:%i %p') AS start_time_f, ";
$sql_presenters .= "DATE_FORMAT(end_time, '%h:%i %p') AS end_time_f, ";
$sql_presenters .= "DATE_FORMAT(start_time, '%W - %b %D') AS schedule_day, ";
$sql_presenters .= "DATE_FORMAT(start_time, '%m%d_%p') AS radio_attribute ";

$sql_presenters .= "FROM schedules ";

$sql_presenters .= "LEFT JOIN talks ";
$sql_presenters .= "ON schedules.talk_id = talks.id ";

$sql_presenters .= "LEFT JOIN registered_tutorials  ";
$sql_presenters .= "ON registered_tutorials.talk_id = talks.id  ";

$sql_presenters .= "LEFT JOIN locations ";
$sql_presenters .= "ON schedules.location_id = locations.id ";

$sql_presenters .= "LEFT JOIN presenters ";
$sql_presenters .= "ON presenter_id = presenters.id ";

$sql_presenters .= "LEFT JOIN license_types ";
$sql_presenters .= "ON license_type_id = license_types.id ";

$sql_presenters .= "WHERE talks.conference_id = 3 ";
$sql_presenters .= "AND track IN ('Introductory','Intermediate','Advanced','Topics') ";
$sql_presenters .= "GROUP BY talks.id ";
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
      if($row['qty'] > 59)
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
   elseif ($row['track'] == 'Intermediate')
     { 
      if($row['qty'] > 62)
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
 elseif ($row['track'] == 'Advanced')
   { 
      if($row['qty'] > 61)
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
      if($row['qty'] > 59)
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
  else 
   {
$display_block .="
<td>---</td>";

   }
}
}

while ($row = mysql_fetch_array($total_presenters));

//===========================
//  pull total registered
//===========================

$sql_registrants = "SELECT ";
$sql_registrants .= "registrations.id, ";
$sql_registrants .= "participants.last_name, ";
$sql_registrants .= "participants.first_name, ";
$sql_registrants .= "affiliation, ";
$sql_registrants .= "email, ";
$sql_registrants .= "participants.address1, ";
$sql_registrants .= "participants.address2, ";
$sql_registrants .= "participants.city, ";
$sql_registrants .= "participants.state, ";
$sql_registrants .= "participants.postal_code, ";
$sql_registrants .= "participants.country, ";
$sql_registrants .= "DATE_FORMAT(registrations.created_at, '%b %d') AS reg_date, ";
$sql_registrants .= "type, ";
$sql_registrants .= "phone ";
$sql_registrants .= "FROM registrations ";
$sql_registrants .= "LEFT JOIN participants ";
$sql_registrants .= "ON registrations.participant_id = participants.id ";
$sql_registrants .= "LEFT JOIN participant_types ";
$sql_registrants .= "ON participant_type_id = participant_types.id ";
$sql_registrants .= "LEFT JOIN billings ";
$sql_registrants .= "ON registrations.participant_id = participants.id ";
$sql_registrants .= "WHERE registrations.participant_id = \"$participant_id\" ";
$sql_registrants .= "AND registrations.conference_id = 3";


$total_registrants = @mysql_query($sql_registrants, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
while($row = mysql_fetch_array($total_registrants))
{

$registration_id = $row['id'];
$last_name = $row['last_name'];
$first_name = $row['first_name'];
$affiliation = $row['affiliation'];
$email = $row['email'];
$address1 = $row['address1'];
$address2 = $row['address2'];
$city = $row['city'];
$state = $row['state'];
$postal_code = $row['postal_code'];
$country = strtoupper($row['country']);
$reg_date = $row['reg_date'];
$type = $row['type'];
$phone = $row['phone'];
}

$sql_sessions = "SELECT ";
$sql_sessions .= "session, ";
$sql_sessions .= "amt_paid, ";
$sql_sessions .= "talk_id, ";
$sql_sessions .= "title ";
$sql_sessions .= "FROM registered_sessions ";
$sql_sessions .= "LEFT JOIN sessions ";
$sql_sessions .= "ON session_id = sessions.id ";
$sql_sessions .= "LEFT JOIN registrations ";
$sql_sessions .= "ON registration_id = registrations.id ";
$sql_sessions .= "LEFT JOIN registered_tutorials ";
$sql_sessions .= "ON registered_session_id = registered_sessions.id ";
$sql_sessions .= "LEFT JOIN talks ";
$sql_sessions .= "ON talk_id = talks.id ";
$sql_sessions .= "WHERE participant_id = $participant_id ";
$sql_sessions .= "AND registrations.conference_id = 3 ";
$sql_sessions .= "ORDER BY session_id";

$total_sessions = @mysql_query($sql_sessions, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_sessions = @mysql_num_rows($total_sessions);

$last_session = '';
$counter = 0;

do {
  if ($row['session'] != '')
  {
    if ($row['session'] != $last_session) 
    {
     $display_sessions .="
     <li>" . $row['session'] . " - $" . $row['amt_paid'] . "</li>";
        
          if ($row['session'] == 'Tutorials' && $row['title'] != "" )
  {
    $tutorials_selected = 1;
    $display_sessions .="<ul><li>" . $row['title'] . "</li>";
  }
  }
   elseif ($row['session'] == 'Tutorials')
  {
    $display_sessions .="<li>" . $row['title'] . "</li>";
  }     
$display_sessions .="";
  }
if ($counter == 4) {$display_sessions .="</ul>";}
$last_session = $row['session'];
$counter = $counter + 1;
}
while($row = mysql_fetch_array($total_sessions));




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

<script>
function tutorialDisplay()
{
var div = document.getElementById("tutorial_display")
if (div.style.display !== 'block') {
        div.style.display = 'block';
    }
    else {
        div.style.display = 'none';
    }
}

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

<div class="form_row">
<h2>Registered Sessions:</h2>

<p><?php echo "$first_name $last_name" ?> - registered at <strong><?php echo "$type" ?></strong> level on <span class="bold"><?php echo "$reg_date" ?></span>, for the following sessions:</p>
<ul>
<?php echo $display_sessions ?>
</ul>
</div>


<br />
<?php if ($tutorials_selected != 1) { ?>
<div class="form_row">
<h2>Tutorial Selection</h2>

<p>You have elected to attend tutorials, please indicate the tutorials you would like to attend.</p>

<form id="formID" class="formular" method="post" action="tutorial_save.php">
<table  class="schedule">
<?php echo $display_block ?>
</table>



<div style="clear:both;"></div>
<br />
  <input type="hidden" name="registered_session_id" value="<?php echo $registered_session_id ?>" />
<div align="center">
  <input type="submit" name="submit" value="Save"/>
</div>
<?php } ?>

</form>
</section>
<div style="clear:both;"></div>
<footer id="page_footer">
<?php include('inc/page_footer.php') ?>
</footer>
</div>
</body>

</html>