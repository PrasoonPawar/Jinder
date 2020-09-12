<?php 
$host='localhost';
  $user='jbh262';
  $password='Jay@351';
  $database='jbh262';
  $table='jinder_users';
  $validate = true;
  $connection = mysql_connect($host,$user,$password,$database) or die("Connection to MYSQL failed!</br> ". mysql_error());
  //check if the entry already exists
  if (ISSET($_REQUEST['func'])) {
    $function = $_REQUEST['func'];
  } ELSE {
    $function = "dummy";
  }
	$query_string = $_REQUEST; 				//Copy $_REQUEST variable so we don't have to mess with it #bestpractices.
  unset ($query_string['func']);			//Strip off any passed variable that isn't a table entry.

  foreach($query_string AS $varname => $varvalue) {	//Combine array key and array value into something we can use in SQL.
    $sqlValues[] = $varname . "='" . $varvalue . "'";
  }  

  if(isset($sqlValues)) {				//Array to string
    $sqlValues = implode(", ", $sqlValues);
  }  
  switch ($function) { 					//Decide what to do based on the value of $function
    case 'checkExisting':
	  $jobLog_query = "SELECT * FROM jbh262.Job_Logs WHERE Job_Posted_Id = '" .$_REQUEST['Job_Posted_Id'] ."' AND email= '". $_REQUEST['email']."'";
      $jobLog_result = mysql_query($jobLog_query, $connection) or die("MYSQL - " . $function . " query failed!</br> " . mysql_error());
      $resultArray = array();
	while($row = mysql_fetch_assoc($jobLog_result)){

		array_push($resultArray, $row);
	}
      echo json_encode($resultArray);
	  //end of the check
	  break;
	  case 'addNew':
	  echo "INSERT INTO jbh262.Job_Logs ". $sqlValues;
	  $newJobPost_query = "INSERT INTO jbh262.Job_Logs SET ". $sqlValues;
      mysql_query($newJobPost_query, $connection) or die("MYSQL - " . $function . " query failed!</br> " . mysql_error());
	  break;
	  case 'updateExisting':
	  
	  break;
	  default: 
				echo "no function set";
				break;
				
  }
  ?>