<?php
    
    include_once('dbconfig.php');
    session_start();
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

    $query = "SELECT * FROM department WHERE STATUS = '1'";
    $statement = $db->prepare($query);
    $statement->execute();
    $departmentList = $statement->fetchAll(PDO::FETCH_ASSOC);

    $query = "SELECT * FROM grants WHERE STATUS = '1'";
    $statement = $db->prepare($query);
    $statement->execute();
    $grantsList = $statement->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_POST['addAwardOrGrant']))
  {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $sponsor = $_POST['sponsor'];
    $type = $_POST['type'];
    $status = "1";
    $query = "INSERT INTO grants(GrantTitle,GrantDescription,AwardSponsor,GrantOrAward,STATUS) VALUES(?,?,?,?,?)";

    $statement = $db->prepare($query);

    $statement->bindParam(1,$name,PDO::PARAM_STR);
    $statement->bindParam(2,$desc,PDO::PARAM_STR);
    $statement->bindParam(3,$sponsor,PDO::PARAM_STR);
    $statement->bindParam(4,$type,PDO::PARAM_STR);
    $statement->bindParam(5,$status,PDO::PARAM_STR);

    $statement->execute();
     echo "<meta http-equiv='refresh' content='0'>";
  }
  if(isset($_POST['edit']))
  {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $sponsor = $_POST["sponsor"];
    $description = $_POST["description"];
    $type = $_POST["type"];
    $query = "UPDATE grants SET GrantTitle = ?, GrantDescription = ? , AwardSponsor = ?, GrantOrAward = ? WHERE GrantID = ?";
    $statement = $db->prepare($query);
    $statement->bindParam(1,$name,PDO::PARAM_STR);
    $statement->bindParam(2,$sponsor,PDO::PARAM_STR);
    $statement->bindParam(3,$description,PDO::PARAM_STR);
    $statement->bindParam(4,$type,PDO::PARAM_STR);
    $statement->bindParam(5,$id,PDO::PARAM_STR);
    $statement->execute();
    echo "<meta http-equiv='refresh' content='0'>";
  }
