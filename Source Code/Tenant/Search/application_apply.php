<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'T'){
    header('Location: ../../index.php');
}
else{
    $UserID = $_SESSION['UserID'];
    $propertyID = $_SESSION['PropertyID'];
}

//$propertyID = '2';//fake session stuff


if(isset($_POST['dNumber']))
    $dNumber = str_replace("|", "", $_POST['dNumber']);
if(isset($_POST['mDate']))
    $mDate = str_replace("|", "", $_POST['mDate']);
if(isset($_POST['rAmount']))
    $rAmount = str_replace("|", "", $_POST['rAmount']);
if(isset($_POST['dAmount']))
    $dAmount = str_replace("|", "", $_POST['dAmount']);
if(isset($_POST['nOccupants']))
    $nOccupants = str_replace("|", "", $_POST['nOccupants']);
if(isset($_POST['nUnderOccupants']))
    $nUnderOccupants = str_replace("|", "", $_POST['nUnderOccupants']);
if(isset($_POST['pet']))
    $pet = str_replace("|", "", $_POST['pet']);
if(isset($_POST['cDate']))
    $cDate = str_replace("|", "", $_POST['cDate']);
if(isset($_POST['leaving']))
    $leaving = str_replace("|", "", $_POST['leaving']);
if(isset($_POST['aName']))
    $aName = str_replace("|", "", $_POST['aName']);
if(isset($_POST['cPhone']))
    $cPhone = str_replace("|", "", $_POST['cPhone']);
if(isset($_POST['bankruptcy']))
    $bankruptcy = str_replace("|", "", $_POST['bankruptcy']);
if(isset($_POST['evicted']))
    $evicted = str_replace("|", "", $_POST['evicted']);
if(isset($_POST['late']))
    $late = str_replace("|", "", $_POST['late']);
if(isset($_POST['refused']))
    $refused = str_replace("|", "", $_POST['refused']);
if(isset($_POST['status']))
    $status = str_replace("|", "", $_POST['status']);
if(isset($_POST['emp']))
    $emp = str_replace("|", "", $_POST['emp']);
if(isset($_POST['supN']))
    $supN = str_replace("|", "", $_POST['supN']);
if(isset($_POST['supP']))
    $supP = str_replace("|", "", $_POST['supP']);
if(isset($_POST['salary']))
    $salary = str_replace("|", "", $_POST['salary']);
if(isset($_POST['school']))
    $school = str_replace("|", "", $_POST['school']);
if(isset($_POST['rName']))
    $rName = str_replace("|", "", $_POST['rName']);
if(isset($_POST['rAddress']))
    $rAddress = str_replace("|", "", $_POST['rAddress']);
if(isset($_POST['rPhone']))
    $rPhone = str_replace("|", "", $_POST['rPhone']);
if(isset($_POST['Rrelationship']))
    $Rrelationship = str_replace("|", "", $_POST['Rrelationship']);

$line = "$dNumber|$mDate|$rAmount|$dAmount|$nOccupants|$nUnderOccupants|$pet|$cDate|$leaving|$aName|$cPhone|$bankruptcy|$evicted|$late|$refused|$status|$emp|$supN|$supP|$salary|$school|
$rName|$rAddress|$rPhone|$Rrelationship";

//upload picture and add to query
include_once '../../db_config.php';
$mySQLConnection = connectToDatabase();

$query = "INSERT INTO Applicants (Email, PropertyID, ApplicantKeywords) ";
$query = $query . "VALUES ('$UserID', '$propertyID', '$line')";

$result = $mySQLConnection->query($query, $mysql_access);
//Close database
$mySQLConnection->close();
header('Location: index.php?message=1');
exit();

?>