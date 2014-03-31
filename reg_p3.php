<?php

include('inc/db_conn.php');

$tutorialamount = $_POST['tutorialamount'];
$conferenceamount = $_POST['conferenceamount'];
$sprintamount = $_POST['sprintamount'];

//clients
$billTo_email = $_POST['billTo_email'];

//=======================================
// enter username into clients
//=======================================

$sql_client = "INSERT INTO clients ";
$sql_client .= "(username) ";
$sql_client .= "VALUES ";
$sql_client .= "(\"$billTo_email\")";

$result_client = @mysql_query($sql_client, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

//=======================================
// pull username just entered to get client.id
//=======================================

$sql_client_id ="SELECT ";
$sql_client_id .="id ";
$sql_client_id .="FROM clients ";
$sql_client_id .="WHERE username = \"$billTo_email\"";

$result_client_id = @mysql_query($sql_client_id, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_client_id = @mysql_num_rows($result_client_id);

while ($row = mysql_fetch_array($result_client_id))
{
  $client_id = $row['id'];
}

//=======================================
// participants
//=======================================

$shipTo_firstName = $_POST['shipTo_firstName'];
$shipTo_lastName = $_POST['shipTo_lastName'];
$affiliation = $_POST['affiliation'];
$shipTo_street1 = $_POST['shipTo_street1'];
$shipTo_street2 = $_POST['shipTo_street2'];
$shipTo_city = $_POST['shipTo_city'];
$shipTo_state = $_POST['shipTo_state'];
$shipTo_postalCode = $_POST['shipTo_postalCode'];
$shipTo_country = $_POST['shipTo_country'];

//=======================================
// enter info into participants
//=======================================

$sql_participant = "INSERT INTO participants ";
$sql_participant .= "(client_id, ";
$sql_participant .= "first_name, ";
$sql_participant .= "last_name, ";
$sql_participant .= "affiliation, ";
$sql_participant .= "email, ";
$sql_participant .= "address1, ";
$sql_participant .= "address2, ";
$sql_participant .= "city, ";
$sql_participant .= "state, ";
$sql_participant .= "postal_code, ";
$sql_participant .= "country, ";
$sql_participant .= "created_at, ";
$sql_participant .= "updated_at) ";
$sql_participant .= "VALUES ";
$sql_participant .= "(\"$client_id\", ";
$sql_participant .= "\"$shipTo_firstName\", ";
$sql_participant .= "\"$shipTo_lastName\", ";
$sql_participant .= "\"$affiliation\", ";
$sql_participant .= "\"$billTo_email\", ";
$sql_participant .= "\"$shipTo_street1\", ";
$sql_participant .= "\"$shipTo_street2\", ";
$sql_participant .= "\"$shipTo_city\", ";
$sql_participant .= "\"$shipTo_state\", ";
$sql_participant .= "\"$shipTo_postalCode\", ";
$sql_participant .= "\"$shipTo_country\", ";
$sql_participant .= "NOW(), ";
$sql_participant .= "NOW())";

$result_participant = @mysql_query($sql_participant, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

//=======================================
// pull participant just entered to get participant.id
//=======================================

$sql_participant_id ="SELECT ";
$sql_participant_id .="id ";
$sql_participant_id .="FROM participants ";
$sql_participant_id .="WHERE email = \"$billTo_email\"";

$result_participant_id = @mysql_query($sql_participant_id, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_participant_id = @mysql_num_rows($result_participant_id);

while ($row = mysql_fetch_array($result_participant_id))
{
  $participant_id = $row['id'];
}

//=======================================
// billings
//=======================================

$billTo_firstName = $_POST['billTo_firstName'];
$billTo_lastName = $_POST['billTo_lastName'];
$billTo_street1 = $_POST['billTo_street1'];
$billTo_street2 = $_POST['billTo_street2'];
$billTo_city = $_POST['billTo_city'];
$billTo_state = $_POST['billTo_state'];
$billTo_postalCode = $_POST['billTo_postalCode'];
$billTo_country = $_POST['billTo_country'];
$billTo_phoneNumber = $_POST['billTo_phoneNumber'];

//=======================================
// enter info into billings
//=======================================

$sql_billing = "INSERT INTO billings ";
$sql_billing .= "(participant_id, ";
$sql_billing .= "first_name, ";
$sql_billing .= "last_name, ";
$sql_billing .= "address1, ";
$sql_billing .= "address2, ";
$sql_billing .= "city, ";
$sql_billing .= "state, ";
$sql_billing .= "postal_code, ";
$sql_billing .= "country, ";
$sql_billing .= "phone, ";
$sql_billing .= "created_at, ";
$sql_billing .= "updated_at) ";
$sql_billing .= "VALUES ";
$sql_billing .= "(\"$participant_id\", ";
$sql_billing .= "\"$billTo_firstName\", ";
$sql_billing .= "\"$billTo_lastName\", ";
$sql_billing .= "\"$billTo_street1\", ";
$sql_billing .= "\"$billTo_street2\", ";
$sql_billing .= "\"$billTo_city\", ";
$sql_billing .= "\"$billTo_state\", ";
$sql_billing .= "\"$billTo_postalCode\", ";
$sql_billing .= "\"$billTo_country\", ";
$sql_billing .= "\"$billTo_phoneNumber\", ";
$sql_billing .= "NOW(), ";
$sql_billing .= "NOW())";

$result_billing = @mysql_query($sql_billing, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());


//=======================================
// registrations
//=======================================

$participant_type_id  = $_POST['participant_type_id'];
$conference_id = 2;
$tshirt_type_id  = $_POST['tshirt_type_id'];
$tshirt_size_id  = $_POST['tshirt_size_id'];
$ordernumber = $_POST['orderNumber'];

//=======================================
// enter info into registrations
//=======================================

$sql_reg = "INSERT INTO registrations ";
$sql_reg .= "(conference_id, ";
$sql_reg .= "participant_id, ";
$sql_reg .= "participant_type_id, ";
$sql_reg .= "tshirt_type_id, ";
$sql_reg .= "tshirt_size_id, ";
$sql_reg .= "ordernumber, ";
$sql_reg .= "created_at, ";
$sql_reg .= "updated_at) ";
$sql_reg .= "VALUES ";
$sql_reg .= "(\"$conference_id\", ";
$sql_reg .= "\"$participant_id\", ";
$sql_reg .= "\"$participant_type_id\", ";
$sql_reg .= "\"$tshirt_type_id\", ";
$sql_reg .= "\"$tshirt_size_id\", ";
$sql_reg .= "\"$ordernumber\", ";
$sql_reg .= "NOW(), ";
$sql_reg .= "NOW())";

$result_reg = @mysql_query($sql_reg, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

//=======================================
// pull registration just entered to get registration.id
//=======================================

$sql_registration_id ="SELECT ";
$sql_registration_id .="id ";
$sql_registration_id .="FROM registrations ";
$sql_registration_id .="WHERE participant_id = \"$participant_id\"";

$result_registration_id = @mysql_query($sql_registration_id, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_registration_id = @mysql_num_rows($result_registration_id);

while ($row = mysql_fetch_array($result_registration_id))
{
  $registration_id = $row['id'];
}


//=======================================
// registered_sessions
//=======================================

//registation_id
//session_id //fm form
$tutorials = $_POST['tutorials'];
$conference = $_POST['conference'];
$sprints = $_POST['sprints'];
$promotion_id = $_POST['promotion_id'];

if ($tutorials == "on")
  {
    $sessions[4] = $tutorialamount;
  }
if ($conference == "on")
  {
    $sessions[5] = $conferenceamount;
  }
if ($sprints == "on")
  {
    $sessions[6] = $sprintamount;
  }

//=======================================
// enter info into registered_sessions
//=======================================

foreach ($sessions as $key =>$value)

{
$sql_rs = "INSERT INTO registered_sessions ";
$sql_rs .= "(registration_id, ";
$sql_rs .= "session_id, ";
$sql_rs .= "amt_paid, ";
$sql_rs .= "promotion_id, ";
$sql_rs .= "created_at, ";
$sql_rs .= "updated_at) ";
$sql_rs .= "VALUES ";;
$sql_rs .= "(\"$registration_id\", ";
$sql_rs .= "\"$key\", ";
$sql_rs .= "\"$value\", ";
$sql_rs .= "\"$promotion_id\", ";
$sql_rs .= "NOW(), ";
$sql_rs .= "NOW())";

$result_rs = @mysql_query($sql_rs, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

}


//=======================================
// registered_tutorials
//=======================================

//=======================================
// pull registered_sessions just entered to get registered_sessions.id
//=======================================

$sql_registered_session_id ="SELECT ";
$sql_registered_session_id .="id ";
$sql_registered_session_id .="FROM registered_sessions ";
$sql_registered_session_id .="WHERE registration_id = \"$registration_id\" ";
$sql_registered_session_id .="AND session_id = 4";

$result_registered_session_id = @mysql_query($sql_registered_session_id, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_registered_session_id = @mysql_num_rows($result_registered_session_id);

while ($row = mysql_fetch_array($result_registered_session_id))
{
  $registered_session_id = $row['id'];
}

//registation_id
//session_id //fm form
$tutorial_0624_AM = $_POST['tutorial_0624_AM'];
$tutorial_0624_PM = $_POST['tutorial_0624_PM'];
$tutorial_0625_AM = $_POST['tutorial_0625_AM'];
$tutorial_0625_PM = $_POST['tutorial_0625_PM'];

if ($tutorial_0624_AM != "")
  {
    $selected_tutorials[0] = $tutorial_0624_AM;
  }
if ($tutorial_0624_PM != "")
  {
    $selected_tutorials[1] = $tutorial_0624_PM;
  }
if ($tutorial_0625_AM != "")
  {
    $selected_tutorials[2] = $tutorial_0625_AM;
  }
if ($tutorial_0625_PM != "")
  {
    $selected_tutorials[3] = $tutorial_0625_PM;
  }

//=======================================
// enter info into registered_tutorials
//=======================================

foreach ($selected_tutorials as $key =>$value)

{
$sql_registered_tutorials = "INSERT INTO registered_tutorials ";
$sql_registered_tutorials .= "(registered_session_id, ";
$sql_registered_tutorials .= "talk_id, ";
$sql_registered_tutorials .= "created_at, ";
$sql_registered_tutorials .= "updated_at) ";
$sql_registered_tutorials .= "VALUES ";
$sql_registered_tutorials .= "(\"$registered_session_id\", ";
$sql_registered_tutorials .= "\"$value\", ";
$sql_registered_tutorials .= "NOW(), ";
$sql_registered_tutorials .= "NOW())";

$result_registered_tutorials = @mysql_query($sql_registered_tutorials, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
}

//===========================
//  pull discount
//===========================

$promotion_id = $_POST['promotion_id'];
$today = date("Y")."-".date("m")."-".date("d");

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

}

//=======================================
// select info to display registered_sessions
//=======================================

$total_price = 0;

$sql_receipt = "SELECT ";
$sql_receipt .= "session, ";
$sql_receipt .= "CONCAT(DATE_FORMAT(start_date, '%M %D'), \" - \", DATE_FORMAT(end_date, '%D')) AS `Dates`, ";
$sql_receipt .= "price ";
$sql_receipt .= "FROM registrations ";
$sql_receipt .= "LEFT JOIN registered_sessions ";
$sql_receipt .= "ON registration_id = registrations.id ";
$sql_receipt .= "LEFT JOIN sessions ";
$sql_receipt .= "ON session_id = sessions.id ";
$sql_receipt .= "LEFT JOIN pricing ";
$sql_receipt .= "ON sessions.id = pricing.session_id ";
$sql_receipt .= "WHERE registrations.id = \"$registration_id\" ";
$sql_receipt .= "AND pricing.participant_type_id = \"$participant_type_id\"";

$total_result_receipt = @mysql_query($sql_receipt, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
//$total_found_receipt = @mysql_num_rows($total_result_receipt);

do {
  if ($row['session'] != '')
  {

$display_receipt .=    "
  <tr>
    <td>" . $row['session'] . "</td>
    <td align=\"center\">" . $row['Dates'] . "</td>";
    
    if ($row['session'] == "Conference" & $discount != "")
        {
    $display_sessions .=   "<td align=\"right\"> $ " . $row['price']*$discount . "</td>";
    $row['price'] = $row['price']*$discount;
        }
    else
        {
    $display_sessions .=   "<td align=\"right\"> $ " . $row['price'] . "</td>";
        }

    $display_sessions .=   "</tr>";
$total_price = $total_price + $row['price'];
  }
}
while($row = mysql_fetch_array($total_result_receipt));



?>