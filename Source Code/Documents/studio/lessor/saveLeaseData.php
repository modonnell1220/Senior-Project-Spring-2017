<?php
// continue landlord session
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'L'){
    header('Location: ../../../Landlord/index.php');
}
else{
    $emailID = $_SESSION['UserID'];
	$PropertyID = $_SESSION['PropertyID'];
}

// Data passed from newLease.html form

// Legal lease dates
$dateCreated = $_POST['dateCreated'];	// Date lease is created
$startDate = date("Y-n-j", $_POST['startDate']);		// first date lease is in effect
$endDate = $_POST['endDate'];			// Last date lease is in effect

// Name / Title of lease
$leaseName = $_POST['leaseName'];

// Names of tenant(s) and landlord / agency
$landlord = str_replace("'", "\'", $_POST['landlord']);				// Name of landlord or leasing agency
$landlordEmail = str_replace("'", "\'", $_POST['landlordEmail']);	// Email of landlord or leasing agency
$tenant = str_replace("'", "\'", $_POST['tenant']);					// Name of tenant
$tenantEmail = str_replace("'", "\'", $_POST['tenantEmail']);		// Email of tenant

// location information of property
$propertyAddress = str_replace("'", "\'", $_POST['propertyAddress']);		// Street address of property
$propertyUnitNumber = $_POST['propertyUnitNumber'];	// Unit number of property (used for condos or townhomes)
$propertyCity = $_POST['propertyCity'];				// City of property
$propertyState = $_POST['propertyState'];			// State of property
$propertyZipCode = $_POST['propertyZipCode'];		// Zip code of property
$propertyCounty = $_POST['propertyCounty'];			// County of property

// Address for mailing or contacting landlord / leasing agency
$contactAddress = str_replace("'", "\'", $_POST['contactAddress']);			// Street address for mailing to contact landlord
$contactUnitNumber = $_POST['contactUnitNumber'];	// Unit number for mailing to contact landlord (used for business unit numbers)
$contactCity = $_POST['contactCity'];				// City for mailing to contact landlord
$contactState = $_POST['contactState'];				// State for mailing to contact landlord
$contactZipCode = $_POST['contactZipCode'];			// Zip code for mailing to contact landlord

// Number of occupants of each type
$numberOfAdultOccupants = $_POST['numberOfAdultOccupants'];	// Number of adults occupying the property
$numberofChildOccupants = $_POST['numberOfChildOccupants'];	// Number of children occupying the property
$numberOfPetOccupants = $_POST['numberOfPetOccupants'];		// Number of pets occupying the property

// Logistical details regarding fees, deposits, and other criteria
$rentAmount = $_POST['rentAmount'];						// Amount of rent money due each month
$latePaymentFee = $_POST['latePaymentFee'];				// Fee amount for late rent payment
$returnCheckFee = $_POST['returnCheckFee'];				// Fee amount for returned check
$depositAmount = $_POST['depositAmount'];				// Deposit amount for property
$numberOfKeys = $_POST['numberOfKeys'];					// Number of keys supplied to the tenant
$replacementKeyFee = $_POST['replacementKeyFee'];		// Fee for a replacement key
$numberOfPetsAllowed = $_POST['numberOfPetsAllowed'];	// Number of pets allowed on property
$petDeposit = $_POST['petDeposit'];						// Deposit amount for each pet
$petRent = $_POST['petRent'];							// Amount of rent money for each pet due each month

// lease text from editLease.php
$finalLease = str_replace("'", "\'", $_POST['editableLease']);

// Insert lease to database

//Establish a connection to the database
include '../databaseConnection.php';
$mySQLConnection = connectToDatabase();

// Build query for database
$query = "INSERT INTO Lease (PropertyID, UserEmail, Landlord, LeaseName, LeaseDate, AgreementBody, IsFinal) ";
$query = $query . "VALUES ('$PropertyID', '$tenantEmail', '$landlordEmail', '$leaseName', '$startDate', '$finalLease', '0')";

//Issue query against database
$result = $mySQLConnection->query($query, $mysql_access);

// Build SELECT query to grab the LeaseID
$query = "SELECT LeaseID FROM Lease WHERE PropertyID = '$PropertyID' AND LeaseName = '$leaseName' AND AgreementBody = '$finalLease'";

// Query the database
$result = $mySQLConnection->query($query, $mysql_access);

// retrieve the data
$data = mysqli_fetch_array($result);

// Store the LeaseID in the session
$_SESSION['LeaseID'] = $data[0];

//Close database

$mySQLConnection->close();

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv = 'Content-Type' content = 'text/html' charset = 'utf-8' />
	</head>
	<body>
		<script>
			window.location = 'signLeaseLandlord.php';
		</script>
	</body>
</html>