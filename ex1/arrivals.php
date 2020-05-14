<?php
$mysql_u = 'root';
$mysql_p = '';
$server_name = 'localhost';
$mysql_t = 'pwajax';

$conn = new mysqli($server_name,$mysql_u,$mysql_p,$mysql_t);
if ($conn->connect_error) { # test connection
	echo("Connection failed: " . $conn->connect_error);
}

function getArrivals($conn,$departureCity){ # get all the end points for a certain departure point
    $sqlCommand = "SELECT DISTINCT arrival FROM circulation WHERE departure = '" . $departureCity . "';";
    $result = mysqli_query($conn,$sqlCommand);
    while($row = mysqli_fetch_array($result)) { # for each departure point, we will display it inside a HTML list item
        echo("<li class ="."arrivals".">" . $row['arrival'] . "</li>"); # no additional listener needed, this is an end point.
    }
}

getArrivals($conn,$_GET['q']); # execute callback received from main page (via AJAX) (responde to this specific query parameter)

mysqli_close($conn); # close connection
?>