<?php
include('functions.php');

function showDoctors(){
	// variable achieved as a result of mysqli_connection()
	global $connection;

	$query = "select * from Doctors";
	$result = mysqli_query($connection, $query);
	// if the query fails this function is interrupted
	if(!$result) return;

  // generating of a form, headers of table and a button, which adds a new record
	$headers = array("Name", "Surname", "specialty", "employmentDate");
	print("<form method='POST'>");
	print("<b>Doctors</b><br>");
	print("<table border = 1><tr>");
	foreach($headers as $header) print("<td><b>$header</b></td>");

  // an attribute name=button[] means that if 'New' button will be pressed
  // in $_POST['button'][0] will be 'New'
	print("<td align='center'><b><input type='submit' name='button[]' value='New'></b></td>");
	print("</tr>");

  // generating remaining rows of table of doctors
  // and buttons for operations on each of them ($_POST['button'][doctorID] will be 'Edit' or 'Remove')
	while($record = mysqli_fetch_row($result)){
			print("<tr>");
			foreach($record as $f=>$field)
				if($f != 0) print("<td>" . $field . "</td>");
		  // click on the button sets a relevant operation to do
		  // for selected doctor (by id)
			print("<td align='center'><input type='submit' name='button[".$record[0]."]' value='Edit'>
									  <input type='submit' name='button[".$record[0]."]' value='Remove'></td>");
			print("</tr>");
	}
	print("</table>");
    print("</form>");
	mysqli_free_result($result);
}

function removeDoctor($id) {
	global $connection;

	$query = "delete from doctors where id=$id;";
	mysqli_query($connection, $query) or exit("Query $query failed");
}

function editDoctor($id) {
	global $connection;

  // id == -1 means adding a new doctor
  // otherwise id points out the selected doctor
	if($id != -1) {
		$query = "select name, surname, specialty, employmentDate from doctors where id=$id;";
		$record = mysqli_query($connection, $query) or exit("Query $query failed");

        $doctor = mysqli_fetch_row($record);
        $name = $doctor[0];
        $surname = $doctor[1];
		$specialty = $doctor[2];
		$employmentDate = $doctor[3];

		//$name = mysqli_result($record, 0, "name");
		//$surname = mysqli_result($record, 0, "surname");
	}
	else {
		$name=''; $surname=''; $specialty=''; $employmentDate='';
	}

  // generating a form for edit of doctor's data
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
	<td>Specialty</td><td colspan=2>
	<input type=text name='specialty' value='$specialty' size=15 style='text-align: left'></td>
	</tr>
	<tr>
	<td>EmploymentDate</td><td colspan=2>
	<input type=text name='employmentDate' value='$employmentDate' size=15 style='text-align: left'></td>
	</tr>
	<tr>
	<td colspan=3>
	<input type='hidden' name='id' value='$id'>
	<input type=submit name='button[]' value='Save' style='width:200'></td>
	</tr>
	</table></form>";
}

function saveDoctor($id) {
	global $connection;
	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$specialty = $_POST['specialty'];
	$employmentDate = $_POST['employmentDate'];
	if($id != -1)
		$query = "update doctors set name='$name', surname='$surname', specialty='$specialty', employmentDate='$employmentDate' where id=$id;";
	else $query = "insert into doctors values(null, '$name', '$surname', '$specialty', '$employmentDate');";
	mysqli_query($connection, $query) or exit("Query $query failed");
}

?>

<html>
<head>
<meta charset="windows-1250">
<title>Doctors management</title>
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
	case 'Remove': removeDoctor($id); break;
	case 'Edit': editDoctor($id); break;
	case 'New': editDoctor(-1); break;
	case 'Save': saveDoctor($_POST['id']); break;
}

showDoctors();
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
