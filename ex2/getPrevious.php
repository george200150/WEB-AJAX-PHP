<?php
$mysql_u = 'root';
$mysql_p = '';
$server_name = 'localhost';
$mysql_t = 'pwajax';
    
$conn = new mysqli($server_name,$mysql_u,$mysql_p,$mysql_t);
if ($conn->connect_error) {
	echo("Connection failed: " . $conn->connect_error);
}

function get3People($conn)
{
	$sqlCommand = "SELECT * FROM people;";
	$result = mysqli_query($conn, $sqlCommand);
	$index = 1;
	$global_index = $_GET['index'];
	
	
	echo "<tr><th>Nume</th><th>Prenume</th><th>Telefon</th><th>E-mail</th></tr>";
	while ($row = mysqli_fetch_array($result)) {
		if ($global_index == $index) {
			break;
		}
		if ($index >= $global_index - 3) { # display the content of the table (-3 because we consider previous 3 or less records)
			echo "<tr id=" . $index . ">" . "<td>" . $row['nume'] . "</td>";
			echo "<td>" . $row['prenume'] . "</td>";
			echo "<td>" . $row['telefon'] . "</td>";
			echo "<td>" . $row['email'] . "</td>" . "</tr>";
		}
		$index++; # next record now
	}
}

get3People($conn); # execute callback received from main page (via AJAX)

mysqli_close($conn);
?>
