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

//$sql_registrants = sprintf( 'SELECT participants.id, registrations.id, last_name AS "Last Name", first_name AS "First Name", email AS "Email Address", affiliation AS "Affiliation", registrations.created_at AS "Registration Date", type AS "Rate", MAX(IF(session_id = "8",amt_paid,"")) AS Conference, MAX(IF(session_id = "9",amt_paid,"")) AS Sprints, MAX(IF(session_id = "7",amt_paid,"")) AS Tutorials, ordernumber AS OrderNum, IF(tshirt_size_id = "5",1,"") AS S, IF(tshirt_size_id = "4",1,"") AS M, IF(tshirt_size_id = "3",1,"") AS L, IF(tshirt_size_id = "2",1,"") AS XL, IF(tshirt_size_id = "1",1,"") AS XXL FROM registrations LEFT JOIN participants ON participant_id = participants.id LEFT JOIN participant_types ON participant_type_id = participant_types.id LEFT JOIN tshirt_sizes ON tshirt_size_id = tshirt_sizes.id LEFT JOIN registered_sessions ON registration_id = registrations.id LEFT JOIN registered_tutorials ON registered_sessions.id = registered_session_id LEFT JOIN sessions ON session_id = sessions.id WHERE registrations.conference_id = 3 GROUP BY participants.id;');

$sql_registrants = sprintf( 'SELECT participant_id, first_name, last_name, email, title FROM registered_tutorials LEFT JOIN registered_sessions ON registered_session_id = registered_sessions.id LEFT JOIN registrations ON  registration_id = registrations.id LEFT JOIN sessions ON session_id = sessions.id LEFT JOIN participants ON participant_id = participants.id LEFT JOIN talks ON talk_id = talks.id WHERE registrations.conference_id = 3 AND registered_sessions.session_id = 7 ORDER BY title, last_name, first_name;');


$result = @mysql_query($sql_registrants, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

  //
  // execute sql query
  //
  //$query = sprintf( 'SELECT * FROM MYSQL_TABLE' );
  //$result = mysql_query( $query, $conn ) or die( mysql_error( $conn ) );
  //
  // send response headers to the browser
  // following headers instruct the browser to treat the data as a csv file called export.csv
  //
  header( 'Content-Type: text/csv' );
  header( 'Content-Disposition: attachment;filename=scipy2014_tutorial_registrants.csv' );
  //
  // output header row (if atleast one row exists)
  //
  $row = mysql_fetch_assoc( $result );
  if ( $row )
  {
    echocsv( array_keys( $row ) );
  }
  //
  // output data rows (if atleast one row exists)
  //
  while ( $row )
  {
    echocsv( $row );
    $row = mysql_fetch_assoc( $result );
  }
  //
  // echocsv function
  //
  // echo the input array as csv data maintaining consistency with most CSV implementations
  // * uses double-quotes as enclosure when necessary
  // * uses double double-quotes to escape double-quotes 
  // * uses CRLF as a line separator
  //
  function echocsv( $fields )
  {
    $separator = '';
    foreach ( $fields as $field )
    {
      if ( preg_match( '/\\r|\\n|,|"/', $field ) )
      {
        $field = '"' . str_replace( '"', '""', $field ) . '"';
      }
      echo $separator . $field;
      $separator = ',';
    }
    echo "\r\n";
  }
?>