<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'T'){
    header('Location: ../index.php');
}
else{
    $UserID = $_SESSION['UserID'];
    $firstName = $_SESSION['firstName'];
    $identifier = $_SESSION['identifier'];
}
//SELECT `IsFinal` FROM `Lease` WHERE `UserEmail` =  $UserID;
//$_SESSION['PropertyID'] = 1; // need to create this for real
/**
 * Created by PhpStorm.
 * User: Tommy
 * Date: 4/11/2017
 * Time: 1:44 PM
 */
function connectToDatabase(){
    //Establish a connection to the database
    $servername = "localhost";
    $dbUsernameToConnect = "davidtec_rent";
    $dbPasswordToConnect = "+q~h(Kb3nbS@";
    $database = "davidtec_renting";
// Create connection
    $mySQLConnection = new mysqli($servername, $dbUsernameToConnect, $dbPasswordToConnect, $database);
// Check connection
    if ($mySQLConnection->connect_error) {
        die("Connection failed: " . $mySQLConnection->connect_error);
    }
    return $mySQLConnection;
}
/*
 * Within the div with the id #propertyDetails, render the following information:
Property Details
Image (in image box)
Address
City
State
Zip
Lease Details
Next Payment Amount
Next Payment Due Date
Lease Start Date
Lease End Date
 * */
function VerifyGood($mySQLConnection, $email){
    $sql = "SELECT LeaseID ,IsFinal FROM Lease WHERE UserEmail =  '".$email."'";
    $result = mysqli_query($mySQLConnection, $sql);
	if( $data=(mysqli_fetch_assoc($result)))
	{
		 $_SESSION["LeaseID"]= $data["LeaseID"];
		 if($data['IsFinal'] == 0)
		 {
			echo "<script>window.location = '../Documents/studio/lessee/reviewLease.php'</script>";
		 }
		 else
		 {
			return 1;
		 }
	}
	else;
}
function getPropertyData($mySQLConnection, $email)
{
    $database = "davidtec_renting";
    //get property data
    ///////////////Tenant Access///////////////
    $sql = "SELECT FileName, PAddress, PCity, PState, PZip, StartDate, Owner, MonthlyRent, PropertyID FROM Property WHERE Tenant= '" .$email ."'";
    $result = mysqli_query($mySQLConnection, $sql);
    $rowsP = [];
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($rowP = mysqli_fetch_assoc($result)) {
            #echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
            #array_push($data,$row);
            $rowsP = $rowP;
            //echo $row["Tenant"];
        }
    } else {
        echo "0 results";
    }
    $holder = array();
    $counter=0;
    //set values into an array to hold the data and pass this back to the caller
    while ($counter< sizeof($rowsP)+1){
        // echo "loop " . $counter;   SELECT ImageDirectory, Info, PAddress, PCity, PState, PZip, BedAndBath, Tenant
        if($counter == 1){array_push($holder,$rowsP["FileName"]);}
        elseif($counter == 2){array_push($holder,$rowsP["PAddress"]);}
        elseif($counter == 3){array_push($holder,$rowsP["PCity"]);}
        elseif($counter == 4){array_push($holder,$rowsP["PState"]);}
        elseif($counter == 5){array_push($holder,$rowsP["PZip"]);}
        elseif($counter == 6){array_push($holder,$rowsP["MonthlyRent"]);}
        elseif($counter == 7){array_push($holder,$rowsP["Owner"]);}
        elseif($counter == 8){array_push($holder,$rowsP["PropertyID"]);}
        $counter+=1;
    }
//echo $rows["PCity"];
    // echo $holder[0]. "result property <br>";
    //echo $holder;
    return $holder;
}
// get Lease information Unused currently
function getAgreementData($mySQLConnection, $email)
{
    $database = "davidtec_renting";
    $sql = "SELECT AgreementBody FROM Lease WHERE UserEmail= '" .$email ."'";
    $result = mysqli_query($mySQLConnection, $sql);
    $rowsL = [];
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($rowL = mysqli_fetch_assoc($result)) {
            #echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
            #array_push($data,$row);
            $rowsL = $rowL;
            //echo $row["Tenant"];
        }
    } else {
        echo "0 results";
    }
    $holder = array();
    $counter=0;
