<?php

include_once 'dbconfig.php';
session_start();

 $choice = mysql_real_escape_string($_GET['choice']);

 $query = "SELECT * FROM grants
  WHERE  STATUS = '1' AND GrantOrAward = '".$choice."' ;";
  $statement = $db->prepare($query);
  $statement->execute();

  $result = $statement->fetchAll(PDO::FETCH_ASSOC);

  if (count($result) > 0)
  {
  	echo '<option hidden selected="" value = "'.$result['GrantID'].'" >Select ';if($choice == "A"){echo 'Award';}else{echo'Grant';} echo '</option>';
  	foreach($result as $result)
  	{
  		echo '<option value = "'.$result['GrantID'].'" >'.$result['GrantTitle'].'</option>';
  	}
  }
?>