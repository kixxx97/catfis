<?php 

	include_once 'dbconfig.php';
	session_start();
	$choice = mysql_real_escape_string($_GET['choice']);

	$query = "SELECT * FROM department where STATUS = '1'";
    $statement = $db->prepare($query);
    $statement->execute();
    $departmentList = $statement->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_SESSION['groupid']) && ($_SESSION['groupid'] == "3" || $_SESSION['groupid'] == "2"))
	{
    $PID = $_SESSION['personid'];
    $query = "SELECT * FROM coursestaught CT where PersonId = ".$PID;
    $statement = $db->prepare($query);
    $statement->execute();
    $courseTaughtList = $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	if($choice == "0")
	{
		$query = "SELECT * FROM courses where status = '1' ";
		$statement = $db->prepare($query);
		$statement->execute();

		$coursesResult = $statement->fetchAll(PDO::FETCH_ASSOC);
		if(count($coursesResult) > 0)
		{
			foreach($coursesResult as $course)
			{
				echo"<tr>
				<td>".$course['CourseName']."</td>
				<td>".$course['CatalogNumber']."</td>
				<td>".$course['courseLevel']."</td>
				<td>".$course['CourseCredits']."</td>
				<td>".$course['CourseSubject']."</td>";
				if(isset($_SESSION['groupid']) && $_SESSION['groupid'] == "1")
				{
					echo'<td>
					<div class="col-md-3">';
					echo '<a href = "javascript:delete_id('.$course['CourseID'].')"><input type = "submit" value = "Delete" class = "btn btn-primary"   name = "dltbutton"></a>
					</div>
					<div class = "col-md-3">';
					echo '<input type = "button" id = "showCourseDialog" value = "EDIT" class="btn btn-primary" data-toggle="modal" data-target="#editCourse'.$course['CourseID'].'-modal">
						<div class="modal fade" id="editCourse'.$course['CourseID'].'-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="loginmodal-container">
								<h1>'.$course['CourseName'].'</h1><br>
								<form action = "courses.php" method = "post">
								<input type="hidden" name="CID" value="'.$course['CourseID'].'">
								CatalogNumber</br><input type = "text" value = '.$course['CatalogNumber'].' name = "catnumber" required><br>
								Course Name</br><input type = "text" value = '.$course['CourseName'].' name = "cname" required><br>
								Course Level</br><input type = "text" value = '.$course['courseLevel'].' name = "clevel" required><br> 
								Course Credits</br><input type = "text" value = '.$course['CourseCredits'].' name = "ccredits" required><br>
								Course Subject</br><input type = "text" value = '.$course['CourseSubject'].' name = "csubj" required><br>  
								<select name= "dept" required="">
								<option value = "0" hidden  selected="">Select Department</option>';

								echo $course['DeptID'];
					foreach($departmentList as $option)
					{
						echo $option['DeptID'];
						if($option['DeptID'] == $course['DeptID'])  
						echo "<option value = ".$option['DeptID']." selected ="." >".$option['DeptName']."</option>";
						else 
						echo "<option value = ".$option['DeptID'].">".$option['DeptName']."</option>";
					}
					echo '
					</select><br>     
					<input type ="submit" name = "updateCourse" value = "Update Course" class="login loginmodal-submit">
								</form>';
							echo'</div>
							</div>
						</div>
					</div>
					</td>';
				}
			if(isset($_SESSION['groupid']) && ($_SESSION['groupid'] == "3" || $_SESSION['groupid'] == "2"))
				echo "<td></td>";
		echo "/tr>";		
		
			}
		}
	}
		else
		{

		$query = "SELECT * FROM courses where status = '1' and  DeptID = '".$choice."';";
		$statement = $db->prepare($query);
		$statement->execute();

		$coursesResult = $statement->fetchAll(PDO::FETCH_ASSOC);
		if(count($coursesResult) > 0)
		{
			foreach($coursesResult as $course)
			{
				$query = 'SELECT DeptID from Courses where CourseID = '.$course['CourseID'];
			    $statement = $db->prepare($query);
			    $statement->execute();
			    $cList = $statement->fetch(PDO::FETCH_ASSOC);
			    $dept = $cList['DeptID'];

				$query = 'SELECT * FROM Courses c inner join coursestaught ct on c.courseid = CT.courseid inner join Person P on CT.personid = P.personid WHERE C.courseid ='.$course['CourseID'];
			    $statement = $db->prepare($query);
			    $statement->execute();
			    $cdList = $statement->fetchAll(PDO::FETCH_ASSOC);

			    if(count($cdList) > 0)
			    {
			    $query = 'SELECT * FROM Person P 
			    inner join facultymember FM 
			    on p.personid = fm.personid 
			    where P.personid not in (';
			    $i = 0;
			    foreach($cdList as $cl)
			    {
					if($i == (count($cdList) - 1))
					$query = $query.$cl['PersonID'];
					else
					$query = $query.$cl['PersonID'].",";
					$i++;
				}
			    $query = $query.') and deptid = '.$dept;
				}
				else
					$query = 'SELECT * FROM facultymember fm inner join person p on fm.personid = p.personid where deptid = '.$dept;
			    $statement = $db->prepare($query);
			    $statement->execute();
			    $cList = $statement->fetchAll(PDO::FETCH_ASSOC);

				echo"<tr>
				<td>".$course['CourseName']."</td>
				<td>".$course['CatalogNumber']."</td>
				<td>".$course['courseLevel']."</td>
				<td>".$course['CourseCredits']."</td>
				<td>".$course['CourseSubject']."</td>";
				if(isset($_SESSION['groupid']) && $_SESSION['groupid'] == "1")
				{
					echo'<td>
					<div class="col-md-3">';
					echo '<a href = "javascript:delete_id('.$course['CourseID'].')"><input type = "submit" value = "Delete" class = "btn btn-primary"   name = "dltbutton"></a>
					</div>
					<div class = "col-md-3">';
					echo '<input type = "button" id = "showCourseDialog" value = "EDIT" class="btn btn-primary" data-toggle="modal" data-target="#editCourse'.$course['CourseID'].'-modal">
						<div class="modal fade" id="editCourse'.$course['CourseID'].'-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="loginmodal-container">
								<h1>'.$course['CourseName'].'</h1><br>
								<form action = "courses.php" method = "post">
								<input type="hidden" name="CID" value="'.$course['CourseID'].'">
								CatalogNumber</br><input type = "text" value = '.$course['CatalogNumber'].' name = "catnumber" required><br>
								Course Name</br><input type = "text" value = '.$course['CourseName'].' name = "cname" required><br>
								Course Level</br><input type = "text" value = '.$course['courseLevel'].' name = "clevel" required><br> 
								Course Credits</br><input type = "text" value = '.$course['CourseCredits'].' name = "ccredits" required><br>
								Course Subject</br><input type = "text" value = '.$course['CourseSubject'].' name = "csubj" required><br>  
								<select name= "dept" required="">
								<option value = "0" hidden  selected="">Select Department</option>';
					foreach($departmentList as $option)
					{
						echo $option['DeptID'];
						if($option['DeptID'] == $course['DeptID'])  
						echo "<option value = ".$option['DeptID']." selected ="." >".$option['DeptName']."</option>";
						else 
						echo "<option value = ".$option['DeptID'].">".$option['DeptName']."</option>";
					}
					echo '
					</select><br>     
					<input type ="submit" name = "updateCourse" value = "Update Course" class="login loginmodal-submit">
								</form>
								</div>
							</div>
						</div>
					</div>';

					echo'<div class = "col-md-3">';
					echo '<input type = "button" id = "showCourseDialog" value = "ASSIGN" class="btn btn-primary" data-toggle="modal" data-target="#assignCourse'.$course['CourseID'].'-modal">
						<div class="modal fade" id="assignCourse'.$course['CourseID'].'-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="loginmodal-container">
								<h1>Assign faculty to <br>'.$course['CourseName'].'</h1><br>
								<form action = "courses.php" method = "post">
								<input type="hidden" name="CID" value="'.$course['CourseID'].'"> 
								<select name= "PID" required="">
								<option value = "0" hidden  selected="">Select faculty</option>';
					foreach($cList as $option)
					{
						echo "<option value = ".$option['PersonId'].">".$option['firstName'].$option['middleInitial'].$option['lastName']."</option>";
					}
					echo '
					</select><br>     
					<input type ="submit" name = "assignTeacher" value = "Assign Teacher" class="login loginmodal-submit">
								</form>';
							echo'</div>
							</div>
						</div>
					</div>';

					echo'<div class = "col-md-3">';
					echo '<input type = "button" id = "showCourseDialog" value = "UNASSIGN" class="btn btn-primary" data-toggle="modal" data-target="#unAssignCourse'.$course['CourseID'].'-modal">
						<div class="modal fade" id="unAssignCourse'.$course['CourseID'].'-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="loginmodal-container">
								<h1>Unassign faculty to <br>'.$course['CourseName'].'</h1><br>
								<form action = "courses.php" method = "post">
								<input type="hidden" name="CID" value="'.$course['CourseID'].'"> 
								<select name= "PID" required="">
								<option value = 0 hidden  selected="">Select faculty</option>';

					foreach($cdList as $option)
					{
						echo "<option value = ".$option['PersonId'].">".$option['firstName'].$option['middleInitial'].$option['lastName']."</option>";
					}
					echo '
					</select><br>     
					<input type ="submit" name = "un
					" value = "Unassign Teacher" class="login loginmodal-submit">
								</form>';
							echo'</div>
							</div>
						</div>
					</div>
					</td>';						
				}
				if(isset($_SESSION['groupid']) && ($_SESSION['groupid'] == "3" || $_SESSION['groupid'] == "2"))
				{
					echo '<td>';
					$ctr = true;
					$dept = false;
					foreach($courseTaughtList as $list)
					{
						if($list['CourseID'] == $course['CourseID'])
						{
							echo '<a href = "javascript:unteach_id('.$course['CourseID'].')"><input type = "submit" value = "Unteach" class = "btn btn-primary"   name = "dltbutton"></a>';
							$ctr = false;
						}
					}
					if($ctr && ($_SESSION['deptid'] == $course['DeptID']))
					echo '<a href = "javascript:teach_id('.$course['CourseID'].')"><input type = "submit" value = "Teach" class = "btn btn-primary"   name = "dltbutton"></a>';
				}
				echo '</tr>';
			}
		}
	}
?>