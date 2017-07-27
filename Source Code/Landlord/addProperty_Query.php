<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'L'){
    header('Location: ../index.php');
}
else{
    $Landlord = $_SESSION['UserID'];
}


$PAddress;$PCity;$PState;$PZip;$PCounty;$Mortgage;$MonthlyRent;$Deposit;$PetDeposit;$Bed; $Bath;$Info;
if(isset($_POST['PAddress']))
    $PAddress=$_POST['PAddress'];
if(isset($_POST['PCity']))
    $PCity=$_POST['PCity'];
if(isset($_POST['PState']))
    $PState=$_POST['PState'];
if(isset($_POST['PZip']))
    $PZip=$_POST['PZip'];
if(isset($_POST['PCounty']))
    $PCounty=$_POST['PCounty'];
if(isset($_POST['Mortgage']))
    $Mortgage=$_POST['Mortgage'];
if(isset($_POST['MonthlyRent']))
    $MonthlyRent=$_POST['MonthlyRent'];
if(isset($_POST['Deposit']))
    $Deposit=$_POST['Deposit'];
if(isset($_POST['PetDeposit']))
    $PetDeposit=$_POST['PetDeposit'];
if(isset($_POST['Bed']))
    $Bed=$_POST['Bed'];
if(isset($_POST['Bath']))
    $Bath=$_POST['Bath'];
if(isset($_POST['Info']))
    $Info=$_POST['Info'];


$file = rand(1000,100000)."-".$_FILES['file']['name'];
$file_loc = $_FILES['file']['tmp_name'];
$file_size = $_FILES['file']['size'];
$file_type = $_FILES['file']['type'];
$folder="UserPics/";

// new file size in KB
$new_size = $file_size/1024;
// new file size in KB

// make file name in lower case
$new_file_name = strtolower($file);
// make file name in lower case

strtok($file_type, "/");
$final_type = strtok("/");


$final_file=str_replace(' ','-',$new_file_name);
//if(1){
//   echo "$PAddress;$PCity;$PState;$PZip;$PCounty;$Mortgage;$MonthlyRent;$Deposit;$PetDeposit;$Bed; $Bath;$Info;$final_file; $final_type;$new_size ";
//}

if($final_type != 'gif' && $final_type != 'jpg' && $final_type != 'png'&& $final_type != 'jpeg' && $final_type != '')
{
    header('Location: index.php?message=1');
    exit();
}
else if(move_uploaded_file($file_loc,$folder.$final_file))
{
    //upload picture and add to query
    include_once '../db_config.php';
    $mySQLConnection = connectToDatabase();

    $query = "INSERT INTO Property (Owner, PAddress, PCity, PState, PZip, PCounty, UniqueID, Mortgage,Deposit,PetDeposit, MonthlyRent,Bed, Bath, Info, FileName, FileType, FileSize) ";
    $query = $query . "VALUES ('$Landlord', '$PAddress', '$PCity', '$PState', '$PZip', '$PCounty', 0, $Mortgage, $Deposit, $PetDeposit, $MonthlyRent, $Bed, $Bath, '$Info', '$final_file', '$final_type', '$new_size')";

    $result = $mySQLConnection->query($query, $mysql_access);
    //Close database
    $mySQLConnection->close();
    header('Location: index.php?message=2');
    exit();
}
else
{
    //add to DB if no picture is there
    include_once '../db_config.php';
    $mySQLConnection = connectToDatabase();

    $query = "INSERT INTO Property (Owner, PAddress, PCity, PState, PZip, PCounty, UniqueID, Mortgage,Deposit,PetDeposit, MonthlyRent,Bed, Bath, Info, FileName, FileType, FileSize) ";
    $query = $query . "VALUES ('$Landlord', '$PAddress', '$PCity', '$PState', '$PZip', '$PCounty', 0, $Mortgage, $Deposit, $PetDeposit, $MonthlyRent, $Bed, $Bath, '$Info', 'defualt.jpg', 'jpg', 32)";

    $result = $mySQLConnection->query($query, $mysql_access);
    //Close database
    $mySQLConnection->close();
    header('Location: index.php?message=2');
    exit();
}

?>