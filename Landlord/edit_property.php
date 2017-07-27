<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'L'){
    header('Location: ../index.php');
}
else{
    $Landlord = $_SESSION['UserID'];
}
$PropertyID = '11';  //still fake need to add to session


$message = $_GET['message'];
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
if ($message==1){
    alert('Not a valid image format. PNG, JPG, JPEG, or GIF only');
}
if ($message==2){
    alert('Sucess added properly');
}
if ($message==3){
    alert('No photo but everything else uploaded');
}

// Create connection
include_once '../db_config.php';
$mySQLConnection = connectToDatabase();

$query = "SELECT PAddress, PCity, PState, PZip, PCounty, Mortgage,Deposit,PetDeposit, MonthlyRent,Bed, Bath, Info FROM Property WHERE PropertyID = '$PropertyID'";  //get all transactions only works
$result = $mySQLConnection->query($query);
if ($result->num_rows <= 0){
    alert('Propety ID not in the system');
}
else{
//    $PAddress;$PCity;$PState;$PZip;$PCounty;$Mortgage;$MonthlyRent;$Deposit;$PetDeposit;$Bed; $Bath;$Info;
    $row = $result->fetch_row();
    $PAddress = $row[0];
    $PCity = $row[1];
    $PState = $row[2];
    $PZip = $row[3];
    $PCounty = $row[4];
    $Mortgage = $row[5];
    $Deposit = $row[6];
    $PetDeposit = $row[7];
    $MonthlyRent = $row[8];
    $Bed = $row[9];
    $Bath = $row[10];
    $Info = $row[11];
}

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css">
</head>

<body>
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
                        <label class="control-label">City </label>
                        Note: <input type="text"  name="note"  maxlength="99">
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
<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#propertyFormModal">Modal Button</button>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="../assets/js/bs-animation.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
</body>

</html>