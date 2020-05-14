<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>one</title>
</head>

<style>
#main {display: flex;}

ol {width: 200px;}

h3 {width: 200px;}

.error{
	font-family: Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", "serif";
	font-weight: bold;
	font-size: 20px;
	color: red;
}
</style>

<body>
<h1 id="selectedCity">Oras selectat:</h1>
<div id="main">
    <div id="From">
        <h3>Statii de plecare:</h3>
        <ol id="Departures">
        </ol>
    </div>
    <div id="To">
        <h3>Statii de sosire:</h3>
        <ol id="Arrivals">
        </ol>
    </div>
</div>
</body>

<?php
#DB connection parameters
$mysql_u = 'root'; # user
$mysql_p = ''; # password
$server_name = 'localhost'; # server
$mysql_t = 'pwajax	'; # database

$conn=@mysqli_connect($server_name, $mysql_u, $mysql_p); # '@' tells PHP to suppress error messages
@mysqli_set_charset($conn, "utf8");
if(!$conn)
{
	echo("<span class='error'>Nu s-a putut realiza conexiunea la baza de date: " . @mysqli_error($conn) . "</span>");
	exit(); # exit programme, in order to stop JS code from executing on a null connection to the DB
}
else
{
$test_select_db=mysqli_select_db($conn,$mysql_t); # test connection to the DB
	if(!$test_select_db)
	{
		echo("<span class='error'>Nu s-a putut selecta baza de date: " . @mysqli_error($conn) . "</span>");
		exit();
	}
}
?>


<script>
function showDepartures() {
	if (window.XMLHttpRequest) { // test compatibility
		xmlhttp = new XMLHttpRequest(); // code for modern browsers, that can support the XMLHttpRequest object
	} else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); // code for old IE browsers
	}
	xmlhttp.onreadystatechange = function () {
		if (this.readyState === 4 && this.status === 200) {
			// readyState: 4: request finished and response is ready AND status: 200: "OK" 
			document.getElementById("Departures").innerHTML = this.responseText; // set the content in the HTML page
		}
	};
	xmlhttp.open("GET", "departures.php?", true);
	xmlhttp.send();
}


showDepartures(); // show departing cities on document ready


function showArrivals(departCity) { // show arrivals on click (this function is assigned to on-click listeners' delegate)
	document.getElementById("selectedCity").innerHTML = "Oras selectat: " + departCity;
	if (departCity === "") {
		document.getElementById("Arrivals").innerHTML = "";
		return;
	}
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function () {
		if (this.readyState === 4 && this.status === 200) {
			document.getElementById("Arrivals").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", "arrivals.php?q=" + departCity, true); // request the server a value for the query parameter
	xmlhttp.send();
}
	
//showArrivals();
</script>


</html>