<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();

$email;$password;$captcha;
if(isset($_POST['email']))
    $email=$_POST['email'];
if(isset($_POST['password']))
    $password=$_POST['password'];
if(isset($_POST['g-recaptcha-response']))
    $captcha=$_POST['g-recaptcha-response'];


if(!$captcha){ //bad captcha
    header('Location: ../index.php?message=3');
}
$response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LexBhgUAAAAAB3hztXcRAIkouzHCJllGj5gcT-E&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
if($response['success'] == false)
{
    echo '<h2>You are spammer ! Please find your way to another site.</h2>';
}
else
{
    // Create connection
    include '../db_config.php';
    $mySQLConnection = connectToDatabase();

    $email = $mySQLConnection->real_escape_string($email); //security
    $password = $mySQLConnection->real_escape_string($password); //security

    $sqlSelect = $mySQLConnection->prepare("SELECT Email , PasswordHash, FirstName, Identifier FROM Users WHERE Email = ?");

    $sqlSelect->bind_param("s", $email);
    $sqlSelect->execute();
    $sqlSelect->bind_result($dbUserEmail, $dbPassword, $firstName, $identifier);
    $sqlSelect->fetch();

//Close database
    $mySQLConnection->close();

    if ($password == $dbPassword)
    {
        $_SESSION['UserID'] = $email;
        $_SESSION['firstName'] = $firstName;
        $_SESSION['identifier'] = $identifier;

        if ($identifier === 'L'){
            header('Location: ../Landlord/index.php');
            exit();
        }
        else{
            header('Location: ../Tenant/index.php');
            exit();
        }
    }
    else
    {
        header('Location: ../index.php?message=1');
        exit();
    }
}

?>