//set values into an array to hold the data and pass this back to the caller
    array_push($holder,$rowsL["AgreementBody"]);
//echo $rows["PCity"];
// echo $holder[7];
    return $holder;
}
///////////////MoneyTransaction Access///////////////
//get financial data
function getMoneyData($mySQLConnection, $email)
{
    $rowsT = [];
    $sql = "SELECT NextDueDate  FROM MoneyTransaction WHERE Tenant = '" .$email ."'";
    $result = mysqli_query($mySQLConnection, $sql);
    $rows = [];
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($rowT = mysqli_fetch_assoc($result)) {
            #echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
            #array_push($data,$row);
            $rowsT = $rowT;
            //echo $row["Tenant"];
        }
    } else {
        echo "0 results";
    }
    $holder = array();
    $counter=0;
    array_push($holder,$rowsT["NextDueDate"]);
//echo $rows["PCity"];
    // echo $holder[7];
    //echo $holder;
    return $holder;
}
// get the tenant data
function getTenantData($mySQLConnection, $email)
{
    $sql = "SELECT FirstName, LastName FROM Users WHERE Email = '" .$email ."'";
    $result = mysqli_query($mySQLConnection, $sql);
    $rowsTn = [];
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($rowTn = mysqli_fetch_assoc($result)) {
            #echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
            #array_push($data,$row);
            $rowsTn = $rowTn;
        }
    } else {
        return "0 results";
    }
    $holder = array();
    $counter=0;
    array_push($holder,$rowsTn["FirstName"]);
//echo $rows["PCity"];
    // echo $holder[7];
    //echo $holder;
    return $holder;
}
// get the data for the tenant's landlord
function getLandlordData($mySQLConnection, $email)
{
    $sql = "SELECT FirstName, LastName, Phone, Rating FROM Users WHERE Email = '" .$email ."'";
    $result = mysqli_query($mySQLConnection, $sql);
    $rowsLL = [];
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($rowLL = mysqli_fetch_assoc($result)) {
            #echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
            #array_push($data,$row);
            $rowsLL = $rowLL;
        }
    } else {
        return "0 results";
    }
    $holder = array();
    $counter=0;
    array_push($holder,$rowsLL["FirstName"]);
    array_push($holder,$rowsLL["LastName"]);
    array_push($holder,$rowsLL["Phone"]);
    array_push($holder,$rowsLL["Rating"]);
//echo $rows["PCity"];
    // echo $holder[7];
    //echo $holder;
    return $holder;
}
function getCompanyData($mySQLConnection, $email)
{
    //Get the company name
    $sql = "SELECT CompanyName FROM Landlord WHERE Email = '" .$email ."'";
    $result = mysqli_query($mySQLConnection, $sql);
    $rowsCN = [];
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($rowCN = mysqli_fetch_assoc($result)) {
            #echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
            #array_push($data,$row);
            $rowsCN = $rowCN;
        }
    } else {
        return "0 results";
    }
    $holder = array();
    $counter=0;
    //set values into an array to hold the data and pass this back to the caller
    array_push($holder,$rowsCN["CompanyName"]);
