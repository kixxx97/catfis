<?php
    
    include_once('dbconfig.php');
    session_start();
    date_default_timezone_set('Asia/Manila');
    if(isset($_POST['login']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT userName,password,U.userid,groupid FROM users as U
        INNER JOIN usergroups as G
        on U.userid = G.userid       
        WHERE username='".$username."';";
        $statement = $db->prepare($query);
        $statement->execute();
        $rowCount = $statement->rowCount();
        if($rowCount > 0)
        {   
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if(password_verify($password,$result['password']))
            {  
            $_SESSION['username'] = $result['userName'];
            $_SESSION['id'] = $result['userid'];
            $_SESSION['groupid'] = $result['groupid'];
            include_once('fmid.php');
            $groupid = $result['groupid'];
            }
            else
            {
                echo "sayop pass";  
            }
        }
        else
        {
            echo "wala ni siya na user";
        }
    }

    $query = "SELECT * FROM department where STATUS = '1'";
    $statement = $db->prepare($query);
    $statement->execute();
    $departmentList = $statement->fetchAll(PDO::FETCH_ASSOC);

    $query = "SELECT * FROM courses C inner join department D on C.deptid = D.deptid where D.status = '1' and C.status = '1'";
    $statement = $db->prepare($query);
    $statement->execute();
    $coursesList = $statement->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_POST['addCourse']))
    {
    $catnumber = $_POST['catnumber'];
    $cname = $_POST['cname'];
    $clevel = $_POST['clevel'];
    $ccredits = $_POST['ccredits'];
    $csubj = $_POST['csubj'];
    $deptid = $_POST['dept'];

    $query = "INSERT INTO Courses(deptid,catalognumber,coursename,courselevel,coursecredits,coursesubject) VALUES(?,?,?,?,?,?)";

    $statement = $db->prepare($query);

    $statement->bindParam(1,$deptid,PDO::PARAM_STR);
    $statement->bindParam(2,$catnumber,PDO::PARAM_STR);
    $statement->bindParam(3,$cname,PDO::PARAM_STR);
    $statement->bindParam(4,$clevel,PDO::PARAM_STR);
    $statement->bindParam(5,$ccredits,PDO::PARAM_STR);
    $statement->bindParam(6,$csubj,PDO::PARAM_STR);

    $statement->execute();
    echo '<script language="javascript">';
    echo 'alert("Successfully inserted course '.$cname.'")';
    echo '</script>';
    echo "<meta http-equiv='refresh' content='0'>";
    }
  if(isset($_POST['updateCourse']))
  {
    $CID = $_POST['CID'];
    $catnumber = $_POST['catnumber'];
    $cname = $_POST['cname'];
    $clevel = $_POST['clevel'];
    $ccredits = $_POST['ccredits'];
    $csubj = $_POST['csubj'];
    $deptid = $_POST['dept'];

    $query = "UPDATE Courses SET deptid = ?, catalognumber = ?, coursename = ? , courselevel = ?, coursecredits = ?, coursesubject = ? WHERE CourseID  = ?  ";

    $statement = $db->prepare($query);

    $statement->bindParam(1,$deptid,PDO::PARAM_STR);
    $statement->bindParam(2,$catnumber,PDO::PARAM_STR);
    $statement->bindParam(3,$cname,PDO::PARAM_STR);
    $statement->bindParam(4,$clevel,PDO::PARAM_STR);
    $statement->bindParam(5,$ccredits,PDO::PARAM_STR);
    $statement->bindParam(6,$csubj,PDO::PARAM_STR);
    $statement->bindParam(7,$CID,PDO::PARAM_STR);
    $statement->execute();
    echo '<script language="javascript">';
    echo 'alert("Successfully updated course '.$cname.'")';
    echo '</script>';
    echo "<meta http-equiv='refresh' content='0'>";
  }
  if(isset($_GET['delete_id']))
  {
    $cid = $_GET['delete_id'];
    $query = "UPDATE Courses SET STATUS = '0' where CourseID = ? ";

    $statement = $db->prepare($query);

    $statement->bindParam(1,$cid,PDO::PARAM_STR);

    $statement->execute();
    echo '<script language="javascript">';
    echo 'alert("Successfully deleted course")';
    echo '</script>';
    header("Location: courses.php");
  }
  if(isset($_GET['unteach_id']))
  {
    $cid = $_GET['unteach_id'];
    $pid = $_SESSION['personid'];
    $query = "DELETE FROM Coursestaught WHERE courseID = ? and PersonID =  ? ";

    $statement = $db->prepare($query);

    $statement->bindParam(1,$cid,PDO::PARAM_STR);
    $statement->bindParam(2,$pid,PDO::PARAM_STR);
    $statement->execute();

    echo '<script language="javascript">';
    echo 'alert("Operation Successful")';
    echo '</script>';
    header("Location: courses.php");
  }
  if(isset($_GET['teach_id']))
  {

    $cid = $_GET['teach_id'];
    $date = date("Y/m/d");
    $pid = $_SESSION['personid'];

    $query = "INSERT INTO Coursestaught(CourseID,PersonID,FirstDateTaught) VALUES(?,?,?)";

    $statement = $db->prepare($query);

    $statement->bindParam(1,$cid,PDO::PARAM_STR);
    $statement->bindParam(2,$pid,PDO::PARAM_STR);
    $statement->bindParam(3,$date,PDO::PARAM_STR);
    $statement->execute();
    echo '<script language="javascript">';
    echo 'alert("Operation Successful")';
    echo '</script>';
    header("Location: courses.php");

  }
  if(isset($_POST['assignTeacher']))
  {
    $cid = $_POST['CID'];
    $date = date("Y/m/d");
    $pid = $_POST['PID'];
    if($pid != 0)
    {
    $query = "INSERT INTO Coursestaught(CourseID,PersonID,FirstDateTaught) VALUES(?,?,?)";

    $statement = $db->prepare($query);

    $statement->bindParam(1,$cid,PDO::PARAM_STR);
    $statement->bindParam(2,$pid,PDO::PARAM_STR);
    $statement->bindParam(3,$date,PDO::PARAM_STR);
    $statement->execute();
    echo '<script language="javascript">';
    echo 'alert("Operation Successful")';
    echo '</script>';
    }
  }

  if(isset($_POST['unAssignTeacher']))
  {
    $cid = $_POST['CID'];
    $pid = $_POST['PID'];
    if($pid != 0)
    {
    $query = "DELETE FROM Coursestaught WHERE courseID = ? and PersonID =  ? ";

    $statement = $db->prepare($query);

    $statement->bindParam(1,$cid,PDO::PARAM_STR);
    $statement->bindParam(2,$pid,PDO::PARAM_STR);
    $statement->execute();

    echo '<script language="javascript">';
    echo 'alert("Operation Successful")';
    echo '</script>';
    }
  } 
