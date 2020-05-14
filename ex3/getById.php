<?php
$mysql_u = 'root';
$mysql_p = '';
$server_name = 'localhost';
$mysql_t = 'pwajax';

$conn = new mysqli($server_name,$mysql_u,$mysql_p,$mysql_t);
if ($conn->connect_error) {
    echo("Connection failed: " . $conn->connect_error);
}

function getById($conn)
{
    $sqlCommand = "SELECT * FROM people WHERE id = " . $_GET['id']; # get the id via the GET request and use it to query the DB
    $result = mysqli_query($conn, $sqlCommand); # the result is only one person from the DB
    while ($row = mysqli_fetch_array($result)) {
        echo $row['nume'] . "," . $row['prenume'] . "," . $row['telefon'] . "," . $row['email'];
		# format the data retreived from the DB (.csv)
    }
}

getById($conn); # get the person from the DB (when on-click on their id from the list)

mysqli_close($conn);