//echo $rows["PCity"];
    // echo $holder[7];
    //echo $holder;
    return $holder;
}
function GetEndDays($startDate){
    $futureDate=date('Y-m-d', strtotime('+1 year', strtotime($startDate)) );
    // echo $datediff. " ". $today. " ". $duedate;
    return $futureDate;
}
function GetFinancialData($mySQLConnection, $email){
    //Get the documents
    $sql = "SELECT PropertyID, Amount, PaidDate, Note FROM MoneyTransaction WHERE Tenant = '".$email ."' ORDER BY PaidDate DESC";
    $result = mysqli_query($mySQLConnection, $sql);
    $rowsFin = [];
    //echo $email;
    //echo $PropertyID;
    if (mysqli_num_rows($result) > 0) {
        // echo "now in doc if";
        // output data of each row
        while ($rowFin = mysqli_fetch_assoc($result)) {
            #echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
            #array_push($data,$row);
            $rowsFin = $rowFin;
        }
    } else {
        // echo "missed";
        return "0 results";
    }
    $holder = array();
    $counter=0;
    //set values into an array to hold the data and pass this back to the caller
    array_push($holder,$rowsFin["PropertyID"]);
    array_push($holder,$rowsFin["Amount"]);
    array_push($holder,$rowsFin["PaidDate"]);
    array_push($holder,$rowsFin["Note"]);
//echo $holder[1];
    //  echo "<-The Name";
    //echo $holder[2];
    //echo $holder;
    return $holder;
}
function getDocData($mySQLConnection, $email, $PropertyID)
{
    if ($PropertyID== null){
        return 0;
    }
    //Get the documents
    $sql = "SELECT LeaseID, LeaseName, LeaseDate FROM Lease WHERE PropertyID = '".$PropertyID. "' AND  UserEmail =
 '".$email ."' UNION SELECT NoticeID, NoticeName, NoticeDate FROM Notice WHERE PropertyID = '".$PropertyID ."'AND  Email =
 '".$email  ."'ORDER BY LeaseDate DESC";
    $result = mysqli_query($mySQLConnection, $sql);
    $rowsDoc = [];
    //echo $email;
    //echo $PropertyID;
    if (mysqli_num_rows($result) > 0) {
        // echo "now in doc if";
        // output data of each row
        while ($rowDoc = mysqli_fetch_assoc($result)) {
            #echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
            #array_push($data,$row);
            $rowsDoc = $rowDoc;
        }
    } else {
        // echo "missed";
        return "0 results";
    }
    $holder = array();
    $counter=0;
    //set values into an array to hold the data and pass this back to the caller
    while ($counter < sizeof($rowsDoc)){
        array_push($holder,$rowsDoc["LeaseID"]);
        array_push($holder,$rowsDoc["LeaseName"]);
        array_push($holder,$rowsDoc["LeaseDate"]);
        $counter = $counter+1;
    }
//echo $holder[1];
    //  echo "<-The Name";
    //echo $holder[0];
    //echo $holder;
    return $holder;
}
/*
 * session exaample
 * on page one: $_SESSION["favcolor"] = "green";
 * on page teo: echo "Favorite color is " . $_SESSION["favcolor"] . ".<br>";
 * */
