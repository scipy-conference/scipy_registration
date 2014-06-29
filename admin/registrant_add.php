<?php

$countries = array('NONE' => '', 'us' => 'United States', 'af' => 'Afghanistan', 'al' => 'Albania', 'dz' => 'Algeria', 'as' => 'American Samoa (US)', 'ad' => 'Andorra', 'ao' => 'Angola', 'ai' => 'Anguilla (UK)', 'ag' => 'Antigua and Barbuda', 'ar' => 'Argentina', 'am' => 'Armenia', 'aw' => 'Aruba', 'au' => 'Australia', 'at' => 'Austria', 'az' => 'Azerbaijan', 'bs' => 'Bahamas', 'bh' => 'Bahrain', 'bd' => 'Bangladesh', 'bb' => 'Barbados', 'by' => 'Belarus', 'be' => 'Belgium', 'bz' => 'Belize', 'bj' => 'Benin', 'bm' => 'Bermuda (UK)', 'bt' => 'Bhutan', 'bo' => 'Bolivia', 'ba' => 'Bosnia and Herzegovina', 'bw' => 'Botswana', 'br' => 'Brazil', 'vg' => 'British Virgin Islands (UK)', 'bn' => 'Brunei Darussalam', 'bg' => 'Bulgaria', 'bf' => 'Burkina Faso', 'mm' => 'Burma', 'bi' => 'Burundi', 'kh' => 'Cambodia', 'cm' => 'Cameroon', 'ca' => 'Canada', 'cv' => 'Cape Verde', 'ky' => 'Cayman Islands (UK)', 'cf' => 'Central African Republic', 'td' => 'Chad', 'cl' => 'Chile', 'cn' => 'China', 'cx' => 'Christmas Island (AU)', 'cc' => 'Cocos (Keeling) Islands (AU)', 'co' => 'Colombia', 'km' => 'Comoros', 'cd' => 'Congo, Democratic Republic of the', 'cg' => 'Congo, Republic of the', 'ck' => 'Cook Islands (NZ)', 'cr' => 'Costa Rica', 'ci' => 'Cote d\'Ivoire', 'hr' => 'Croatia', 'cu' => 'Cuba', 'cy' => 'Cyprus', 'cz' => 'Czech Republic', 'dk' => 'Denmark', 'dj' => 'Djibouti', 'dm' => 'Dominica', 'do' => 'Dominican Republic', 'tp' => 'East Timor', 'ec' => 'Ecuador', 'eg' => 'Egypt', 'sv' => 'El Salvador', 'gq' => 'Equatorial Guinea', 'er' => 'Eritrea', 'ee' => 'Estonia', 'et' => 'Ethiopia', 'fk' => 'Falkland Islands (UK)', 'fo' => 'Faroe Islands (DK)', 'fj' => 'Fiji', 'fi' => 'Finland', 'fr' => 'France', 'gf' => 'French Guiana (FR)', 'pf' => 'French Polynesia (FR)', 'ga' => 'Gabon', 'gm' => 'Gambia', 'ge' => 'Georgia', 'de' => 'Germany', 'gh' => 'Ghana', 'gi' => 'Gibraltar (UK)', 'gr' => 'Greece', 'gl' => 'Greenland (DK)', 'gd' => 'Grenada', 'gp' => 'Guadeloupe (FR)', 'gu' => 'Guam (US)', 'gt' => 'Guatemala', 'gn' => 'Guinea', 'gw' => 'Guinea-Bissau', 'gy' => 'Guyana', 'ht' => 'Haiti', 'va' => 'Holy See (Vatican City)', 'hn' => 'Honduras', 'hk' => 'Hong Kong (CN)', 'hu' => 'Hungary', 'is' => 'Iceland', 'in' => 'India', 'id' => 'Indonesia', 'ir' => 'Iran', 'iq' => 'Iraq', 'ie' => 'Ireland', 'il' => 'Israel', 'it' => 'Italy', 'jm' => 'Jamaica', 'jp' => 'Japan', 'jo' => 'Jordan', 'kz' => 'Kazakstan', 'ke' => 'Kenya', 'ki' => 'Kiribati', 'kp' => 'Korea, Democratic People\'s Republic (North)', 'kr' => 'Korea, Republic of (South)', 'kw' => 'Kuwait', 'kg' => 'Kyrgyzstan', 'la' => 'Laos', 'lv' => 'Latvia', 'lb' => 'Lebanon', 'ls' => 'Lesotho', 'lr' => 'Liberia', 'ly' => 'Libya', 'li' => 'Liechtenstein', 'lt' => 'Lithuania', 'lu' => 'Luxembourg', 'mo' => 'Macau (CN)', 'mk' => 'Macedonia', 'mg' => 'Madagascar', 'mw' => 'Malawi', 'my' => 'Malaysia', 'mv' => 'Maldives', 'ml' => 'Mali', 'mt' => 'Malta', 'mh' => 'Marshall islands', 'mq' => 'Martinique (FR)', 'mr' => 'Mauritania', 'mu' => 'Mauritius', 'yt' => 'Mayotte (FR)', 'mx' => 'Mexico', 'fm' => 'Micronesia, Federated States of', 'md' => 'Moldova', 'mc' => 'Monaco', 'mn' => 'Mongolia', 'ms' => 'Montserrat (UK)', 'ma' => 'Morocco', 'mz' => 'Mozambique', 'na' => 'Namibia', 'nr' => 'Nauru', 'np' => 'Nepal', 'nl' => 'Netherlands', 'an' => 'Netherlands Antilles (NL)', 'nc' => 'New Caledonia (FR)', 'nz' => 'New Zealand', 'ni' => 'Nicaragua', 'ne' => 'Niger', 'ng' => 'Nigeria', 'nu' => 'Niue', 'nf' => 'Norfolk Island (AU)', 'mp' => 'Northern Mariana Islands (US)', 'no' => 'Norway', 'om' => 'Oman', 'pk' => 'Pakistan', 'pw' => 'Palau', 'pa' => 'Panama', 'pg' => 'Papua New Guinea', 'py' => 'Paraguay', 'pe' => 'Peru', 'ph' => 'Philippines', 'pn' => 'Pitcairn Islands (UK)', 'pl' => 'Poland', 'pt' => 'Portugal', 'pr' => 'Puerto Rico (US)', 'qa' => 'Qatar', 're' => 'Reunion (FR)', 'ro' => 'Romania', 'ru' => 'Russia', 'rw' => 'Rwanda', 'sh' => 'Saint Helena (UK)', 'kn' => 'Saint Kitts and Nevis', 'lc' => 'Saint Lucia', 'pm' => 'Saint Pierre and Miquelon (FR)', 'vc' => 'Saint Vincent and the Grenadines', 'ws' => 'Samoa', 'sm' => 'San Marino', 'st' => 'Sao Tome and Principe', 'sa' => 'Saudi Arabia', 'sn' => 'Senegal', 'yu' => 'Serbia and Montenegro', 'sc' => 'Seychelles', 'sl' => 'Sierra Leone', 'sg' => 'Singapore', 'sk' => 'Slovakia', 'si' => 'Slovenia', 'sb' => 'Solomon Islands', 'so' => 'Somalia', 'za' => 'South Africa', 'gs' => 'South Georgia & South Sandwich Islands (UK)', 'es' => 'Spain', 'lk' => 'Sri Lanka', 'sd' => 'Sudan', 'sr' => 'Suriname', 'sz' => 'Swaziland', 'se' => 'Sweden', 'ch' => 'Switzerland', 'sy' => 'Syria', 'tw' => 'Taiwan', 'tj' => 'Tajikistan', 'tz' => 'Tanzania', 'th' => 'Thailand', 'tg' => 'Togo', 'tk' => 'Tokelau', 'to' => 'Tonga', 'tt' => 'Trinidad and Tobago', 'tn' => 'Tunisia', 'tr' => 'Turkey', 'tm' => 'Turkmenistan', 'tc' => 'Turks and Caicos Islands (UK)', 'tv' => 'Tuvalu', 'ug' => 'Uganda', 'ua' => 'Ukraine', 'ae' => 'United Arab Emirates', 'gb' => 'United Kingdom', 'uy' => 'Uruguay', 'uz' => 'Uzbekistan', 'vu' => 'Vanuatu', 've' => 'Venezuela', 'vn' => 'Vietnam', 'vg' => 'British Virgin Islands (UK)', 'wf' => 'Wallis and Futuna (FR)', 'eh' => 'Western Sahara', 'ye' => 'Yemen', 'zm' => 'Zambia', 'zw' => 'Zimbabwe');


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
    <td>" . $row['type'] . "";
    if ($row[id] > 3)
      {
         $display_participants .=" - <span class=\"highlight\"><em>free</em></span>";
      }
    
    $display_participants .="</td>
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
<?php include('../inc/force_ssl.php') ?>

