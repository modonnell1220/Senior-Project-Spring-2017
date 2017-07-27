<?php
// continue landlord session
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'L'){
    header('Location: ../../../Landlord/index.php');
}
else{
    $emailID = $_SESSION['UserID'];
	$PropertyID = $_SESSION['PropertyID'];
	$LeaseID = $_SESSION['LeaseID'];
}


$lorem=$_POST['lorem'];
$lorem= urlencode($lorem);
$lorem = str_replace("+", "%2B",$lorem);
$lorem= urldecode($lorem);

$data = explode(",", $lorem);

//variable for flipping between tenent and landlord
$isLandlord = true;
//Establish a connection to the database
include '../databaseConnection.php';
$mySQLConnection = connectToDatabase();

// Build UPDATE Query
$query = "UPDATE Lease SET LandlordSign = '$data[1]' WHERE LeaseID = '$LeaseID'";

//Issue query against database
$result = $mySQLConnection->query($query, $mysql_access);
//Close database
$mySQLConnection->close();y
?>