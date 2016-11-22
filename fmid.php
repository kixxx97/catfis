<?php
	include_once('dbconfig.php');

	$uid = $_SESSION['id'];

	$query = "SELECT FacultyId,fm.PersonId,DeptID from FacultyMember FM  inner join Person P on FM.personid = P.personid where P.userid = ".$uid;
	$statement = $db->prepare($query);
	$statement->execute();
	$personresult = $statement->fetch(PDO::FETCH_ASSOC);

	$_SESSION['deptid'] = $personresult['DeptID'];
	$_SESSION['personid'] = $personresult['PersonId'];
	$_SESSION['facultyid'] = $personresult['FacultyId'];
?>