<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'L'){
    header('Location: ../index.php');
}
else{
    $emailID = $_SESSION['UserID'];
    $firstName = $_SESSION['firstName'];
}
$PropertyID = $_POST['PropertyID'];
$_SESSION['PropertyID'] = $PropertyID;
//$PropertyID = 1; //this is for session or wherever it is stored
//Establish a connection to the database
include '../db_config.php';
$mySQLConnection = connectToDatabase();
$selectAmount = 9;
$printGoodOrBad = ""; //displays the status
//Tommy - Query altered
$propertyQuery = "SELECT Info, PAddress, PCity, PState, PZip, Bed, Bath, Tenant, FileName, PCounty, Mortgage, Deposit, PetDeposit, MonthlyRent FROM Property WHERE PropertyID = $PropertyID";  //get all of users code  //get all of users code
$propertyResult = $mySQLConnection->query($propertyQuery);
if ($propertyResult->num_rows <= 0){
    for($i = 0; $i < $selectAmount; $i++){
        $propData[$i] = 'N/A';
        $tenantData[$i] = 'N/A';
    }
}
else{
    $tenantQuery = "SELECT FirstName, LastName,  Phone, Rating FROM Users WHERE Email = (SELECT Tenant FROM Property WHERE PropertyID = $PropertyID)";  //get all of users code
    $tenantResult = $mySQLConnection->query($tenantQuery);
    if ($tenantResult->num_rows <= 0){
        for($i = 0; $i < $selectAmount; $i++){
            $tenantData[$i] = 'N/A';
            $printGoodOrBad = "Unit is Unoccupied";
        }
    }
    else{
        $tenData = $tenantResult->fetch_row();
        $tenantData = $tenData;
    }
    $propertyData = $propertyResult->fetch_row();
    $propData = $propertyData;
    //this crazy query only returns aything if the tenant is behind on rent or not paid over 30 days
    $goodOrBadQuery = "SELECT * FROM `MoneyTransaction` WHERE MoneyID = (SELECT MoneyID FROM `MoneyTransaction` WHERE PropertyID = $PropertyID ORDER BY MoneyID DESC LIMIT 1) AND PaidDate < DATE_SUB(now(), interval 1 month) OR  MoneyID = (SELECT MoneyID FROM `MoneyTransaction` WHERE PropertyID = $PropertyID ORDER BY MoneyID DESC LIMIT 1) AND LateAmountDue > 0";
    $goodOrBadResult = $mySQLConnection->query($goodOrBadQuery);
    if($printGoodOrBad !== "Unit is Unoccupied"){
        if ($goodOrBadResult->num_rows <= 0){
            $printGoodOrBad = "Tenant up to Date";
        } else {
            $printGoodOrBad = "Tenant is overdue";
        }
    }
}
///////////////////graph quries
$monthsCountingFor = 6; //for now just going 6 months but could increase right here and need to change script accordingly
$query = "SELECT Amount, MONTH(PaidDate) FROM MoneyTransaction WHERE PropertyID = $PropertyID AND PaidDate >= date_sub(now(), interval $monthsCountingFor month)";  //get all of users code
$result = $mySQLConnection->query($query);
$MortgageQuery = "SELECT Mortgage FROM Property WHERE PropertyID = $PropertyID";  //get all of users code
$MortgageQueryResult = $mySQLConnection->query($MortgageQuery);
$lossQuery = "SELECT Amount, MONTH(TheDate) FROM Loss WHERE PropertyID = $PropertyID AND TheDate >= date_sub(now(), interval $monthsCountingFor month)";  //get all of users code
$lossResult = $mySQLConnection->query($lossQuery);
//this is for the for display of everything together
$gainAndLossQuery =  "SELECT Note, PaidDate, Amount FROM MoneyTransaction WHERE PropertyID = $PropertyID AND PaidDate >= date_sub(now(), interval $monthsCountingFor month) UNION SELECT Note, TheDate, Amount FROM Loss WHERE PropertyID = $PropertyID AND TheDate >= date_sub(now(), interval $monthsCountingFor month) ORDER BY PaidDate DESC";
$gainAndLossResult = $mySQLConnection->query($gainAndLossQuery);
///////////////////Document Queries
$docQuery = "SELECT LeaseID, LeaseName, LeaseDate FROM Lease WHERE PropertyID = $PropertyID UNION SELECT NoticeID, NoticeName, NoticeDate FROM Notice WHERE PropertyID = $PropertyID ORDER BY LeaseDate DESC";
$docResult = $mySQLConnection->query($docQuery);
///////////////////////////////////////// modify property query
$modifyquery = "SELECT PAddress, PCity, PState, PZip, PCounty, Mortgage,Deposit,PetDeposit, MonthlyRent,Bed, Bath, Info FROM Property WHERE PropertyID = '$PropertyID'";  //get all transactions only works
$modifyresult = $mySQLConnection->query($modifyquery);
//Close the Database
$mySQLConnection->close();
////////////////////////////////////////////These are all the gains
if ($modifyresult->num_rows <= 0){
    alert('Propety ID not in the system');
}
else{
//    $PAddress;$PCity;$PState;$PZip;$PCounty;$Mortgage;$MonthlyRent;$Deposit;$PetDeposit;$Bed; $Bath;$Info;
    $modify = $modifyresult->fetch_row();
    $PAddress = $modify[0];
    $PCity = $modify[1];
    $PState = $modify[2];
    $PZip = $modify[3];
    $PCounty = $modify[4];
    $Mortgage = $modify[5];
    $Deposit = $modify[6];
    $PetDeposit = $modify[7];
    $MonthlyRent = $modify[8];
    $Bed = $modify[9];
    $Bath = $modify[10];
    $Info = $modify[11];
}
if ($result->num_rows <= 0){
    for($i = 0; $i < $monthsCountingFor; $i++){
        $month[$i] = 'N/A';
        $amount[$i] = '0';
    }
}
else {
    $i = 0;
    $month[] = 0;
    $amount[] = 0;
    while ($row = $result->fetch_row()) {
        $Amount = $row[0];
        $Month = $row[1];
        if ($Month === $month[$i - 1]){ //same months or more than 1 payment that month
            $amount[$i - 1] += $Amount;
        }
        else{
            $amount[$i] = $Amount; //single payment or different month
            $month[$i] = $Month;
            $i++;
        }
    }
    if (sizeof($month) < $monthsCountingFor){ // if all months are not full of data
        for($i = sizeof($month); $i < $monthsCountingFor; $i++){
            $month[$i] = 'N/A';
            $amount[$i] = '0';
        }
    }
}
////////////////////////////////handle losses from here
$finalMonthLoss[] = 0;
$finalAmountLoss[] = 0;
$mortgage = $MortgageQueryResult->fetch_row();
if ($MortgageQueryResult->num_rows <= 0){
    for($i = 0; $i < $monthsCountingFor; $i++){
        $finalMonthLoss[$i] = 'N/A';
        $finalAmountLoss[$i] = '0';
    }
}
else{
    $i = 0;
    $monthLoss[] = 0;
    $amountLoss[] = 0;
    while ($wholeRow = $lossResult->fetch_row()) {
        $Amount2 = $wholeRow[0];
        $Month2 = $wholeRow[1];
        if ($Month2 === $monthLoss[$i - 1]){ //same months or more than 1 payment that month
            $amountLoss[$i - 1] += $Amount2;
        }
        else{
            $amountLoss[$i] = $Amount2; //single payment or different month
            $monthLoss[$i] = $Month2;
            $i++;
        }
    }
}
//calculate loss and fill in empty months with just rent collected
$k = 0;
for ($j = 0; $j < $monthsCountingFor; $j++){
    if ($month[$j] === 'N/A'){
        $finalMonthLoss[$j] = 'N/A';
        $finalAmountLoss[$j] = 0;
    }
    else if ($month[$j] === $monthLoss[$k]){
        $finalMonthLoss[$j] = $monthLoss[$k];
        $finalAmountLoss[$j] = $amountLoss[$k] + $mortgage[0];
        $k++;
    }
    else{
        $finalMonthLoss[$j] = $month[$j];
        $finalAmountLoss[$j] = $mortgage[0];
    }
}
?>