if(isset($_SESSION['id']))
    {
      $query= "SELECT * FROM USERS U 
      LEFT JOIN PERSON P 
      ON P.USERID = U.USERID 
      LEFT JOIN FACULTYMEMBER FM 
      ON FM.PERSONID = P.PERSONID 
      WHERE U.USERID = ".$_SESSION['id'];
      $statement = $db->prepare($query);
      $statement->execute();
      $inforesult = $statement->fetch(PDO::FETCH_ASSOC);

      $query = "SELECT * FROM Department";
      $statement = $db->prepare($query);
      $statement->execute();
      $deptresult = $statement->fetchAll(PDO::FETCH_ASSOC);
    } 
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>FISCAT</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<style>
        .loginmodal-container {
  padding: 30px;
  max-width: 350px;
  width: 100% !important;
  background-color: #F7F7F7;
  margin: 0 auto;
  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  overflow: hidden;
  font-family: roboto;
}

.loginmodal-container h1 {
  text-align: center;
  font-size: 1.8em;
  font-family: roboto;
}

.loginmodal-container input[type=submit] {
  width: 100%;
  display: block;
  margin-bottom: 10px;
  position: relative;
}

.loginmodal-container input[type=text], input[type=password], select {
  height: 44px;
  font-size: 16px;
  width: 100%;
  margin-bottom: 10px;
  -webkit-appearance: none;
  background: #fff;
  border: 1px solid #d9d9d9;
  border-top: 1px solid #c0c0c0;
  /* border-radius: 2px; */
  padding: 0 8px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}

.loginmodal-container input[type=text]:hover, input[type=password]:hover, select:hover {
  border: 1px solid #b9b9b9;
  border-top: 1px solid #a0a0a0;
  -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
}

