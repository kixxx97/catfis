<?php
	
	session_start();
	session_destroy();
	$page = $_GET['page'];
	header("Location: ".$page."");
?>