<?php



$conference_id = 3;
$shipTo_firstName = $_POST['shipTo_firstName']; 
$shipTo_lastName = $_POST['shipTo_lastName']; 
$affiliation = $_POST['affiliation'];
$billTo_email = $_POST['billTo_email'];
$shipTo_street1 = $_POST['shipTo_street1'];
$shipTo_street2 = $_POST['shipTo_street2'];
$shipTo_city = $_POST['shipTo_city'];
$shipTo_state = $_POST['shipTo_state'];
$shipTo_postalCode = $_POST['shipTo_postalCode'];
$shipTo_country = $_POST['shipTo_country'];
$participant_type_id = $_POST['participant_type'];
$tshirt_type_id = $_POST['tshirt_type'];
$tshirt_size_id = $_POST['tshirt_size']; 
$ordernumber = $_POST['ordernumber'];
$order_timestamp = $_POST['timestamp'];
$session_id_7 = $_POST['session_id_7'];
$session_id_8 = $_POST['session_id_8'];
$session_id_9 = $_POST['session_id_9'];
$session_id_10 = $_POST['session_id_10'];


include('../inc/db_conn.php');

if ($_POST['submit'] == "Add Registrant")
{

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

//=======================================
// enter info into participants
//=======================================

$sql_participant = "INSERT INTO participants ";
$sql_participant .= "(client_id, ";
$sql_participant .= "first_name, ";
$sql_participant .= "last_name, ";
$sql_participant .= "email, ";
$sql_participant .= "address1, ";
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
$sql_participant .= "\"$billTo_email\", ";
$sql_participant .= "\"$shipTo_street1\", ";
$sql_participant .= "\"$shipTo_city\", ";
$sql_participant .= "\"$shipTo_state\", ";
$sql_participant .= "\"$shipTo_postalCode\", ";
$sql_participant .= "\"$shipTo_country\", ";
$sql_participant .= "\"$order_timestamp\", ";
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

//=======================================
// enter info into billings
//=======================================

$sql_billing = "INSERT INTO billings ";
$sql_billing .= "(participant_id, ";
$sql_billing .= "first_name, ";
$sql_billing .= "last_name, ";
$sql_billing .= "address1, ";
$sql_billing .= "city, ";
$sql_billing .= "state, ";
$sql_billing .= "postal_code, ";
$sql_billing .= "country, ";
$sql_billing .= "created_at, ";
$sql_billing .= "updated_at) ";
$sql_billing .= "VALUES ";
$sql_billing .= "(\"$participant_id\", ";
$sql_billing .= "\"$shipTo_firstName\", ";
$sql_billing .= "\"$shipTo_lastName\", ";
$sql_billing .= "\"$shipTo_street1\", ";
$sql_billing .= "\"$shipTo_city\", ";
$sql_billing .= "\"$shipTo_state\", ";
$sql_billing .= "\"$shipTo_postalCode\", ";
$sql_billing .= "\"$shipTo_country\", ";
$sql_billing .= "\"$order_timestamp\", ";
$sql_billing .= "NOW())";

$result_billing = @mysql_query($sql_billing, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

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
$sql_reg .= "\"$order_timestamp\", ";
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
$session_id_7 = $_POST['session_id_7'];
$session_id_8 = $_POST['session_id_8'];
$session_id_9 = $_POST['session_id_9'];
$session_id_10 = $_POST['session_id_10'];
$promotion_id = $_POST['promotion_id'];

//=======================================
// get session pricing
//=======================================

$sql_pricing ="SELECT ";
$sql_pricing .="session_id, ";
$sql_pricing .="price ";
$sql_pricing .="FROM pricing ";
$sql_pricing .="WHERE conference_id = 3 ";
$sql_pricing .="AND participant_type_id = \"$participant_type_id\"";

$result_sql_pricing = @mysql_query($sql_pricing, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_sql_pricing = @mysql_num_rows($result_sql_pricing);

while ($row = mysql_fetch_array($result_sql_pricing))
{
  if ($row['session_id'] == 7) 
    {
       $tutorialamount = $row['price'];
    }
  if ($row['session_id'] == 8) 
    {
       $conferenceamount = $row['price'];
    }
  if ($row['session_id'] == 9) 
    {
       $sprintamount = $row['price'];
    }
  if ($row['session_id'] == 10) 
    {
       $luncheon = $row['price'];
    }
}

//=======================================
// create session pricing array
//=======================================

if ($session_id_7 == "on")
  {
    $sessions[7] = $tutorialamount;
  }
if ($session_id_8 == "on")
  {
    $sessions[8] = $conferenceamount;
  }
if ($session_id_9 == "on")
  {
    $sessions[9] = $sprintamount;
  }
if ($session_id_10 == "on")
  {
    $sessions[10] = $luncheon;
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
$sql_rs .= "\"$order_timestamp\", ";
$sql_rs .= "NOW())";

$result_rs = @mysql_query($sql_rs, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

}

}
//=======================================================================================
//=======================================================================================
//=======================================================================================
//=======================================================================================
//=======================================================================================
//=======================================================================================
//=======================================================================================


elseif ($_POST['submit'] == "Save Changes >> ")
{

$client_id = $_POST['client_id'];
$participant_id = $_POST['participant_id'];

//=======================================
// update username into clients
//=======================================

$sql_client = "UPDATE clients SET ";
$sql_client .= "`username` = \"$billTo_email\" ";
$sql_client .= "WHERE `id` = \"$client_id\"";

$result_client = @mysql_query($sql_client, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

//=======================================
// update info into participants
//=======================================

$sql_participant = "UPDATE participants SET ";
$sql_participant .= "first_name = \"$shipTo_firstName\", ";
$sql_participant .= "last_name = \"$shipTo_lastName\", ";
$sql_participant .= "affiliation = \"$affiliation\", ";
$sql_participant .= "email = \"$billTo_email\", ";
$sql_participant .= "address1 = \"$shipTo_street1\", ";
$sql_participant .= "address2 = \"$shipTo_street2\", ";
$sql_participant .= "city = \"$shipTo_city\", ";
$sql_participant .= "state = \"$shipTo_state\", ";
$sql_participant .= "postal_code = \"$shipTo_postalCode\", ";
$sql_participant .= "country = \"$shipTo_country\",  ";
$sql_participant .= "created_at = \"$order_timestamp\", ";
$sql_participant .= "updated_at = NOW()";
$sql_participant .= "WHERE client_id = \"$client_id\"";

$result_participant = @mysql_query($sql_participant, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

//=======================================
// enter info into billings
//=======================================

$sql_billing = "UPDATE billings SET ";
$sql_billing .= "first_name = \"$shipTo_firstName\", ";
$sql_billing .= "last_name = \"$shipTo_lastName\", ";
$sql_billing .= "address1 = \"$shipTo_street1\", ";
$sql_billing .= "city = \"$shipTo_city\", ";
$sql_billing .= "state = \"$shipTo_state\", ";
$sql_billing .= "postal_code = \"$shipTo_postalCode\", ";
$sql_billing .= "country = \"$shipTo_country\", ";
$sql_billing .= "created_at = \"$order_timestamp\", ";
$sql_billing .= "updated_at = NOW() ";
$sql_billing .= "WHERE  participant_id = \"$participant_id\"";

$result_billing = @mysql_query($sql_billing, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

//=======================================
// enter info into registrations
//=======================================

$sql_reg = "UPDATE registrations SET ";
$sql_reg .= "participant_type_id = \"$participant_type_id\", ";
$sql_reg .= "tshirt_type_id = \"$tshirt_type_id\", ";
$sql_reg .= "tshirt_size_id =  \"$tshirt_size_id\", ";
$sql_reg .= "ordernumber = \"$ordernumber\", ";
$sql_reg .= "created_at = \"$order_timestamp\", ";
$sql_reg .= "updated_at = NOW() ";
$sql_reg .= "WHERE participant_id = \"$participant_id\"";

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
$session_id_7 = $_POST['session_id_7'];
$session_id_8 = $_POST['session_id_8'];
$session_id_9 = $_POST['session_id_9'];
$session_id_10 = $_POST['session_id_10'];
$promotion_id = $_POST['promotion_id'];

//=======================================
// get session pricing
//=======================================

$sql_pricing ="SELECT ";
$sql_pricing .="session_id, ";
$sql_pricing .="price ";
$sql_pricing .="FROM pricing ";
$sql_pricing .="WHERE conference_id = 3 ";
$sql_pricing .="AND participant_type_id = \"$participant_type_id\"";

$result_sql_pricing = @mysql_query($sql_pricing, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_sql_pricing = @mysql_num_rows($result_sql_pricing);

while ($row = mysql_fetch_array($result_sql_pricing))
{
  if ($row['price'] == "") 
    {
        $row['price'] = "0.00";
    }
  if ($row['session_id'] == 7) 
    {
       $tutorialamount = $row['price'];
    }
  if ($row['session_id'] == 8) 
    {
       $conferenceamount = $row['price'];
    }
  if ($row['session_id'] == 9) 
    {
       $sprintamount = $row['price'];
    }
  if ($row['session_id'] == 10) 
    {
       $luncheonamount = $row['price'];
    }
}

//=======================================
// create session pricing array
//=======================================

if ($session_id_7 == "on")
  {
    $sessions[7] = $tutorialamount;
  }
if ($session_id_8 == "on")
  {
    $sessions[8] = $conferenceamount;
  }
if ($session_id_9 == "on")
  {
    $sessions[9] = $sprintamount;
  }
if ($session_id_10 == "on")
  {
    $sessions[10] = $luncheonamount;
  }

//=======================================
// enter info into registered_sessions
//=======================================

foreach ($sessions as $key =>$value)

{
$sql_rs = "UPDATE registered_sessions SET ";
$sql_rs .= "session_id =  \"$key\", ";
$sql_rs .= "amt_paid = \"$value\", ";
$sql_rs .= "promotion_id = \"$promotion_id\", ";
$sql_rs .= "updated_at = NOW() ";
$sql_rs .= "WHERE registration_id = \"$registration_id\" ";
$sql_rs .= "AND session_id = \"$key\"";

$result_rs = @mysql_query($sql_rs, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

//=======================================
// get db registered_sessions
//=======================================

$sql_db_rs = "SELECT ";
$sql_db_rs .= "id, ";
$sql_db_rs .= "session_id, ";
$sql_db_rs .= "promotion_id, ";
$sql_db_rs .= "amt_paid ";
$sql_db_rs .= "FROM registered_sessions ";
$sql_db_rs .= "WHERE registration_id = \"$registration_id\"";

$result_db_rs = @mysql_query($sql_db_rs, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_db_rs = @mysql_num_rows($result_db_rs);

while ($row = mysql_fetch_array($result_db_rs))
{
  $db_sessions[$row['session_id']] = $amt_paid;
}

//=======================================
// add new registered_sessions
//=======================================

$session_additions = array_diff_key($sessions, $db_sessions);

foreach ($session_additions as $key =>$value)

{
$sql_add_rs = "INSERT INTO registered_sessions ";
$sql_add_rs .= "(registration_id, ";
$sql_add_rs .= "session_id, ";
$sql_add_rs .= "amt_paid, ";
$sql_add_rs .= "promotion_id, ";
$sql_add_rs .= "created_at, ";
$sql_add_rs .= "updated_at) ";
$sql_add_rs .= "VALUES ";
$sql_add_rs .= "(\"$registration_id\", ";
$sql_add_rs .= "\"$key\", ";
$sql_add_rs .= "\"$value\", ";
$sql_add_rs .= "\"$promotion_id\", ";
$sql_add_rs .= "\"$order_timestamp\", ";
$sql_add_rs .= "NOW())";

$result_add_rs = @mysql_query($sql_add_rs, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

}

//=======================================
// delete new registered_sessions
//=======================================

$session_subtractions = array_diff_key($db_sessions, $sessions);

foreach ($session_subtractions as $key =>$value)

{
$sql_sub_rs = "DELETE FROM registered_sessions ";
$sql_sub_rs .= "WHERE registration_id = \"$registration_id\" ";
$sql_sub_rs .= "AND session_id = \"$key\"";

$result_sub_rs = @mysql_query($sql_sub_rs, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

}









}
}

header( "Location: registrant_info.php?id=$participant_id" )

?>