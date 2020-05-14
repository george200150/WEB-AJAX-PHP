<?php
    $mysql_u = 'root';
    $mysql_p = '';
    $server_name = 'localhost';
    $mysql_t = 'pwajax';

    $conn = new mysqli($server_name,$mysql_u,$mysql_p,$mysql_t);
    if ($conn->connect_error) {
        echo("Connection failed: " . $conn->connect_error);
    }

    $prod = $_GET["prod"]; // receive all the parameters sent via GET request
    $proc = $_GET["proc"];
    $mem = $_GET["mem"];
    $hdd = $_GET["hdd"];
    $video = $_GET["video"];
    
    echo $prod;
    if($prod == "") { // ignore empty inputs
        $prod = "%";
    }
    if($proc == "") {
        $proc = "%";
    }
    if($mem == "") {
        $mem = "%";
    }
    if ($hdd == "") {
        $hdd = "%";
    }
    if($video == "") {
        $video = "%";
    }
    $command = "SELECT producator, procesor, memorie, capacitateHDD, placa_video FROM `stoc` where producator like '" . $prod . "' and procesor like '" . $proc . "' and memorie like '" . $mem . "' and capacitateHDD like '" . $hdd . "' and placa_video like '" . $video . "';"; // complete query
    $result = $conn->query($command);
    if($result === false) {
        echo("incorrect"); // incorrect query
        return false;
    }
    if ($result->num_rows > 0) {
        echo "<table border = " . "1px" . ">";
        while($row = $result->fetch_assoc()) { // envelop the data returned from the DB in HTML tags (associative array ~ dict)
            echo "<tr>";
            echo "<td>" . $row["producator"] . "</td>";
            echo "<td>" . $row["procesor"] . "</td>";
            echo "<td>" . $row["memorie"] . "</td>";
            echo "<td>" . $row["capacitateHDD"] . "</td>";
            echo "<td>" . $row["placa_video"] . "</td>";
            echo "</tr>";
         }
         echo "</table>";
    }
    else  {
        echo "0"; // nothing matches the query criteria
    }
?>