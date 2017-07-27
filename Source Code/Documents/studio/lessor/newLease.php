<?php
// continue landlord session
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'L'){
    header('Location: ../../../Landlord/index.php');
}
else{
    $emailID = $_SESSION['UserID'];
    $firstName = $_SESSION['firstName'];
	$PropertyID = $_SESSION['PropertyID'];
}

// grab dates for suggesting to landlord
$today = date("n/j/Y");
$end = strtotime("+1 year", strtotime($today));
$end = date("n/j/Y", $end);

//Establish a connection to the database
include '../databaseConnection.php';
$mySQLConnection = connectToDatabase();

// Retrieve property information

	// Build query 
	$query = "SELECT Owner, Tenant, PAddress, UnitNumber, PCity, PState, PZip, PCounty, Deposit, PetDeposit, MonthlyRent FROM Property WHERE PropertyID = '$PropertyID'";

	// Send query to database
	$result = $mySQLConnection->query($query, $mysql_access);

	// grab result from database
	$data = mysqli_fetch_assoc($result);

	// store data locally
	$landlordEmail = $data['Owner'];
	$tenantEmail = $data['Tenant'];
	$propertyAddress = $data['PAddress'];
	$propertyUnitNumber = $data['UnitNumber'];
	$propertyCity = $data['PCity'];
	$propertyState = $data['PState'];
	$propertyZipCode = $data['PZip'];
	$propertyCounty = $data['PCounty'];
	$depositAmount = $data['Deposit'];
	$petDeposit = $data['PetDeposit'];
	$rentAmount = $data['MonthlyRent'];

//Get landlord address

	// Build new query
	$query = "SELECT Address, City, UserState, Zip FROM Users WHERE Email = '$landlordEmail'";

	// Send query to Database
	$result = $mySQLConnection->query($query, $mysql_access);

	// grab data from database
	$data = mysqli_fetch_assoc($result);

	// store data locally

	$contactAddress = $data['Address'];
	$contactCity = $data['City'];
	$contactState = $data['UserState'];
	$contactZip = $data['Zip'];

// Get Landlord name

	// Build new query
	$query = "SELECT FirstName, LastName FROM Users WHERE Email = '$landlordEmail'";

	// Send query to database
	$result = $mySQLConnection->query($query, $mysql_access);

	// grab data from database
	$data = mysqli_fetch_assoc($result);

	// store data locally

	$landlord = $data['FirstName'] . " " . $data['LastName'];

// Get tenant name

	// Build new query
	$query = "SELECT FirstName, LastName FROM Users WHERE Email = '$tenantEmail'";

	// Send query to database
	$result = $mySQLConnection->query($query, $mysql_access);

	// grab data from database
	$data = mysqli_fetch_assoc($result);

	// store data locally

	$tenant = $data['FirstName'] . " " . $data['LastName'];

