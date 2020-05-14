<?php
$mysql_u = 'root';
$mysql_p = '';
$server_name = 'localhost';
$mysql_t = 'pwajax';

$conn = new mysqli($server_name,$mysql_u,$mysql_p,$mysql_t);
if ($conn->connect_error) { # test connection
	echo("Connection failed: " . $conn->connect_error);
}

function getDepartures($conn){
    $sqlCommand = "SELECT DISTINCT departure FROM circulation"; # query DB to get all the departure points
    $result = mysqli_query($conn,$sqlCommand);
    if (!$result) { # bad result
        printf("Error: %s\n", mysqli_error($conn));
        exit();
    }
    while($row = mysqli_fetch_array($result)) { # for each departure point, we will display it inside a HTML list item
        echo "<li class ="."depart"." onclick="."showArrivals(this.innerText)>" . $row['departure'] . "</li>"; # set listener to the html elements (each departure point) that are displayed
    }
}

getDepartures($conn); # execute callback received from main page (on start)

mysqli_close($conn); # close connection
?>