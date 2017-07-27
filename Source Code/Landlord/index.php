<?php

if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'L'){
    header('Location: ../index.php');
}
else{
    $emailID = $_SESSION['UserID'];
    $firstName = $_SESSION['firstName'];
}
$_SESSION['PropertyID'] = "";

//$UserID = "bob@ilovemail.com";

?>





<!DOCTYPE html>
<html>
<!--
request1(landlordname) this part needs to be changed!!!!!!!!!!

-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentingFromMeMockup</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="assets/js/LLRegInfo.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
    <link rel="stylesheet" href="../assets/css/styles.css">

</head>

<body>
<div class="main-header-container">
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
            <div class="row" id="headerTop">
                <div class="col-md-12">
                    <h1 id="headerTitle">Properties </h1>
                    <h4 id="headerSubTitle"></h4></div>
            </div>
            <div class="row" id="headerBottom">
                <div class="col-md-12">
                    <div class="flex-container">
                        <div id="filterOptions"><span>Options: </span><span><span class="label label-default">Label</span></span>
                        </div>
                        <div id="searchAndToggleBlock">
                            <!-- SEARCH & TOGGLE BUTTONS
                            <input type="text">
                            <button class="btn btn-default" type="button">Search </button>-->
                            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#propertyFormModal">Add Property </button>
                            <button class="btn btn-default" type="button" onclick=cardview()>Card </button>
                            <button class="btn btn-default" type="button" onclick=listview()>List </button>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>

<div id="contentContainer" class="container">
    <!--        RENDER PROPERTIES HERE          -->
    <script>
    //alert("<?php echo $UserID; ?>");
    //request1("<?php echo $UserID; ?>");
    //request1("<?php echo $UserID;?>");
    //"bob@ilovemail.com"
    request1("bob@iloveemail.com");

    </script>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="../assets/js/bs-animation.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
</body>

</html>
