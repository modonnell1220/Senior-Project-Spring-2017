<?php
// continue landlord session
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'L'){
    header('Location: ../../../Landlord/index.php');
}
else{
    $emailID = $_SESSION['UserID'];
}
$PropertyID = $_POST['PropertyID'];
$_SESSION['PropertyID'] = $PropertyID;

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv = "Content-Type" content = "text/html" charset = "utf-8" />
		<title>Success</title>
	</head>
	<body>
		<div id = "messageDiv">
			<strong>
			Lease has been submitted successfully.
			<br>
			Please notify your tenant the lease is ready for them to review."
			</strong>
			<form id = "messageForm" method = "POST" action = "../../../Landlord/index.php">
				<input type = "submit" value = "OK">
			</form>
		</div>
	</body>
</html>