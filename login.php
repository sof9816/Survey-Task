<?php 
include('file.php');
session_start();
include("config/connection.php");

function chk($dbc, $user, $pass)
{
    $q = 'select user_name,password from users where ( user_name="'
        . $user . '" or email ="'
        . $user . '" ) AND password="' . $pass . '" ;';

    $rs = mysqli_query($dbc, $q);

    $row = mysqli_fetch_array($rs, MYSQLI_ASSOC);

    if ($row) {
        return true;
    }
    return false;
}

function auth($dbc)
{

    $sqlUser = filter_var($_POST['name'], FILTER_SANITIZE_ENCODED);
    if (filter_var($_POST['name'], FILTER_VALIDATE_EMAIL)) {
        $sqlUser = filter_var($_POST['name'], FILTER_VALIDATE_EMAIL);
    }
    $sqlPass = filter_var($_POST['pass'], FILTER_SANITIZE_ENCODED);

    if (chk($dbc, $sqlUser, $sqlPass)) {
        $_SESSION['user'] = $sqlUser;
        ob_start();
        header('Location: index.php');
        ob_end_flush();

    } elseif ($sqlUser == null or empty($_POST['pass'])) {
        echo '
                <div class="wrongUser">Fill all the fields please ! </div>
                ';
    } else {
        echo '
                <div class="wrongUser">Wrong user or password ! </div>
                ';
    }

}

function login($dbc)
{

    echo '
    <form action="login.php" method="POST" >
        <input type="text" name="name"  placeholder="username or email">
        <br>
        <input type="password" name="pass"  placeholder="password">
        <br>
        <input type="submit" name="submit" value="Login">
    </form>
    <div><a href="signUp.php"> Not a user ? Sign up</a></div>

    ';
}

if (isset($_POST['submit'])) {
    auth($dbc);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="loginStyle.css">
    <title>SURVEY</title>
</head>
<body>
    <div class="login">
        <h3>LOGIN</h3>
       <?php login($dbc) ?>
       <div class="user"></div>
    </div>
    
</body>
</html>



