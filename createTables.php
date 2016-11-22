<?php  

include_once 'dbconfig.php';

$createTables = array();
$createTables[0] = "ALTER TABLE COURSES ADD STATUS ENUM('0','1') NOT NULL DEFAULT '1'";
$createTables[1] = "ALTER TABLE COURSESTAUGHT ADD STATUS ENUM('0','1') NOT NULL DEFAULT '1'";
$createTables[2] = "ALTER TABLE degrees ADD STATUS ENUM('0','1') NOT NULL DEFAULT '1'";
$createTables[3] = "ALTER TABLE department ADD STATUS ENUM('0','1') NOT NULL DEFAULT '1'";
$createTables[4] = "ALTER TABLE facultymember ADD STATUS ENUM('0','1') NOT NULL DEFAULT '1'";
$createTables[5] = "ALTER TABLE grantrecipients ADD STATUS ENUM('0','1') NOT NULL DEFAULT '1'";
$createTables[6] = "ALTER TABLE grants ADD STATUS ENUM('0','1') NOT NULL DEFAULT '1'";
$createTables[7] = "ALTER TABLE groups ADD STATUS ENUM('0','1') NOT NULL DEFAULT '1'";
$createTables[8] = "ALTER TABLE jobs ADD STATUS ENUM('0','1') NOT NULL DEFAULT '1'";
$createTables[9] = "ALTER TABLE person ADD STATUS ENUM('0','1') NOT NULL DEFAULT '1'";
$createTables[10] = "ALTER TABLE publication ADD STATUS ENUM('0','1') NOT NULL DEFAULT '1'";
$createTables[12] = "ALTER TABLE publicationtype ADD STATUS ENUM('0','1') NOT NULL DEFAULT '1'";
$createTables[13] = "ALTER TABLE relationauthor ADD STATUS ENUM('0','1') NOT NULL DEFAULT '1'";
$createTables[14] = "ALTER TABLE usergroups ADD STATUS ENUM('0','1') NOT NULL DEFAULT '1'";
$createTables[15] = "ALTER TABLE users ADD STATUS ENUM('0','1') NOT NULL DEFAULT '1'";
$createTables[16] = "ALTER TABLE workhistory ADD STATUS ENUM('0','1') NOT NULL DEFAULT '1'";


echo "hello world?";
foreach ($createTables as $value)
	{
		$sql_query = $value;
		$statement = $db->prepare($sql_query);

		$statement->execute();
	}
?>
