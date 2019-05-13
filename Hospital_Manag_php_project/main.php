<?php
// script uses functions included in functions.php file
include('functions.php');
?>

<html>
<head>
<meta charset="windows-1250">
<title>Hospitals management</title>
</head>
<?php
// below sequence of functions should be invoked on first loading of our website
// structure of database is created and test data are inserted

createDatabase();
openConnection();
createTables();
insertTestData();
closeConnection();

?>

<body bgcolor=yellow text="#000FFF">
<input type=button value=" PATIENTS "
       onClick="window.location='patients.php'">
<br><br>
<form name=menu action='visits.php'>
<input type=submit value=" VISITS ">
<br><br>
</form>
<a href='doctors.php'> DOCTORS </a>

<hr>

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
