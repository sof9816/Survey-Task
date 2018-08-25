<?php
include('file.php');
include("config/connection.php");

function sginup($dbc)
{

    echo '
    <form action="signUp.php" method="POST" >
        <input type="text" name="names"  placeholder="username">
        <br>
        <input type="password" name="passs"  placeholder="password">
        <br>
        <input type="submit" name="register" value="Sign Up">
    </form>
    <div><a href="login.php">Log In </a></div>
    ';

    if (isset($_POST['register'])) {
        // echo '
        //     <div>Submit</div>
        //     ';
        if (empty($_POST['names']) or empty($_POST['passs'])) {
            echo '
            <div class="wrongUser">Fill all the fields please ! </div>
            ';
        } elseif (isset($_POST['names']) && isset($_POST['passs'])) {
            setUsers($dbc, $_POST['names'], $_POST['passs']);
        }

    }
}

function setUsers($dbc, $user, $pass)
{
    // $user = array();

    // $usr = mysqli_real_escape_string($dbc, $user);
    // $pas = mysqli_real_escape_string($dbc, $pass);

    $usr = filter_var($user, FILTER_SANITIZE_ENCODED);
    $pas = filter_var($pass, FILTER_SANITIZE_ENCODED);

    $q = "INSERT INTO `users`( `user_name`, `password`) 
    VALUES ('" . $usr . "','" . $pas . "')";

    $qSelec = "select * from users where 1";
    $rs = mysqli_query($dbc, $qSelec);


    if ($rs) {
        $sqlUser = array();
        while ($row = mysqli_fetch_assoc($rs)) {
            array_push($sqlUser, $row['user_name']);
        }

        if (in_array($usr, $sqlUser)) {
            echo '
            <div class="wrongUser">This user already Exists !  </div>
            ';

        } else {
            mysqli_query($dbc, "ALTER TABLE users AUTO_INCREMENT = 1;");
            if (mysqli_query($dbc, $q)) {
                mysqli_close($dbc);
                echo '<div>Done you have signed up successfully</div>
                ';
                // sleep(2);
                header('Location: login.php');
            } else {
                echo '<div>Error, check Your inputs</div>
                ';
            }
        }

    }

}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="loginStyle.css">
    <title>Sign Up</title>
</head>
<body>
    <div class="login">
        <h3>Sign Up</h3>
       <?php sginup($dbc) ?>
       <div class="user"></div>
    </div>
    
</body>
</html>
