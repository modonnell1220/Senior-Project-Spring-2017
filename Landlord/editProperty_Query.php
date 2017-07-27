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
if(isset($_POST['PropertyID']))
    $PropertyID=$_POST['PropertyID'];


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
    // Create connection
    include_once '../db_config.php';
    $mySQLConnection = connectToDatabase();

    $getFileName = "SELECT FileName FROM Property WHERE PropertyID = '$PropertyID'";  //get all transactions only works
    $FileNameResult = $mySQLConnection->query($getFileName);
    $mySQLConnection->close();

//    if ($FileNameResult->num_rows <= 0){     This is where files should be deleted when new one is being inserted
//        //no file to unlink
//    }
//    else{
//        $fileToUnlink = $FileNameResult->fetch_row();
//        unlink('UserPics/$fileToUnlink[0]');
//    }
    $mySQLConnection = connectToDatabase();

    $query = "UPDATE Property SET Owner = '$Landlord', PAddress = '$PAddress', PCity = '$PCity', PState = '$PState', PZip = '$PZip', PCounty = '$PCounty', Mortgage = $Mortgage, Deposit = $Deposit,
              PetDeposit = $PetDeposit, MonthlyRent = $MonthlyRent, Bed = $Bed, Bath = $Bath, Info = '$Info', FileName = '$final_file', FileType = '$final_type', FileSize = '$new_size' WHERE PropertyID = $PropertyID";

    $result = $mySQLConnection->query($query);
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

    $query = "UPDATE Property SET Owner = '$Landlord', PAddress = '$PAddress', PCity = '$PCity', PState = '$PState', PZip = '$PZip', PCounty = '$PCounty', Mortgage = $Mortgage, Deposit = $Deposit,
              PetDeposit = $PetDeposit, MonthlyRent = $MonthlyRent, Bed = $Bed, Bath = $Bath, Info = '$Info' WHERE PropertyID = $PropertyID";

    $result = $mySQLConnection->query($query);
    //Close database
    $mySQLConnection->close();
    header('Location: index.php?message=2');
    exit();
}

?>