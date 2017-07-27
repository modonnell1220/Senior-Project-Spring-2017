<?php session_start();
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'T'){
    header('Location: ../index.php');
}
else{
    $emailID = $_SESSION['UserID'];
}

$message = $_GET['message'];
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
if ($message==1){
    alert('Sorry you types an incorrect password. Please try again.');
}
if ($message==2){
    alert('Your passwords dont match. Please try again.');
}
if ($message==3){
    alert('Password has been changed!');
}
if ($message==4){
    alert('System error PROFILE');
}
if ($message==5){
    alert('Information has been updated');
}

//Establish a connection to the database
include '../db_config.php';
$mySQLConnection = connectToDatabase();

$query = "SELECT * FROM Users WHERE Email = '$emailID'";  //get all of users code
$result = $mySQLConnection->query($query);

//Close the Database
$mySQLConnection->close();

if ($result->num_rows <= 0 ){
   //something bad
}
else{
    $row = $result->fetch_row();
        $firstName = $row[1];
        $lastName = $row[2];
        $dob = $row[3];
        $address = $row[4];
        $city = $row[5];
        $state = $row[6];
        $zip = $row[7];
        $phone = $row[8];
        $sms = $row[9];
        $identifier = $row[11];
        $EmailTextNot = $row[12];

    strtok($sms, "@");  //break down carrier ID
    $withoutSign =strtok("@");
    $carrierID = "@$withoutSign";
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
<div class="container-fluid">
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
    <div class="col-md-6 col-md-offset-3">
        <form action='../User/change_Password.php' method='post'>
            <div class="table-responsive">
                <table class="table">
                    <caption><h3>Change Password</h3></caption>
                    <tr>
                        <td>Old Password :</td>
                        <td><input type='password' name='oldPassword'></td>
                    </tr>
                    <tr>
                        <td>New Password :</td>
                        <td><input type='password' name='newPassword' maxlength="99"></td>
                    </tr>
                    <tr>
                        <td> Re-Type Password :</td>
                        <td><input type='password' name='newPassword2' maxlength="99"></td>
                    </tr>
                    <tr>
                        <td colspan='2'><input type='Submit' value='Change Password'></td>
                    </tr>
                </table>
            </div>

        </form>
        <hr>
        <form action='../User/editProfile.php' method='post'>
            <div class="form-group">
                <label class="control-label">First Name</label>
                <input type="text" name="first_name" value="<?php echo $firstName;?>" maxlength="250" required>
            </div>
            <div class="form-group">
                <label class="control-label">Last Name</label>
                <input type="text" name="last_name"value="<?php echo $lastName;?>"  maxlength="50" required>
            </div>
            <div class="form-group">
                <label class="control-label">Date of Birth</label>
                <input type="date" name="dob" value="<?php echo $dob;?>" required>
            </div>
            <div class="form-group">
                <label class="control-label">Address </label>
                <input type="text" name = "address" value="<?php echo $address;?>"  maxlength="200" required>
            </div>
            <div class="form-group">
                <label class="control-label">City </label>
                <input type="text" name = "city" value="<?php echo $city;?>" maxlength="100" required>
            </div>
            <div class="form-group">
                <label class="control-label">State </label>
                <input type="text" name = "state" value="<?php echo $state;?>" maxlength="20" required>
            </div>
            <div class="form-group">
                <label class="control-label">Zip Code</label>
                <input type="text" name = "zip" value="<?php echo $zip;?>" maxlength="12" required>
            </div>
            <div class="form-group">
                <label class="control-label">Phone </label>
                <input type="tel" name = "phone" value="<?php echo $phone;?>" maxlength="13" required>
            </div>
            <div class="form-group">
                <label class="control-label">SMS </label>
                <select name="carrier">
                    <option value="" >Please select Provider</option>
                    <option value="@sms.3rivers.net" <?php if($carrierID === '@sms.3rivers.net'){echo "selected";}?>>3 River Wireless</option>
                    <option value="@paging.acswireless.com" <?php if($carrierID === '@paging.acswireless.com'){echo "selected";}?>>ACS Wireless</option>
                    <option value="@message.alltel.com" <?php if($carrierID === '@message.alltel.com'){echo "selected";}?>>Alltel</option>
                    <option value="@txt.att.net" <?php if($carrierID === '@txt.att.net'){echo "selected";}?>>AT&T</option>
                    <option value="@txt.bellmobility.ca" <?php if($carrierID === '@txt.bellmobility.ca'){echo "selected";}?>>Bell Canada</option>
                    <option value="@txt.bellmobility.ca" <?php if($carrierID === '@txt.bellmobility.ca'){echo "selected";}?>>Bell Mobility</option>
                    <option value="@blueskyfrog.com" <?php if($carrierID === '@blueskyfrog.com'){echo "selected";}?>>Blue Sky Frog</option>
                    <option value="@sms.bluecell.com" <?php if($carrierID === '@sms.bluecell.com'){echo "selected";}?>>Bluegrass Cellular</option>
                    <option value="@myboostmobile.com" <?php if($carrierID === '@myboostmobile.com'){echo "selected";}?>>Boost</option>
                    <option value="@bplmobile.com" <?php if($carrierID === '@bplmobile.com'){echo "selected";}?>>BPL Mobile</option>
                    <option value="@cwwsms.com" <?php if($carrierID === '@cwwsms.com'){echo "selected";}?>>Carolina West</option>
                    <option value="@mobile.celloneusa.com" <?php if($carrierID === '@mobile.celloneusa.com'){echo "selected";}?>>Cellular One</option>
                    <option value="@csouth1.com" <?php if($carrierID === '@csouth1.com'){echo "selected";}?>>Cellular South</option>
                    <option value="@cwemail.com" <?php if($carrierID === '@cwemail.com'){echo "selected";}?>>Centennial Wireless</option>
                    <option value="@messaging.centurytel.net" <?php if($carrierID === '@messaging.centurytel.net'){echo "selected";}?>>CenturyTel</option>
                    <option value="@txt.att.net" <?php if($carrierID === '@txt.att.net'){echo "selected";}?>>Cingular</option>
                    <option value="@msg.clearnet.com" <?php if($carrierID === '@msg.clearnet.com'){echo "selected";}?>>Clearnet</option>
                    <option value="@comcastpcs.textmsg.com" <?php if($carrierID === '@comcastpcs.textmsg.com'){echo "selected";}?>>Comcast</option>
                    <option value="@corrwireless.net" <?php if($carrierID === '@corrwireless.net'){echo "selected";}?>>Corr Wireless Communications</option>
                    <option value="@mms.cricketwireless.net" <?php if($carrierID === '@mms.cricketwireless.net'){echo "selected";}?>>Cricket</option>
                    <option value="@mobile.dobson.net" <?php if($carrierID === '@mobile.dobson.net'){echo "selected";}?>>Dobson</option>
                    <option value="@sms.edgewireless.com" <?php if($carrierID === '@sms.edgewireless.com'){echo "selected";}?>>Edge</option>
                    <option value="@fido.ca" <?php if($carrierID === '@fido.ca'){echo "selected";}?>>Fido</option>
                    <option value="@sms.goldentele.com" <?php if($carrierID === '@sms.goldentele.com'){echo "selected";}?>>Golden Telecom</option>
                    <option value="@messaging.sprintpcs.com" <?php if($carrierID === '@messaging.sprintpcs.com'){echo "selected";}?>>Helio</option>
                    <option value="@text.houstoncellular.net" <?php if($carrierID === '@text.houstoncellular.net'){echo "selected";}?>>Houston Cellular</option>
                    <option value="@ideacellular.net" <?php if($carrierID === '@ideacellular.net'){echo "selected";}?>>Idea Cellular</option>
                    <option value="@pagemci.com" <?php if($carrierID === '@pagemci.com'){echo "selected";}?>>MCI</option>
                    <option value="@page.metrocall.com" <?php if($carrierID === '@page.metrocall.com'){echo "selected";}?>>Metrocall</option>
                    <option value="@mymetropcs.com" <?php if($carrierID === '@mymetropcs.com'){echo "selected";}?>>Metro PCS</option>
                    <option value="@fido.ca" <?php if($carrierID === '@fido.ca'){echo "selected";}?>>Microcell</option>
                    <option value="@mobilecomm.net" <?php if($carrierID === '@mobilecomm.net'){echo "selected";}?>>Mobilcomm</option>
                    <option value="@text.mtsmobility.com" <?php if($carrierID === '@text.mtsmobility.com'){echo "selected";}?>>MTS</option>
                    <option value="@messaging.nextel.com" <?php if($carrierID === '@messaging.nextel.com'){echo "selected";}?>>Nextel</option>
                    <option value="@onlinebeep.net" <?php if($carrierID === '@onlinebeep.net'){echo "selected";}?>>OnlineBeep</option>
                    <option value="@pcsone.net" <?php if($carrierID === '@pcsone.net'){echo "selected";}?>>PCS One</option>
                    <option value="@txt.bell.ca" <?php if($carrierID === '@txt.bell.ca'){echo "selected";}?>>President's Choice</option>
                    <option value="@msg.fi.google.com" <?php if($carrierID === '@msg.fi.google.com'){echo "selected";}?>>Project Fi</option>
                    <option value="@sms.pscel.com" <?php if($carrierID === '@sms.pscel.com'){echo "selected";}?>>Public Service Cellular</option>
                    <option value="@qwestmp.com" <?php if($carrierID === '@qwestmp.com'){echo "selected";}?>>Qwest</option>
                    <option value="@pcs.rogers.com" <?php if($carrierID === '@pcs.rogers.com'){echo "selected";}?>>Rogers</option>
                    <option value=".pageme@satellink.net" <?php if($carrierID === '@satellink.net'){echo "selected";}?>>Satellink</option>
                    <option value="@email.swbw.com" <?php if($carrierID === '@email.swbw.com'){echo "selected";}?>>Southwestern Bell</option>
                    <option value="@messaging.sprintpcs.com" <?php if($carrierID === '@messaging.sprintpcs.com'){echo "selected";}?>>Sprint</option>
                    <option value="@tms.suncom.com" <?php if($carrierID === '@tms.suncom.com'){echo "selected";}?>>SunCom</option>
                    <option value="@mobile.surewest.com" <?php if($carrierID === '@mobile.surewest.com'){echo "selected";}?>>Sure West</option>
                    <option value="@tmomail.net" <?php if($carrierID === '@tmomail.net'){echo "selected";}?>>T Mobile</option>
                    <option value="@msg.telus.com" <?php if($carrierID === '@msg.telus.com'){echo "selected";}?>>Telus</option>
                    <option value="@txt.att.net" <?php if($carrierID === '@txt.att.net'){echo "selected";}?>>Tracfone</option>
                    <option value="@tms.suncom.com" <?php if($carrierID === '@tms.suncom.com'){echo "selected";}?>>Triton</option>
                    <option value="@utext.com" <?php if($carrierID === '@utext.com'){echo "selected";}?>>Unicel</option>
                    <option value="@email.uscc.net" <?php if($carrierID === '@email.uscc.net'){echo "selected";}?>>US Cellular</option>
                    <option value="@vtext.com" <?php if($carrierID === '@vtext.com'){echo "selected";}?>>Verizon</option>
                    <option value="@vmobl.com" <?php if($carrierID === '@vmobl.com'){echo "selected";}?>>Virgin Mobile</option>
                    <option value="@sms.wcc.net" <?php if($carrierID === '@sms.wcc.net'){echo "selected";}?>>West Central Wireless</option>
                    <option value="@cellularonewest.com" <?php if($carrierID === '@cellularonewest.com'){echo "selected";}?>>Western Wireless</option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label"></label>
                <input type="text" name = "identifier" value="<?php echo $identifier;?>" hidden>
            </div>
            <div>
                <input type="radio" name="EmailTextNot" <?php if($EmailTextNot === 'ET'){echo "checked";}?> value="ET"> Get Email and Text Notifications
                <input type="radio" name="EmailTextNot" <?php if($EmailTextNot === 'T'){echo "checked";}?> value="T"> Get Just Text Notifications
                <input type="radio" name="EmailTextNot" <?php if($EmailTextNot === 'E'){echo "checked";}?> value="E"> Get Just Email Notifications
                <input type="radio" name="EmailTextNot" <?php if($EmailTextNot === ''){echo "checked";}?> value=""> Get No Notifications
            </div>
            <tr>
                <td colspan='2'><input type='Submit' value='Change Information'></td>
            </tr>
        </form>
    </div>
</div>
</body>
</html>
