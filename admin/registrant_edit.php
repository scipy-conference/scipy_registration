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

$participant_id = $_GET['id'];

//===========================
//  pull total registered
//===========================

$sql_registrants = "SELECT ";
$sql_registrants .= "participants.last_name, ";
$sql_registrants .= "participants.first_name, ";
$sql_registrants .= "affiliation, ";
$sql_registrants .= "email, ";
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

$last_name = $row['last_name'];
$first_name = $row['first_name'];
$affiliation = $row['affiliation'];
$email = $row['email'];
$city = $row['city'];
$state = $row['state'];
$postal_code = $row['postal_code'];
$country = $row['country'];
$reg_date = $row['reg_date'];
$type = $row['type'];
$phone = $row['phone'];
}


//===========================
//  pull registered sessions
//===========================

$sql_reg_sessions = "SELECT ";
$sql_reg_sessions .= "session, ";
$sql_reg_sessions .= "amt_paid ";
$sql_reg_sessions .= "FROM registered_sessions ";
$sql_reg_sessions .= "LEFT JOIN sessions ";
$sql_reg_sessions .= "ON session_id = sessions.id ";
$sql_reg_sessions .= "LEFT JOIN registrations ";
$sql_reg_sessions .= "ON registration_id = registrations.id ";
$sql_reg_sessions .= "WHERE participant_id = $participant_id ";
$sql_reg_sessions .= "AND registrations.conference_id = 3";

$total_reg_sessions = @mysql_query($sql_reg_sessions, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_reg_sessions = @mysql_num_rows($total_reg_sessions);

do {
  if ($row['session'] != '')
  {

$display_reg_sessions .="<ul>
    <li>" . $row['session'] . " - $" . $row['amt_paid'] . "</li>

  </ul>";
  }
}
while($row = mysql_fetch_array($total_reg_sessions));

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
$sql_sessions .= "WHERE pricing.conference_id = 2 ";
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
$display_sessions .=" /></td>
    <td>" . $row['session'] . "";
      if ($row['session'] == "Sprints")
        {
        $display_sessions .="*";
        }
$display_sessions .="</td>
    <td>" . $row['Dates'] . "</td>
    <td align=\"right\"> $ " . $row['Standard'] . "</td>
    <td align=\"right\"> $ " . $row['Academic'] . "</td>
    <td align=\"right\"> $ " . $row['Student'] . "</td>
  </tr>";
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
$sql_participants .= "ORDER BY Field(id,1,3,2)";

$total_result_participants = @mysql_query($sql_participants, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_participants = @mysql_num_rows($total_result_participants);

do {
  if ($row['type'] != '')
  {

$display_participants .=    "
  <tr>
    <td><span><input class=\"validate[required] radio\" name=\"participant_type\" id=\"participant_type\" type=\"radio\" value=\"" . $row[id] . "\" ";
$display_participants .="/></span></td>
    <td>" . $row['type'] . "</td>
  </tr>";
  }
}
while($row = mysql_fetch_array($total_result_participants));

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
    <td><input class=\"validate[required] radio\" name=\"tshirt_size\" id=\"tshirt_size\" type=\"radio\" value=\"" . $row[id] . "\"  ";
      if ($_POST['tshirt_size'] == $row[size])
        {
          $display_sizes .="checked ";
        }
        
$display_sizes .="/></td>
    <td>" . $row['size'] . "</td>
  </tr>";
  }
}
while($row = mysql_fetch_array($total_result_sizes));



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

<h1>Registrant Info:</h1>

<div class="form_row">
<div class="form_cell">
<h2>Contact Information</h2>

<table class="indent">
    <tr>
    <td class="no_brder"><label for="FirstName">* First Name</label><br /><input class="validate[required] text-input" type='text' id='FirstName' name='shipTo_firstName' value='<?php echo $last_name ?>'></td>
    <td class="no_brder"><label for="">* Last Name</label><br /><input class="validate[required] text-input" type='text' id='LastName' name='shipTo_lastName' value='<?php echo $first_name ?>'></td>
    <td class="no_brder"><label for="">Affiliation</label><br /><input type='text' name='affiliation' value='<?php echo $affiliation ?>'></td>
    </tr>
    <tr>
      <td class="no_brder"><label for="">* Email</label><br /><input class="validate[required,custom[email]]" type='text' id='email' name='billTo_email' value='<?php echo $email ?>'></td>
    </tr>
    <tr>
      <td class="no_brder"><label for="">Address 1</label><br /><input type='text' id='Addr1'  name='shipTo_street1' value='<?php echo $address1 ?>'></td>
      <td class="no_brder"><label for="">Address 2</label><br /><input type='text' id='Addr2' name='shipTo_street2' value='<?php echo $address2 ?>'></td>
    </tr>
    <tr>
    <td class="no_brder"><label for="">City</label><br /><input type='text' id='City' name='shipTo_city' value='<?php echo $city ?>'></td>
    <td class="no_brder"><label for="">State</label><br /><input type='text' id='State' name='shipTo_state' value='<?php echo $state ?>'></td>
    <td class="no_brder"><label for="">Zip</label><br /><input type='text' id='ZipCode' name='shipTo_postalCode' value='<?php echo $postal_code ?>'></td>
   </tr>
    <tr>
      <td class="no_brder"><label for="">Country</label><br />

        <select id='Country' name="shipTo_country" size="1" style="width:150px">
            <?php foreach ($countries as $key => $shipTo_country) {
            echo "<option value=\"$key\">$shipTo_country</option>";
            } ?></select>
    </td>
    </tr>
</table>

</div>
<div class="form_cell">
<h2>Registered Sessions:</h2>

<p>Registered at <span class="bold"><?php echo "$type" ?></span> level on <span class="bold"><?php echo "$reg_date" ?></span>, for the following sessions:

<table id="schedule">
  <tr>
    <th colspan="2">Session </th>
    <th>Dates</th>
    <th><div align="right">Price</div></th>
    <th><div align="right">Academic<br />Price</div></th>
    <th><div align="right">Student<br />Price</div></th>
  </tr><?php echo $display_sessions ?>
  <tr>
    <td colspan="6"><span class="asterisk_text">*SciPy 2013 Sprints will be free of cost to everyone. However, for catering purposes, we would like to know whether you plan on attending.</span></td>
</table>


</div>
</div>

<p><a href="registrant_edit.php?id=<?php echo $participant_id ?> ">Edit</a></p>

</section>



<div style="clear: both;"></div>
<footer id="page_footer">
<?php include('../inc/page_footer.php') ?>
</footer>
</div>
</body>

</html>