<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'L'){
    header('Location: ../index.php');
}
else{
    $Landlord = $_SESSION['UserID'];
}
$UserID= 'fdgkjgkj@lhlksdjhflk.com'; //fake session stuff
$propertyID = '2';

//upload picture and add to query
include_once '../db_config.php';
$mySQLConnection = connectToDatabase();

$query = "SELECT  ApplicantKeywords FROM Applicants WHERE PropertyID = '$propertyID' AND Email = '$UserID'";

$result = $mySQLConnection->query($query, $mysql_access);
//Close database
$mySQLConnection->close();

if ($result->num_rows <= 0){
    echo"Nothing Found";
}
else{
    $row = $result->fetch_row();
    $dNumber = strtok($row[0], "|");
    $mDate = strtok("|");
    $rAmount = strtok("|");
    $dAmount = strtok("|");
    $nOccupants = strtok("|");
    $nUnderOccupants = strtok("|");
    $pet = strtok("|");
    $cDate = strtok("|");
    $leaving = strtok("|");
    $aName = strtok("|");
    $cPhone = strtok("|");
    $bankruptcy = strtok("|");
    $evicted = strtok("|");
    $late = strtok("|");
    $refused = strtok("|");
    $status = strtok("|");
    $emp = strtok("|");
    $supN = strtok("|");
    $supP = strtok("|");
    $salary = strtok("|");
    $school = strtok("|");
    $rName = strtok("|");
    $rAddress = strtok("|");
    $rPhone = strtok("|");
    $Rrelationship = strtok("|");

    echo "$nOccupants;$nUnderOccupants;$pet;$cDate;$leaving;$aName;$cPhone;$bankruptcy;$evicted;$late;$refused;$status;$emp;$supN;$supP;$salary;$school;
    $rName;$rAddress;$rPhone;$Rrelationship";
}

?>