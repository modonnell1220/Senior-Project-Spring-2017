<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] == ""){
    header('Location: ../index.php');
}
else{
    $emailID = $_SESSION['UserID'];
}


$firstName;$lastName;$dob;$address;$city;$state;$zip;$phone;$carrier;$identifier;$cname;$keys;$repKey;$lateFee;$checkFee; $lateDays; $EmailTextNot;
if(isset($_POST['first_name']))
    $firstName=$_POST['first_name'];
if(isset($_POST['last_name']))
    $lastName=$_POST['last_name'];
if(isset($_POST['dob']))
    $dob=$_POST['dob'];
if(isset($_POST['address']))
    $address=$_POST['address'];
if(isset($_POST['city']))
    $city=$_POST['city'];
if(isset($_POST['state']))
    $state=$_POST['state'];
if(isset($_POST['zip']))
    $zip=$_POST['zip'];
if(isset($_POST['phone']))
    $phone=$_POST['phone'];
if(isset($_POST['carrier']))
    $carrier=$_POST['carrier'];
if(isset($_POST['identifier']))
    $identifier=$_POST['identifier'];
if(isset($_POST['cname']))
    $cname=$_POST['cname'];
if(isset($_POST['keys']))
    $keys=$_POST['keys'];
if(isset($_POST['repKey']))
    $repKey=$_POST['repKey'];
if(isset($_POST['lateFee']))
    $lateFee=$_POST['lateFee'];
if(isset($_POST['checkFee']))
    $checkFee=$_POST['checkFee'];
if(isset($_POST['lateDays']))
    $lateDays=$_POST['lateDays'];
if(isset($_POST['EmailTextNot']))
    $EmailTextNot=$_POST['EmailTextNot'];

if($carrier === ""){  //checks if carrier was selected if so then create a text
    $text = "";
}
else{
    $text = $phone.''.$carrier;
}

//echo "$firstName;$lastName;$dob;$address;$city;$state;$zip;$phone;$text;$identifier;$cname;$keys;$repKey;$lateFee;$checkFee; $lateDays; $EmailTextNot";

include '../db_config.php';
$mySQLConnection = connectToDatabase();

//Create query string
$firstName = $mySQLConnection->real_escape_string($firstName); //security
$lastName = $mySQLConnection->real_escape_string($lastName); //security
$dob = $mySQLConnection->real_escape_string($dob); //security
$address = $mySQLConnection->real_escape_string($address); //security
$city = $mySQLConnection->real_escape_string($city); //security
$state = $mySQLConnection->real_escape_string($state); //security
$zip = $mySQLConnection->real_escape_string($zip); //security
$phone = $mySQLConnection->real_escape_string($phone); //security
$text = $mySQLConnection->real_escape_string($text); //security
$cname = $mySQLConnection->real_escape_string($cname); //security
$keys = $mySQLConnection->real_escape_string($keys); //security
$repKey = $mySQLConnection->real_escape_string($repKey); //security
$lateFee = $mySQLConnection->real_escape_string($lateFee); //security
$checkFee = $mySQLConnection->real_escape_string($checkFee); //security
$lateDays = $mySQLConnection->real_escape_string($lateDays); //security

$query = "UPDATE Users SET FirstName = '$firstName', LastName = '$lastName', DOB = '$dob', Address = '$address', UserState = '$state', Zip = '$zip', Phone = $phone, SMS = '$text', EmailTextNot = '$EmailTextNot'
             WHERE Email = '$emailID'";
$result = $mySQLConnection->query($query);
if ($identifier === 'L'){
    $query2 = "UPDATE Landlord SET CompanyName = '$cname', LateFee = '$lateFee', CheckFee = '$checkFee', KeyFurnashed = '$keys', DaysTillRentLate = '$lateDays', ReplacementKey = '$repKey'
             WHERE Email = '$emailID'";
    $result2 = $mySQLConnection->query($query2);
}
//Close database
$mySQLConnection->close();

if ($identifier === 'L'){
    header('Location: ../Landlord/profile.php?message=5');
}
else{
    header('Location: ../Tenant/profile.php?message=5');
}


?>