<?php @ require_once ("../inc/second_level_header.php"); ?>

<link rel="shortcut icon" href="http://conference.scipy.org/scipy2013/favicon.ico" />

        <link rel="stylesheet" href="../inc/validationEngine.jquery.css" type="text/css"/>
        <!-- <link rel="stylesheet" href="../inc/template.css" type="text/css"/> -->
        <script src="../inc/jquery-1.6.min.js" type="text/javascript">
        </script>
        <script src="../inc/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8">
        </script>
        <script src="../inc/jquery.validationEngine.js" type="text/javascript" charset="utf-8">
        </script>
        <script>
            jQuery(document).ready(function(){
                // binds form submission and fields to the validation engine
                jQuery("#formID").validationEngine();
            });
        </script>



</head>

<body>

<div id="container">

<?php include('../inc/admin_page_headers.php') ?>

<section id="sidebar">
  <?php include("../inc/sponsors.php") ?>
</section>

<section id="main-content">
<form id="formID" class="formular" method="post" action="add_registrant.php">
<?php include('_registrant_form.php') ?>

<div align="center">
  <input type="submit" name="submit" value="Add Registrant"/>
</div>
</form>
</section>



<div style="clear: both;"></div>
<footer id="page_footer">
<?php include('../inc/page_footer.php') ?>
</footer>
</div>
</body>

</html>