<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentingFromMe.com</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <!---   EDIT PROPERTY MODAL  (you can move this segment anywhere if it helps with the PHP. edit_property.php has php code to pull in current values in the form.)  --->
        <div class="modal fade" role="dialog" tabindex="-1" id="editPropertyFormModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Property </h4>
                </div>
                <form method="post" action="editProperty_Query.php" enctype="multipart/form-data">
                <div class="modal-body">
                          <div class="form-group">
                            <label class="control-label">Address </label>
                            <input class="form-control" type="text" name="PAddress" value="<?php echo"$propData[1]"?>"  maxlength="199" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">City </label>
                            <input class="form-control" type="text" maxlength="99" value="<?php echo"$propData[2]"?>" name = "PCity" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">State </label>
                            <input class="form-control" type="text" maxlength="20" value="<?php echo"$propData[3]"?>" name = "PState" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Zip </label>
                            <input class="form-control" type="text" maxlength="12" value="<?php echo"$propData[4]"?>" name = "PZip" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">County </label>
                            <input class="form-control" type="text" maxlength="50" value="<?php echo"$propData[9]"?>" name="PCounty" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Mortage </label>
                            <input class="form-control" type="number" maxlength="11" value="<?php echo"$propData[10]"?>" name="Mortgage" step = .01 required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Monthly Rent</label>
                            <input class="form-control" type="number" maxlength="11" value="<?php echo"$propData[13]"?>" name="MonthlyRent" step = .01 required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Deposit </label>
                            <input class="form-control" type="number" maxlength="11" value="<?php echo"$propData[11]"?>" name="Deposit" step = .01 required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Pet Deposit</label>
                            <input class="form-control" type="number" maxlength="11" value="<?php echo"$propData[12]"?>" name="PetDeposit" step = .01 required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Image </label>
                            <input type="file" name="file">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Bed </label>
                            <input class="form-control" type="number" maxlength="3" value="<?php echo"$propData[5]"?>" name="Bed" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Bath </label>
                            <input class="form-control" type="number" maxlength="3" value="<?php echo"$propData[6]"?>" name="Bath" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Info/Description </label>
                            <textarea class="form-control" maxlength="250" name="Info"  minlength="1"><?php echo"$propData[0]"?></textarea>
                        </div>
                        <textarea  name="PropertyID"  hidden><?php echo"$PropertyID"?></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" type="reset" >Clear</button>
                    <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<!--    //////////////////////////////add charge modal-->
    <div class="modal fade" role="dialog" tabindex="-1" id="propertyFormModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Property </h4></div>
                <div class="modal-body">
                    <form method="post" action="addcharge_query.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label">Addition Cost: </label>
                            <input type="number"  name="amount" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Date to Post: </label>
                            <input type="date"  name="date" value="<?php echo  date("Y-m-d");?> " required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Note: </label>
                            <input type="text"  name="note"  maxlength="99">
                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" type="reset" >Clear</button>
                    <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    
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
                    <p id="userBanner" class="navbar-text navbar-right">
                        <span>Welcome, <?php echo $firstName; ?></span>
                    </p>
                </div>
            </div>
        </nav>
        <div id="headerBlock" class="header-block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-7 header-card" id="propertyDetails">
                        <div class="row">
                            
                            <div class="col-md-5">
                                <img width="225" src='UserPics/<?php echo $propData[8]; ?>'> 
                            </div>
                            <div class="col-md-7">
                                Information - <?php echo  $propData[0]; ?>
                                <br>
                                <?php echo  $propData[1]; ?> <?php echo  $propData[2]; ?>, <?php echo $propData[3]; ?> <?php echo  $propData[4]; ?>
                                <br> 
                                <?php echo $propData[5];?> Bedroom, 
                                <?php echo $propData[6];?> Bathrooms
                                <br> 
                                Status: <?php  echo $printGoodOrBad;?>
                            </div>
                        </div>
                            
                        <div class="row">
                            <div class="col-md-12">
                                <div class="flex-container">
                                    <div>
                                        <span style="font-size:24px;">
                                        <button id="edit-icon-button" type="button" data-toggle="modal" data-target="#editPropertyFormModal"><i class="fa fa-pencil" style="padding-right:7px;"></i></button>
                                        <i class="fa fa-trash"></i>
                                        </span>
                                    </div>
                                    <div>
                                    Is Active Property
                                        <label class="switch">
                                          <input type="checkbox">
                                          <div class="slider round"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 header-card" id="tenantDetails">
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    <p class="text-center">Tenant Details</p>
                                    <p class="text-center">Rating <?php if (!empty($PTenant)){echo $Rating;} else {echo
                                        "Vacant Property";}?></p>
                                    <p class="text-center"> First Name: <?php echo $tenantData[0];?></p>
                                    <p class="text-center"> Last Name: <?php echo $tenantData[1]; ?></p>
                                    <p class="text-center"> Phone Number: <?php echo $tenantData[2];?></p>
                                    <p class="text-center"> SMS: <?php echo $tenantData[3];?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-center">Status: <?php if (!empty($propData)){echo $stats;} else {echo
                                    "N/A";}?></p>
                            </div>
                            <div class="col-md-6">
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
                <h1>Documents<button class="btn btn-default"  onClick="location.href='../Documents/studio/lessor/newLease.php'" type="button">Create </button> </h1></div>
            <div class="col-md-12" id="documentsContainer">
                
                <!--    This is an example of what needs to be rendered for a document instance    
                        Render:
                        - documentId in the id attribute
                        - Document Title i.e Lease
                        - Date Created
                        - If you want to include actions, you can add an onclick handler for the icons
                        such that landlords can re-create/refresh, soft delete, send to tenant. look up
                        'data-[whatever]' attributes on HTML elements so you can use javascript to get info
                        for element (like the doc id) when a user clicks an icon. this is so when a user clicks
                        on the delete icon, you can use JS to quickly grab the document id if you have a 'data-id'
                        attribute on the icon <i> element.
                -->
                <div class="row" id="DOCUMENTID" style="font-size:17px;">
                    <?php
                    if ($docResult->num_rows <= 0){
                        echo "<div class=\"col-lg-5 col-md-6 col-sm-6 col-xs-12 flex\">
                        <i class=\"fa fa-file-pdf-o\"></i>
                        <p>Document Title N/A</p>
                    </div>
                    <div class=\"col-lg-3 col-md-2 col-sm-3 col-xs-4\" style=\"/*text-align:center;*/\">
                        <p>N/A </p>
                    </div>
                    <div class=\"col-lg-4 col-md-4 col-sm-3 col-xs-8\" style=\"text-align:right;\">
                        <i class=\"fa fa-refresh\"></i>
                        <i class=\"fa fa-trash\"></i>
                        <i class=\"fa fa-arrow-circle-o-right\"></i></div>";
                    }
                    else {
                        while ($wholeRow = $docResult->fetch_row()) {
                            echo "<div class=\"col-lg-5 col-md-6 col-sm-6 col-xs-12 flex\">
                        <i class=\"fa fa-file-pdf-o\"></i>
                        <p>$wholeRow[0]</p>
                    </div>
                    <div class=\"col-lg-3 col-md-2 col-sm-3 col-xs-4\" style=\"/*text-align:center;*/\">
                        <p>$wholeRow[1]</p>
                    </div>
                    <div class=\"col-lg-4 col-md-4 col-sm-3 col-xs-8\" style=\"text-align:right;\">
						<button id = 'edit-icon-button' type = 'button' onClick=\"location.href='../Landlord/property.php\">
							<i class=\"fa fa-refresh\"></i>
						</button>
						
						<button id = 'edit-icon-button' type = 'button' onClick=\"location.href='../Documents/studio/deleteLease.php?id=$wholeRow[0]'\">
							<i class=\"fa fa-trash\"></i>
						</button>
						
						<button id = 'edit-icon-button' type = 'button' onClick=\"location.href='../Documents/studio/checkLease.php?id=$wholeRow[0]'\">
							<i class=\"fa fa-arrow-circle-o-right\"></i></div>
						</button>"
						;
                        }
                    }
                    ?>
                </div>
                <!--    end     -->
                
            </div>
        </div>
        

        <div class="row" id="financeBlock">
            <div class="col-md-12">
                <h1>Finances<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#propertyFormModal">Add Charge</button><button class="btn btn-default" onClick="location.href='../assets/php/payment.php'" type="button">Collect Rent</button>  </h1>
                <div id="financeChart"></div>
            </div>
            <div class="col-md-12">
                <div id="financeChart" style="height: 400px></div>
            </div>
            <div class="col-md-12" id="financesContainer">
                <!--    This is an example of what needs to be rendered for a document instance    
                        Render:
                        - payment/chargeId in the id attribute
                        - Payment Title (monthly payment, late fee etc.)
                        - Date Created
                        - Payment Amount
                        - If you want landlords to be able to delete charges, you can add an icon for that too
                -->
                <?php
                if ($gainAndLossResult->num_rows <= 0){   //Nothing pulled in database
                echo"<div class=\"row\" id=\"PAYMENT/CHARGEID\" style=\"font-size:17px;\">
                    <div class=\"col-lg-5 col-md-6 col-sm-6 col-xs-12 flex\"><i class=\"fa fa-dollar\"></i>
                        <p>No Payments to Show</p>
                    </div>
                    <div class=\"col-lg-3 col-md-2 col-sm-3 col-xs-4\" style=\"/*text-align:center;*/\">
                        <p>N/A </p>
                    </div>
                    <div class=\"col-lg-4 col-md-4 col-sm-3 col-xs-8\" style=\"text-align:right;\">
                        <p>N/A</p>
                    </div>
                </div>";
                }
                else{               //Data in Database
                    while ($display = $gainAndLossResult->fetch_row()) {
                        echo "<div class=\"row \" id=\"PAYMENT/CHARGEID\" style=\"font-size:17px;\">
                        <div class=\"col-lg-5 col-md-6 col-sm-6 col-xs-12 flex\"><i class=\"fa fa-dollar\"></i>
                            <p>$display[2]</p>
                        </div>
                        <div class=\"col-lg-3 col-md-2 col-sm-3 col-xs-4\" style=\"/*text-align:center;*/\">
                            <p>$display[1]</p>
                        </div>
                        <div class=\"col-lg-4 col-md-4 col-sm-3 col-xs-8\" style=\"text-align:right;\">
                            <p>$display[0]</p>
                        </div>
                    </div>";
                    }
                }
                ?>
                <!--    end region    -->
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-animation.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        Highcharts.chart('financeChart', {
            title: {
                text: 'Gains and Losses'
            },
            chart: {
                type: 'area'
            },
            xAxis: {
                categories: [<?php echo "'$month[0]', '$month[1]', '$month[2]', '$month[3]', '$month[4]', '$month[5]'";?>]
            },
            colors: ['#2F518B', '#f44245'],
            series: [{
                name: 'Gains',
                data: [<?php echo "$amount[0], $amount[1], $amount[2], $amount[3], $amount[4], $amount[5]";?>],
            }, {
                name: 'Losses',
                data: [<?php echo "$finalAmountLoss[0], $finalAmountLoss[1], $finalAmountLoss[2], $finalAmountLoss[3], $finalAmountLoss[4], $finalAmountLoss[5]";?>]
            }]
        });
    </script>
</body>
</html>