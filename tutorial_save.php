<?php 

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

?>
