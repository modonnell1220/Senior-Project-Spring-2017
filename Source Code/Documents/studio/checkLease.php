<?php
// continue landlord session
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'L'){
    header('Location: ../../Landlord/index.php');
}
else{
    $emailID = $_SESSION['UserID'];
	$PropertyID = $_SESSION['PropertyID'];
	$_SESSION['LeaseID'] = $_GET["id"];
	$leaseID = $_SESSION['LeaseID'];
}


// Establish a connection to the database
include 'databaseConnection.php';
$mySQLConnection = connectToDatabase();

// Build query for retrieving landlord signature data
$query = "SELECT IsFinal FROM Lease WHERE LeaseID = '$leaseID'";

//Issue query against database
$result = $mySQLConnection->query($query, $mysql_access);

$data = mysqli_fetch_assoc($result);

//Close database
$mySQLConnection->close();

echo "<!DOCTYPE HTML>
		<html>
		<head>
		<meta http-equiv = 'Content-Type' content = 'text/html' charset = 'utf-8' />
		</head>
		<body>";

if($data['IsFinal'] == 1)
{
	echo"<script>
		window.location = 'viewLease.php';
		</script>
		</body>
		</html>";
}
else
{
	echo "<form  method = 'POST' action = '../../Landlord/index.php' id = 'leaseCheckFailForm'>";
			echo "<h1>Lease unavailable at this time</h1>";
			echo "<label for 'landlordNotifier'>";
			echo "<em>";
			echo "Please inform your tenant to sign the lease before viewing.";
			echo "</em>";
			echo "<br>";
			echo "</label>";
			echo "<hr><br><br>";
			echo "<input type = 'submit' value = 'Return Home'>";
		echo "</form>";
}
?>