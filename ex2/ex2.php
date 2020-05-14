<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>two</title>
</head>


<style>
table, th, td {border: 1px solid black;}

th, td {width: 150px;}

div {width: 750px;}

button {margin-left: 170px;}
</style>


<body>
<table id="table">
</table>

<div><br>
	<button id="previous" onclick="previous()">Previous</button>
	<button id="next" onclick="next()">Next</button>
</div>
</body>

<?php
#DB connection parameters
$mysql_u = 'root'; # user
$mysql_p = ''; # password
$server_name = 'localhost'; # server
$mysql_t = 'pwajax'; # database

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
var globalIndex = 1; // the index that will be passed via request to the server, so that the paginator knows what records to return
var size; // number of records retreived from the DB.

dataBaseSize(); // setup the size
showNames(globalIndex); // setup the page content on startup

function previous() {
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function () {
		if (this.readyState === 4 && this.status === 200) {
			// readyState: 4: request finished and response is ready AND status: 200: "OK" 
			document.getElementById("table").innerHTML = this.responseText; // set the content in the HTML page
			setGlobalIndex(); // update the current index
			checkAvailability(); // update the state of the buttons (avoid indexes out of bounds)
		}
	};
	if (globalIndex % 3 == 0) // treat different parity cases, to avoid inconsistent prev/next functionality (index out of bounds)
		xmlhttp.open("GET", "getPrevious.php?index=" + (globalIndex - 2), true); // default case
	else if (globalIndex % 3 == 1)
		xmlhttp.open("GET", "getPrevious.php?index=" + (globalIndex - 0), true); // only one record on the last page
	else if (globalIndex % 3 == 2)
		xmlhttp.open("GET", "getPrevious.php?index=" + (globalIndex - 1), true); // only two records on the last page
	xmlhttp.send();
}

function showNames(index) {
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function () {
		if (this.readyState === 4 && this.status === 200) {
			// readyState: 4: request finished and response is ready AND status: 200: "OK" 
			document.getElementById("table").innerHTML = this.responseText;
			setGlobalIndex(); // update the current index
			checkAvailability(); // update the state of the buttons (avoid indexes out of bounds)
		}
	};
	xmlhttp.open("GET", "get3People.php?index=" + index, true); // request 3 users
	xmlhttp.send();
}

function next() {
	showNames(globalIndex + 1); // increment the index, to start from the next page of records
}

function setGlobalIndex() {
	var allTablerows = document.getElementsByTagName("table")[0].rows; // get all the rows, in order to extract the max index
	globalIndex = parseInt(allTablerows[allTablerows.length - 1].getAttribute('id'));
	// this attribute was programatically assigned to each row of the table when getting the paginated records from the DB.
}

function dataBaseSize() {
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function () { // setup the global variable that saves the number of records
		if (this.readyState === 4 && this.status === 200) {
			size = parseInt(this.responseText); // assign the value of the result to the variable
		}
	};
	xmlhttp.open("GET", "size.php?", true); // request the number of records
	xmlhttp.send();
}

function checkAvailability() { // disable any button in order to prevent errors
	document.getElementById("previous").disabled = globalIndex <= 3; // -> negative index
	document.getElementById("next").disabled = globalIndex === size; // -> positive overflow
}
</script>
</html>