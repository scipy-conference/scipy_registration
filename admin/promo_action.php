<?php

$submit = $_POST['submit'];

if ($submit == "Update") 

{

$action = "updated";

$id = $_POST['id'];
$code = $_POST['code'];
$discount = $_POST['discount'];
$description = $_POST['description'];
$promotion_name = $_POST['promotion_name'];
$active_date = $_POST['active_date'];
$exp_date = $_POST['exp_date'];


//======================================
//  UPDATE PROMO TABLE
//======================================

include('../inc/db_conn.php');

$sql_3 ="UPDATE promotion_codes ";
$sql_3 .="SET ";
$sql_3 .="code=\"$code\", ";
$sql_3 .="discount=\"$discount\", ";
$sql_3 .="description=\"$description\", ";
$sql_3 .="promotion_name=\"$promotion_name\", ";
$sql_3 .="active_date=\"$active_date\", ";
$sql_3 .="exp_date=\"$exp_date\", ";
$sql_3 .="updated_at=NOW() ";
$sql_3 .="WHERE id=\"$id\"";

$result_3 = @mysql_query($sql_3, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

include("promo_action_result.php");

} 

elseif ($submit == "Enter") 

{

$action = "entered";

$id = $_POST['id'];
$code = $_POST['code'];
$discount = $_POST['discount'];
$description = $_POST['description'];
$promotion_name = $_POST['promotion_name'];
$active_date = $_POST['active_date'];
$exp_date = $_POST['exp_date'];


//======================================
//  UPDATE PROMO TABLE
//======================================

include('../inc/db_conn.php');

$sql_1 ="INSERT INTO promotion_codes ";
$sql_1 .="(";
$sql_1 .="conference_id, ";
$sql_1 .="code, ";
$sql_1 .="discount, ";
$sql_1 .="description, ";
$sql_1 .="promotion_name, ";
$sql_1 .="active_date, ";
$sql_1 .="exp_date, ";
$sql_1 .="created_at, ";
$sql_1 .="updated_at ";
$sql_1 .=") ";
$sql_1 .="VALUES ";
$sql_1 .="(";
$sql_1 .="3, ";
$sql_1 .="\"$code\", ";
$sql_1 .="\"$discount\", ";
$sql_1 .="\"$description\", ";
$sql_1 .="\"$promotion_name\", ";
$sql_1 .="\"$active_date\", ";
$sql_1 .="\"$exp_date\", ";
$sql_1 .="NOW(), ";
$sql_1 .="NOW()";
$sql_1 .=")";

$result_1 = @mysql_query($sql_1, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

include("promo_action_result.php");

} 

?>