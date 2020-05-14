<?php
$mysql_u = 'root';
$mysql_p = '';
$server_name = 'localhost';
$mysql_t = 'pwajax';

$conn = new mysqli($server_name,$mysql_u,$mysql_p,$mysql_t);
if ($conn->connect_error) {
    echo("Connection failed: " . $conn->connect_error);
}

$sqlCommand = "SELECT COUNT(*) AS c FROM people"; # query the DB in order to get the number of people as 'c'
$result = mysqli_query($conn, $sqlCommand); # returns a mysqli_result object or False

$size = mysqli_fetch_array($result);
echo $size['c']; # return the number of people

#$size = mysql_num_rows($result); # used with select without count(*)
#echo $size;