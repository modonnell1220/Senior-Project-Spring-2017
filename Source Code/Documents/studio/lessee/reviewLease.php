<?php
// continue landlord session
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'T'){
    header('Location: ../../../Tenant/index.php');
}
else{
    $emailID = $_SESSION['UserID'];
	$PropertyID = $_SESSION['PropertyID'];
	$LeaseID = $_SESSION['LeaseID'];
}

// Establish a connection to the database
include '../databaseConnection.php';
$mySQLConnection = connectToDatabase();

// Build query for retrieving landlord signature data
$query = "SELECT AgreementBody, LeaseName FROM Lease WHERE LeaseID = '$LeaseID'";

//Issue query against database
$result = $mySQLConnection->query($query, $mysql_access);

$data = mysqli_fetch_assoc($result);

$agreementBody = $data['AgreementBody'];
$leaseName = $data['LeaseName'];

$agreementBody = str_replace("\n", "<br>", $agreementBody);	// converts escape characters to html linebreaks


//Close database
$mySQLConnection->close();

echo "<!DOCTYPE HTML>
		<html>
			<head>
				<meta charset='utf-8'>
				<meta name='viewport' content='width=device-width, initial-scale=1.0'>
				<title>RentingFromMe.com</title>
				<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
				<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css'>
				<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700'>
				<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
				<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.min.css'>
				<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css'>
				<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css'>
				<link rel = 'stylesheet' type = 'text/css' href = '../css/styles.css' />
			</head>
		<body>
			<div class = 'container'>
				<h1>LEASE AGREEMENT</h1>
					<em><strong>
					Review lease below, then sign using button at bottom of page.
					</strong></em>
					<br>
				<form  class = 'well form-horizontal' method = 'POST' action = 'signLeaseTenant.php' id = 'tenantLeaseReviewForm'>
					<h3>
					".$leaseName."
					</h3>
					<hr>
					<div>
						".$agreementBody."
					</div>
					<br><br>					
						<div class = 'form-group'>
							<label class = 'col-md-4 control-label'></label>
							<div class = 'col-md-4 inputGroupContainer'>
								<div class = 'input-group'>
									<input class = 'btn btn-primary' type = 'submit' value = 'Sign Lease'>
								</div>
							</div>
						</div>
			</div>
		</body>
	</html>";
?>