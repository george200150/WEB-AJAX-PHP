<?php
    $mysql_u = 'root';
    $mysql_p = '';
    $server_name = 'localhost';
    $mysql_t = 'pwajax';

    $conn = new mysqli($server_name,$mysql_u,$mysql_p,$mysql_t);
    if ($conn->connect_error) {
        echo("Connection failed: " . $conn->connect_error);
    }

    $sqlCommand = "UPDATE people SET nume='" . $_POST['name'] . "', prenume = '" . $_POST['surname'] . "', telefon = '" . $_POST['telephone'] . "', email = '" . $_POST['email'] . "' WHERE id =" . $_POST['id'] . "";
	# send sensitive data through POST method, which is safer an more capable of large data transport
    if($conn->query($sqlCommand) == TRUE)
      echo "Efectuat";
    else
      echo "Eroare";
?>