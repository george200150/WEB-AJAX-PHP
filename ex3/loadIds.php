<?php
$mysql_u = 'root';
$mysql_p = '';
$server_name = 'localhost';
$mysql_t = 'pwajax';

$conn = new mysqli($server_name,$mysql_u,$mysql_p,$mysql_t);
if ($conn->connect_error) {
    echo("Connection failed: " . $conn->connect_error);
}

function getIds($conn){
    $sqlCommand = "SELECT id FROM people"; // query DB
    $result = mysqli_query($conn,$sqlCommand);
    while($row = mysqli_fetch_array($result)) {
        echo "<option>" . $row['id'] . "</option>"; // format the result of the query (options of a list)
    }
}

getIds($conn); // fill the list of id-s in the main window

mysqli_close($conn);
?>