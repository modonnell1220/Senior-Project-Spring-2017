<?php

$amount = $_POST['amount'];
$note = $_POST['note'];
$firstTransaction = $_POST['firstTransaction'];  //set true if it is the first transaction between the landlord and tenant
$rent= $_POST['rentDue']; //for first time
$today = date("Y-m-d");       //get todays date
$nextDueDate = $_POST['nextDueDate'];
$daysTillLate = $_POST['daysTillLate'];
$latefee = $_POST['latefee'];
$lastDueDate = $_POST['lastDueDate'];
$lastBalance = $_POST['lastBalance'];
$lastLateFeeOwed = $_POST['lastLateFeeOwed'];
$Landlord = $_POST['Landlord'];
$UserEmail = $_POST['UserEmail'];

//$UserEmail = 'another@email.com'; //this will erase when session is made
//$Landlord = 'bob@iloveemail.com'; //will need to be created when click on property


$fee = 0; //initialize fee to 0
$balance = 0;

if ($firstTransaction){
    $balance = $rent - $amount;

    include '../../db_config.php';
    $mySQLConnection = connectToDatabase();

    $query_FirstTimePayment = "INSERT INTO `MoneyTransaction`(`Landlord`, `Tenant`, `Amount`, `PaidDate`, `NextDueDate`, `AmountDue`, `LateAmountDue`, `LatePerThisTrans`,`ThePersonPaying`, `Note`)
      VALUES ('$Landlord', '$UserEmail', $amount, '$today', '$nextDueDate', $balance, 0, 0,'$User', '$note')";
    $mySQLConnection->query($query_FirstTimePayment);

//Close database
    $mySQLConnection->close();
    print 'Paid';
}
else{
    $amountPaid = $amount * -1;            //negative indicates the amount paid
    include 'calculate_Amounts.php';

    include '../../db_config.php';
    $mySQLConnection = connectToDatabase();

    $query_FirstTimePayment = "INSERT INTO `MoneyTransaction`(`Landlord`, `Tenant`, `Amount`, `PaidDate`, `NextDueDate`, `AmountDue`, `LateAmountDue`, `LatePerThisTrans`,`ThePersonPaying`, `Note`)
      VALUES ('$Landlord', '$UserEmail', $amount, '$today', '$nextDueDate', $balance, $fee, '$lateFeeForRecord','$User', '$note')";
    $mySQLConnection->query($query_FirstTimePayment);

//Close database
    $mySQLConnection->close();
    print 'Paid 2';
}

$mySQLConnection = connectToDatabase();

$getWhoToMessage = "SELECT Email,EmailTextNot, SMS FROM Users WHERE Email = (SELECT Tenant FROM Property WHERE Owner = '$Landlord' AND Tenant = '$UserEmail')";
$UserData = $mySQLConnection->query($getWhoToMessage);
$UserDataFinal = $UserData->fetch_row();

$receiver = $UserDataFinal[0];
$textOrEmail = $UserDataFinal[1];
$sms = $UserDataFinal[2];

//Close database
$mySQLConnection->close();

if ($textOrEmail === 'ET'){
    sms($receiver, $amount, $Landlord);
    sendEMail($sms, $amount, $Landlord);
}
else if($textOrEmail === 'E'){
    sendEMail($receiver, $amount, $Landlord);
}
else if($textOrEmail === 'T'){
    sms($receiver, $amount, $Landlord);
}
////////////////end
function sms($receiver, $amount, $Landlord){
    if ($receiver != ""){  //check to see if empty and if not send
        $to      = "$receiver";
        $message = "Your payment has been sent for the amount of $amount to $Landlord. Report abuse at contact@RentingFromMe.com";
        $from = "DoNotReply@RentingFromMe.com";
        $headers = "From: $from";

        mail($to, "", $message, $headers);
    }
}
function sendEMail($email, $amount, $Landlord){
    if ($email != ""){
        $subject = "Your reciept of payment";     //email password to User
        $message = "Your payment has been sent for the amount of $amount to $Landlord. Report abuse at contact@RentingFromMe.com";
        $from = "DoNotReply@RentingFromMe.com";
        $headers = "From: $from";

        mail($email, $subject, $message, $headers);
    }
}

?>