// Obtain user email and get property data, landlord data, and lease data
//TODO utilize the session data for the user id once it has been set up.
//$UserID= "another@email.com";//$_SESSION["Email"];
$connection = connectToDatabase();
VerifyGood($connection, $UserID);
$propertyData = getPropertyData($connection, $UserID);
$UserData = getTenantData($connection, $UserID);
$MoneyData = getMoneyData($connection, $UserID);
/*
        if($counter == 1){array_push($holder,$rowsP["FileName"]);}
        elseif($counter == 2){array_push($holder,$rowsP["PAddress"]);}
        elseif($counter == 3){array_push($holder,$rowsP["PCity"]);}
        elseif($counter == 4){array_push($holder,$rowsP["PState"]);}
        elseif($counter == 5){array_push($holder,$rowsP["PZip"]);}
        elseif($counter == 6){array_push($holder,$rowsP["MonthlyRent"]);}
        elseif($counter == 7){array_push($holder,$rowsP["Owner"]);}
        elseif($counter == 8){array_push($holder,$rowsP["PropertyID"]);}
*/
$ImageP = $propertyData[0];
$Address = $propertyData[1];
$City = $propertyData[2];
$State = $propertyData[3];
$Zip = $propertyData[4];
$StartDate = $MoneyData[0];
$NDueDate = $MoneyData[1];
$MonthlyRent= $propertyData[5];
$LandlordEmail= $propertyData[6];
$_SESSION['PropertyID'] = $propertyData[7];
$propertyID= $propertyData[7];
//echo $propertyID;
$CompanyData = getCompanyData($connection,$LandlordEmail );
$Landlord = getLandlordData($connection, $LandlordEmail);
$Documents= getDocData($connection, $UserID, $propertyID);
$Finance= GetFinancialData($connection, $UserID);
//document data
$documentId = $Documents[0];
$documentName = $Documents[1];
$documentDate = $Documents[2];
//$LeaseDetails = $propertyData[8];
//financial data
/*array_push($holder,$rowsFin["PropertyID"]);
array_push($holder,$rowsFin["Amount"]);
array_push($holder,$rowsFin["PaidDate"]);
array_push($holder,$rowsFin["Note"]);*/
$financialAmount= $Finance[1];
$financialPaidDate= $Finance[2];
$financialNote= $Finance[3];
/////
$Name = $UserData[0];
$LLFName= $Landlord[0];
$LLLName= $Landlord[1];
$LLPhone= $Landlord[2];
$LLRating= $Landlord[3];
$LLCompanyName= $CompanyData[0];
$LeaseEndDate = GetEndDays($StartDate);
mysqli_close($connection);
$PropertyID = $_POST['PropertyID'];
$_SESSION['PropertyID'] = $PropertyID;
//include '../db_config.php';
//$mySQLConnection = $connection;
//$docQuery = "SELECT LeaseID, LeaseName, LeaseDate FROM Lease WHERE PropertyID = $PropertyID AND  UserEmail =
// '$UserID' UNION SELECT NoticeID, NoticeName, NoticeDate FROM Notice WHERE PropertyID = $PropertyID  AND  UserEmail =
// '$UserID' ORDER BY LeaseDate DESC";
//$docResult = mysqli_query($mySQLConnection, $docQuery);
//echo $docResult;
//$mySQLConnection->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentingFromMeMockup</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
        	<!-- ****** faviconit.com favicons ****** -->
    <link rel="shortcut icon" href="../assets/img/favicons/favicon.ico">
	<link rel="icon" sizes="16x16 32x32 64x64" href="assets/img/favicons/favicon.ico">
	<link rel="icon" type="image/png" sizes="196x196" href="assets/img/favicons/favicon-192.png">
	<link rel="icon" type="image/png" sizes="160x160" href="assets/img/favicons/favicon-160.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicons/favicon-96.png">
	<link rel="icon" type="image/png" sizes="64x64" href="assets/img/favicons/favicon-64.png">
	<link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/favicon-32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/favicon-16.png">
	<link rel="apple-touch-icon" href="assets/img/favicons/favicon-57.png">
	<link rel="apple-touch-icon" sizes="114x114" href="assets/img/favicons/favicon-114.png">
	<link rel="apple-touch-icon" sizes="72x72" href="assets/img/favicons/favicon-72.png">
	<link rel="apple-touch-icon" sizes="144x144" href="assets/img/favicons/favicon-144.png">
	<link rel="apple-touch-icon" sizes="60x60" href="assets/img/favicons/favicon-60.png">
	<link rel="apple-touch-icon" sizes="120x120" href="assets/img/favicons/favicon-120.png">
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/favicons/favicon-76.png">
	<link rel="apple-touch-icon" sizes="152x152" href="assets/img/favicons/favicon-152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/favicon-180.png">
	<meta name="msapplication-TileColor" content="#FFFFFF">
	<meta name="msapplication-TileImage" content="assets/img/favicons/favicon-144.png">
	<meta name="msapplication-config" content="assets/img/favicons/bro">
	<!-- ****** faviconit.com favicons ****** -->
</head>

