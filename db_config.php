<?php

function connectToDatabase(){

    //Establish a connection to the database
    $servername = "localhost";
    $dbUsernameToConnect = "davidtec_rent";
    $dbPasswordToConnect = "+q~h(Kb3nbS@";
    $database = "davidtec_renting";

// Create connection
    $mySQLConnection = new mysqli($servername, $dbUsernameToConnect, $dbPasswordToConnect, $database);

// Check connection
    if ($mySQLConnection->connect_error) {
        die("Connection failed: " . $mySQLConnection->connect_error);
    }

    return $mySQLConnection;

}