<?php 

	include_once 'dbconfig.php';
	session_start();

	$choice = mysql_real_escape_string($_GET['choice']);

	$query = "SELECT * FROM facultymember as F
	INNER JOIN person as P
	on F.personID = P.personID
	WHERE F.STATUS = '1' AND F.DeptID = '".$choice."';";
	$statement = $db->prepare($query);
	$statement->execute();

	$facultyResult = $statement->fetchAll(PDO::FETCH_ASSOC);

	if(count($facultyResult) > 0)
	{
		foreach($facultyResult as $faculty)
		{
			echo "<option value=".$faculty['userID'].">".$faculty['TitleofCourtesy'].$faculty['firstName']." ".$faculty['middleInitial']." ".$faculty['lastName']."</option>";
		}
	}
	else
	{
		echo "<option value = 0>No Available Faculty</option>";
	}



?>