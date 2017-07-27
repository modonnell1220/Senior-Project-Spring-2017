<?php session_start();
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] == ""){
    header('Location: ../index.php');
}
else{
    $emailID = $_SESSION['UserID'];
}

$oldPassword = $_POST['oldPassword'];
$newPassword = $_POST['newPassword'];
$newPassword2 = $_POST['newPassword2'];

//Establish a connection to the database
include '../db_config.php';
$mySQLConnection = connectToDatabase();

$oldPassword = $mySQLConnection->real_escape_string($oldPassword);
$newPassword = $mySQLConnection->real_escape_string($newPassword);
$newPassword2 = $mySQLConnection->real_escape_string($newPassword2);

//Create query string
$query = "SELECT Identifier, PasswordHash FROM Users WHERE Email='$emailID'";

//Issue query against database
$result = $mySQLConnection->query($query, $mysql_access);

if ($result->num_rows <= 0){
    if ($Identifier === 'L'){
        header('Location: ../Landlord/profile.php?message=4');
    }
    else{
        header('Location: ../Tenant/profile.php?message=4');
    }
}
//Fetch row
$row = $result->fetch_row();
$Identifier = $row[0];
$PasswordHash = $row[1];

//Close database
$mySQLConnection->close();


if ( $oldPassword != $PasswordHash){        // old password does not match
    if ($Identifier === 'L'){
        header('Location: ../Landlord/profile.php?message=1');
    }
    else{
        header('Location: ../Tenant/profile.php?message=1');
    }
}
else if ($newPassword != $newPassword2)     //password dont match
{
    if ($Identifier === 'L'){
        header('Location: ../Landlord/profile.php?message=2');
    }
    else{
        header('Location: ../Tenant/profile.php?message=2');
    }
}
else if($newPassword == $newPassword2){
    //Establish a connection to the database
    $mySQLConnection = connectToDatabase();

    $newPassword = $mySQLConnection->real_escape_string($newPassword);

//Create query string
    $query = "UPDATE Users SET PasswordHash= '$newPassword' WHERE Email = '$emailID'";

//Issue query against database
    $result = $mySQLConnection->query($query);

//Close database
    $mySQLConnection->close();

//Redirect back to main

    if ($Identifier === 'L'){
        header('Location: ../Landlord/profile.php?message=3');
    }
    else{
        header('Location: ../Tenant/profile.php?message=3');
    }
}
else{
    if ($Identifier === 'L'){
        header('Location: ../Landlord/profile.php');
    }
    else{
        header('Location: ../Tenant/profile.php');
    }
}
?>