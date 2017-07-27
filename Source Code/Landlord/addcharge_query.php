<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'L'){
    header('Location: ../index.php');
}
else{
    $UserID = $_SESSION['UserID'];

}
$PropertyID = $_SESSION['PropertyID'];

    $amount=$_POST['amount'];
    $date=$_POST['date'];
    $note=$_POST['note'];

////upload picture and add to query
include_once '../db_config.php';
$mySQLConnection = connectToDatabase();

$query = "INSERT INTO Loss (PropertyID, Amount, TheDate, Note) ";
$query = $query . "VALUES ($PropertyID, $amount, '$date', '$note')";

$result = $mySQLConnection->query($query, $mysql_access);
////Close database
$mySQLConnection->close();

header('Location: index.php');
exit();




?>

