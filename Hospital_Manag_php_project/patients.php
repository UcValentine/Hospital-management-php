<?php
include('functions.php');

function showPatients(){
	// variable achieved as a result of mysqli_connection()
	global $connection;

	$query = "select * from Patients";
	$result = mysqli_query($connection, $query);
	// if the query fails this function is interrupted
	if(!$result) return;

	$headers = array("Name", "Surname", "gender", "dateOfBirth");
	print("<form method='POST'>");
	print("<b>Patients</b><br>");
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

function removePatient($id) {
	global $connection;

	$query = "delete from patients where id=$id;";
	mysqli_query($connection, $query) or exit("Query $query failed");
}


function editPatient($id) {
	global $connection;

	if($id != -1) {
		$query = "select name, surname, gender, dateOfBirth from patients where id=$id;";

		$record = mysqli_query($connection, $query) or exit("Query $query failed");

        $patient = mysqli_fetch_row($record);
        $name = $patient[0];
        $surname = $patient[1];
		$gender = $patient[2];
		$dateOfBirth = $patient[3];

	}
	else {
		$name=''; $surname=''; $gender=''; $dateOfBirth='';
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
	<td>Gender</td><td colspan=2>
	<input type=text name='gender' value='$gender' size=15 style='text-align: left'></td>
	</tr>
	<tr>
	<td>DateOfBirth</td><td colspan=2>
	<input type=text name='dateOfBirth' value='$dateOfBirth' size=15 style='text-align: left'></td>
	</tr>
	<tr>
	<td colspan=3>
	<input type='hidden' name='id' value='$id'>
	<input type=submit name='button[]' value='Save' style='width:200'></td>
	</tr>
	</table></form>";
}

function savePatient($id) {
	global $connection;
	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$gender = $_POST['gender'];
	$dateOfBirth = $_POST['dateOfBirth'];
	if($id != -1)
		$query = "update patients set name='$name', surname='$surname', gender='$gender', dateOfBirth='$dateOfBirth' where id=$id;";
	else $query = "insert into patients values(null, '$name', '$surname', '$gender', '$dateOfBirth');";
	mysqli_query($connection, $query) or exit("Query $query failed");
}

?>

<html>
<head>
<meta charset="windows-1250">
<title>Patients management</title>
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
	case 'Remove': removePatient($id); break;
	case 'Edit': editPatient($id); break;
	case 'New': editPatient(-1); break;
	case 'Save': savePatient($_POST['id']); break;
}

showPatients();
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
