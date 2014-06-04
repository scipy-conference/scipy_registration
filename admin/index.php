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

//===========================
//  pull total registered
//===========================

$sql_total = "SELECT ";
$sql_total .= "SUM(IF(conference_id = 3,1,0)) AS registered_qty ";
$sql_total .= "FROM registrations ";
$sql_total .= "WHERE conference_id = 3 ";

$total_ = @mysql_query($sql_total, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

while ($row = mysql_fetch_array($total_)) {

$registered_qty=$row['registered_qty'];
}

//===========================
//  pull total paid
//===========================

$sql_paid_total = "SELECT ";
$sql_paid_total .= "SUM(IF(conference_id = 3,amt_paid,0)) AS amt_paid ";
$sql_paid_total .= "FROM registered_sessions ";
$sql_paid_total .= "LEFT JOIN registrations ";
$sql_paid_total .= "ON registration_id = registrations.id ";
$sql_paid_total .= "WHERE conference_id = 3 ";

$total_paid = @mysql_query($sql_paid_total, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

while ($row = mysql_fetch_array($total_paid)) {

$registered_amt_paid=number_format($row['amt_paid'],2);
}

//===========================
//  country map summary
//===========================

$country_map = array('Country','Participants');
$country_II .= "['Country','Participants'],";


$sql_country_map = "SELECT  ";
$sql_country_map .= "country, ";
$sql_country_map .= "COUNT(country) AS qty  ";
$sql_country_map .= "FROM participants  ";
$sql_country_map .= "LEFT JOIN registrations ON  ";
$sql_country_map .= "participant_id = participants.id  ";
$sql_country_map .= "WHERE conference_id = 3 ";
$sql_country_map .= "AND country != \"\"";
$sql_country_map .= "GROUP BY country";

$total_country_map = @mysql_query($sql_country_map, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

while ($row = mysql_fetch_array($total_country_map)) {

$country_map[$row['country']] = $row['qty'];

$country_II .= "['" . $row['country'] . "', " . $row['qty'] . "],";
}

$country_II = rtrim($country_II, ",");


//===========================
//  daily registrations
//===========================

$sql_daily = "SELECT ";
$sql_daily .= "DATE_FORMAT(created_at,'%m-%d') AS Date, ";
$sql_daily .= "COUNT(ordernumber) AS qty ";
$sql_daily .= "FROM registrations ";
$sql_daily .= "WHERE created_at > \"2014-01-05\" ";
$sql_daily .= "GROUP BY Date";

$result_daily = @mysql_query($sql_daily, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

$total_found_daily = @mysql_num_rows($resultresult_daily);

while ($row = mysql_fetch_array($result_daily)) {


$date_array[] = $row['Date'];
$line_src_l =implode ("|" ,$date_array );
$qty_array[] = $row['qty'];
$line_src_d =implode ("," ,$qty_array );

}

$daily_reg_chart= "<img src=\"http://chart.apis.google.com/chart?
cht=bvs
&chbh=a
&chds=a
&chd=t:$line_src_d
&chs=350x175
&chxl=0:|$line_src_l|
&chco=2b5da6
&chm=N*f1*,999999,0,-1,10,,e::4
&chtt=\" width=\"280\" height=\"144\">";

//===========================
//  registered pie
//===========================

$sql_total_pie = "SELECT ";
$sql_total_pie .= "type, ";
$sql_total_pie .= "SUM(IF(conference_id = 3,1,0)) AS qty ";
$sql_total_pie .= "FROM registrations ";
$sql_total_pie .= "LEFT JOIN participant_types ";
$sql_total_pie .= "ON participant_type_id = participant_types.id ";
$sql_total_pie .= "WHERE conference_id = 3 ";
$sql_total_pie .= "GROUP BY type";

$total_result_reg_pie = @mysql_query($sql_total_pie, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_reg_pie = @mysql_num_rows($total_result_reg_pie);

while ($row = mysql_fetch_array($total_result_reg_pie)) {

    $type=$row['type'];
    $reg_qty=$row['qty'];
    $reg_diff_radius=($reg_qty/$registered_qty);
    $reg_count_array[] = $reg_diff_radius; 
    $reg_pie_src_d =implode ("," ,$reg_count_array );
    $reg_text_array[] = $type." - ".$reg_qty." [" . number_format($reg_diff_radius * 100,0) . "%]";
    $reg_text_array = str_replace (" " ,"%20" ,$reg_text_array );
    $reg_pie_src_l =implode ("|" ,$reg_text_array );
}

$chart_reg = "<img src=\"http://chart.apis.google.com/chart?cht=p&chd=t:$reg_pie_src_d&chs=347x106&chl=$reg_pie_src_l&chco=2b5da6\" width=\"347\" height=\"106\">";


$row_1="odd";
$row_2="even";
$row_count=1;

//===========================
//  pull sessions detail
//===========================

$sql_sessions = "SELECT  ";
$sql_sessions .= "type,  ";
$sql_sessions .= "SUM(IF(session_id = 7,amt_paid,0)) AS tutorials_paid,  ";
$sql_sessions .= "SUM(IF(session_id = 8,amt_paid,0)) AS conference_paid,  ";
$sql_sessions .= "SUM(IF(session_id = 9,amt_paid,0)) AS sprints_paid,  ";
$sql_sessions .= "SUM(IF(session_id = 10,amt_paid,0)) AS luncheon_paid,  ";
$sql_sessions .= "SUM(IF(session_id = 7,1,0)) AS Tutorials,  ";
$sql_sessions .= "SUM(IF(session_id = 8,1,0)) AS Conference,  ";
$sql_sessions .= "SUM(IF(session_id = 9,1,0)) AS Sprints,  ";
$sql_sessions .= "SUM(IF(session_id = 10,1,0)) AS WSCL  ";
$sql_sessions .= "FROM registrations  ";
$sql_sessions .= "LEFT JOIN registered_sessions  ";
$sql_sessions .= "ON registration_id = registrations.id  ";
$sql_sessions .= "LEFT JOIN sessions  ";
$sql_sessions .= "ON session_id = sessions.id  ";
$sql_sessions .= "LEFT JOIN participant_types  ";
$sql_sessions .= "ON participant_type_id = participant_types.id  ";
$sql_sessions .= "GROUP BY participant_type_id";


$total_result_sessions = @mysql_query($sql_sessions, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_sessions = @mysql_num_rows($total_result_sessions);
$row_color=($row_count%2)?$row_1:$row_2;

do {
  if ($row['type'] != '')
  {

$display_sessions_paid .="<tr class=$row_color>
    <td>" . $row['type'] . "</td>
    <td align=\"right\">$ " . number_format($row['conference_paid'],2) . "</td>
    <td align=\"right\">n/a</td>
    <td align=\"right\">$ " . number_format($row['tutorials_paid'],2) . "</td>
    <td align=\"right\">$ " . number_format($row['luncheon_paid'],2) . "</td>
  </tr>";

$display_sessions .="<tr class=$row_color>
    <td>" . $row['type'] . "</td>
    <td align=\"right\">" . $row['Conference'] . "</td>
    <td align=\"right\">" . $row['Sprints'] . "</td>
    <td align=\"right\">" . $row['Tutorials'] . "</td>
    <td align=\"right\">" . $row['WSCL'] . "</td>
  </tr>";
  }
$row_color=($row_count%2)?$row_1:$row_2;
$row_count++;
}
while($row = mysql_fetch_array($total_result_sessions));

//===========================
//  pull sessions summary
//===========================

$sql_sess_sum = "SELECT  ";
$sql_sess_sum .= "SUM(IF(session_id = 7,amt_paid,0)) AS tutorials_paid,  ";
$sql_sess_sum .= "SUM(IF(session_id = 8,amt_paid,0)) AS conference_paid,  ";
$sql_sess_sum .= "SUM(IF(session_id = 9,amt_paid,0)) AS sprints_paid,  ";
$sql_sess_sum .= "SUM(IF(session_id = 10,amt_paid,0)) AS luncheon_paid,  ";
$sql_sess_sum .= "SUM(IF(session_id = 7,1,0)) AS Tutorials,  ";
$sql_sess_sum .= "SUM(IF(session_id = 8,1,0)) AS Conference,  ";
$sql_sess_sum .= "SUM(IF(session_id = 9,1,0)) AS Sprints,  ";
$sql_sess_sum .= "SUM(IF(session_id = 10,1,0)) AS WSCL  ";
$sql_sess_sum .= "FROM registrations  ";
$sql_sess_sum .= "LEFT JOIN registered_sessions  ";
$sql_sess_sum .= "ON registration_id = registrations.id  ";
$sql_sess_sum .= "LEFT JOIN sessions  ";
$sql_sess_sum .= "ON session_id = sessions.id  ";
$sql_sess_sum .= "LEFT JOIN participant_types  ";
$sql_sess_sum .= "ON participant_type_id = participant_types.id";


$total_result_sess_sum = @mysql_query($sql_sess_sum, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_sess_sum = @mysql_num_rows($total_result_sess_sum);

do {
  if ($row['Tutorials'] != '')
  {

$display_sess_sum .="<tr>
    <td><strong>Totals</strong></td>
    <td align=\"right\"><strong>" . $row['Conference'] . "</strong></td>
    <td align=\"right\"><strong>" . $row['Sprints'] . "</strong></td>
    <td align=\"right\"><strong>" . $row['Tutorials'] . "</strong></td>
    <td align=\"right\"><strong>" . $row['WSCL'] . "</strong></td>
  </tr>";

$display_sess_paid_sum .="<tr>
    <td><strong>Totals</strong></td>
    <td align=\"right\"><strong>$ " . number_format($row['conference_paid'],2) . "</strong></td>
    <td align=\"right\"><strong>n/a</strong></td>
    <td align=\"right\"><strong>$ " . number_format($row['tutorials_paid'],2) . "</strong></td>
    <td align=\"right\"><strong>$ " . number_format($row['luncheon_paid'],2) . "</strong></td>
  </tr>";
  }
}
while($row = mysql_fetch_array($total_result_sess_sum));

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
  <th colspan=\"9\">" . $row['schedule_day'] . "</th>
</tr>
  <tr>
    <th width=\"13%\">Time</th>
    <th colspan=\"2\" width=\"22%\" style=\"background: #cadbeb;\">Introductory</th>
    <th colspan=\"2\" width=\"22%\" style=\"background: #9fbdeb;\">Intermediate</th>
    <th colspan=\"2\" width=\"22%\" style=\"background: #4f82c8;\">Advanced</th>
    <th colspan=\"2\" width=\"22%\" style=\"background: #316fc6;\">Topics</th>
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
        <td>" . $row['title'] . "<span style=\"font-size: 0.75em;\"><ul><li>Rm: " . $row['name'] . "</li><li>" . $row['description'] . "</li></ul></span></td><td>" . $row['qty'] . "</td>";
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
        <td>" . $row['title'] . "<span style=\"font-size: 0.75em;\"><ul><li>Rm: " . $row['name'] . "</li><li>" . $row['description'] . "</li></ul></span></td><td>" . $row['qty'] . "</td>";
        $last_start_time = $row['start_time'];
//        }
   }
 elseif ($row['track'] == 'Advanced')
   { 
      if($row['talk_id'] == '102')
        {
        $display_block .="
        <td>" . $row['title'] . "<span style=\"font-size: 0.75em;\"><ul><li>Rm: " . $row['name'] . "</li><li>" . $row['description'] . "</li></ul></span></td><td>" . $row['qty'] . "</td>";
        $last_start_time = $row['start_time'];
        }
        else
        {
        $display_block .="
        <td>" . $row['title'] . "<span style=\"font-size: 0.75em;\"><ul><li>Rm: " . $row['name'] . "</li><li>" . $row['description'] . "</li></ul></span></td><td>" . $row['qty'] . "</td>";
        $last_start_time = $row['start_time'];
        }
   }
 elseif ($row['track'] == 'Topics')
   { 
        $display_block .="
        <td>" . $row['title'] . "<span style=\"font-size: 0.75em;\"><ul><li>Rm: " . $row['name'] . "</li><li>" . $row['description'] . "</li></ul></span></td><td>" . $row['qty'] . "</td>";
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

//===========================
//  pull ladies tshirts summary
//===========================

$t_shirt_qty = 0;

$sql_tshirts = "SELECT  ";
$sql_tshirts .= "SUM(IF(tshirt_size_id = 5,1,0)) AS s, ";
$sql_tshirts .= "SUM(IF(tshirt_size_id = 4,1,0)) AS m, ";
$sql_tshirts .= "SUM(IF(tshirt_size_id = 3,1,0)) AS l, ";
$sql_tshirts .= "SUM(IF(tshirt_size_id = 2,1,0)) AS xl, ";
$sql_tshirts .= "SUM(IF(tshirt_size_id = 1,1,0)) AS xxl ";
$sql_tshirts .= "FROM registrations ";
$sql_tshirts .= "WHERE conference_id = 3 ";
$sql_tshirts .= "AND tshirt_type_id = 1";


$total_result_tshirts = @mysql_query($sql_tshirts, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_tshirts = @mysql_num_rows($total_result_tshirts);

do {
  if ($row['s'] != '')
  {

$display_tshirts .="<tr>
    <td align=\"right\"><strong>" . $row['s'] . "</strong></td>
    <td align=\"right\"><strong>" . $row['m'] . "</strong></td>
    <td align=\"right\"><strong>" . $row['l'] . "</strong></td>
    <td align=\"right\"><strong>" . $row['xl'] . "</strong></td>
    <td align=\"right\"><strong>" . $row['xxl'] . "</strong></td>
  </tr>";

  $t_shirt_qty = $row['s'] + $row['m'] + $row['l'] + $row['xl'] + $row['xxl'];
  }

}
while($row = mysql_fetch_array($total_result_tshirts));

//==================================================
//   ladies tshirts Pie QUERY
//==================================================

$row_count=1;

$sql_tshirts_pie = "SELECT  ";
$sql_tshirts_pie .= "size, ";
$sql_tshirts_pie .= "SUM(IF(tshirt_size_id > 0,1,0)) AS qty ";
$sql_tshirts_pie .= "FROM registrations ";
$sql_tshirts_pie .= "LEFT JOIN tshirt_sizes ";
$sql_tshirts_pie .= "ON tshirt_size_id = tshirt_sizes.id ";
$sql_tshirts_pie .= "WHERE conference_id = 3 ";
$sql_tshirts_pie .= "AND tshirt_type_id = 1 ";
$sql_tshirts_pie .= "GROUP BY size ";
$sql_tshirts_pie .= "ORDER BY tshirt_sizes.id DESC";

$total_result_pie = @mysql_query($sql_tshirts_pie, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_pie = @mysql_num_rows($total_result_pie);

while ($row = mysql_fetch_array($total_result_pie)) {

    $size=$row['size'];
    $qty=$row['qty'];
    $diff_radius=($qty/$t_shirt_qty);
    $count_array[] = $diff_radius; 
    $pie_src_d =implode ("," ,$count_array );
    $text_array[] = $size." - ".$qty." [" . number_format($diff_radius *100,0) . "%]";
    $text_array = str_replace (" " ,"%20" ,$text_array );
    $pie_src_l =implode ("|" ,$text_array );
}

$chart= "<img src=\"http://chart.apis.google.com/chart?cht=p&chd=t:$pie_src_d&chs=350x106&chl=$pie_src_l&chco=2b5da6\" width=\"350\" height=\"106\">";


//===========================
//  pull unisex tshirts summary
//===========================

$uni_t_shirt_qty = 0;

$sql_uni_tshirts = "SELECT  ";
$sql_uni_tshirts .= "SUM(IF(tshirt_size_id = 5,1,0)) AS s, ";
$sql_uni_tshirts .= "SUM(IF(tshirt_size_id = 4,1,0)) AS m, ";
$sql_uni_tshirts .= "SUM(IF(tshirt_size_id = 3,1,0)) AS l, ";
$sql_uni_tshirts .= "SUM(IF(tshirt_size_id = 2,1,0)) AS xl, ";
$sql_uni_tshirts .= "SUM(IF(tshirt_size_id = 1,1,0)) AS xxl ";
$sql_uni_tshirts .= "FROM registrations ";
$sql_uni_tshirts .= "WHERE conference_id = 3 ";
$sql_uni_tshirts .= "AND tshirt_type_id = 2";


$total_result_uni_tshirts = @mysql_query($sql_uni_tshirts, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_uni_tshirts = @mysql_num_rows($total_result_uni_tshirts);

do {
  if ($row['s'] != '')
  {

$display_uni_tshirts .="<tr>
    <td align=\"right\"><strong>" . $row['s'] . "</strong></td>
    <td align=\"right\"><strong>" . $row['m'] . "</strong></td>
    <td align=\"right\"><strong>" . $row['l'] . "</strong></td>
    <td align=\"right\"><strong>" . $row['xl'] . "</strong></td>
    <td align=\"right\"><strong>" . $row['xxl'] . "</strong></td>
  </tr>";

  $uni_t_shirt_qty = $row['s'] + $row['m'] + $row['l'] + $row['xl'] + $row['xxl'];
  }

}
while($row = mysql_fetch_array($total_result_uni_tshirts));

//==================================================
//   unisex tshirts Pie QUERY
//==================================================

$row_count=1;

$sql_uni_tshirts_pie = "SELECT  ";
$sql_uni_tshirts_pie .= "size, ";
$sql_uni_tshirts_pie .= "SUM(IF(tshirt_size_id > 0,1,0)) AS qty ";
$sql_uni_tshirts_pie .= "FROM registrations ";
$sql_uni_tshirts_pie .= "LEFT JOIN tshirt_sizes ";
$sql_uni_tshirts_pie .= "ON tshirt_size_id = tshirt_sizes.id ";
$sql_uni_tshirts_pie .= "WHERE conference_id = 3 ";
$sql_uni_tshirts_pie .= "AND tshirt_type_id = 2 ";
$sql_uni_tshirts_pie .= "GROUP BY size ";
$sql_uni_tshirts_pie .= "ORDER BY tshirt_sizes.id DESC";

$total_result_uni_pie = @mysql_query($sql_uni_tshirts_pie, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found_uni_pie = @mysql_num_rows($total_result_uni_pie);

while ($row = mysql_fetch_array($total_result_uni_pie)) {

    $u_size=$row['size'];
    $u_qty=$row['qty'];
    $u_diff_radius=($u_qty/$uni_t_shirt_qty);
    $u_count_array[] = $u_diff_radius; 
    $u_pie_src_d =implode ("," ,$u_count_array );
    $u_text_array[] = $u_size." - ".$u_qty." [" . number_format($u_diff_radius *100,0) . "%]";
    $u_text_array = str_replace (" " ,"%20" ,$u_text_array );
    $u_pie_src_l =implode ("|" ,$u_text_array );
}

$chart_uni= "<img src=\"http://chart.apis.google.com/chart?cht=p&chd=t:$u_pie_src_d&chs=350x106&chl=$u_pie_src_l&chco=2b5da6\" width=\"350\" height=\"106\">";


?>

<!DOCTYPE html>
<html>
<?php $thisPage="Admin"; ?>
<head>
<?php include('../inc/force_ssl.php') ?>

<?php @ require_once ("../inc/second_level_header.php"); ?>

<link rel="shortcut icon" href="http://conference.scipy.org/scipy2013/favicon.ico" />

    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
     google.load('visualization', '1', {'packages': ['geochart']});
     google.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
        <?php echo $country_II ?>
         ]);

        var options = {minValue: 0,  colors: ['#cadbeb','#2b5da6']};

        var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    };
    </script>

</head>

<body>

<div id="container">

<?php include('../inc/admin_page_headers.php') ?>

<section id="sidebar">
  <?php include("../inc/sponsors.php") ?>
</section>

<section id="main-content">

<h1>Admin</h1>

<h2>Registrations</h2>
<p>Total Registered: <strong><?php echo $registered_qty ?></strong></p>
<div align="center">

<div class="row">
  <h3 style="text-align: center;">Participants Locations</h3>
<div id="chart_div" style="width: 600px; height: 330px;"></div>
</div>

<div class="row" style="margin-top: 3em;">
  <div class="cell">
  <h3>Daily Registrations</h3>
<?php echo "$daily_reg_chart" ?>
  </div>
  <div class="cell">
  <h3 style="margin-bottom: 3em;">Registration Types</h3>
<?php echo"$chart_reg" ?>
  </div>
</div>

<table id="registrants_table" width="450">
<tr>
  <th>Participant Type<br />[qty]</th>
  <th><div align="right">Conference</div></th>
  <th><div align="right">Sprints</div></th>
  <th><div align="right">Tutorials</div></th>
  <th><div align="right">WSCL</div></th>
</tr>
<?php echo $display_sessions ?>
<?php echo $display_sess_sum ?>
</table>
<br />
</div>

<p>Total Paid: <strong>$ <?php echo $registered_amt_paid ?></strong></p>

<div align="center">
<table id="registrants_table" width="450">
<tr>
  <th>Participant Type<br />[$]</th>
  <th><div align="right">Conference</div></th>
  <th><div align="right">Sprints</div></th>
  <th><div align="right">Tutorials</div></th>
  <th><div align="right">WSCL</div></th>
</tr>
<?php echo $display_sessions_paid ?>
<?php echo $display_sess_paid_sum ?>
</table>
</div>
<br />
<hr />
<div class="row">
<h2>Tutorials</h2>

<div class="cell" style="width: 90%;">
<table class="registrants_table schedule" width="700" style="margin: 0 auto;">

<?php echo "$display_block" ?>

</table>
</div>
<div style="clear: both;"></div>

<hr />
<div class="row">
<h2>T-Shirts</h2>

<div class="cell">
<p>Ladies T-Shirts: <strong><?php echo $t_shirt_qty ?></strong></p>
<?php echo"$chart" ?>
<table id="registrants_table"  class="schedule"width="250" style="margin: 0 auto;">
<tr>
  <th width="50"><div align="right">S</th>
  <th width="50"><div align="right">M</div></th>
  <th width="50"><div align="right">L</div></th>
  <th width="50"><div align="right">XL</div></th>
  <th width="50"><div align="right">XXL</div></th>
</tr>
<?php echo $display_tshirts ?>
</table>
</div>
<div class="cell">
<p>Unisex T-Shirts: <strong><?php echo $uni_t_shirt_qty ?></strong></p>
<?php echo"$chart_uni" ?>
<table id="registrants_table" class="schedule" width="250" style="margin: 0 auto;">
<tr>
  <th width="50"><div align="right">S</th>
  <th width="50"><div align="right">M</div></th>
  <th width="50"><div align="right">L</div></th>
  <th width="50"><div align="right">XL</div></th>
  <th width="50"><div align="right">XXL</div></th>
</tr>
<?php echo $display_uni_tshirts ?>
</table>
</div>
</div>
<hr />
</section>



<div style="clear: both;"></div>
<footer id="page_footer">
<?php include('../inc/page_footer.php') ?>
</footer>
</div>
</body>

</html>