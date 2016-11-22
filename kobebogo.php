<?php

	if(!isset($count))
		$count = 0;

	$arrayOfInputs = array();
	if(isset($_POST['submitbtn']))
	{
		$arrayOfInputs[$count] = $_POST['subject'];
		$count++;
	}
	foreach($arrayOfInputs as $element)
	{
		echo $elements;
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>kobe</title>
</head>
<body>

<form action = "kobebogo.php" method ="post">
<input type = "text" name ="subject" required>
<input type ="submit" name = "submitbtn">
</form>
</body>
</html>