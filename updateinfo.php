<?php
	include_once 'dbconfig.php';
	session_start();
	if(isset($_POST['basicupdate']))
	{
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$mi = $_POST['mi'];
		$title = $_POST['title'];
		$id = $_SESSION['id'];
		echo $id;
		$query = "SELECT * FROM Person where userid = $id";
		$statement= $db->prepare($query);
		$statement->execute();

		$rowCount = $statement->rowCount();
		if($rowCount == 0)
		{
		$insertsql = "INSERT INTO Person(titleofcourtesy,firstName,middleInitial,lastName,userId) values(?,?,?,?,?)";

		$statement = $db->prepare($insertsql);	

		$statement->bindParam(1,$title,PDO::PARAM_STR);      
    	$statement->bindParam(2,$fname,PDO::PARAM_STR);      
    	$statement->bindParam(3,$mi,PDO::PARAM_STR);  
    	$statement->bindParam(4,$lname,PDO::PARAM_STR);  
    	$statement->bindParam(5,$id,PDO::PARAM_STR);  

    	$statement->execute();
    	}
    	else
    	{
		$rowCount = $statement->rowCount();  
		$updatesql = "UPDATE Person SET titleOfCourtesy = ?,firstName = ?, middleInitial = ?, lastName = ? where userId = ?";
		$statement = $db->prepare($updatesql);
		
		$statement->bindParam(1,$title,PDO::PARAM_STR);      
    	$statement->bindParam(2,$fname,PDO::PARAM_STR);      
    	$statement->bindParam(3,$mi,PDO::PARAM_STR);  
    	$statement->bindParam(4,$lname,PDO::PARAM_STR); 
    	$statement->bindParam(5,$id,PDO::PARAM_STR);

    	$statement->execute(); 
   		}
   	}
	if(isset($_POST['facultyupdate']))
	{
		echo $ssn = $_POST['ssn'].' ';
		echo $homestreetadd = $_POST['homestreetadd'].' ';
		echo $homecity = $_POST['homecity'].' ';
		echo $homezip = $_POST['homezip'].' ';
		echo $homephone = $_POST['homephone'].' ';
		echo $daytime = $_POST['daytime'].' ';
		echo $adjuncthd = $_POST['adjunct'].' ';
		echo $fulltimehd = $_POST['fulltime'].' ';
		echo $retiredate = $_POST['retire'].' ';
		echo $emailaddress = $_POST['email'].' ';
		echo $dob = $_POST['dob'].' ';
		$dept = $_POST['dept'];
		$id = $_SESSION['id'].' ';
		echo $id.'a';
		
		$query = "SELECT * FROM Person P 
		INNER JOIN FacultyMember F 
		on P.PersonId = F.PersonId 
		where P.userid = $id";

		$statement= $db->prepare($query);
		$statement->execute();

		$rowCount = $statement->rowCount();

		if($rowCount == 0)
		{

		$query = "SELECT PersonId FROM Person 	where userid = $id";
		$statement= $db->prepare($query);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);
		$id = $result['PersonId'];
		echo $id.'b';

		$insertsql = "INSERT INTO Facultymember(personid,ssn,homestreetaddress,homecity,homezip,homephone,daytimephone,adjuncthiredate,fulltimehiredate,retiredate,emailaddress,dob,DeptID) 
		values(?,?,?,?,?,?,?,?,?,?,?,?,?);";
		$statement = $db->prepare($insertsql);	

		$statement->bindParam(1,$id,PDO::PARAM_INT);      
    	$statement->bindParam(2,$ssn,PDO::PARAM_STR);      
    	$statement->bindParam(3,$homestreetadd,PDO::PARAM_STR);  
    	$statement->bindParam(4,$homecity,PDO::PARAM_STR);  
    	$statement->bindParam(5,$homezip,PDO::PARAM_STR);  
		$statement->bindParam(6,$homephone,PDO::PARAM_STR);      
		$statement->bindParam(7,$daytime,PDO::PARAM_STR); 	
    	$statement->bindParam(8,$adjuncthd,PDO::PARAM_STR);      
    	$statement->bindParam(9,$fulltimehd,PDO::PARAM_STR);  
    	$statement->bindParam(10,$retiredate,PDO::PARAM_STR);  
    	$statement->bindParam(11,$emailaddress,PDO::PARAM_STR); 
    	$statement->bindParam(12,$dob,PDO::PARAM_STR); 
    	$statement->bindParam(13,$dept,PDO::PARAM_STR); 

    	$statement->execute();
    	}
    	else
    	{

		$result = $statement->fetch(PDO::FETCH_ASSOC);
		$id = $result['PersonId'];
		echo $id.'c';
		$updatesql = "UPDATE FacultyMember SET ssn = ?,homestreetaddress = ?,homecity = ?,homezip = ?,homephone = ?,daytimephone = ?, adjuncthiredate = ?,fulltimehiredate = ?,retiredate = ?,emailaddress = ?,dob  = ? , DeptID = ? where PersonId = ?";
		$statement = $db->prepare($updatesql);
      
    	$statement->bindParam(1,$ssn,PDO::PARAM_STR);      
    	$statement->bindParam(2,$homestreetadd,PDO::PARAM_STR);  
    	$statement->bindParam(3,$homecity,PDO::PARAM_STR);  
    	$statement->bindParam(4,$homezip,PDO::PARAM_STR);  
		$statement->bindParam(5,$homephone,PDO::PARAM_STR);  
		$statement->bindParam(6,$daytime,PDO::PARAM_STR); 	    
    	$statement->bindParam(7,$adjuncthd,PDO::PARAM_STR);      
    	$statement->bindParam(8,$fulltimehd,PDO::PARAM_STR);  
    	$statement->bindParam(9,$retiredate,PDO::PARAM_STR);  
    	$statement->bindParam(10,$emailaddress,PDO::PARAM_STR); 
    	$statement->bindParam(11,$dob,PDO::PARAM_STR); 
	   	$statement->bindParam(12,$dept,PDO::PARAM_STR);
		$statement->bindParam(13,$id,PDO::PARAM_STR);


    	$statement->execute();
   		}
   	}
?>