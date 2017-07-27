<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'L'){
    header('Location: ../index.php');
}
else{
    $Landlord = $_SESSION['UserID'];
}

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
    alert('Photo did not upload properly please try again');
}
//http://www.php-mysql-tutorial.com/wikis/mysql-tutorials/uploading-files-to-mysql-database.aspx
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
                    <form method="post" action="addProperty_Query.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label">Address </label>
                            <input class="form-control" type="text" name="PAddress" maxlength="199" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">City </label>
                            <input class="form-control" type="text" maxlength="99" name = "PCity" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">State </label>
                            <input class="form-control" type="text" maxlength="20" name = "PState" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Zip </label>
                            <input class="form-control" type="text" maxlength="12" name = "PZip" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">County </label>
                            <input class="form-control" type="text" maxlength="50" name="PCounty" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Mortage </label>
                            <input class="form-control" type="number" maxlength="11" name="Mortgage" step = .01 required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Monthly Rent</label>
                            <input class="form-control" type="number" maxlength="11" name="MonthlyRent" step = .01 required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Deposit </label>
                            <input class="form-control" type="number" maxlength="11" name="Deposit" step = .01 required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Pet Deposit</label>
                            <input class="form-control" type="number" maxlength="11" name="PetDeposit" step = .01 required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Image </label>
                            <input type="file" name="file">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Bed </label>
                            <input class="form-control" type="number" maxlength="3" name="Bed" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Bath </label>
                            <input class="form-control" type="number" maxlength="3" name="Bath" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Info/Description </label>
                            <textarea class="form-control" maxlength="250" name="Info" required></textarea>
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