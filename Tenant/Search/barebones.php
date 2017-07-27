<?php
/**
 * Created by PhpStorm.
 * User: clinton
 * Date: 4/11/17
 * Time: 9:40 PM
 */
$post = $_POST['Catcher'];

if(strlen($post)=== 0) {
    $post = "an error has occurred";
    echo $post;
    return;

}




class TableRows extends RecursiveIteratorIterator {
    function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current() {
        return "<td>" . parent::current(). "</td>";
    }

    function beginChildren() {
        echo "<tr>";
    }

    function endChildren() {
        echo "</tr>" . "\n";
    }
}

try {
    $servername = "localhost";
    $dbUsernameToConnect = "davidtec_rent";
    $dbPasswordToConnect = "+q~h(Kb3nbS@";
    $database = "davidtec_renting";
    $conn = new PDO("mysql:host=$servername;dbname=davidtec_renting", $dbUsernameToConnect, $dbPasswordToConnect);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare($post);
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $return ="";
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
        $return = $return.$v;
    }
    print $return;
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;




?>