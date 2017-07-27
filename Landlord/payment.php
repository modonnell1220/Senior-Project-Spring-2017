<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'L'){
    header('Location: ../index.php');
}
else{
    $User = $_SESSION['UserID'];

    // Create connection
    include '../db_config.php';
    $mySQLConnection = connectToDatabase();

    $sqlSelect = $mySQLConnection->prepare("SELECT Tenant FROM Property WHERE Owner = '$User'");
    if ($result->num_rows <= 0){
        session_destroy();
        header('Location: ../index.php');
    }
}
$row = $result->fetch_row();

$UserEmail = $row[0];
$Landlord = $_SESSION['UserID'];

include '../assets/php/payment.php';
?>