.loginmodal {
  text-align: center;
  font-size: 14px;
  font-family: 'Arial', sans-serif;
  font-weight: 700;
  height: 36px;
  padding: 0 8px;
/* border-radius: 3px; */
/* -webkit-user-select: none;
  user-select: none; */
}

.loginmodal-submit {
  /* border: 1px solid #3079ed; */
  border: 0px;
  color: #fff;
  text-shadow: 0 1px rgba(0,0,0,0.1); 
  background-color: #4d90fe;
  padding: 17px 0px;
  font-family: roboto;
  font-size: 14px;
  /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#4787ed)); */
}

.loginmodal-submit:hover {
  /* border: 1px solid #2f5bb7; */
  border: 0px;
  text-shadow: 0 1px rgba(0,0,0,0.3);
  background-color: #357ae8;
  /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#357ae8)); */
}

.loginmodal-container a {
  text-decoration: none;
  color: #666;
  font-weight: 400;
  text-align: center;
  display: inline-block;
  opacity: 0.6;
  transition: opacity ease 0.5s;
} 

.login-help{
  font-size: 12px;
}
      .infomodal-container {
  padding: 30px;
  max-width: 550px;
  width: 100% !important;
  background-color: #F7F7F7;
  margin: 0 auto;
  border-radius: 2px;
  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  overflow: hidden;
  font-family: roboto;
}

.infomodal-container h1 {
  text-align: center;
  font-size: 1.8em;
  font-family: roboto;
}

.infomodal-container input[type=submit] {
  width: 100%;
  display: block;
  margin-bottom: 10px;
  position: relative;
}

.infomodal-container input[type=text], input[type=password],input[type=date],select {
  height: 44px;
  font-size: 16px;
  width: 100%;
  margin-bottom: 10px;
  -webkit-appearance: none;
  background: #fff;
  border: 1px solid #d9d9d9;
  border-top: 1px solid #c0c0c0;
  /* border-radius: 2px; */
  padding: 0 8px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}

.infomodal-container input[type=text]:hover, input[type=password]:hover, input[type=date]:hover,select:hover{
  border: 1px solid #b9b9b9;
  border-top: 1px solid #a0a0a0;
  -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
}

.infomodal {
  text-align: center;
  font-size: 14px;
  font-family: 'Arial', sans-serif;
  font-weight: 700;
  height: 36px;
  padding: 0 8px;
/* border-radius: 3px; */
/* -webkit-user-select: none;
  user-select: none; */
}

.infomodal-submit {
  /* border: 1px solid #3079ed; */
  border: 0px;
  color: #fff;
  text-shadow: 0 1px rgba(0,0,0,0.1); 
  background-color: #4d90fe;
  padding: 17px 0px;
  font-family: roboto;
  font-size: 14px;
  /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#4787ed)); */
}

.infomodal-submit:hover {
  /* border: 1px solid #2f5bb7; */
  border: 0px;
  text-shadow: 0 1px rgba(0,0,0,0.3);
  background-color: #357ae8;
  /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#357ae8)); */
}

.infomodal-container a {
  text-decoration: none;
  color: #666;
  font-weight: 400;
  text-align: center;
  display: inline-block;
  opacity: 0.6;
  transition: opacity ease 0.5s;
} 

