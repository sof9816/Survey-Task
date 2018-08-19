<?php 
include('file.php');
session_start();
include_once("config/connection.php");
// $_SESSION['user'] = "" ;
function getUsers($dbc)
{
    $user = array();
    $q = "select * from users where 1";
    $rs = mysqli_query($dbc, $q);
    if ($rs) {
        while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
            array_push($user, $row['user_name']);
        }


    }
    return $user;
}

function auth($user)
{
    $sqlUser = $_POST['name'];
    if (in_array($sqlUser, $user)) {
        $_SESSION['user'] = $sqlUser;
        // sleep(2);
        ob_start();
        header('Location: index.php');
        ob_end_flush();
        // exit();
    } elseif ($sqlUser == null) {
        echo '
            <div class="wrongUser">Enter a username please ! </div>
            ';
    } else {
        echo '
            <div class="wrongUser"> The user Does not exists ! </div>
            ';
    }
}

function login($dbc)
{

    echo '
    <form action="login.php" method="POST" >
        <input type="text" name="name"  placeholder="username">
        <br>
        <input type="submit" name="submit" value="Login">
    </form>
    ';

  
}
    $user = null;
  if (isset($_POST['submit'])) {
        $user = getUsers($dbc); 
    }
    if (isset($_POST['name'])) {
            auth($user);
        }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="loginStyle.css">
    <title>Login</title>

</head>
<body>
    <div class="login">
        <h3>LOGIN</h3>
       <?php login($dbc) ?>
       <div class="user"></div>
    </div>
    
</body>
</html>



