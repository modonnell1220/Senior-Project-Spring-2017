<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'T'){
    header('Location: .../../../index.php');
}
else{
    $UserID = $_SESSION['UserID'];
    $firstName = $_SESSION['firstName'];
    $identifier = $_SESSION['identifier'];
}
if(isset($_POST['PropertyID'])){
    $_SESSION['PropertyID'] = $_POST['PropertyID'];
}   //$id = $_POST['PropertyID'];}

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>

<body>
<div>
    <nav class="navbar navbar-default navigation-clean-search" id="navigationBar">
        <div class="container">
            <div class="navbar-header" id="homeIcon">
                <img height="35.1875" width="39.4375" src="../../assets/img/logo.png">
                <a class="navbar-brand navbar-link" href="../index.php">Renting From Me</a>
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navcol-1">
                <a id="logoutTab" href="../../User/logout.php" class="navbar-text navbar-right nav-links">
                    <i class="icon-logout"></i>
                    <span>Logout</span>
                </a>
                <a id="settingsTab" href="../profile.php" class="navbar-text navbar-right nav-links">
                    <i class="icon-settings"></i>
                    <span>Settings</span>
                </a>
                <a id="inboxTab" href="../../Inbox/index.php" class="navbar-text navbar-right nav-links">
                    <i class="icon-envelope"></i>
                    <span>Inbox</span>
                </a>
                <a id="inboxTab" href="index.php" class="navbar-text navbar-right nav-links">
                    <i class="icon-magnifier"></i>
                    <span>Search</span>
                </a>
                <p id="userBanner" class="navbar-text navbar-right">
                    <span>Welcome, <?php echo $firstName; ?></span>
                </p>
            </div>
        </div>
    </nav>
    <div>
        <div>
            <div>
                <h4 class="modal-title">Property Details</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="application_apply.php">
                    <div class="form-group">
                        <label class="control-label">Drivers Licence or ID Number</label>
                        <input class="form-control" type="text" name="dNumber" maxlength="99" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Anticipated move-in date</label>
                        <input class="form-control" type="date" name="mDate" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Rent Amount You Agree to Pay</label>
                        <input class="form-control" type="number" maxlength="99" name = "rAmount" step=".01" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Deposit Amount You Agree to Pay</label>
                        <input class="form-control" type="number" maxlength="99" name = "dAmount" step=".01" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Number of Occupants Over 18</label>
                        <input class="form-control" type="number" maxlength="3" name = "nOccupants" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Number of Occupants Under 18</label>
                        <input class="form-control" type="number" maxlength="3" name = "nUnderOccupants" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Will you have pets?</label>
                        <input type="radio" name="pet" value="yes" required> Yes
                        <input type="radio" name="pet" value="no"> No<br>
                    </div>
            </div>
            <div>
                <h4 class="modal-title">Residential History</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label">Month/Year moved into current address</label>
                    <input class="form-control" type="date" name="cDate" required>
                </div>
                <div class="form-group">
                    <label class="control-label">Reason for leaving</label>
                    <input class="form-control" type="text" maxlength="99" name = "leaving" required>
                </div>
                <div class="form-group">
                    <label class="control-label">Owner/Agent Name</label>
                    <input class="form-control" type="text" maxlength="50" name = "aName" required>
                </div>
                <div class="form-group">
                    <label class="control-label">Contact Phone</label>
                    <input class="form-control" type="text" maxlength="20" name = "cPhone" required>
                </div>
            </div>
            <div>
                <h4 class="modal-title">Credit History</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label">Have you declared bankruptcy in the past 7 years?</label>
                    <input type="radio" name="bankruptcy" value="yes" required> Yes
                    <input type="radio" name="bankruptcy" value="no"> No<br>
                </div>
                <div class="form-group">
                    <label class="control-label">Have you ever been evicted from a rental residence?</label>
                    <input type="radio" name="evicted" value="yes" required> Yes
                    <input type="radio" name="evicted" value="no"> No<br>
                </div>
                <div class="form-group">
                    <label class="control-label">Have you had two or more late rental payments in the past year?</label>
                    <input type="radio" name="late" value="yes" required> Yes
                    <input type="radio" name="late" value="no"> No<br>
                </div>
                <div class="form-group">
                    <label class="control-label">Have you ever willfully or intentionally refused to pay rent when due?</label>
                    <input type="radio" name="refused" value="yes" required> Yes
                    <input type="radio" name="refused" value="no"> No<br>
                </div>
            </div>
            <div>
                <h4 class="modal-title">Employment Information</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label">Status</label>
                    <input type="radio" name="status" value="Full Time" required> Full Time
                    <input type="radio" name="status" value="Part Time"> Part Time
                    <input type="radio" name="status" value="Student"> Student
                    <input type="radio" name="status" value="Unemployed"> Unemployed
                </div>
                <div class="form-group">
                    <label class="control-label">Employer</label>
                    <input class="form-control" type="text" maxlength="50" name = "emp">
                </div>
                <div class="form-group">
                    <label class="control-label">Supervisor Name</label>
                    <input class="form-control" type="text" maxlength="50" name = "supN">
                </div>
                <div class="form-group">
                    <label class="control-label">Supervisor Phone</label>
                    <input class="form-control" type="text" maxlength="20" name = "supP">
                </div>
                <div class="form-group">
                    <label class="control-label">Salary</label>
                    <input class="form-control" type="text" maxlength="20" name = "salary">
                </div>
                <div class="form-group">
                    <label class="control-label">School</label>
                    <input class="form-control" type="text" maxlength="50" name = "school">
                </div>
            </div>
            <div>
                <h4 class="modal-title">References – Personal or Emergency Contact</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label">Name</label>
                    <input class="form-control" type="text" name="rName" required>
                </div>
                <div class="form-group">
                    <label class="control-label">Address</label>
                    <input class="form-control" type="text" maxlength="99" name = "rAddress" required>
                </div>
                <div class="form-group">
                    <label class="control-label">Phone</label>
                    <input class="form-control" type="text" maxlength="50" name = "rPhone" required>
                </div>
                <div class="form-group">
                    <label class="control-label">Relationship</label>
                    <input class="form-control" type="text" maxlength="20" name = "Rrelationship" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Submit</button>
                <button class="btn btn-default" type="reset" >Clear</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="../assets/js/bs-animation.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
</body>

</html>