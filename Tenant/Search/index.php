<?php

if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] == ""){
    header('Location: ../index.php');
}
else{
    $UserID = $_SESSION['UserID'];
    $firstName = $_SESSION['firstName'];
    $identifier = $_SESSION['identifier'];
}
$_SESSION['PropertyID'] =  "";

$message = $_GET['message'];
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
if ($message==1){
    alert('Application has been submitted');
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
    <link rel="stylesheet" href="assets/css/main.css">
    <script type="text/javascript" src="assets/js/SearchInfoReg.js"></script>
    <script type="text/javascript" src="assets/js/searchButton.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
</head>

<body>
<div class="main-header-container">
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
                        <div id="filterOptions"><span>Options: <div id="selector">
    <div id ="sendReg">
        <select id= "fun" onchange=changeName()>
            <option value =""></option>
            <option value="address">county</option>
            <option value="zip">zip</option>
            <option value="monthlyRent">monthly rent</option>
            <option value="bed">bed</option>
            <option value="bath">bath</option>
        </select>
        <div id="insertlocation"></div>
    </div>
    <p id="added"></p>
</div>
                        </div>
                        <div id="searchAndToggleBlock">

                            <input id="uniquenametext" type="text">
                            <button class="btn btn-default" type="button" onclick="run()">Search </button>
                            <button class="btn btn-default" type="button" onclick=cardview()>Card </button>
                            <button class="btn btn-default" type="button"onclick=listview()>List </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="contentContainer" class="container">

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="../assets/js/bs-animation.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
</body>

</html>
