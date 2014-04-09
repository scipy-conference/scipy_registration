<?php
session_start();

$session_id_7 = $_POST['session_id_7'];
$session_id_8 = $_POST['session_id_8'];
$session_id_9 = $_POST['session_id_9'];
$session_id_10 = $_POST['session_id_10'];

$session_param = "AND ";
//===========================
// Construct session parameter string for session lookup
//===========================

if ($session_id_7 == "on")
  {
    $session_param .= "session_id = 7 ";
  }
if ($session_id_8 == "on")
  {
    $session_param .= "session_id = 8 ";
  }
if ($session_id_9 == "on")
  {
    $session_param .= "session_id = 9 ";
  }
if ($session_id_10 == "on")
  {
    $session_param .= "session_id = 10 ";
  }

//===========================
// add parens and "or"s for longer session parameter strings
//===========================

if (strlen($session_param) > 20)
  {
    $session_param = substr_replace($session_param, '(', 4,0);
    $session_param = substr_replace($session_param, ')', -1,0);
  }
if (strlen($session_param) > 20)
  {
    $session_param = substr_replace($session_param, 'OR ', 20,0);
  }
if (strlen($session_param) > 40)
  {
    $session_param = substr_replace($session_param, 'OR ', 38,0);
  }
if (strlen($session_param) > 60)
  {
    $session_param = substr_replace($session_param, 'OR ', 56,0);
  }


//===========================
// if there are no session id's go back to registration page
//===========================

if ($session_id_7 == "" && $session_id_8 =="" && $session_id_9 =="")
  {
    header('Location: index.php');
  }

//===========================
// Set participant_type level variable
//===========================

$participant_type = $_POST['participant_type'];

if ($participant_type == 1)
  {
    $level = "Standard";
  }
if ($participant_type == 2)
  {
    $level = "Student";
  }
if ($participant_type == 3)
  {
    $level = "Academic";
  }

//===========================
// Set tshirt variables
//===========================

$tshirt_size = $_POST['tshirt_size'];

if ($tshirt_size == 1)
  {
    $display_size = "XX-Large";
  }
if ($tshirt_size == 2)
  {
    $display_size = "X-Large";
  }
if ($tshirt_size == 3)
  {
    $display_size = "Large";
  }
if ($tshirt_size == 4)
  {
    $display_size = "Medium";
  }
if ($tshirt_size == 5)
  {
    $display_size = "Small";
  }

$tshirt_type = $_POST['tshirt_type'];

if ($tshirt_type == 1)
  {
    $display_type = "womens/fitted";
  }
if ($tshirt_type == 2)
  {
    $display_type = "mens/unisex";
  }



$total_price = 0;

include('inc/db_conn.php');

$promotion_id = $_POST['promotion_id'];
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

$promotion_id = $row['id'];
$promotion_name = $row['promotion_name'];
$discount = $row['discount'];

}

//===========================
//  pull sessions
//===========================

$sql_sessions = "SELECT ";
$sql_sessions .= "pricing.id AS price_id, ";
$sql_sessions .= "session_id, ";
$sql_sessions .= "session, ";
$sql_sessions .= "CONCAT(DATE_FORMAT(start_date, '%M %D'), \" - \", DATE_FORMAT(end_date, '%D')) AS `Dates`, ";
$sql_sessions .= "price ";
$sql_sessions .= "FROM pricing ";
$sql_sessions .= "LEFT JOIN participant_types ";
$sql_sessions .= "ON participant_type_id = participant_types.id ";
$sql_sessions .= "LEFT JOIN sessions ON session_id = sessions.id ";
$sql_sessions .= "WHERE pricing.conference_id = 3 ";
$sql_sessions .= "AND participant_type_id = $participant_type ";
$sql_sessions .= "$session_param ";
$sql_sessions .= "GROUP BY session ";
$sql_sessions .= "ORDER BY sessions.id ASC";

$total_result_sessions = @mysql_query($sql_sessions, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_sessions = @mysql_num_rows($total_result_sessions);
$index = 1;

do {
  if ($row['session'] != '')
  {
$display_sessions .=    "
  <tr>
    <td>" . $row['session'] . "</td>";
    
    if ($row['Dates'] == "July 9th - 9th")
        {
         $display_sessions .= "<td align=\"center\">July 9th</td>";
        }
    else
        {
         $display_sessions .= "<td align=\"center\">" . $row['Dates'] . "</td>";
        }
    
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

$pp["item_name_" . $index] = $row['session'];
$pp["on0_" . $index] = $row['session_id'];
$pp["on1_" . $index] = $level;
$pp["amount_" . $index] = $row['price'];

$index = $index + 1;
  }
}
while($row = mysql_fetch_array($total_result_sessions));



      if ($row['session'] == "Conference")
        {
        $display_sessions .="checked";
        }

$pp["item_name_" . $index] = "Souvenir T";
$pp["amount_" . $index] = 0;
$pp["os0_" . $index] = $display_size;
$pp["on0_" . $index] = $tshirt_size;
$pp["on1_" . $index] = $tshirt_type;


?>


<!DOCTYPE html>
<html>
<?php $thisPage="Register"; ?>
<head>

<?php
//force redirect to secure page
if($_SERVER['SERVER_PORT'] != '443') { header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); exit(); }
?>

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

<link rel="shortcut icon" href="http://conference.scipy.org/scipy2013/favicon.ico" />

</head>

<body>

<div id="container">

<section id="sidebar">
&nbsp;
</section>


<section id="main-content">
<h1>Registration Cont.</h1>
<hr />

<p>Please confirm these prices and submit your payment information below.</p>
<div align="center">

<p><em>Participant Level:</em> <strong><?php echo $level; ?></strong> <span style="margin: 0 2em;"> || </span> <em>T-Shirt size:</em> <strong><?php echo $display_size; ?></strong> (<?php echo $display_type; ?>)</p>

<table id="schedule" width="350" class="schedule">
  <tr>
    <th width="150">Session</th>
    <th><div align="center">Dates</div></th>
    <th><div align="right">Price</div></th>
  </tr>
<?php echo $display_sessions; ?>
  <tr>
    <td><strong>Total</strong></td>
    <td>&nbsp;</td>
    <td align="right"><strong>$ <?php echo $total_price; ?></strong></td>
  </tr>
</table>
</div>
<div style="clear:both;"></div>
<hr />

<!-- switch between sandbox and www and business name jim30@toliveistofly.com vs Accounting@enthought.com -->
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_cart">
<input type="hidden" name="upload" value="1">
<input type="hidden" name="business" value="accounting@enthought.com">


<!-- #### Summary Table  -->

<!-- #### Payment Form -->

<?php //include("inc/HOP.php") ?>

<?php $TOTALAMT = $total_price ?>

<?php //InsertSignature( $TOTALAMT, 'usd' ) ?>

<?php
foreach($pp as $key=>$value) {
    echo "<input type=\"hidden\" name=\"".$key."\"  value=\"".$value."\">";
}
?>




<div align="center">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</div>

</form>
<p style="margin: 2em 0 0 0; font-size: 0.85em;">Scipy2014 Registration processing is provided by Enthought Inc.'s PayPal Account.<br />You may also register by phone at (512)536-1057.</p>

</section>
<div style="clear:both;"></div>
<footer id="page_footer">
<?php include('inc/page_footer.php') ?>
</footer>
</div>
</body>

</html>