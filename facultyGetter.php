<?php 

	include_once 'dbconfig.php';
	session_start();

	$choice = mysql_real_escape_string($_GET['choice']);

	$query = "SELECT * FROM person as P
	INNER JOIN facultymember as F
	on F.personID = P.personID
	INNER JOIN department as D 
	ON F.deptid = D.deptid
	WHERE F.DeptID = '".$choice."';";
	$statement = $db->prepare($query);
	$statement->execute();

	$facultyResult = $statement->fetchAll(PDO::FETCH_ASSOC);
	$counter = $counter = 1;


    $query = "SELECT * FROM department";
    $statement = $db->prepare($query);
    $statement->execute();
    $departmentList = $statement->fetchAll(PDO::FETCH_ASSOC);

	if($choice == "0")
	{

		echo "<meta http-equiv='refresh' content='0'>";
	}
	else
	{
		if(count($facultyResult) > 0)
		{
			foreach($facultyResult as $inforesult)
			{

                                          echo"<tr>";
                                          if(isset($_SESSION['groupid']))
                                          {
                                          echo '<td><input type = "button" id = "showCourseDialog" value = "VIEW" class="btn btn-primary" data-toggle="modal" data-target="#info-modal'.$inforesult['FacultyId'].'-modal"></td>
                                          <div class="modal fade" id="info-modal'.$inforesult['FacultyId'].'-modal"   tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">';?>
                            <div class="modal-dialog">
                                <div class="infomodal-container">
                                    <h1>Basic Information</h1><br>  
                                        <form id = "UI-form" action = "updateinfo.php" method = "post">
                                          First Name</br><input type = "text" name = "lname" value = "<?php echo $inforesult['firstName'];?>" readonly required>
                                          M.I<input type = "text" name = "mi" value = "<?php echo $inforesult['middleInitial'];?>" readonly required>
                                          Last Name<input type = "text" name = "fname" value = "<?php echo $inforesult['lastName'];?>" readonly required></br>
                                          Title</br><input type = "text" name = "title" value = "<?php echo $inforesult['TitleofCourtesy'];?>" readonly required></br>
                                        </form>
                                        <?php 
                                         //if($_SESSION['groupid'] != 4) 
                                         //{
                                         echo "<br><h1>Faculty Information</h1>";
                                         echo "<form action = 'updateinfo.php' method = 'post' ";
                                        ?>
                                          SSN <input type = "text" name = "ssn" value = "<?php echo $inforesult['SSN'];?>" readonly required></br>
                                          HomeStreetAddress <input type = "text" name = "homestreetadd" value = "<?php echo $inforesult['HomeStreetAddress'];?>" readonly required>
                                          </br>
                                          HomeCity <input type = "text" name = "homecity" value = "<?php echo $inforesult['HomeCity'];?>" readonly required></br>
                                          HomeZip <input type = "text" name = "homezip" value = "<?php echo $inforesult['HomeZip'];?>" readonly required></br>
                                          HomePhone <input type = "text" name = "homephone" value = "<?php echo $inforesult['HomePhone'];?>" readonly required></br>
                                          DayTimePhone <input type = "text" name = "daytime" value = "<?php echo $inforesult['DayTimePhone'];?>" readonly required> </br>
                                          AdjunctHireDate <input type = "date" name = "adjunct" value = "<?php echo $inforesult['AdjunctHireDate'];?>" readonly required></br>
                                          FullTimeHireDat <input type = "date" name = "fulltime" value = "<?php echo $inforesult['FullTimeHireDate'];?>" readonly required></br>
                                          RetireDate <input type = "date" name = "retire" value = "<?php echo $inforesult['RetireDate'];?>" readonly required></br>
                                          emailAddress <input type = "text" name = "email" value = "<?php echo $inforesult['emailAddress'];?>" readonly required> </br>
                                          DOB <input type = "date" name = "dob" value = "<?php echo $inforesult['DOB'];?>" required></br>
                                          Department  <select name= "dept" readonly required="">
                                                <option hidden disabled="">Select Department</option>
                                                <?php
                                                foreach($departmentList as $option)
                                                {
                                                  if($option['DeptID'] == $inforesult['DeptID'])  
                                                  echo "<option value = ".$option['DeptID']."selected ="." >".$option['DeptName']."</option>";
                                                  else 
                                              echo "<option value = ".$option['DeptID'].">".$option['DeptName']."</option>";
                                                }
                                                ?>

                                              </select><br>
                                        </form>
                                        <?php //} ?>
                                 </div>
                            </div>
                        </div><?php 
                  	}
                                          echo "<td>".$inforesult['firstName']." ".$inforesult['middleInitial']." ".$inforesult['lastName']."</td>
                                          <td>".$inforesult['DeptName']."</td></tr>";
                }
			}
		}

?>