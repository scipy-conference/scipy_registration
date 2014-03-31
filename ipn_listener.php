<?php

// read the post from PayPal system and add _notify-validate
$req = 'cmd=_notify-validate';
foreach ($_POST as $key => $value) {
  $value = urlencode(stripslashes($value));
  $req .= "&$key=$value";
  }

// send validation to PayPal
$header .= "POST /cgi-bin/webscr HTTP/1.1\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
// $header .= "Host: www.paypal.com\r\n";  // www.sandbox.paypal.com for a test site
$header .= "Host: www.sandbox.paypal.com\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n";
$header .= "Connection: close\r\n\r\n";


//$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
//$fp = fsockopen ('www.sandbox.paypal.com', 80, $errno, $errstr, 30);


$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

if (!$fp) {
// HTTP error...
$to = 'jim@polarbeardesign.net';
$subject = 'SciPy2014 | HTTP error';
$message = 'somethings wrong';
$headers = 'From:noreply@scipy.org' . "\r\n";
mail($to, $subject, $message, $headers);

} else {
fputs ($fp, $header . $req);
while (!feof($fp)) {
  $res = fgets ($fp, 1024);
  if (stripos($res, "VERIFIED") !== false) {
// check for duplicate message
// payment valid insert info into db

//if (($payment_status == 'Completed') &&   //payment_status = Completed
//   ($receiver_email == "jim30@toliveistofly.com") &&   // receiver_email is same as your account email
//   ($payment_amount == $amount_they_should_have_paid ) &&  //check they payed what they should have
//   ($payment_currency == "USD") &&  // and its the correct currency 
//   (!txn_id_used_before($txn_id))) {  //txn_id isn't same as previous to stop duplicate payments. You will need to write a function to do this check.

$first_name = $_POST['first_name'];
//$pp_array = print_r($_POST);
foreach ($_POST as $key => $value) {
  $pp_array .= $key . " = " . $value . "<br />";
}

$to = 'jim@polarbeardesign.net';
$subject = 'SciPy2014 | Payment';
$message = "from: " .  $pp_array . " ";
$headers = 'From:noreply@scipy.org' . "\r\n";
mail($to, $subject, $message, $headers);

include('inc/db_conn.php');


//clients
$billTo_email = $_POST['payer_email'];

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

$shipTo_firstName = $_POST['first_name'];
$shipTo_lastName = $_POST['last_name'];
$shipTo_street1 = $_POST['address_street'];
$shipTo_city = $_POST['address_city'];
$shipTo_state = $_POST['address_state'];
$shipTo_postalCode = $_POST['address_zip'];
$shipTo_country = $_POST['address_country_code'];

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

$billTo_firstName = $_POST['first_name'];
$billTo_lastName = $_POST['last_name'];
$billTo_street1 = $_POST['address_street'];
$billTo_city = $_POST['address_city'];
$billTo_state = $_POST['address_state'];
$billTo_postalCode = $_POST['address_zip'];
$billTo_country = $_POST['address_country_code'];

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
$sql_billing .= "\"$billTo_firstName\", ";
$sql_billing .= "\"$billTo_lastName\", ";
$sql_billing .= "\"$billTo_street1\", ";
$sql_billing .= "\"$billTo_city\", ";
$sql_billing .= "\"$billTo_state\", ";
$sql_billing .= "\"$billTo_postalCode\", ";
$sql_billing .= "\"$billTo_country\", ";
$sql_billing .= "NOW(), ";
$sql_billing .= "NOW())";

$result_billing = @mysql_query($sql_billing, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

//=======================================
// registrations
//=======================================


// find sessions and tshirt ids

$tshirt_item_no = substr(array_search("Souvenir T", $_POST),9);

$tshirt_type_id = $_POST['option_name2_'.$tshirt_item_no];
$tshirt_size_id = $_POST['option_name1_'.$tshirt_item_no];

// participant types
$participant_types = array('1' => 'Standard', '2' => 'Student', '3' => 'Academic');
$participant_type_id  = array_search($_POST['option_name2_1'],$participant_types);
$ordernumber = $_POST['txn_id'];
$conference_id = 3;


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

for ($i = 1; $i <= $_POST['num_cart_items']; $i++)
 { 
  $sessions[$_POST['option_name1_'.$i]] = $_POST['mc_gross_'.$i];
 } 

unset($sessions[$tshirt_size_id]);  //remove t-shirt from sessions

//=======================================
// enter info into registered_sessions
//=======================================

foreach ($sessions as $key => $value)

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

}
 
    else if (stripos ($res, "INVALID") !== false) {
 
// payment was not valid - send an email to trigger investigation

$to      = 'jivanoff@enthought.com';
$subject = 'SciPy2014 | Invalid Payment';
$message = '
 
A payment has been made but is flagged as INVALID.
Please verify the payment manually and contact the registrant.
 
Buyer Email: '.$email.'
';
$headers = 'From:noreply@scipy.org' . "\r\n";
 
mail($to, $subject, $message, $headers);
 
}
}
fclose ($fp);
}


?>