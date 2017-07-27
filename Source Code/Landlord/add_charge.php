<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'L'){
    header('Location: ../index.php');
}
else{
    $UserID = $_SESSION['UserID'];

}
$PropertyID = $_SESSION['PropertyID'];

?>
<html>
<body>
    <form action="addcharge_query.php" method="post">
        Addition Cost: <input type="number"  name="amount" step="0.01" required>
        Date to Post: <input type="date"  name="date" required>
        Note: <input type="text"  name="note"  maxlength="99">
        <button type="submit">Submit</button>
    </form>
</body>
</html>