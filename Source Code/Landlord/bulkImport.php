<?php
$Landlord = "";

$file_name = "data.txt";
$fp = fopen($file_name, "r");

include_once '../db_config.php';
$mySQLConnection = connectToDatabase();

while ($line = fgets($fp))
{
    $PAddress = strtok($line, "|");
    $PCity = strtok("|");
    $PState = strtok("|");
    $PZip = strtok("|");
    $PCounty = strtok("|");
    $Mortgage = strtok("|");
    $Deposit = strtok("|");
    $PetDeposit = strtok("|");
    $MonthlyRent = strtok("|");
    $Bed = strtok("|");
    $Bath = strtok("|");
    $Info = strtok("|");
    $fileName= strtok("|");
    $fileType = strtok("|");
    $fileSize = strtok("|");

    $query = "INSERT INTO Property (Owner, PAddress, PCity, PState, PZip, PCounty, UniqueID, Mortgage,Deposit,PetDeposit, MonthlyRent,Bed, Bath, Info, FileName, FileType, FileSize) ";
    $query = $query . "VALUES ('$Landlord', '$PAddress', '$PCity', '$PState', '$PZip', '$PCounty', 0, $Mortgage, $Deposit, $PetDeposit, $MonthlyRent, $Bed, $Bath, '$Info', '$fileName', '$fileType', '$fileSize')";

    $result = $mySQLConnection->query($query, $mysql_access);
}
//Close database
$mySQLConnection->close();

fclose($fp);

echo "All DONE!!";

?>