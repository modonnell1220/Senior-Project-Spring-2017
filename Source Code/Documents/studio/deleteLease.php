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
$query = "DELETE FROM Lease WHERE LeaseID = '$leaseID'";

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
			<body>
				<script>
					window.location = '../../Landlord/index.php';
				</script>
			</body>
		</html>";
?>