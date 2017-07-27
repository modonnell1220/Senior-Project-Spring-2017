<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
session_destroy(); //just have this here for now so we can escape sessions
header('Location: ../index.php');

?>