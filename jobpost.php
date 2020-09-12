<?php
session_start();

$db = new mysqli("localhost","jbh262","Jay@351","jbh262");
if($db->connect_error){
  die ("Connection error: " . $db->connect_error);
}

if ($_REQUEST['function'] == "blah"){

$EmployerEmail="testuser@test.com";
$JobTitle = $_POST['jtitle'];
$PositionType = $_POST['ptype'];
$JobDescription = $_POST['jdesc'];

$Comp_Query="Select * from Employer where email='$EmployerEmail';";
$Comp_Result=$db->query($Comp_Query);
$row = $Comp_Result->fetch_assoc();

$Comp = $row["Company_Name"];

$Sal=$_POST['salary'];
$Qualify=$_POST['qualif'];
$Respo=$_POST['respo'];
    if(isset($_POST['Submit'])){
    $querys="INSERT into Jobs_Posted (email,Job_Title,Position_type,Description,company,Salary,Responsibilities) VALUES ('$EmployerEmail','$JobTitle','$PositionType','$JobDescription','$Comp','$Sal','$Qualify','$Respo');";
    $result = $db->query($querys);
    if($result){
        header('location: Shez.php');
        }   
    }
}


?>