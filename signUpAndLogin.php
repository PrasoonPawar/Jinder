<?php
  $host='localhost';
  $user='jbh262';
  $password='Jay@351';
  $database='jbh262';
  $table='jinder_users';
$validate = true;
  $connection = mysqli_connect($host,$user,$password,$database) or die("Connection to MYSQL failed!</br> ". mysql_error());

  if (ISSET($_REQUEST['function'])) {
    $function = $_REQUEST['function'];
  } ELSE {
    $function = "dummy";
  }

  $query_string = $_REQUEST; 				//Copy $_REQUEST variable so we don't have to mess with it #bestpractices.
  unset ($query_string['function']);			//Strip off any passed variable that isn't a table entry.

  foreach($query_string AS $varname => $varvalue) {	//Combine array key and array value into something we can use in SQL.
    $sqlValues[] = $varname . "='" . $varvalue . "'";
  }  

  if(isset($sqlValues)) {				//Array to string
    $sqlValues = implode(", ", $sqlValues);
  }  

  switch ($function) { 					//Decide what to do based on the value of $function
    case 'sign_in':
	echo $query_string["email"];
	echo $query_string["password"];
      //print "last action -> SIGN IN!";
	  $validate = true;
	  $email = trim($_POST["email"]);
	  $password = trim($_POST["password"]);
      $query = "SELECT * FROM jbh262.jinder_users WHERE email = '" . $query_string['email'] ."' AND password = '". $query_string['password']."'";
	  //$timeOut_result = mysql_query($query, $connection) or die("MYSQL -" . $function . " query failed!</br> " . mysql_error());
	  $r = $connection->query($query);
		$resultArray = $r->fetch_assoc();
        //$resultArray = mysql_fetch_assoc($timeOut_result);
		
		if($query_string['email'] != $resultArray["email"] && $query_string['password'] != $resultArray["password"]){
			//incorrect password
			
			$validate = false;
		}else{
		
        if($email == null || $email == "" )
        {
			

            $validate = false;
        }
        
        
        if($password == null || $password == "" )
        {
            $validate = false;
        }
		}
		if($validate == true)
		{
        
        session_start();
        $_SESSION["email"] = $resultArray["email"];
		$_SESSION["user_type"] = $resultArray["user_type"];
        header("Location: main.php");
        //$db->close();
        exit();
		}
		else 
		{
        $error = "The email/password combination was incorrect. Login failed.";
		//echo $error;
       // echo '<script> </script>';
       header("location: login.html");
		echo '<script> alert("The email/password combination was incorrect. Login failed.") </script>';
        //$db->close();
		}
		
      break;
    case 'sign_up':
        $email = trim($_POST["email"]);
        $password = trim($_POST["pswd"]);
        $usertype = trim($_POST["usertype"]);
        $validate = false; 
        $firstname = trim($_POST["fname"]);
        
        echo "usertype " . $usertype;
        
        if (strlen($email) > 0 && strlen($password) > 0){
            $q1 = "INSERT INTO jbh262.jinder_users (email, password, user_type) VALUES ('$email', '$password', '$usertype');";
            if($result = $connection->query($q1)){
                $validate = true;
            }
            else{
                header("location: signup.html");
            }
        }
        
        if ($usertype == "employer" && $validate){
            $firstname = trim($_POST["fname"]);
            $lastname = trim($_POST["lname"]);
            $companyname = trim($_POST["cname"]);
            $dob = trim($_POST["dob"]);
            
            if (strlen($firstname) > 0 && strlen($lastname) > 0 && strlen($dob) > 0 && strlen($email) > 0 && strlen($companyname) > 0){
                $q2 = "INSERT INTO Employer (Email, First_Name, Last_Name, Company_Name) VALUES ('$email', '$firstname', '$lastname', '$companyname');";
                
                $result = $connection->query($q2);
                header("location: login.html");
            }
        
        }
        else if ($usertype == "jobSeeker" && $validate){
            $firstname = trim($_POST["fname"]);
            $lastname = trim($_POST["lname"]);
            $dob = trim($_POST["dob"]);
            
            if (strlen($firstname) > 0 && strlen($lastname) > 0 && strlen($dob) > 0 && strlen($email) > 0){
                $q3 = "INSERT INTO Job_Seekers (Email, First_Name, Last_Name, D_O_B) VALUES ('$email', '$firstname', '$lastname', '$dob');";
                    
                $result = $connection->query($q3);
                
                header("location: login.html");
            }
        }
        else{
             header("location: signup.html");
        }
            
          break;
            
        //}
    /*case 'sign_out':
      print "last action -> SIGN OUT!";
      $query = "UPDATE dcAccess.signIns SET timeOut = NOW() WHERE PID = '" . $query_string['PID'] . "' ORDER BY id DESC LIMIT 1";
      mysql_query($query, $connection) or die("MYSQL " . $function . " query failed!</br> " . mysql_error());
     	 exit(1);
	 break;
    case 'queryEscorteeTimeOut':
	$timeOut_query = "SELECT * FROM dcAccess.signIns WHERE escorteePID = '" . $query_string['PID'] . "' ORDER BY id DESC LIMIT 1";
        $timeOut_result = mysql_query($timeOut_query, $connection) or die("MYSQL - " . $function . " query failed!</br> " . mysql_error());
        $resultArray = mysql_fetch_assoc($timeOut_result);
        echo json_encode($resultArray);
	exit(1);
	break;
    case 'queryTimeOut':
	$timeOut_query = "SELECT * FROM dcAccess.signIns WHERE pid = '" . $query_string['PID'] . "' ORDER BY id DESC LIMIT 1";
        $timeOut_result = mysql_query($timeOut_query, $connection) or die("MYSQL - " . $function . " query failed!</br> " . mysql_error());
        $resultArray = mysql_fetch_assoc($timeOut_result);
        echo json_encode($resultArray);
        exit(1);
        break;
    case 'bombDB':
	for($x = 1; $x <= 20000; $x++){
	$query = "INSERT INTO dcAccess.tempUsers (name, pid, company) VALUES('xxxxxx', '" . $x*10000 . "','yyyyyyy')";
	mysql_query($query, $connection) or die("MYSQL - " . $function . " query failed!</br>" . mysql_error());
	}
	exit(1);
	break;
    case 'query':
      //print "last action -> QUERY DATABASE!";
      $tempUsers_query = "SELECT * FROM dcAccess.tempUsers WHERE pid = '" . $query_string['PID']."'";
      $tempUsers_result = mysql_query($tempUsers_query, $connection) or die("MYSQL - " . $function . " query failed!</br> " . mysql_error());
	if (mysql_num_rows($tempUsers_result)==0) { $query = "SELECT * FROM dcAccess.tempUsers WHERE tempPID = '".$query_string['PID']."'";
		 $tempUsers_result = mysql_query($query, $connection) or die("MYSQL - " . $function . " query failed!</br> " . mysql_error());
	  }
	$resultArray = mysql_fetch_assoc($tempUsers_result);
      	echo json_encode($resultArray);
      exit(1);
      break;
    case 'tempSignIn':
	$tempSignIn_query = "UPDATE dcAccess.tempUsers SET tempPID = '".$query_string['tempPID']."' WHERE empid = '".$query_string['empid']."'";
	mysql_query($tempSignIn_query, $connection) or die ("MYSQL " . $function . " query failed!</br> " . mysql_error());
	exit(1);
	break;
    case 'tempSignOut':
	$tempSignOut_query = "UPDATE dcAccess.tempUsers SET tempPID = NULL where empid = '".$query_string['empid']."'";
	mysql_query($tempSignOut_query, $connection) or die ("MYSQL " . $function . " query failed!</br> " . mysql_error());
	exit(1);
	break;
    case 'queryEmpID':
	$tempUsers_query = "SELECT * FROM dcAccess.tempUsers WHERE empid = '" . $query_string['empid']."'";
      $tempUsers_result = mysql_query($tempUsers_query, $connection) or die("MYSQL - " . $function . " query failed!</br> " . mysql_error());
        $resultArray = mysql_fetch_assoc($tempUsers_result);
        echo json_encode($resultArray);
      exit(1);
      break;
    case 'queryTempPID':
	$query = "SELECT * FROM dcAccess.tempUsers WHERE tempPID = '".$query_string['tempPID']."'";
	$result = mysql_query($query, $connection) or die("MYSQL - " . $function . " query failed!</br> " . mysql_error());
        $resultArray = mysql_fetch_assoc($result);
        echo json_encode($resultArray);
	exit(1);
	break; 
    case 'queryKey':
        $query = "SELECT * FROM dcAccess.keyLog WHERE key_name = '".$query_string['key_name']."' ORDER BY id DESC LIMIT 1";
        $result = mysql_query($query, $connection) or die("MYSQL - " . $function . " query failed!</br> " . mysql_error());
        $resultArray = mysql_fetch_assoc($result);
        echo json_encode($resultArray);
        exit(1);
        break;
    case 'currentUsers':
	$activeUsers_query = "SELECT * FROM dcAccess.signIns WHERE timeOut is NULL";
	$activeUsers_result = mysql_query($activeUsers_query, $connection) or die("MYSQL - " . $function . " query failed!</br> " . mysql_error());
	$response = array();
	$response['users'] = array();
	//$resultArray = mysql_fetch_assoc($activeUsers_result);
	while($row = mysql_fetch_assoc($activeUsers_result)){
	array_push($response['users'],$row);
	//echo json_encode($row);
	}
	echo json_encode($response);
	exit(1);
	break; 
    case 'trackTempCards':
	$activeUsers_query = "SELECT * FROM dcAccess.tempUsers WHERE tempPID IS NOT NULL";
        $activeUsers_result = mysql_query($activeUsers_query, $connection) or die("MYSQL - " . $function . " query failed!</br> " . mysql_error());
        $response = array();
        $response['users'] = array();
        //$resultArray = mysql_fetch_assoc($activeUsers_result);
        while($row = mysql_fetch_assoc($activeUsers_result)){
        array_push($response['users'],$row);
        //echo json_encode($row);
        }
        echo json_encode($response);
        exit(1);
        break;
     case 'trackKeys':
        $activeUsers_query = "SELECT * FROM dcAccess.keyLog WHERE timeOut IS  NULL";
        $activeUsers_result = mysql_query($activeUsers_query, $connection) or die("MYSQL - " . $function . " query failed!</br> " . mysql_error());
        $response = array();
        $response['users'] = array();
        //$resultArray = mysql_fetch_assoc($activeUsers_result);
        while($row = mysql_fetch_assoc($activeUsers_result)){
        array_push($response['users'],$row);
        //echo json_encode($row);
        }
        echo json_encode($response);
        exit(1);
        break;
    case 'key_sign_in':
      //print "last action -> SIGN IN!";
      $query = "INSERT INTO dcAccess.keyLog SET timeIn = NOW()," . $sqlValues;
      mysql_query($query, $connection) or die("MYSQL -" . $function . " query failed!</br> " . mysql_error());
      break;
    case 'key_sign_out':
      //print "last action -> SIGN OUT!";
      $query = "UPDATE dcAccess.keyLog SET timeOut = NOW() WHERE key_name = '" . $query_string['key_name'] . "' ORDER BY id DESC LIMIT 1";
      mysql_query($query, $connection) or die("MYSQL " . $function . " query failed!</br> " . mysql_error());
         exit(1);
         break;
    
    case 'clear':
      print "last action -> CLEAR DATABASE!";
      $query = "truncate " . $table;
      mysql_query($query, $connection) or die("MYSQL - " . $function . " query failed!</br> " . mysql_error());
      break;*/
    default:
      echo "last action -> DEFAULT!";
      break;
  }  
  
  
  
  ?>
  
