<?php

/* ----------------------------------------- */
/* ######################################### */
/* ############# connect to db ############# */
/* ######################################### */
/* ----------------------------------------- */

define('user_name', 'surveyUser');
define('user_pass', 'usersur');
define('db_host', 'localhost');
define('db_name', 'survey');

$dbc = @mysqli_connect(db_host, user_name, user_pass, db_name)
  or die('Could not connect to the database because : ' . mysqli_connect_error());

function getSurName()
{
  $query = "SELECT * FROM `survey_` WHERE 1";
  $result = @mysqli_query($GLOBALS["dbc"], $query);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      $sn = $row['survey_name'];
      echo "<h1><code>".$sn."</code></h1><br>";
    }
  } 
  // return $sn;
}

?>