if(isset($_GET['delete_id'])) 
{ 
     $delete_id = $_GET['delete_id']; 
     echo $delete_id;
     $sql_query="UPDATE grants SET STATUS = '0'  WHERE GrantID = ?";  
     $statement = $db->prepare($sql_query); 
 
     $statement->bindParam(1,$delete_id,PDO::PARAM_STR); 
      
     $statement->execute(); 
      if(($count = $statement->rowCount()) > 0)          
        header("Location: $_SERVER[PHP_SELF]");      
    else 
         echo "Delete operation has failed."; 
} 
if (isset($_POST['giveAwardOrGrant']))
{
    $award = $_POST['award'];
    $type = $_POST['type'];
    $recipient = $_POST['recipient'];
    $status = "1";
    $query = "INSERT INTO grantrecipients(DeptID,GrantID,PersonID,GrantBeginDate,STATUS) VALUES(?,?,?,?,?)";

    $statement = $db->prepare($query);

    $statement->bindParam(1,$name,PDO::PARAM_STR);
    $statement->bindParam(2,$desc,PDO::PARAM_STR);
    $statement->bindParam(3,$sponsor,PDO::PARAM_STR);
    $statement->bindParam(4,$type,PDO::PARAM_STR);
    $statement->bindParam(5,$status,PDO::PARAM_STR);

    $statement->execute();
     echo "<meta http-equiv='refresh' content='0'>";
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
  border-radius: 2px;
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

.loginmodal-container input[type=text], input[type=password] {
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

.loginmodal-container input[type=text]:hover, input[type=password]:hover {
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
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php?page=awardsAndGrants.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
                            <a href="courses.php">Courses</a>
                        </li>
                        <li>
                            <a href="awardsAndGrants.php" class="active">Awards & Grants</a>
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
                                    <form action="index.php" method="POST">
                                        <input type="text" name="username" placeholder="Username">
                                        <input type="password" name="password" placeholder="Password">
                                        <input type="submit" name="login" class="login loginmodal-submit" value="Login">
                                    </form>
                                 </div>
                            </div>
                        </div>
        <!-- login modal -->
                    </div>
                    <div class="form-group">
                        <label>Select Grant or Award</label>
                        <select class="form-control" id="awardsOrGrants">
                          <option selected="" value = "0">All grants and awards</option>
                          <option value="A">Awards</option>
                          <option value="G">Grants</option>
                        </select>
                    </div>
                                            <!-- START OF COL-LG-3 -->
                    <?php
                    if(isset($_SESSION['groupid']) && ($_SESSION['groupid'] == '1' || $_SESSION['groupid'] == '2'))
                    {

                    echo'<div class="row">
                        <div class="col-lg-2">
                        <input type = "button" id = "showDeptDialog" value = "Add Award or Grant" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addAwardOrGrant-modal">
                        <div class="modal fade" id="addAwardOrGrant-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                              <div class="loginmodal-container">
                                <h1>ADD AWARD OR GRANT</h1><br>
                                <form action = "awardsAndGrants.php" method = "post">
                                <input type = "text" name = "name" required placeholder="Title"></br>
                                <select class="form-control" name="type" required="required">
                                   <option hidden disabled="" selected="" >Type</option>
                                    <option value="A">Award</option>
                                    <option value="G">Grant</option>
                                  </select></br>
                                  <input type="text" name="description" required="required" placeholder="Description">
                                  <input type="text" name="sponsor" required="required" placeholder="Sponsor">
                                  <input type ="submit" name = "addAwardOrGrant" value = "ADD AWARD OR GRANT" class="login loginmodal-submit">
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-2" style="padding-left:40px;">
                        <input type = "button" id = "showDeptDialog" value = "Give Award or Grant " class="btn btn-primary btn-lg" data-toggle="modal" data-target="#giveAwardOrGrant-modal">
                        <div class="modal fade" id="giveAwardOrGrant-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                              <div class="loginmodal-container">
                                <h1>GIVE AWARD/GRANT</h1><br>
                                <form action = "awardsAndGrants.php" method = "post" required="required">
                                <select name="type" required="required" class="form-control" id="type">
                                  <option hidden disabled="" selected="">Select Type</option>
                                  <option value="A">Award</option>
                                  <option value="G">Grant</option>
                                </select><br>
                                <select name="award" required="required" class="form-control" id="award">
                                  <option hidden disabled="" selected="">Select Award/Grant</option>
                                  
                                </select><br>
                                <select name="dept" required="required" id="deep" class="form-control">
                                  <option hidden disabled="" selected="">Select Department Type</option>
                                  <?php
                                    foreach($departmentList as $dep)
                                    {
                                      echo "<option value=".$dep["DeptID"].">".$dep["DeptName]."</option>";
                                    }
                                  ?>
                                </select><br>
                                <select name="recipient" required="required" id="recipient2" class="form-control">
                                  <option hidden disabled="" selected="">Select Recipient</option>
                                </select><br>
                                  <input type ="submit" name = "giveAwardOrGrant" value = "GIVE AWARD OR GRANT" class="login loginmodal-submit">
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>';
                    }
                    ?>
                      <!-- END OF COL-LG-3 -->
                      <div class="row" style="padding-top:13px;">
                        <div class="col-lg-12">
                          <div class="panel panel-default" id="awardsOrGrantTable">
                          <?php 
                            if(isset($_SESSION['grantsChoice']))
                            {

                            }
                            else
                            {
                              echo'<div class="panel-heading">
                                    Grants and Awards
                                    </div>
                                    <div class="panel-body">
                                      <div class="table-responsive">
                                        <table class="table table-stripped table-bordered table-hover">
                                          <thead>
                                            <tr>
                                              <th>Title</th>
                                              <th>Sponsor</th>
                                              <th>Description</th>
                                              <th>Type</th>';
                                              if(isset($_SESSION['groupid']) && $_SESSION['groupid'] == "1")
                                              {
                                                echo '<th>Actions</th>';
                                              }
                                            echo'</tr>
                                          </thead>
                                          <tbody>
                                          ';
                              foreach($grantsList as $grants)
                                {
                                  echo"<tr>
                                  <td>".$grants['GrantTitle']."</td>
                                  <td>".$grants['AwardSponsor']."</td>
                                  <td>".$grants['GrantDescription']."</td>
                                  <td>".$grants['GrantOrAward']."</td>";
                                  if(isset($_SESSION['groupid']) && $_SESSION['groupid'] == "1")
                                    {
                                      echo'<td>
                                            <p>';
                                            echo '<a href = "javascript:delete_id('.$grants['GrantID'].')"><input type = "submit" value = "Delete" class = "btn btn-primary"   name = "dltbutton"></a>';
                                            echo '<input type = "button" id = "showDeptDialog" value = "EDIT" class="btn btn-primary" data-toggle="modal" data-target="#editDepartment'.$grants['GrantID'].'-modal">
                                            <div class="modal fade" id="editDepartment'.$grants['GrantID'].'-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                  <div class="loginmodal-container">
                                                    <h1>'.$grants['GrantTitle'].'</h1><br>
                                                    <form action = "awardsAndGrants.php" method = "post">
                                                      <input type = "text" name = "name" value="'.$grants['GrantTitle'].'" required>
                                                      <input type = "text" name = "sponsor" value="'.$grants['AwardSponsor'].'" required>
                                                      <input type = "text" name = "description" value="'.$grants['GrantDescription'].'" required>
                                                      <select class="form-control" name="type" required="required">';
                                                          if ($grants['GrantOrAward'] == "A")
                                                          {
                                                            echo '<option value="A" selected="">Award</option>
                                                            <option value="G">Grant</option>';
                                                          }
                                                          else
                                                          {
                                                            echo'<option value="A">Award</option>
                                                            <option value="G" selected="">Grant</option>';
                                                          }
                                                        echo '</select>
                                                      <input type="hidden" name="id" value="'.$grants['GrantID'].'">
                                                      <input type ="submit" name = "edit" value = "Save Changes" class="login loginmodal-submit">
                                                  </form>

                                                </div>
                                              </div>
                                            </div>
                                          </p>
                                            </td>';
                                    }
                                  echo '</tr>';
                                }
                                echo '</tbody>
                                      </table>
                                      </div>
                                      </div>';
                            }
                          ?>
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
    <script src = "jquery-2.2.3.min.js"></script>
    <script src = "jquery-ui.min.js"></script>

    <script type = "text/javascript">
    (function()
 {
  $("#awardsOrGrants").change(function() {
    $("#awardsOrGrantTable").load("awardsOrGrantsGetter.php?choice=" + $("#awardsOrGrants").val());
  });
  $("#type").change(function(){
    $("#award").load("awardsOrGrantsGetter2.php?choice=" + $("#type").val());
  });
  $("#deep").change(function(){
    $("#recipient2").load("awardsOrGrantsGetter3.php?choice=" + $("#deep").val());
  });
 }())
</script>
<script type ="text/javascript">
function delete_id(id)
{
  if(confirm('Sure to Delete?'))
  {
    window.location.href='awardsAndGrants.php?delete_id='+id;
  }
}
</script>
</body>

</html>