.info-help{
  font-size: 12px;
}
    </style>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">FISCAT</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
            
                <!-- /.dropdown -->
                <!-- /.dropdown -->
                <!-- /.dropdown -->
                    <?php
                        if(isset($_SESSION['groupid']))
                        {
                            echo '<li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>'.$_SESSION['username'].'<i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#" data-toggle="modal" data-target="#info-modal" ><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="repository.php"><i class="fa fa-gear fa-fw"></i> Repository</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php?page=courses.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>';
              }
                        else
                        {
                            echo '<li class="dropdown"><a href="#" data-toggle="modal" data-target="#login-modal">Login</a></li>';
                        }
                        
                    ?>
                    <!-- /.dropdown-user -->
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="department.php">Department</a>
                        </li>
                        <li>
                            <a href="courses.php" class="active">Courses</a>
                        </li>
                        <li>
                            <a href="awardsAndGrants.php">Awards & Grants</a>
                        </li>
                        <li>
                            <a href="publications.php">Publications</a>
                        </li>
                        <li>
                            <a href="faculty.php">Faculty</a>
                        </li>
                        <li>
                            <a href="users.php">Users</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Welcome to catfis</h1>
        <!-- login modal -->
  <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="loginmodal-container">
                                    <h1>Login to Your Account</h1><br>
                                    <form action="courses.php" method="POST">
                                        <input type="text" name="username" placeholder="Username">
                                        <input type="password" name="password" placeholder="Password">
                                        <input type="submit" name="login" class="login loginmodal-submit" value="Login">
                                    </form>
                                 </div>
                            </div>
                        </div>
        <!-- login modal -->
        <!-- info modal -->
                        <div class="modal fade" id="info-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="infomodal-container">
                                    <h1>Basic Information</h1><br>  
                                        <form id = "UI-form" action = "updateinfo.php" method = "post">
                                          First Name</br><input type = "text" name = "lname" value = "<?php echo $inforesult['firstName'];?>" required>
                                          M.I<input type = "text" name = "mi" value = "<?php echo $inforesult['middleInitial'];?>" required>
                                          Last Name<input type = "text" name = "fname" value = "<?php echo $inforesult['lastName'];?>" required></br>
                                          Title</br><input type = "text" name = "title" value = "<?php echo $inforesult['TitleofCourtesy'];?>" required></br>
                                              <input type="submit" name="basicupdate" class = "info infomodal-submit" value="Update Basic Information ">
                                        </form>
                                        <?php 
                                         if($_SESSION['groupid'] != 4) 
                                         {
                                         echo "<br><h1>Faculty Information</h1>";
                                         echo "<form action = 'updateinfo.php' method = 'post' ";
                                        ?>
                                          SSN <input type = "text" name = "ssn" value = "<?php echo $inforesult['SSN'];?>" required></br>
                                          HomeStreetAddress <input type = "text" name = "homestreetadd" value = "<?php echo $inforesult['HomeStreetAddress'];?>" required>
                                          </br>
                                          HomeCity <input type = "text" name = "homecity" value = "<?php echo $inforesult['HomeCity'];?>" required></br>
                                          HomeZip <input type = "text" name = "homezip" value = "<?php echo $inforesult['HomeZip'];?>" required></br>
                                          HomePhone <input type = "text" name = "homephone" value = "<?php echo $inforesult['HomePhone'];?>" required></br>
                                          DayTimePhone <input type = "text" name = "daytime" value = "<?php echo $inforesult['DayTimePhone'];?>" required> </br>
                                          AdjunctHireDate <input type = "date" name = "adjunct" value = "<?php echo $inforesult['AdjunctHireDate'];?>" required></br>
                                          FullTimeHireDat <input type = "date" name = "fulltime" value = "<?php echo $inforesult['FullTimeHireDate'];?>" required></br>
                                          RetireDate <input type = "date" name = "retire" value = "<?php echo $inforesult['RetireDate'];?>" required></br>
                                          emailAddress <input type = "text" name = "email" value = "<?php echo $inforesult['emailAddress'];?>" required> </br>
                                          DOB <input type = "date" name = "dob" value = "<?php echo $inforesult['DOB'];?>" required></br>
                                          Department  <select name= "dept" required="">
                                                <option hidden disabled="">Select Department</option>
                                                <?php
                                                foreach($deptresult as $option)
                                                {
                                                  if($option['DeptID'] == $inforesult['DeptID'])  
                                                  echo "<option value = ".$option['DeptID']."selected ="." >".$option['DeptName']."</option>";
                                                  else 
                                              echo "<option value = ".$option['DeptID'].">".$option['DeptName']."</option>";
                                                }
                                                ?>

                                              </select><br> 
                                              <input type="submit" name="basicupdate" class = "info infomodal-submit" value="Update Faculty Information ">
                                        </form>
                                        <?php } ?>
                                 </div>
                            </div>
                        </div>
        <!-- login modal -->
                    </div>
                    <div class="form-group">
                        <label>Select Department</label>
                        <select class="form-control" id="dept">
                          <option value="0" selected="">All Department</option>
                            <?php
                              foreach($departmentList as $dept)
                                      {
                                        echo'<option value="'.$dept['DeptID'].'">'.$dept['DeptName'].'</option>';
                                      }
                            ?>
                        </select>
                    </div>
                      <div class="row">
                        <!-- START OF COL-LG-3 -->
                        <div class="col-lg-3">
                        <?php if(isset($_SESSION['groupid']) && $_SESSION['groupid'] == "1")
                        echo '<input type = "button" id = "showDeptDialog" value = "Add Course" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addDepartment-modal">';
                        ?>
                        <div class="modal fade" id="addDepartment-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                              <div class="loginmodal-container">
                                <h1>ADD COURSE</h1><br>
                                <form action = "courses.php" method = "post">
                                  CatalogNumber</br><input type = "text" name = "catnumber" required><br>
                                  Course Name</br><input type = "text" name = "cname" required><br>
                                  Course Level</br><input type = "text" name = "clevel" required><br> 
                                  Course Credits</br><input type = "text" name = "ccredits" required><br>
                                  Course Subject</br><input type = "text" name = "csubj" required><br>  
                                    <select name= "dept" required="" class="form-control">
                                        <option hidden disabled="" selected="">Select Department</option>
                                        <?php
                                        foreach($departmentList as $option)
                                        {
                                          echo $option['DeptID'];
                                          echo "<option value = ".$option['DeptID'].">".$option['DeptName']."</option>";
                                        }
                                        ?>
                                      </select><br>     
                                  <input type ="submit" name = "addCourse" value = "Add Course" class="login loginmodal-submit">
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- END OF COL-LG-3 -------------------------------------------------------------->
                      </div>
                      <div class="row" style="padding-top:13px;">
                        <div class="col-lg-12">

                          <div class="panel panel-default">
                            <div class="panel-heading">
                              Courses
                            </div>
                        <!-- /.panel-heading -->
                            <div class="panel-body">
                              <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                  <thead>
                                    <tr>
                                      <th>Course Name</th>
                                      <th>Catalog  Number</th>
                                      <th>Course Level</th>
                                      <th>Course Credits</th>
                                      <th>Course Subject</th>
                                      <?php
                                        if(isset($_SESSION['groupid']) && ($_SESSION['groupid'] != "4"))
                                        {
                                          echo '<th>Actions</th>';
                                        }
                                      ?>
                                    </tr>
                                  </thead>
                                  <tbody id="coursesTable">
                                      <?php 
                                        foreach($coursesList as $course)
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
                                          <p>';
                                          echo '<a href = "javascript:delete_id('.$course['CourseID'].')"><input type = "submit" value = "Delete" class = "btn btn-primary"   name = "dltbutton"></a>';
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
                                                          <select name= "dept" required="">';
                                                              //<?php
                                                              foreach($departmentList as $option2)
                                                              {
                                                                  if($option2['DeptID'] == $course['DeptID'])  
                                                                  echo '<option value = '.$option2['DeptID'].' selected = "" >'.$option2['DeptName'].'</option>';
                                                                 else 
                                                                  echo "<option value = ".$option2['DeptID'].">".$option2['DeptName']."</option>";
                                                              }
                                                              ?>
                                                              </select><br>     
                                                        <input type ="submit" name = "updateCourse" value = "Update Course" class="login loginmodal-submit">
                                                    </form>
                                                </div>
                                              </div>
                                            </div>
                                          </p>
                                        </td>

                                      <?php 
                                          }
                                      if(isset($_SESSION['groupid']) && ($_SESSION['groupid'] == "3" || $_SESSION['groupid'] == "2"))
                                        echo "<td></td>";
                                      echo "</tr>";
                                        }
                                    ?>
                                  </tbody>
                                </table>
                              </div>
                              <!-- /.table-responsive -->
                          </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    <script type = "text/javascript">
 (function()
 {
  $("#dept").change(function() {
    $("#coursesTable").load("coursesGetter.php?choice=" + $("#dept").val());
  });

 }())
</script>
<script type ="text/javascript">
function delete_id(id)
{
  if(confirm('Sure to Delete?'))
  {
    window.location.href='courses.php?delete_id='+id;
  }
}
function teach_id(id)
{
  if(confirm('Sure to Delete?'))
  {
    window.location.href='courses.php?teach_id='+id;
  }
}
function unteach_id(id)
{
  if(confirm('Sure to Delete?'))
  {
    window.location.href='courses.php?unteach_id='+id;
  }
}
</script>

</body>

</html>