//Close database
$mySQLConnection->close();
?>
<html>
	<head>
		<meta charset = "utf-8">
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0">
		<title>RentingFromMe.com</title>
		<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css">
		<link rel = "stylesheet" href = "https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
		<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.min.css">
		<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css">
		<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
		<link rel = "stylesheet" type = "text/css" href = "../css/styles.css" />
	</head>
	<body>
		 <nav class = "navbar navbar-default navigation-clean-search" id = "navigationBar">
				<div class = "container">
					<div class = "navbar-header" id = "homeIcon">
						<img height = "35.1875" width = "39.4375" src = "../img/logo.png">
						<a class = "navbar-brand navbar-link" href = "../../../Landlord/index.php">Renting From Me</a>
						<button class = "navbar-toggle collapsed" data-toggle = "collapse" data-target = "#navcol-1">
							<span class = "sr-only">Toggle navigation</span>
							<span class = "icon-bar"></span>
							<span class = "icon-bar"></span>
							<span class = "icon-bar"></span>
						</button>
					</div>
					<div class = "collapse navbar-collapse" id = "navcol-1">
						<a id = "logoutTab" href = "../../../User/logout.php" class = "navbar-text navbar-right nav-links">
							<i class = "icon-logout"></i>
							<span>Logout</span>
						</a>
						<a id = "settingsTab" href = "../../../Landlord/profile.php" class = "navbar-text navbar-right nav-links">
							<i class = "icon-settings"></i>
							<span>Settings</span>
						</a>
						<a id = "inboxTab" href = "../../../Inbox/index.php" class = "navbar-text navbar-right nav-links">
							<i class = "icon-envelope"></i>
							<span>Inbox</span>
						</a>
						<p id = "userBanner" class = "navbar-text navbar-right">
							<span>Welcome, <?php echo $firstName; ?></span>
						</p>
					</div>
				</div>
			</nav>
		
		<!-- >
			The following form is for creating a new lease.
			All fields are required to be filled out.
		<-->
		<div class = "container">
			<h1>New Lease Creation Form</h1>
			<br>
			<p>* If no pets allowed please enter 0 for Pet Deposit.</p>
			<div id = "formDiv">
				<form class = "well form-horizontal" method = "POST" action = "editLease.php" id = "newLeaseForm">
					<!-- Lease name or title -->
					
						<!-- Lease name -->
						<div class = "form-group" id = "leaseNameDiv">
							<label class = "col-md-4 control-label" for "leaseName">Lease Name / Title</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-file"></i></span><input class = "form-control" name = "leaseName" type = "text" value = "New Lease Agreement">
								</div>
							</div>
						</div>
					
					
					<!-- Legal dates of the lease agreement -->
					<hr>
					<h3 class = "text-center">Legal Dates</h3>
					
						<!-- Date created -->
						<div class = "form-group" id = "dateCreatedDiv">	
							<label class = "col-md-4 control-label" for "dateCreated">Date Created</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-calendar"></i></span>
									<input class = "form-control" type = "date" name = "dateCreated" value = <?php echo $today; ?> required>	<!-- Date the lease is created -->
								</div>
							</div>
						</div>
						
						<!-- Lease start date -->
						<div class = "form-group" id = "startDateDiv">
							<label class = "col-md-4 control-label" for "startDate">Start Date</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-calendar"></i></span>
									<input class = "form-control" type = "date" name = "startDate" value = <?php echo $today; ?> required>		<!-- Date the lease is in effect -->
								</div>
							</div>
						</div>
								
								
								
						
						<!-- Lease end date -->
						<div class = "form-group" id = "endDateDiv">
							<label class = "col-md-4 control-label" for "endDate">End Date</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-calendar"></i></span>
									<input class = "form-control" type = "date" name = "endDate" value = <?php echo $end; ?> required>		<!-- Date the lease ends -->
								</div>
							</div>
						</div>
						
					<!-- Information / names of landlord and tenant -->
					<hr>
					<h3 class = "text-center">Personell Information</h3>
						
						<!-- Landlord / Agency name -->
						<div class = "form-group" id = "landlordNameDiv">
							<label class = "col-md-4 control-label" for "landlord">Landlord / Agency name</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-user"></i></span>
									<input class = "form-control" type = "text" name = "landlord" value = "<?php echo $landlord; ?>" required>			<!-- Email of landlord / leasing agency -->
								</div>
							</div>
						</div>
							
						<!-- Landlord / Agency email -->
						<div class = "form-group" id = "landlordEmailDiv">
							<label class = "col-md-4 control-label" for "landlordEmail">Landlord / Agency email</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-envelope"></i></span>
									<input class = "form-control" type = "text" name = "landlordEmail" value = "<?php echo $landlordEmail; ?>" required>			<!-- Email of landlord / leasing agency -->
								</div>
							</div>
						</div>
						
						<!-- Tenant name -->
						<div class = "form-group" id = "tenantNameDiv">	
							<label class = "col-md-4 control-label" for "tenant">Primary tenant name</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-user"></i></span>
									<input class = "form-control" type = "text" name = "tenant" value = "<?php echo $tenant; ?>" required>	<!-- Emamil of primary tenant -->
								</div>
							</div>
						</div>
						
						<!-- Tenant email -->
						<div class = "form-group" id = "tenantEmailDiv">	
							<label class = "col-md-4 control-label" for "tenantEmail">Primary tenant email</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-envelope"></i></span>
									<input class = "form-control" type = "text" name = "tenantEmail" value = "<?php echo $tenantEmail; ?>" required>	<!-- Emamil of primary tenant -->
								</div>
							</div>
						</div>
						
					<!-- Address of property -->
					<hr>
					<h3 class = "text-center">Property Location Information</h3>
						
						<!-- Property address -->
						<div class = "form-group" id = "propertyAddressDiv">
							<label class = "col-md-4 control-label" for "propertyAddress">Address</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-home"></i></span>
									<input class = "form-control" type = "text" name = "propertyAddress" value = "<?php echo $propertyAddress; ?>" required>		<!-- Street address for property -->
								</div>
							</div>
						</div>
							
						<!-- Property unit number -->
						<div class = "form-group" id = "propertyUnitNumberDiv">	
							<label class = "col-md-4 control-label" for "propertyUnitNumber">Unit Number</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-home"></i></span>
									<input class = "form-control" type = "text" name = "propertyUnitNumber" value = "<?php echo $propertyUnityNumber; ?>">					<!-- Unit number of property if applicable (mostly used for condos or townhomes) -->
								</div>
							</div>
						</div>
							
							
						<!-- Property city -->
						<div class = "form-group" id = "propertyCityDiv">
							<label class = "col-md-4 control-label" for "propertyCity">City</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-home"></i></span>
									<input class = "form-control" type = "text" name = "propertyCity" value = "<?php echo $propertyCity; ?>" required>				<!-- City of property -->
								</div>
							</div>
						</div>
							
						<!-- Property state -->
						<div class = "form-group" id = "propertyStateDiv">
							<label class = "col-md-4 control-label" for "propertyState">State</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-list"></i></span>
									<select name = "propertyState" value = "<?php echo $propertyState; ?>" class = "form-control selectpicker" required>		<!-- State of property -->
										<option value = "" >Please select your state</option>
										<option value="AL" <?php if(strtolower($propertyState) === 'al' || strtolower($propertyState) === 'alabama'){echo "selected";}?>>Alabama</option>
										<option value="AK" <?php if(strtolower($propertyState) === 'ak' || strtolower($propertyState) === 'alaska'){echo "selected";}?>>Alaska</option>
										<option value="AZ" <?php if(strtolower($propertyState) === 'az' || strtolower($propertyState) === 'arizona'){echo "selected";}?>>Arizona</option>
										<option value="AR" <?php if(strtolower($propertyState) === 'ar' || strtolower($propertyState) === 'arkansas'){echo "selected";}?>>Arkansas</option>
										<option value="CA" <?php if(strtolower($propertyState) === 'ca' || strtolower($propertyState) === 'california'){echo "selected";}?>>California</option>
										<option value="CO" <?php if(strtolower($propertyState) === 'co' || strtolower($propertyState) === 'colorado'){echo "selected";}?>>Colorado</option>
										<option value="CT" <?php if(strtolower($propertyState) === 'ct' || strtolower($propertyState) === 'connecticut'){echo "selected";}?>>Connecticut</option>
										<option value="DE" <?php if(strtolower($propertyState) === 'de' || strtolower($propertyState) === 'delaware'){echo "selected";}?>>Delaware</option>
										<option value="DC" <?php if(strtolower($propertyState) === 'dc' || strtolower($propertyState) === 'district of columbia'){echo "selected";}?>>District Of Columbia</option>
										<option value="FL" <?php if(strtolower($propertyState) === 'fl' || strtolower($propertyState) === 'florida'){echo "selected";}?>>Florida</option>
										<option value="GA" <?php if(strtolower($propertyState) === 'ga' || strtolower($propertyState) === 'georgia'){echo "selected";}?>>Georgia</option>
										<option value="HI" <?php if(strtolower($propertyState) === 'hi' || strtolower($propertyState) === 'hawaii'){echo "selected";}?>>Hawaii</option>
										<option value="ID" <?php if(strtolower($propertyState) === 'id' || strtolower($propertyState) === 'idaho'){echo "selected";}?>>Idaho</option>
										<option value="IL" <?php if(strtolower($propertyState) === 'il' || strtolower($propertyState) === 'illinois'){echo "selected";}?>>Illinois</option>
										<option value="IN" <?php if(strtolower($propertyState) === 'in' || strtolower($propertyState) === 'indiana'){echo "selected";}?>>Indiana</option>
										<option value="IA" <?php if(strtolower($propertyState) === 'ia' || strtolower($propertyState) === 'iowa'){echo "selected";}?>>Iowa</option>
										<option value="KS" <?php if(strtolower($propertyState) === 'ks' || strtolower($propertyState) === 'kansas'){echo "selected";}?>>Kansas</option>
										<option value="KY" <?php if(strtolower($propertyState) === 'ky' || strtolower($propertyState) === 'kentucky'){echo "selected";}?>>Kentucky</option>
										<option value="LA" <?php if(strtolower($propertyState) === 'la' || strtolower($propertyState) === 'louisiana'){echo "selected";}?>>Louisiana</option>
										<option value="ME" <?php if(strtolower($propertyState) === 'me' || strtolower($propertyState) === 'maine'){echo "selected";}?>>Maine</option>
										<option value="MD" <?php if(strtolower($propertyState) === 'md' || strtolower($propertyState) === 'maryland'){echo "selected";}?>>Maryland</option>
										<option value="MA" <?php if(strtolower($propertyState) === 'ma' || strtolower($propertyState) === 'massachusetts'){echo "selected";}?>>Massachusetts</option>
										<option value="MI" <?php if(strtolower($propertyState) === 'mi' || strtolower($propertyState) === 'michigan'){echo "selected";}?>>Michigan</option>
										<option value="MN" <?php if(strtolower($propertyState) === 'mn' || strtolower($propertyState) === 'minnesota'){echo "selected";}?>>Minnesota</option>
										<option value="MS" <?php if(strtolower($propertyState) === 'ms' || strtolower($propertyState) === 'mississippi'){echo "selected";}?>>Mississippi</option>
										<option value="MO" <?php if(strtolower($propertyState) === 'mo' || strtolower($propertyState) === 'missouri'){echo "selected";}?>>Missouri</option>
										<option value="MT" <?php if(strtolower($propertyState) === 'mt' || strtolower($propertyState) === 'montana'){echo "selected";}?>>Montana</option>
										<option value="NE" <?php if(strtolower($propertyState) === 'ne' || strtolower($propertyState) === 'nebraska'){echo "selected";}?>>Nebraska</option>
										<option value="NV" <?php if(strtolower($propertyState) === 'nv' || strtolower($propertyState) === 'nevada'){echo "selected";}?>>Nevada</option>
										<option value="NH" <?php if(strtolower($propertyState) === 'nh' || strtolower($propertyState) === 'new hampshire'){echo "selected";}?>>New Hampshire</option>
										<option value="NJ" <?php if(strtolower($propertyState) === 'nj' || strtolower($propertyState) === 'new jersey'){echo "selected";}?>>New Jersey</option>
										<option value="NM" <?php if(strtolower($propertyState) === 'nm' || strtolower($propertyState) === 'new mexico'){echo "selected";}?>>New Mexico</option>
										<option value="NY" <?php if(strtolower($propertyState) === 'ny' || strtolower($propertyState) === 'new york'){echo "selected";}?>>New York</option>
										<option value="NC" <?php if(strtolower($propertyState) === 'nc' || strtolower($propertyState) === 'north carolina'){echo "selected";}?>>North Carolina</option>
										<option value="ND" <?php if(strtolower($propertyState) === 'nd' || strtolower($propertyState) === 'north dakota'){echo "selected";}?>>North Dakota</option>
										<option value="OH" <?php if(strtolower($propertyState) === 'oh' || strtolower($propertyState) === 'ohio'){echo "selected";}?>>Ohio</option>
										<option value="OK" <?php if(strtolower($propertyState) === 'ok' || strtolower($propertyState) === 'oklahoma'){echo "selected";}?>>Oklahoma</option>
										<option value="OR" <?php if(strtolower($propertyState) === 'or' || strtolower($propertyState) === 'oregon'){echo "selected";}?>>Oregon</option>
										<option value="PA" <?php if(strtolower($propertyState) === 'pa' || strtolower($propertyState) === 'pennsylvania'){echo "selected";}?>>Pennsylvania</option>
										<option value="RI" <?php if(strtolower($propertyState) === 'ri' || strtolower($propertyState) === 'rhode island'){echo "selected";}?>>Rhode Island</option>
										<option value="SC" <?php if(strtolower($propertyState) === 'sc' || strtolower($propertyState) === 'south carolina'){echo "selected";}?>>South Carolina</option>
										<option value="SD" <?php if(strtolower($propertyState) === 'sd' || strtolower($propertyState) === 'south dakota'){echo "selected";}?>>South Dakota</option>
										<option value="TN" <?php if(strtolower($propertyState) === 'tn' || strtolower($propertyState) === 'tennessee'){echo "selected";}?>>Tennessee</option>
										<option value="TX" <?php if(strtolower($propertyState) === 'tc' || strtolower($propertyState) === 'texas'){echo "selected";}?>>Texas</option>
										<option value="UT" <?php if(strtolower($propertyState) === 'ut' || strtolower($propertyState) === 'utah'){echo "selected";}?>>Utah</option>
										<option value="VT" <?php if(strtolower($propertyState) === 'vt' || strtolower($propertyState) === 'vermont'){echo "selected";}?>>Vermont</option>
										<option value="VA" <?php if(strtolower($propertyState) === 'va' || strtolower($propertyState) === 'virginia'){echo "selected";}?>>Virginia</option>
										<option value="WA" <?php if(strtolower($propertyState) === 'wa' || strtolower($propertyState) === 'washington'){echo "selected";}?>>Washington</option>
										<option value="WV" <?php if(strtolower($propertyState) === 'wv' || strtolower($propertyState) === 'west virginia'){echo "selected";}?>>West Virginia</option>
										<option value="WI" <?php if(strtolower($propertyState) === 'wi' || strtolower($propertyState) === 'wisconsin'){echo "selected";}?>>Wisconsin</option>
										<option value="WY" <?php if(strtolower($propertyState) === 'wy' || strtolower($propertyState) === 'wyoming'){echo "selected";}?>>Wyoming</option>
									</select>
								</div>
							</div>
						</div>
							
						<!-- Property zip code -->
						<div class = "form-group" id = "propertyZipCodeDiv">	
							<label class = "col-md-4 control-label" for "propertyZipCode">Zip Code</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-home"></i></span>
									<input class = "form-control" type = "text" name = "propertyZipCode" value = "<?php echo $propertyZipCode; ?>" required>	<!-- Zip code of property -->
								</div>
							</div>
						</div>
							
						<!-- Property county -->
						<div class = "form-group" id = "propertyCountyDiv">
							<label class = "col-md-4 control-label" for "propertyCounty">County</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-home"></i></span>
									<input class = "form-control" type = "text" name = "propertyCounty" value = "<?php echo $propertyCounty; ?>" required>		<!-- County of property -->
								</div>
							</div>
						</div>
						
					<!-- Contact / Mailing information for landlord or leasing agency-->
					<hr>
					<h3 class = "text-center">Landlord Contact Information</h3>
					
						<!-- Landlord address -->
						<div class = "form-group" id = "landlordAddressDiv">
							<label class = "col-md-4 control-label" for "contactAddress">Address</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-home"></i></span>
									<input class = "form-control" type = "text" name = "contactAddress" value = "<?php echo $contactAddress; ?>" required>	<!-- Street address for contact -->
								</div>
							</div>
						</div>
							
						<!-- Landlord unit number -->
						<div class = "form-group" id = "landlordUnitNumberDiv">	
							<label class = "col-md-4 control-label" for "contactUnitNumber">Unit Number</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-home"></i></span>
									<input class = "form-control" type = "text" name = "contactUnitNumber" value = "">				<!-- Unit number for contact (used for business unit numbers) -->
								</div>
							</div>
						</div>
						
						<!-- Landlord city -->
						<div class = "form-group" id = "landlordCityDiv">
							<label class = "col-md-4 control-label" for "contactCity">City</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-home"></i></span>
									<input class = "form-control" type = "text" name = "contactCity" value = "<?php echo $contactCity; ?>" required>			<!-- City for contact -->
								</div>
							</div>
						</div>
							
						<!-- Landlord state -->
						<div class = "form-group" id = "landlordStateDiv">
							<label class = "col-md-4 control-label" for "contactState">State</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-list"></i></span>
									<select name = "contactState" selected value = "<?php echo $contactState; ?>" class = "form-control selectpicker" required>	<!-- State for contact -->
										<option value="AL" <?php if(strtolower($contactState) === 'al' || strtolower($contactState) === 'alabama'){echo "selected";}?>>Alabama</option>
										<option value="AK" <?php if(strtolower($contactState) === 'ak' || strtolower($contactState) === 'alaska'){echo "selected";}?>>Alaska</option>
										<option value="AZ" <?php if(strtolower($contactState) === 'az' || strtolower($contactState) === 'arizona'){echo "selected";}?>>Arizona</option>
										<option value="AR" <?php if(strtolower($contactState) === 'ar' || strtolower($contactState) === 'arkansas'){echo "selected";}?>>Arkansas</option>
										<option value="CA" <?php if(strtolower($contactState) === 'ca' || strtolower($contactState) === 'california'){echo "selected";}?>>California</option>
										<option value="CO" <?php if(strtolower($contactState) === 'co' || strtolower($contactState) === 'colorado'){echo "selected";}?>>Colorado</option>
										<option value="CT" <?php if(strtolower($contactState) === 'ct' || strtolower($contactState) === 'connecticut'){echo "selected";}?>>Connecticut</option>
										<option value="DE" <?php if(strtolower($contactState) === 'de' || strtolower($contactState) === 'delaware'){echo "selected";}?>>Delaware</option>
										<option value="DC" <?php if(strtolower($contactState) === 'dc' || strtolower($contactState) === 'district of columbia'){echo "selected";}?>>District Of Columbia</option>
										<option value="FL" <?php if(strtolower($contactState) === 'fl' || strtolower($contactState) === 'florida'){echo "selected";}?>>Florida</option>
										<option value="GA" <?php if(strtolower($contactState) === 'ga' || strtolower($contactState) === 'georgia'){echo "selected";}?>>Georgia</option>
										<option value="HI" <?php if(strtolower($contactState) === 'hi' || strtolower($contactState) === 'hawaii'){echo "selected";}?>>Hawaii</option>
										<option value="ID" <?php if(strtolower($contactState) === 'id' || strtolower($contactState) === 'idaho'){echo "selected";}?>>Idaho</option>
										<option value="IL" <?php if(strtolower($contactState) === 'il' || strtolower($contactState) === 'illinois'){echo "selected";}?>>Illinois</option>
										<option value="IN" <?php if(strtolower($contactState) === 'in' || strtolower($contactState) === 'indiana'){echo "selected";}?>>Indiana</option>
										<option value="IA" <?php if(strtolower($contactState) === 'ia' || strtolower($contactState) === 'iowa'){echo "selected";}?>>Iowa</option>
										<option value="KS" <?php if(strtolower($contactState) === 'ks' || strtolower($contactState) === 'kansas'){echo "selected";}?>>Kansas</option>
										<option value="KY" <?php if(strtolower($contactState) === 'ky' || strtolower($contactState) === 'kentucky'){echo "selected";}?>>Kentucky</option>
										<option value="LA" <?php if(strtolower($contactState) === 'la' || strtolower($contactState) === 'louisiana'){echo "selected";}?>>Louisiana</option>
										<option value="ME" <?php if(strtolower($contactState) === 'me' || strtolower($contactState) === 'maine'){echo "selected";}?>>Maine</option>
										<option value="MD" <?php if(strtolower($contactState) === 'md' || strtolower($contactState) === 'maryland'){echo "selected";}?>>Maryland</option>
										<option value="MA" <?php if(strtolower($contactState) === 'ma' || strtolower($contactState) === 'massachusetts'){echo "selected";}?>>Massachusetts</option>
										<option value="MI" <?php if(strtolower($contactState) === 'mi' || strtolower($contactState) === 'michigan'){echo "selected";}?>>Michigan</option>
										<option value="MN" <?php if(strtolower($contactState) === 'mn' || strtolower($contactState) === 'minnesota'){echo "selected";}?>>Minnesota</option>
										<option value="MS" <?php if(strtolower($contactState) === 'ms' || strtolower($contactState) === 'mississippi'){echo "selected";}?>>Mississippi</option>
										<option value="MO" <?php if(strtolower($contactState) === 'mo' || strtolower($contactState) === 'missouri'){echo "selected";}?>>Missouri</option>
										<option value="MT" <?php if(strtolower($contactState) === 'mt' || strtolower($contactState) === 'montana'){echo "selected";}?>>Montana</option>
										<option value="NE" <?php if(strtolower($contactState) === 'ne' || strtolower($contactState) === 'nebraska'){echo "selected";}?>>Nebraska</option>
										<option value="NV" <?php if(strtolower($contactState) === 'nv' || strtolower($contactState) === 'nevada'){echo "selected";}?>>Nevada</option>
										<option value="NH" <?php if(strtolower($contactState) === 'nh' || strtolower($contactState) === 'new hampshire'){echo "selected";}?>>New Hampshire</option>
										<option value="NJ" <?php if(strtolower($contactState) === 'nj' || strtolower($contactState) === 'new jersey'){echo "selected";}?>>New Jersey</option>
										<option value="NM" <?php if(strtolower($contactState) === 'nm' || strtolower($contactState) === 'new mexico'){echo "selected";}?>>New Mexico</option>
										<option value="NY" <?php if(strtolower($contactState) === 'ny' || strtolower($contactState) === 'new york'){echo "selected";}?>>New York</option>
										<option value="NC" <?php if(strtolower($contactState) === 'nc' || strtolower($contactState) === 'north carolina'){echo "selected";}?>>North Carolina</option>
										<option value="ND" <?php if(strtolower($contactState) === 'nd' || strtolower($contactState) === 'north dakota'){echo "selected";}?>>North Dakota</option>
										<option value="OH" <?php if(strtolower($contactState) === 'oh' || strtolower($contactState) === 'ohio'){echo "selected";}?>>Ohio</option>
										<option value="OK" <?php if(strtolower($contactState) === 'ok' || strtolower($contactState) === 'oklahoma'){echo "selected";}?>>Oklahoma</option>
										<option value="OR" <?php if(strtolower($contactState) === 'or' || strtolower($contactState) === 'oregon'){echo "selected";}?>>Oregon</option>
										<option value="PA" <?php if(strtolower($contactState) === 'pa' || strtolower($contactState) === 'pennsylvania'){echo "selected";}?>>Pennsylvania</option>
										<option value="RI" <?php if(strtolower($contactState) === 'ri' || strtolower($contactState) === 'rhode island'){echo "selected";}?>>Rhode Island</option>
										<option value="SC" <?php if(strtolower($contactState) === 'sc' || strtolower($contactState) === 'south carolina'){echo "selected";}?>>South Carolina</option>
										<option value="SD" <?php if(strtolower($contactState) === 'sd' || strtolower($contactState) === 'south dakota'){echo "selected";}?>>South Dakota</option>
										<option value="TN" <?php if(strtolower($contactState) === 'tn' || strtolower($contactState) === 'tennessee'){echo "selected";}?>>Tennessee</option>
										<option value="TX" <?php if(strtolower($contactState) === 'tc' || strtolower($contactState) === 'texas'){echo "selected";}?>>Texas</option>
										<option value="UT" <?php if(strtolower($contactState) === 'ut' || strtolower($contactState) === 'utah'){echo "selected";}?>>Utah</option>
										<option value="VT" <?php if(strtolower($contactState) === 'vt' || strtolower($contactState) === 'vermont'){echo "selected";}?>>Vermont</option>
										<option value="VA" <?php if(strtolower($contactState) === 'va' || strtolower($contactState) === 'virginia'){echo "selected";}?>>Virginia</option>
										<option value="WA" <?php if(strtolower($contactState) === 'wa' || strtolower($contactState) === 'washington'){echo "selected";}?>>Washington</option>
										<option value="WV" <?php if(strtolower($contactState) === 'wv' || strtolower($contactState) === 'west virginia'){echo "selected";}?>>West Virginia</option>
										<option value="WI" <?php if(strtolower($contactState) === 'wi' || strtolower($contactState) === 'wisconsin'){echo "selected";}?>>Wisconsin</option>
										<option value="WY" <?php if(strtolower($contactState) === 'wy' || strtolower($contactState) === 'wyoming'){echo "selected";}?>>Wyoming</option>
									</select>
								</div>
							</div>
						</div>
						
						<!-- Landlord zip code -->
						<div class = "form-group" id = "landlordZipCodeDiv">
							<label class = "col-md-4 control-label" for "contactZipCode">Zip Code</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-home"></i></span>
									<input class = "form-control" type = "text" name = "contactZipCode" value = "<?php echo $contactZip; ?>" required>	<!-- Zip code for contact -->
								</div>
							</div>
						</div>
						
					<!-- Number of occupants of each type -->
					<hr>
					<h3 class = "text-center">Occupants Information</h3>
					
						<!-- Adults -->
						<div class = "form-group" id = "adultOccupantsDiv">
							<label class = "col-md-4 control-label" for "numberOfAdultOccupants">Adult Occupants</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-user"></i></span>
									<input class = "form-control" type = "number" name = "numberOfAdultOccupants" value = "2" maxLength = "2" required>		<!-- Number of adults occupying property -->
								</div>
							</div>
						</div>
							
						<!-- Children -->
						<div class = "form-group" id = "childOccupantsDiv">
							<label class = "col-md-4 control-label" for "numberOfChildOccupants">Child Occupants</label class = "col-md-4 control-label"> 
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-user"></i></span>
									<input class = "form-control" type = "number" name = "numberOfChildrenOccupants" value = "2" maxLength = "2" required>	<!-- Number of children occupying property -->
								</div>
							</div>
						</div>
						
					<!-- Logistical details regarding fees, deposits, and other criteria -->
					<hr>
					<h3 class = "text-center">Logistical Information</h3>
					
						<!-- Rent amount -->
						<div class = "form-group" id = "rentAmountDiv">
							<label class = "col-md-4 control-label" for "rentAmount">Rent Amount</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-usd"></i></span>
									<input class = "form-control" type = "number" name = "rentAmount" value = "<?php echo $rentAmount; ?>" maxlength = "10" required>		<!-- Amount of rent due each month -->
								</div>
							</div>
						</div>
							
						<!-- Late payment fee -->
						<div class = "form-group" id = "latePaymentFeeDiv">
							<label class = "col-md-4 control-label" for "latePaymentFee">Late Payment Fee</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-usd"></i></span>
									<input class = "form-control" type = "number" name = "latePaymentFee" value = "50" maxlength = "10" required>	<!-- Fee for late payments -->
								</div>
							</div>
						</div>
						
						
						<!-- Returned Check Fee -->
						<div class = "form-group" id = "returnedCheckFeeDiv">
							<label class = "col-md-4 control-label" for "retrunCheckFee">Return Check Fee</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-usd"></i></span>
									<input class = "form-control" type = "number" name = "returnCheckFee" value = "50" maxlength = "10" required>	<!-- Fee for returned checks -->
								</div>
							</div>
						</div>
						
						<!-- Deposit Amount -->
						<div class = "form-group" id = "depositAmountDiv">
							<label class = "col-md-4 control-label" for "depositAmount">Deposit Amount</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-usd"></i></span>
									<input class = "form-control" type = "number" name = "depositAmount" value = "<?php echo $depositAmount; ?>" maxlength = "10" required>	<!-- Deposit for move in -->
								</div>
							</div>
						</div>
						
						<!-- Keys Provided -->
						<div class = "form-group" id = "numberOfKeysDiv">
							<label class = "col-md-4 control-label" for "numberOfKeys">Keys Provided</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-lock"></i></span>
									<input class = "form-control" type = "number" name = "numberOfKeys" value = "2" maxlength = "2" required>		<!-- Number of keys provided to tenant from landlord -->
								</div>
							</div>
						</div>
							
							
						<!-- Replacement Key Fee -->
						<div class = "form-group" id = "replacementKeyFeeDiv">	
							<label class = "col-md-4 control-label" for "replacementKeyFee">Replacement Key Fee</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-usd"></i></span>
									<input class = "form-control" type = "number" name = "replacementKeyFee" value = "10" maxlength = "3" required>	<!-- Fee for making a replacement key -->
								</div>
							</div>
						</div>
						
						<!-- Pet deposit -->
						<div class = "form-group" id = "petDepositDiv">
							<label class = "col-md-4 control-label" for "petDeposit">*Pet Deposit Per Animal</label class = "col-md-4 control-label">
							<div class = "col-md-4 inputGroupContainer">
								<div class = "input-group">
									<span class = "input-group-addon"><i class = "glyphicon glyphicon-usd"></i></span>
									<input class = "form-control" type = "number" name = "petDeposit" value = "<?php echo $petDeposit; ?>" maxlength = "5" required>		<!-- Deposit amount for each pet -->
								</div>
							</div>
						</div>
						
						
					<!-- Submit button -->
					<div class = "form-group">
						<label class = "col-md-4 control-label"></label>
						<div class = "col-md-4 inputGroupContainer">
							<div class = "input-group">
								<input class = "btn btn-primary" type = "submit" value = "Generate Lease">
							</div>
						</div>
					</div>
					
				</form>
			</div>
		</div>
		<hr>
	</body>
</html>