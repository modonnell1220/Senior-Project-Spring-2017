<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
session_destroy(); //just have this here for now so we can escape sessions
//if ($_SESSION['UserID'] !== ""){
//    $UserID = $_SESSION['UserID'];
//    $firstName = $_SESSION['firstName'];
//    $identifier = $_SESSION['identifier'];
//        if($identifier === 'T'){
//            header('Location: Tenant/index.php');
//        }
//        else if ($identifier === 'L'){
//            header('Location: Landlord/index.php');
//        }
//}

$message = $_GET['message'];
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
if ($message==1){
    alert('Wrong Email/Password please try again');
}
if ($message==2){
    alert('email taken already');
}
if ($message==3){
    alert('Must verify captcha');
}
if ($message==4){
    alert('Your account has been created please check your email.');
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renting From Me</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="assets/css/Footer-Basic.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css">
    <link href="https://fonts.googleapis.com/css?family=Lato|Source+Sans+Pro" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
        	<!-- ****** faviconit.com favicons ****** -->
    <link rel="shortcut icon" href="assets/img/favicons/favicon.ico">
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
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
	  (adsbygoogle = window.adsbygoogle || []).push({
		google_ad_client: "ca-pub-7141900937065734",
		enable_page_level_ads: true
	  });
	</script>
</head>

<script type="text/javascript">   //this helps both re-captcha run on both modals
    var CaptchaCallback = function() {
        grecaptcha.render('RecaptchaField1', {'sitekey' : '6LexBhgUAAAAADlM7rjdB3ZVpNUhfEj5s9aWVXy7'});
        grecaptcha.render('RecaptchaField2', {'sitekey' : '6LexBhgUAAAAADlM7rjdB3ZVpNUhfEj5s9aWVXy7'});
    };
</script>
    
<body>
    <!--    LOGIN MODAL  -->
    <div class="modal fade" role="dialog" tabindex="-1" id="loginModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="User/authenticate_user.php" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Login</h4>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">E-mail </label>
                            <input type="email" name="email" required autofocus="true" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password </label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    <div id="form-verifier">
                        <div id="RecaptchaField1" style="transform:scale(0.76);-webkit-transform:scale(0.76);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Login</button>
                </div>
                </form>
            </div>
        </div>
    </div>
        <!--    SIGNUP MODAL  -->
    <div class="modal fade" role="dialog" tabindex="-1" id="signupModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="User/create_user.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Signup</h4>
                </div>
                <div class="modal-body">
                    <div id="userForm">
                        <div class="form-row">
                            <div class="form-group lr">
                                <label class="control-label">First Name</label>
                                <input class="form-control" type="text" name="first_name" maxlength="250" required>
                            </div>
                            <div class="form-group lr">
                                <label class="control-label">Last Name</label>
                                <input class="form-control" type="text" name="last_name" maxlength="50" required>
                            </div>
                            <div class="form-group md">
                                <label class="control-label">Date of Birth</label>
                                <input class="form-control" type="date" name="dob" required>
                            </div>
                        </div>
                        <div class="form-row">
                                <div class="form-group xl">
                                    <label class="control-label">Address </label>
                                    <input class="form-control" type="text" name = "address" maxlength="200" required>
                                </div>
                                <div class="form-group sm">
                                <label class="control-label">City </label>
                                <input class="form-control" type="text" name = "city" maxlength="100" required>
                                </div>
                                <div class="form-group sm">
                                    <label class="control-label">State </label>
                                    <input class="form-control" type="text" name = "state" maxlength="20" required>
                                </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group xs">
                                <label class="control-label">Zip Code</label>
                                <input class="form-control" type="text" name = "zip" maxlength="12" required>
                            </div>
                            <div class="form-group sm">
                            <label class="control-label">Phone </label>
                            <input class="form-control" type="tel" name = "phone" maxlength="13" required>
                            </div>
                            <div class="form-group md">
                                <label class="control-label">SMS </label>
                                <select class="form-control" name="carrier">
                                <option value="" >Please select Provider</option>
                                <option value="@sms.3rivers.net">3 River Wireless</option>
                                <option value="@paging.acswireless.com">ACS Wireless</option>
                                <option value="@message.alltel.com">Alltel</option>
                                <option value="@txt.att.net">AT&T</option>
                                <option value="@txt.bellmobility.ca">Bell Canada</option>
                                <option value="@txt.bellmobility.ca">Bell Mobility</option>
                                <option value="@blueskyfrog.com">Blue Sky Frog</option>
                                <option value="@sms.bluecell.com">Bluegrass Cellular</option>
                                <option value="@myboostmobile.com">Boost</option>
                                <option value="@bplmobile.com">BPL Mobile</option>
                                <option value="@cwwsms.com">Carolina West</option>
                                <option value="@mobile.celloneusa.com">Cellular One</option>
                                <option value="@csouth1.com">Cellular South</option>
                                <option value="@cwemail.com">Centennial Wireless</option>
                                <option value="@messaging.centurytel.net">CenturyTel</option>
                                <option value="@txt.att.net">Cingular</option>
                                <option value="@msg.clearnet.com">Clearnet</option>
                                <option value="@comcastpcs.textmsg.com">Comcast</option>
                                <option value="@corrwireless.net">Corr Wireless Communications</option>
                                <option value="@mms.cricketwireless.net">Cricket</option>
                                <option value="@mobile.dobson.net">Dobson</option>
                                <option value="@sms.edgewireless.com">Edge</option>
                                <option value="@fido.ca">Fido</option>
                                <option value="@sms.goldentele.com">Golden Telecom</option>
                                <option value="@messaging.sprintpcs.com">Helio</option>
                                <option value="@text.houstoncellular.net">Houston Cellular</option>
                                <option value="@ideacellular.net">Idea Cellular</option>
                                <option value="@pagemci.com">MCI</option>
                                <option value="@page.metrocall.com">Metrocall</option>
                                <option value="@mymetropcs.com">Metro PCS</option>
                                <option value="@fido.ca">Microcell</option>
                                <option value="@mobilecomm.net">Mobilcomm</option>
                                <option value="@text.mtsmobility.com">MTS</option>
                                <option value="@messaging.nextel.com">Nextel</option>
                                <option value="@onlinebeep.net">OnlineBeep</option>
                                <option value="@pcsone.net">PCS One</option>
                                <option value="@txt.bell.ca">President's Choice</option>
                                <option value="@msg.fi.google.com">Project Fi</option>
                                <option value="@sms.pscel.com">Public Service Cellular</option>
                                <option value="@qwestmp.com">Qwest</option>
                                <option value="@pcs.rogers.com">Rogers</option>
                                <option value=".pageme@satellink.net">Satellink</option>
                                <option value="@email.swbw.com">Southwestern Bell</option>
                                <option value="@messaging.sprintpcs.com">Sprint</option>
                                <option value="@tms.suncom.com">SunCom</option>
                                <option value="@mobile.surewest.com">Sure West</option>
                                <option value="@tmomail.net">T Mobile</option>
                                <option value="@msg.telus.com">Telus</option>
                                <option value="@txt.att.net">Tracfone</option>
                                <option value="@tms.suncom.com">Triton</option>
                                <option value="@utext.com">Unicel</option>
                                <option value="@email.uscc.net">US Cellular</option>
                                <option value="@vtext.com">Verizon</option>
                                <option value="@vmobl.com">Virgin Mobile</option>
                                <option value="@sms.wcc.net">West Central Wireless</option>
                                <option value="@cellularonewest.com">Western Wireless</option>
                            </select>
                            </div>
                            <div class="form-group md">
                            <label class="control-label">E-mail </label>
                            <input class="form-control" type="email" name="email" maxlength="255" required>
                            </div>
                        </div>
                        <div class="text-center">
                            <label class="control-label">I am a</label>
                            <div class="form-group">
                            <label for="Radios">
                                <input type="radio" name="rb" id="raadio2" value="T" required onchange="dynInput(this);" /> Tenant
                            <input type="radio" style="margin-left: 10px;" name="rb" id="raadio" value="L" onchange="dynInput(this);" /> Landlord</label>
                            </div>
                        </div>
                        <div id="landlordBox" style="display: none;">
                        <div class="form-row">
                            <div class="form-group xl" id="insertinputs"></div>
                            <div class="form-group sm" id="insertinputs2"></div>
                            <div class="form-group sm" id="insertinputs3"></div>
                        </div>
                        <div class="form-row">
                            <div class="form-group ml" id="insertinputs4"></div>
                            <div class="form-group ml" id="insertinputs5"></div>
                            <div class="form-group ml" id="insertinputs6"></div>
                        </div>
                        </div>
                        <div>
                            <div id="form-verifier">
                            <div id="RecaptchaField2" style="transform:scale(0.85);-webkit-transform:scale(0.85);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Register</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!--    NAVIGATION  -->
    <div>
        <div class="header-blue">
            <nav class="navbar">
                <div class="container">
                    <div class="navbar-header">
                        <a class="navbar-brand navbar-link" href="#">Renting From Me</a>
                        <!--    COLLAPSED MOBILE NAVIGATION  -->
                        <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="navcol-1">
                        <!--    NAVIGATION LINKS  -->
                        <p class="navbar-text navbar-right">
                            <a class="navbar-link login" href="#landlord-anchor">Landlords</a>
                            <a class="navbar-link login" href="#tenant-anchor">Tenants</a>
                            <a class="navbar-link login" href="#main-footer">About</a>
                        </p>
                    </div>
                </div>
            </nav>
            <div class="container hero">
                <!--    MAIN TITLE  -->
                <h1 class="text-center" style="font-family: 'Lato', sans-serif;">To Simplify and Modernize the Landlord-Tenant Relationship</h1>
                <!--    SUBTITLE  -->
                <p class="text-center">Built to cater to the Landlord and the Tenant to make the rental process easier while maintaining privacy. Almost a completely paperless place where you don’t have to worry where you stored your documents and eases the entire rental process.</p>
                <!--    MAIN BUTTONS  -->
                <div class="col-md-4 col-md-offset-0" style="text-align:center;width:100%;">
                    <button class="btn btn-default btn-lg action-button" type="button" data-toggle="modal" data-target="#loginModal">Log In</button>
                    <button class="btn btn-default btn-lg action-button" type="button" data-toggle="modal" data-target="#signupModal">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <div id="main-content">
    <!--    LANDLORD FEATURES  -->
    <div id="landlord-anchor">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>Landlord</h2>
                    <h3>Currently fully functional area for landlords in the state of Florida. This will almost take managing out of property management.</h3>
                    <ul class="fa-ul">
                        <li style="margin-bottom: 10px;">
                            <i class="fa-li fa fa-line-chart"></i>
                            Keep track of rent payments, late fees, and based on account activity will generate statistical information.
                        </li>
                        <li style="margin-bottom: 16px;">
                            <i class="fa-li fa fa-star"></i>
                            Rate the tenants each month.
                        </li>
                        <li>
                            <i class="fa-li fa fa-files-o"></i>
                            Digitally create a lease and handle the application process in a fraction of the time
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <img alt="Image" width="500" height="500" data-aos="fade-left" data-aos-duration="800" data-aos-once="true">
                </div>
            </div>
        </div>
    </div>
    <!--    TENANT FEATURES  -->
    <div id="tenant-anchor">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img alt="Image" width="500" height="500" data-aos="zoom-in" data-aos-duration="800" data-aos-once="true">
                </div>
                <div class="col-md-6">
                    <h2>Tenant</h2>
                    <h3>Make payments on your property without the added confusion. Know when your next due date is with the ability to retrieve your lease at any time of day.</h3>
                    <ul class="fa-ul">
                        <li style="margin-bottom: 16px;">
                            <i class="fa-li fa fa-credit-card"></i>
                            Make payments without the confusion of the whole process
                        </li>
                        <li style="margin-bottom: 16px;">
                            <i class="fa-li fa-li fa fa-star"></i>
                            Rate your landlord every month
                        </li>
                        <li>
                            <i class="fa-li fa fa-clock-o"></i>
                            Don’t worry about losing your lease and be informed what’s going on during the application process
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>
    <hr>
    <!--    FOOTER  -->
    <div id="main-footer" class="footer-basic">
        <footer>
            <p class="copyright">int elligence; © 2017 | contact@RentingFromMe.com</p>
        </footer>
    </div>
    <!--    SCRIPTS  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-animation.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit" async defer></script>
    <script src="assets/js/landlordBox.js"></script>
</body>
</html>