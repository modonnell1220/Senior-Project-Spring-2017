<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
//if ($_SESSION['UserID'] == ""){
//    header('Location: ../index.php');
//}
$firstName;$lastName;$dob;$address;$city;$state;$zip;$phone;$carrier;$email;$identifier;$cname;$keys;$repKey;$lateFee;$checkFee; $lateDays; $captcha;
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
if(isset($_POST['email']))
    $email=$_POST['email'];
if(isset($_POST['rb']))
    $identifier=$_POST['rb'];
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
if(isset($_POST['g-recaptcha-response']))
    $captcha=$_POST['g-recaptcha-response'];

//echo "VALUES ('$email', '$firstName', '$lastName', '$dob', '$address','$city', '$state', '$zip','$phone', 'number', 500, '$identifier', 'ET', 'pass')";
//echo "VALUES ('$email', '$cname', $lateFee,$checkFee, $keys, $lateDays, $repKey)";

if($carrier === ""){  //checks if carrier was selected if so then create a text
    $text = "";
}
else{
    $text = $phone.''.$carrier;
}

if(!$captcha){ //bad captcha
    header('Location: index.php?message=3');
}
$response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LexBhgUAAAAAB3hztXcRAIkouzHCJllGj5gcT-E&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
if($response['success'] == false)
{
    echo '<h2>You are spammer ! Please find your way to another site.</h2>';
}
else
{
    //Establish a connection to the database
    include '../db_config.php';
    $mySQLConnection = connectToDatabase();

    $email = $mySQLConnection->real_escape_string($email); //security

    $query = "SELECT * FROM Users WHERE Email ='$email'";

//Issue query against database
    $result = $mySQLConnection->query($query);       //check if email is taken already

    $row = $result->fetch_row();

//Close database
    $mySQLConnection->close();

    if ($row[2] != ""){                             //check if email is taken already
        header('Location: ../index.php?message=5'); //email taken already
    }
    else {

        $password = generateRandomString(); //generate password to email

        //Establish a connection to the database

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

        $query2 = "INSERT INTO Users (Email, FirstName, LastName, DOB, Address, City, UserState, Zip, Phone, SMS, Rating, Identifier, EmailTextNot, Passwordhash) ";
        $query2 = $query2 . "VALUES ('$email', '$firstName', '$lastName', '$dob', '$address','$city', '$state', '$zip','$phone', '$text', 500, '$identifier', 'ET', '$password')";
        //Issue query against database
        $result = $mySQLConnection->query($query2, $mysql_access);

        if ($identifier === 'L'){
            $query3 = "INSERT INTO Landlord (Email, CompanyName, LateFee, CheckFee, KeyFurnashed, DaysTillRentLate, ReplacementKey) ";
            $query3 = $query3 . "VALUES ('$email', '$cname', $lateFee,$checkFee, $keys, $lateDays, $repKey)";
            //Issue query against database
            $result2 = $mySQLConnection->query($query3, $mysql_access);
            //Close database
            $mySQLConnection->close();

            $subject = "Your RentingForMe.com account";     //email Landlord
            $message = "Welcome to RentingFromMe.com! Your account has been created however we need to verify you are a landlord. Please reply to conact@RentingFromMe.com with a tax statement or some sort of reputable paperwork to verify you are a landlord and your account will be activated.";
            $from = "contact@RentingFromMe.com";
            $headers = "From: $from";

            mail($email, $subject, $message, $headers);

            header('Location: ../index.php?message=4'); //sucess
        }
        else{
            //Close database
            $mySQLConnection->close();

            $subject = "Your RentingForMe.com password";     //email password to User
            $message = "Welcome to RentingFromMe.com! Your assigned password is $password. If you wish to change it click on the My Profile button";
            $from = "DoNotReply@RentingFromMe.com";
            $headers = "From: $from";

            mail($email, $subject, $message, $headers);

            header('Location: ../index.php?message=4');   //sucess
        }
    }
}

//generate random string with characters
function generateRandomString($length = 8) { //create a randompassword to email
    $characters = '23456789abcdefghjkmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ*-#@'; // exclude similiar  char i,l,1,0,O
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>

