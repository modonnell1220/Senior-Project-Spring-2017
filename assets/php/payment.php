<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === ""){
    header('Location: ../index.php');
}
else{
    $PropertyID =$_SESSION['PropertyID'];
}
//$UserEmail = 'another@email.com'; //this will erase when session is made
//$Landlord = 'bob@iloveemail.com'; //will need to be created when click on property

$today = date("Y-m-d");       //get todays date
$amountPaid = 0;
$firstTransaction= false;
// Create connection
include '../../db_config.php';
$mySQLConnection = connectToDatabase();

$query = "SELECT NextDueDate, AmountDue, LateAmountDue FROM MoneyTransaction WHERE PropertyID = '$PropertyID' ORDER BY MoneyID DESC LIMIT 1";  //get all transactions only works
$result = $mySQLConnection->query($query);

if ($result->num_rows <= 0){ //nothing in query and is the first payment made
    $query2 = "SELECT  MonthlyRent, Deposit, PetDeposit, StartDate, Owner, Tenant FROM Property WHERE PropertyID = '$PropertyID'";  //get all transactions
    $result2 = $mySQLConnection->query($query2);
    if ($result2->num_rows <= 0){
        echo "System error somehow you made it here when you shouldnt be. Please contact admin! ERROR PAYNODATA1";
    }
    else{
        $row2 = $result2->fetch_row();
        $rent = $row2[0] + $row2[1] + $row2[2];
        $lastDueDate = $row2[3];
        $Landlord = $row2[4];
        $UserEmail = $row2[5];
        //Close database
        $mySQLConnection->close();

        $lastLateFeeOwed = 0;
        $lastBalance = 0;
        $lateFeeForRecord = 0;
        $tempDate = $lastDueDate; //create so next line wont mess up date
        $nextDueDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($tempDate)) . "1 month "));
        $firstTransaction = true; //set for post to handle calulation diffrently
    }
}
else{
    //this section is for when the tenant is in the system and not the first payment they have made like above
    $row = $result->fetch_row();

    $lastDueDate = $row[0];    //This is pulled from the database as last transaction
    $lastBalance = $row[1];               // if negative they paid more than due amount
    $lastLateFeeOwed = $row[2];

    $query3 = "SELECT  DaysTillRentLate, LateFee FROM Landlord WHERE Email = (SELECT Owner FROM Property WHERE PropertyID = '$PropertyID')";  //get all transactions

    $result3 = $mySQLConnection->query($query3);
    if ($result3->num_rows <= 0){
        echo "System error somehow you made it here when you shouldnt be. Please contact admin! ERROR PAYNODATA2";
    }
    $row3 = $result3->fetch_row();
    $daysTillLate = $row3[0];;
    $latefee = $row3[1];

    $query4 = "SELECT  MonthlyRent, Owner, Tenant FROM Property WHERE PropertyID = '$PropertyID'";  //get all transactions
    $result4 = $mySQLConnection->query($query4);
    if ($result4->num_rows <= 0){
        echo "System error somehow you made it here when you shouldnt be. Please contact admin! ERROR PAYNODATA3";
    }
    $row4 = $result4->fetch_row();
    $rent = $row4[0];
    $Landlord = $row4[0];
    $UserEmail = $row4[1];
    $fee = 0; //initialize fee to 0

    //Close database
    $mySQLConnection->close();

    include 'calculate_Amounts.php';

}


?>
<html>
<body>
<div>Last Due Date:<?php echo date('m-d-Y', strtotime($lastDueDate))?> Todays Date:<?php echo date('m-d-Y', strtotime($today))?></div>
<div>Next Due Date:<?php echo date('m-d-Y', strtotime($nextDueDate))?>  Rent: <?php echo $rent?>
    <?php
    if($firstTransaction){
        ?><div>Last Balance:<?php echo $lastBalance?> Current Fee: <?php echo $rent?> Last Late Fee Owed: <?php echo $lastLateFeeOwed?> </div> <?php
    }
    else{
    ?><div>Last Balance:<?php echo $lastBalance?> Current Fee: <?php echo $balance?> Last Late Fee Owed: <?php echo $lastLateFeeOwed?> </div> <?php
    }
    ?>
<form action="payment_query.php" method="post">
    Amount You Wish to Pay:<input type="number"  name="amount" step="0.01" required>
    Note:<input type="text"  name="note"  maxlength="99">
    <input type="number" value="<?php echo $rent?>" name="rentDue" hidden>
    <input type="text"  value="<?php echo $firstTransaction?>" name="firstTransaction"  hidden>
    <input type="text"  value="<?php echo $nextDueDate?>" name="nextDueDate"  hidden>
    <input type="number"  value="<?php echo $daysTillLate?>" name="daysTillLate"  hidden>
    <input type="number"  value="<?php echo $latefee?>" name="latefee"  hidden>
    <input type="date"  value="<?php echo $lastDueDate?>" name="lastDueDate"  hidden>
    <input type="number"  value="<?php echo $lastBalance?>" name="lastBalance"  hidden>
    <input type="number"  value="<?php echo $lastLateFeeOwed?>" name="lastLateFeeOwed"  hidden>
    <input type="text"  value="<?php echo $Landlord?>" name="Landlord"  hidden>
    <input type="text"  value="<?php echo $UserEmail?>" name="UserEmail"  hidden>
    <button type="submit">Pay</button>
</form>
</body>
</html>