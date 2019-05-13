<?php
include('functions.php');

function showVisits(){
	global $connection;

	$query = "select * from Visits";
	$result = mysqli_query($connection, $query);
	// if the query fails this function is interrupted
	if(!$result) return;

	$headers = array("Name", "Surname", "startDate", "endDate", "diagnosis", "doctorInCharge");
	print("<form method='POST'>");
	print("<b>Visits</b><br>");
	print("<table border = 1><tr>");
	foreach($headers as $header) print("<td><b>$header</b></td>");

	print("<td align='center'><b><input type='submit' name='button[]' value='New'></b></td>");
	print("</tr>");

	while($record = mysqli_fetch_row($result)){
			print("<tr>");
			foreach($record as $f=>$field)
				if($f != 0) print("<td>" . $field . "</td>");

			print("<td align='center'><input type='submit' name='button[".$record[0]."]' value='Edit'>
									  <input type='submit' name='button[".$record[0]."]' value='Remove'></td>");
			print("</tr>");
	}
	print("</table>");
    print("</form>");
	mysqli_free_result($result);
}

function removeVisit($id) {
	global $connection;

	$query = "delete from visits where id=$id;";
	mysqli_query($connection, $query) or exit("Query $query failed");
}


function editVisit($id) {
	global $connection;

	if($id != -1) {
		$query = "select name, surname, startDate, endDate, diagnosis, doctorInCharge from visits where id=$id;";

		$record = mysqli_query($connection, $query) or exit("Query $query failed");

        $visit = mysqli_fetch_row($record);
        $name = $visit[0];
        $surname = $visit[1];
		$startDate = $visit[2];
		$endDate = $visit[3];
		$diagnosis = $visit[4];
		$doctorInCharge = $visit[5];

	}
	else {
		$name=''; $surname=''; $startDate=''; $endDate=''; $diagnosis=''; $doctorInCharge='';
	}

echo "
	<form method=POST action=''>
	<table border=0>
	<tr>
	<td>Name</td><td colspan=2>
	<input type=text name='name' value='$name' size=15 style='text-align: left'></td>
	</tr>
	<tr>
	<td>Surname</td><td colspan=2>
	<input type=text name='surname' value='$surname' size=15 style='text-align: left'></td>
	</tr>
	<tr>
	<td>StartDate</td><td colspan=2>
	<input type=text name='startDate' value='$startDate' size=15 style='text-align: left'></td>
	</tr>
	<tr>
	<td>EndDate</td><td colspan=2>
	<input type=text name='endDate' value='$endDate' size=15 style='text-align: left'></td>
	</tr>
	<tr>
	<td>Diagnosis</td><td colspan=2>
	<input type=text name='diagnosis' value='$diagnosis' size=15 style='text-align: left'></td>
	</tr>
	<tr>
	<td>DoctorInCharge</td><td colspan=2>
	<input type=text name='doctorInCharge' value='$doctorInCharge' size=15 style='text-align: left'></td>
	</tr>
	<tr>
	<td colspan=3>
	<input type='hidden' name='id' value='$id'>
	<input type=submit name='button[]' value='Save' style='width:200'></td>
	</tr>
	</table></form>";
}

function saveVisit($id) {
	global $connection;
	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate'];
	$diagnosis = $_POST['diagnosis'];
	$doctorInCharge = $_POST['doctorInCharge'];
	if($id != -1)
		$query = "update visits set name='$name', surname='$surname', startDate='$startDate', endDate='$endDate', diagnosis='$diagnosis', doctorInCharge='$doctorInCharge' where id=$id;";
	else $query = "insert into visits values(null, '$name', '$surname', '$startDate', '$endDate', '$diagnosis', '$doctorInCharge');";
	mysqli_query($connection, $query) or exit("Query $query failed");
}

?>

<html>
<head>
<meta charset="windows-1250">
<title>Visits management</title>
</head>
<body bgcolor=yellow text="#000FFF">
<header><h3>Hospitals Management</h3></header>
<input type=button value=" PATIENTS " onClick="window.location='patients.php'">
<br><br>
<form name=menu action='visits.php'>
<input type=submit value=" VISITS ">
<br><br>
</form>
<a href='doctors.php'> DOCTORS </a>

<hr>
<center>

<?php
$command = '';

if(isset($_POST['button'])) {
	$command = current($_POST['button']);
	$id = key($_POST['button']);
}


openConnection();

switch($command) {
	case 'Remove': removeVisit($id); break;
	case 'Edit': editVisit($id); break;
	case 'New': editVisit(-1); break;
	case 'Save': saveVisit($_POST['id']); break;
}

showVisits();
closeConnection();
?>

</center>

<footer>
  <div>
    <p>This Project was created by Valentine Onah
			<a href="https://www.linkedin.com/in/valentine-onah-479690136/">| linkedin |</a>
      <a href="https://github.com/UcValentine/"> Github |</a>
      <a href="https://www.special-talk.com/"> Blog |</a>
    </p>
</footer>
</body>
</html>