<body>
<div class="main-header-container">
    <nav class="navbar navbar-default navigation-clean-search" id="navigationBar">
        <div class="container">
            <div class="navbar-header" id="homeIcon">
                <img height="35.1875" width="39.4375" src="../assets/img/logo.png">
                <a class="navbar-brand navbar-link" href="index.php">Renting From Me</a>
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navcol-1">
                <a id="logoutTab" href="../User/logout.php" class="navbar-text navbar-right nav-links">
                    <i class="icon-logout"></i>
                    <span>Logout</span>
                </a>
                <a id="settingsTab" href="profile.php" class="navbar-text navbar-right nav-links">
                    <i class="icon-settings"></i>
                    <span>Settings</span>
                </a>
                <a id="inboxTab" href="../Inbox/index.php" class="navbar-text navbar-right nav-links">
                    <i class="icon-envelope"></i>
                    <span>Inbox</span>
                </a>
                <a id="inboxTab" href="Search/index.php" class="navbar-text navbar-right nav-links">
                    <i class="icon-magnifier"></i>
                    <span>Search</span>
                </a>
                <p id="userBanner" class="navbar-text navbar-right">
                    <span>Welcome, <?php echo $firstName; ?></span>
                </p>
            </div>
        </div>
    </nav>
    <div id="headerBlock" class="header-block">
        <div class="container" style="/*height:100%;*//*display:table;*/">
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-7 no-float header-card" id="propertyDetails" style="/*display:flex;*//*flex-direction:column;*//*justify-content:space-between;*/">
                    <div class="row">
                        <div class="col-md-7">
                            <h4>Property Details</h4>
                            <p>Address: <?php  echo $Address;  ?>
                                <br> City: <?php  echo $City;  ?>
                                <br> State: <?php  echo $State;  ?>
                                <br> Zip: <?php  echo $Zip;  ?>
                            </p>
                            <h4>Lease Details</h4>
                            <p><br> Lease Start Date:<?php  echo $StartDate;  ?>
                                <br> Lease End Date:<?php  echo $LeaseEndDate;  ?>
                            </p>
                        </div>
                        <div class="col-md-5"><img src="../Landlord/UserPics/<?php echo $ImageP; ?>" alt="property image" style="width:304px;height:228px;"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div style="text-align:right;">
                                <p>Next Payment: $<?php echo $MonthlyRent ?> Due <?php  echo $NDueDate  ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 no-float header-card" id="landlordDetails">
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="center-content"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <p class="text-center">Landlord Details</p>
                                <p class="text-center">Rating: <?php echo $LLRating ?>
                                    <br> First Name: <?php echo $LLFName ?>
                                    <br> Last Name: <?php echo $LLLName ?>
                                    <br> Phone Number: <?php echo $LLPhone ?>
                                    <br> Company Name: <?php echo $LLCompanyName ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-center"><i class="material-icons" style="font-size:28px;">mail_outline</i></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container" id="contentContainer">
    <div class="row" id="documentBlock">
        <div class="col-md-12">
            <h1>Documents</h1></div>
        <div class="col-md-12" id="documentsContainer">
            <div class="row" style="font-size:17px;">
                <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12 flex"><i class="fa fa-file-pdf-o"></i>
                    <p>Document Title</p>
                    <p><?php echo $documentName?></p>
                </div>
                <div class="col-lg-3 col-md-2 col-sm-3 col-xs-4" style="/*text-align:center;*/">
                    <p>Dated </p>
                    <p><?php echo $documentDate ?></p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-3 col-xs-8" style="text-align:right;">
                    <i class="fa fa-refresh"></i>
                    <i class="fa fa-trash"></i>
                    <button id = "edit-icon-button" type = "button" onClick="location.href='../Documents/studio/viewLease.php'">
                        <i class="fa fa-arrow-circle-o-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="financeBlock">
        <div class="col-md-12">
            <h1>Finances<button class="btn btn-default" onClick="location.href='../assets/php/payment.php'" type="button">Add Payment</button> </h1>
            <div id="financeChart"></div>
        </div>
        <div class="col-md-12">
            <div id="financeChart"></div>
        </div>
        <div class="col-md-12" id="financesContainer">
            <div class="row" style="font-size:17px;">
                <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12 flex"><i class="fa fa-dollar"></i>
                    <p>Payment Title <br><?php echo "     ". $financialNote?> </p>

                </div>
                <div class="col-lg-3 col-md-2 col-sm-3 col-xs-4" style="/*text-align:center;*/">
                    <p>Payment Date <br><?php echo $financialPaidDate?></p>

                </div>
                <div class="col-lg-4 col-md-4 col-sm-3 col-xs-8" style="text-align:right;">
                    <p>+/- Payment Amount  <br><?php echo $financialAmount?></p>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="../assets/js/bs-animation.js"></script>
</body>
