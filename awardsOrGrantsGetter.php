<?php 

  include_once 'dbconfig.php';
  session_start();

  $choice = mysql_real_escape_string($_GET['choice']);

  $query = "SELECT * FROM grants
  WHERE  STATUS = '1' AND GrantOrAward = '".$choice."' ;";
  $statement = $db->prepare($query);
  $statement->execute();

  $result = $statement->fetchAll(PDO::FETCH_ASSOC);

  if($choice == "0")
  {
    unset($_SESSION['grantChoice']);
    echo "<meta http-equiv='refresh' content='0'>";
  } 
  else
  {
    if($choice == "A")
    {
        echo'<div class="panel-heading">Awards
                            </div>
                            <div class="panel-body">
                              <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                  <thead>
                                    <tr>
                                      <th>Award Title</th>
                                      <th>Award Sponsor</th>
                                      <th>Award Description</th>';
                                      if(isset($_SESSION['groupid']) && $_SESSION['groupid'] == '1')
                                      {
                                        echo '<th>Actions</th>';
                                      }
                                    echo '</tr>
                                  </thead>
                                  <tbody>';
                                  foreach($result as $award)
                                  {
                                    echo'<tr>
                                      <td>'.$award['GrantTitle'].'</td>
                                      <td>'.$award['AwardSponsor'].'</td>
                                      <td>'.$award['GrantDescription'].'</td>';
                                      if(isset($_SESSION['groupid']) && $_SESSION['groupid'] == "1")
                                    {
                                      echo'<td>
                                            <p>';
                                            echo '<a href = "javascript:delete_id('.$award['GrantID'].')"><input type = "submit" value = "Delete" class = "btn btn-primary"   name = "dltbutton"></a>';
                                            echo '<input type = "button" id = "showDeptDialog" value = "EDIT" class="btn btn-primary" data-toggle="modal" data-target="#editDepartment'.$award['GrantID'].'-modal">
                                            <div class="modal fade" id="editDepartment'.$award['GrantID'].'-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                  <div class="loginmodal-container">
                                                    <h1>'.$award['GrantTitle'].'</h1><br>
                                                    <form action = "awardsAndGrants.php" method = "post">
                                                      <input type = "text" name = "name" value="'.$award['GrantTitle'].'" required>
                                                      <input type = "text" name = "sponsor" value="'.$award['AwardSponsor'].'" required>
                                                      <input type = "text" name = "description" value="'.$award['GrantDescription'].'" required>
                                                      <select class="form-control" name="type" required="required">';
                                                          if ($award['GrantOrAward'] == "A")
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
                                                      <input type="hidden" name="id" value="'.$award['GrantID'].'">
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
    else
    {
            echo'<div class="panel-heading">Grants
                            </div>
                            <div class="panel-body">
                              <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                  <thead>
                                    <tr>
                                      <th>Award Title</th>
                                      <th>Award Sponsor</th>
                                      <th>Award Description</th>';
                                      if(isset($_SESSION['groupid']) && $_SESSION['groupid'] == '1')
                                      {
                                        echo '<th>Actions</th>';
                                      }
                                    echo'</tr>
                                  </thead>
                                  <tbody>';
                                  foreach($result as $award)
                                  {
                                    echo'<tr>
                                      <td>'.$award['GrantTitle'].'</td>
                                      <td>'.$award['AwardSponsor'].'</td>
                                      <td>'.$award['GrantDescription'].'</td>';
                                         if(isset($_SESSION['groupid']) && $_SESSION['groupid'] == "1")
                                    {
                                      echo'<td>
                                            <p>';
                                            echo '<a href = "javascript:delete_id('.$award['GrantID'].')"><input type = "submit" value = "Delete" class = "btn btn-primary"   name = "dltbutton"></a>';
                                            echo '<input type = "button" id = "showDeptDialog" value = "EDIT" class="btn btn-primary" data-toggle="modal" data-target="#editDepartment'.$award['GrantID'].'-modal">
                                            <div class="modal fade" id="editDepartment'.$award['GrantID'].'-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                  <div class="loginmodal-container">
                                                    <h1>'.$award['GrantTitle'].'</h1><br>
                                                    <form action = "awardsAndGrants.php" method = "post">
                                                      <input type = "text" name = "name" value="'.$award['GrantTitle'].'" required>
                                                      <input type = "text" name = "sponsor" value="'.$award['AwardSponsor'].'" required>
                                                      <input type = "text" name = "description" value="'.$award['GrantDescription'].'" required>
                                                      <select class="form-control" name="type" required="required">';
                                                          if ($award['GrantOrAward'] == "A")
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
                                                      <input type="hidden" name="id" value="'.$award['GrantID'].'">
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
  $_SESSION['grantChoice'] = $choice;
}
?>