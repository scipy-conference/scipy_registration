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
$registered_tutorials .= "participant_id, ";
$registered_tutorials .= "email, ";
$registered_tutorials .= "ordernumber, ";
$registered_tutorials .= "sha1(ordernumber), ";
$registered_tutorials .= "size, ";
$registered_tutorials .= "IF(type_abbr = 'F', 'Women\'s','Men\'s') AS t_type, ";
$registered_tutorials .= "registered_sessions.id  ";
$registered_tutorials .= "FROM registered_sessions  ";
$registered_tutorials .= "LEFT JOIN registrations ON registration_id = registrations.id  ";
$registered_tutorials .= "LEFT JOIN participants ON participant_id = participants.id  ";
$registered_tutorials .= "LEFT JOIN tshirt_sizes ON tshirt_size_id = tshirt_sizes.id ";
$registered_tutorials .= "LEFT JOIN tshirt_types ON tshirt_type_id = tshirt_types.id ";
$registered_tutorials .= "WHERE registrations.conference_id = 3 ";
$registered_tutorials .= "AND amt_paid > 0 ";
$registered_tutorials .= "GROUP BY participant_id";

//$registered_tutorials .= "LEFT JOIN registered_tutorials ON registered_session_id = registered_sessions.id ";
//$registered_tutorials .= "WHERE session_id = 7 ";
//$registered_tutorials .= "AND registered_tutorials.talk_id IS NULL ";

$result_registered_tutorials = @mysql_query($registered_tutorials, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

$total_found = @mysql_num_rows($result_registered_tutorials);
while($row = mysql_fetch_array($result_registered_tutorials))
{
$participant_id = $row['participant_id'];
$last_name = $row['last_name'];
$first_name = $row['first_name'];
$email = $row['email'];
$t_type = $row['t_type'];
$size = $row['size'];
$ordernumber = $row['ordernumber'];
$reg_code = $row['sha1(ordernumber)'];
$index = $index + 1;
$display_block .="<tr>
<td align=right>$index</td>
<td><a href=\"https://conference.scipy.org/scipy_registration/admin/registrant_info.php?id=$participant_id\">$first_name&nbsp;$last_name</a></td>
<td><a href=\"mailto:$email?bcc=jivanoff@enthought.com&subject=SciPy2014 Registration Confirmation&body=Dear $first_name:%0A%0A

SciPy is quickly approaching and we would like to take a minute of your time to confirm your registration information and also highlight a few notable events.%0A%0A

Your name as it will appear on your conference badge: $first_name $last_name%0A%0A

You are currently registered for the following%0A%0A";

//===========================
//  pull registered sessions
//===========================

// adding registered tutorials to view

$sql_sessions = "SELECT ";
$sql_sessions .= "sessions.id, ";
$sql_sessions .= "session, ";
$sql_sessions .= "DATE_FORMAT(sessions.start_date, '%b %D') AS start, ";
$sql_sessions .= "DATE_FORMAT(sessions.end_date, '%D') AS end, ";
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
         - " . $row['session'] . ": " . $row['start'] . "";

         if ($row['id'] != 10) 
           {
             $display_sessions .=" - " . $row['end'] . "%0D%0A";
           }

         if ($row['session'] == 'Tutorials' AND $row['title'] != NULL)
           {
             $display_sessions .="            -- " . $row['title'] . "%0D%0A";
           }
         elseif ($row['session'] == 'Tutorials' AND $row['title'] == NULL)
           {
             $display_sessions .="               Our records do not show that you have registered for your tutorials yet.%0D%0A
               Please use this link to select your preferred tutorials:%0D%0A
               https://conference.scipy.org/scipy_registration/tutorial_select.php?reg_code=$reg_code%0D%0A";
           }  
       }
     elseif ($row['session'] == 'Tutorials')
       {
         $display_sessions .="            -- " . $row['title'] . "%0D%0A";
       }     
$display_sessions .="";
  }
if ($counter == 4) {$display_sessions .="";}

$last_session = $row['session'];
$counter = $counter + 1;
}
while($row = mysql_fetch_array($total_sessions));

$display_block .="$display_sessions";


$display_block .="%0A%0A

T-Shirt: $t_type $size%0A%0A

If you would like to make any changes to this information, please email jillc@enthought.com or call 512-536-1057.%0A%0A

New to SciPy this year is a Job Fair during the opening night reception on Tuesday, July 8th. Several sponsors have job openings and are very interested to speak with attendees about their opportunities. You may find a list of opening on the jobs listing page - https://conference.scipy.org/scipy2014/job_listings/. Bring copies of your resume!%0A%0A

Also, Enthought will be hosting their annual reception on Monday, July 7th at 6:30 PM. The reception is a wonderful way to reconnect with old friends and meet some new ones just before the general session kicks off. Please drop by the Enthought office at 515 Congress Ave, Suite 2100 if you can make it. There will also be happy hours sponsored by Real Massive and Continuum at Sholtz’s Beer Garten on Wednesday, July 8th and Thursday, July 9th.%0A%0A

Our speakers and presenters are excited to showcase their latest scientific Python projects. It will be a week filled with over 100 talks and poster presentation in addition to mini-symposia on Astronomy and Astrophysics, Bioinformatics, Computational Social Science, Digital Humanities, Engineering, Geophysics, Geospatial Computing, and Vision, Visualization, and Imaging.  See you in Austin at SciPy 2014!%0A%0A

Warmly,%0A%0A

The SciPy Registration Team\">$email</a></td>
</tr>";

$display_sessions = "";
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



<h1>2014 Conference Registration</h1>

<form id="formID" class="formular" method="post" action="tutorial_save.php">

<h2>Paid Registrations <?php echo $total_found ?></h2>


<table class="schedule">
<?php echo $display_block ?>
</table>



<div style="clear:both;"></div>
<footer id="page_footer">
<?php include('inc/page_footer.php') ?>
</footer>
</div>
</body>

</html>