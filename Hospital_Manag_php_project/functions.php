<?php

function openConnection(){
	global $connection;
	$server = "127.0.0.1";
	$user = "root";
	$password = "";
	$dbaseName = "hospital";

	$connection = mysqli_connect($server, $user, $password) or exit("Server connection failed");	
	mysqli_select_db($connection, $dbaseName) or exit("Database $dbaseName selection failed");
	mysqli_set_charset($connection, "utf-8");
}

function closeConnection(){
	global $connection;
	mysqli_close($connection);
}

function createDatabase() {
	$connection = mysqli_connect("127.0.0.1", "root", "") or exit("Server connection failed");
	$dbaseName = 'hospital';
	
	echo "<h3>Hospitals Management</h3> <br>";
	mysqli_query($connection, "CREATE DATABASE `$dbaseName` DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;") 
	or exit("Creating database failed");
}

function createTables() {
	global $connection;

	$query = 	"create table doctors " .
				"(id int NOT NULL AUTO_INCREMENT ," .
				"name varchar(32), " .
				"surname varchar(32), " .
                "specialty varchar(32), " .				
				"employmentDate DATE, PRIMARY KEY (`id`))";
	mysqli_query($connection, $query) or exit("Query $query failed");
	
	$query = 	"create table patients " .
				"(id int NOT NULL AUTO_INCREMENT ," .
				"name varchar(32), " .	
				"surname varchar(32), " .
                "gender varchar(6), " .
                "DateOfBirth DATE, 
				PRIMARY KEY (`id`))";
	mysqli_query($connection, $query) or exit("Query $query failed");
	
	$query = 	"create table visits " .
				"(id int NOT NULL AUTO_INCREMENT ," .
                "name varchar(32), " .	
				"surname varchar(32), " .				
				"startDate DATETIME, " .	
				"endDate DATETIME, " .
				"diagnosis varchar(50)," .
				"doctorInCharge varchar(32), PRIMARY KEY (`id`))";
				")";
	mysqli_query($connection, $query) or exit("Query $query failed");
	//echo $query;
}

function InsertTestData() {
	global $connection;
	$queries = array("insert into doctors values(null, 'John', 'Smith', 'Dentist', '2018-11-10');",
					 "insert into doctors values(null, 'Valentine', 'Onah', 'Physicians', '2018-11-10');",
				     "insert into doctors values(null, 'Luise', 'Luke', 'Neurologists', '2018-11-10');");	
	foreach($queries as $query)
		mysqli_query($connection, $query) or exit("Query $query failed");
	
	$queries = array("insert into patients values(null, 'Jan', 'Paul', 'male', '1992-03-11');",
					 "insert into patients values(null, 'Angela', 'Lukas', 'female', '1990-12-07');",
					 "insert into patients values(null, 'Adam', 'Smith', 'male', '1997-09-18');");
	foreach($queries as $query)				 
		mysqli_query($connection, $query) or exit("Query $query failed");
	
	$queries = array("insert into visits values(null, 'Jan', 'Paul', '2018-04-06 15:30:00', '2018-11-10 13:50:10', 'canser', 'Dr. John Smith');",
				     "insert into visits values(null, 'Angela', 'Lukas', '2017-01-11 16:30:00', '2017-05-18 19:10:00', 'headech', 'Dr. Valentine Onah');",
					 "insert into visits values(null, 'Adam', 'Smith', '2016-08-26 19:30:00', '2016-02-27 11:33:50', 'fever', 'Dr. Luise Luke');");			   
	foreach($queries as $query)				 
		mysqli_query($connection, $query) or exit("Query $query failed");
}

?>