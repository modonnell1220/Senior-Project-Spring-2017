<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'T'){
    header('Location: ../index.php');
}
else{
    $UserEmail = $_SESSION['UserID'];

    // Create connection
    include '../db_config.php';
    $mySQLConnection = connectToDatabase();

    $sqlSelect = $mySQLConnection->prepare("SELECT Owner FROM Property WHERE Tenant = '$UserEmail'");
    if ($result->num_rows <= 0){
        session_destroy();
        header('Location: ../index.php');
    }
}
$row = $result->fetch_row();

$User = $_SESSION['UserID'];
$Landlord = $row[0];

include '../assets/php/payment.php';
?>