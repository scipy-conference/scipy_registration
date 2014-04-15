<?php
// production
$identity_token = "JgvAMg8amsmRCCUY228qiKJLL72mEN038Cndz1ZyLqNGo6o5hQevjSdZIFa";


// sandbox
//$identity_token = "XC-RVBLamoaBjbaRR_46H0Rr_veMEbUGuFHnHQMXReu2DIotjZO0uHQqBUe";
//=============================================================================
// PDT code
//=============================================================================
// switch $to https://www.paypal.com || https://www.sandbox.paypal.com and $token for testing and production

$to = "https://www.paypal.com/cgi-bin/webscr";
$token = "JgvAMg8amsmRCCUY228qiKJLL72mEN038Cndz1ZyLqNGo6o5hQevjSdZIFa";
$cmd = "_notify-synch";
$arr_var;
$posted;

if ($_GET['tx'])
  {

  $conn = curl_init($to);
  curl_setopt($conn, CURLOPT_HEADER, 0);
  curl_setopt($conn, CURLOPT_NOBODY, 0);
  curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($conn, CURLOPT_USERAGENT, "Mozilla/5.0");
  curl_setopt($conn, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, 1);
  curl_setopt($conn, CURLOPT_POST, 1);
  curl_setopt($conn, CURLOPT_POSTFIELDS, array(
		'cmd' => $cmd,
		'tx' => $_GET['tx'],
		'at' => $token));

  if (!$page = curl_exec($conn))
	{
	echo curl_error($conn);
	curl_close($conn);
	}
  else
    {

    $arr_var = preg_split("/\n/", $page);

    if ($arr_var[0] == "FAIL")
	{echo "Error getting data";}
    else if ($arr_var[0] == "SUCCESS")
	{

	for ($a=1; $a<count($arr_var); $a++)
	  {

	  list ($key, $val) = preg_split("/\=/", $arr_var[$a]);
	  $val = preg_replace('/\+/', ' ', $val);

	  # # # # # # # # # # # # # # # # # # # # # # # # #
	  # # This is a single line 

	  $val = preg_replace('/%([\da-f][\da-f])/ei',"chr(hexdec('\\1'))", $val);

	  # # This is a single line 
	  # # # # # # # # # # # # # # # # # # # # # # # # #

	  $posted[$key] = $val;

	  }

	}

      curl_close($conn);

    }

  }

//================================================================================

include('inc/db_conn.php');
$ordernumber = $posted['txn_id'];
$rate = $posted['option_name2_1'];
$participant_types = array('1' => 'Standard', '2' => 'Student', '3' => 'Academic');
$participant_type_id  = array_search($posted['option_name2_1'],$participant_types);


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
$sql_receipt .= "WHERE ordernumber = \"$ordernumber\" ";
$sql_receipt .= "AND pricing.participant_type_id = \"$participant_type_id\"";

$total_result_receipt = @mysql_query($sql_receipt, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_receipt = @mysql_num_rows($total_result_receipt);

do {
  if ($row['session'] != '')
  {

$display_receipt .=    "
  <tr>
    <td>" . $row['session'] . "</td>";
    if ($row['Dates'] == "July 9th - 9th")
        {
         $display_receipt .= "<td align=\"center\">July 9th</td>";
        }
    else
        {
         $display_receipt .= "<td align=\"center\">" . $row['Dates'] . "</td>";
        }

    if ($row['session'] == "Conference" & $discount != "")
        {
    $display_receipt .=   "<td align=\"right\"> $ " . $row['price']*$discount . "</td>";
    $row['price'] = $row['price']*$discount;
        }
    else
        {
    $display_receipt .=   "<td align=\"right\"> $ " . $row['price'] . "</td>";
        }

    $display_receipt .=   "</tr>";
$total_price = $total_price + $row['price'];
  }
}
while($row = mysql_fetch_array($total_result_receipt));


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

<h1>SciPy 2014 Registration  - Thank You!</h1>

<p>Thank you for registering for the SciPy 2014 Conference. You have been registered with the following information:</p>
<ul>
	<li>Name: <strong><?php echo $posted['first_name']; ?>  <?php echo $posted['last_name']; ?></strong> </li>
	<li>Email: <strong><?php echo $posted['payer_email']; ?></strong> </li>
	<li>Rate: <strong><?php echo $rate; ?></strong> </li>
	<li>Sessions</li></ul>
	<table class="schedule" style="margin: 0 10em 2em; ">
	  <tr>
	    <th width="150">Session</th>
	    <th>Date(s)</th>
	    <th>Price</th>
	  </tr>
	<?php echo $display_receipt; ?>
	  <tr>
	    <td colspan="2"><strong>Total</strong></td>
	    <td align="right"><strong>$ <?php echo $total_price; ?></strong></td>
	  </tr>
	</table

<p>Your order number is <strong><?php echo $posted['txn_id']; ?></strong>. You should receive an email shortly that can serve as your receipt.</p>

<p>If you would like to change something in your registration or have a problem with your order please contact Enthought at +1 (512)536-1057.</p>
<h2>Lodging</h2>
<p>On-site lodging for SciPy 2014 is available at the AT&T Executive Conference Center Hotel. Hotel rooms are available at a conference rate of $121 a night plus tax. <a href="https://resweb.passkey.com/go/SCIPYM0714">Make your reservations</a> soon because at this rate, availability won't last long!</p>

<p>Other lodging options:</p>

<p><a href="http://doubletree3.hilton.com/en/hotels/texas/doubletree-suites-by-hilton-hotel-austin-AUSFLDT/index.html">DoubleTree by Hilton Hotel Austin</a><br />
303 W. 15th Street<br />
Austin, TX 78701</p>

<p><a href="http://doubletree3.hilton.com/en/hotels/texas/doubletree-by-hilton-hotel-austin-university-area-AUSIMDT/index.html">DoubleTree by Hilton Hotel Austin - University Area</a><br />
1617 IH-35 North<br />
Austin, TX 78702</p>

<p><a href="http://www.starwoodhotels.com/sheraton/property/overview/index.html?propertyID=3079">Sheraton Austin Hotel at the Capitol</a><br />
701 East 11th Street<br />
Austin, TX 78701</p>

<p><a href="http://www.extendedstayamerica.com/property/extended-stay-america-austin-downtown-6th-st-hotel.html">Extended Stay America - Austin - Downtown - 6th St.</a><br />
600 Guadalupe St.<br />
Austin, TX 78701</p>

</section>
<div style="clear:both;"></div>
<footer id="page_footer">
<?php include('inc/page_footer.php') ?>
</footer>
</div>
</body>

</html>
