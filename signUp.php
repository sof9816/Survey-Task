<?php
include('file.php');
include("config/connection.php");

function encryptIt($q)
{
    $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
    $qEncoded = @base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $q, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
    return ($qEncoded);
}

function setUsers($dbc, $user, $pass, $email, $fullname, $city)
{
    $usr = filter_var($user, FILTER_SANITIZE_ENCODED);
    $pas = encryptIt(filter_var($pass, FILTER_SANITIZE_ENCODED));
    $eml = filter_var($email, FILTER_VALIDATE_EMAIL);
    $fm = filter_var($fullname, FILTER_SANITIZE_ENCODED);
    $ct = filter_var($city, FILTER_SANITIZE_ENCODED);


    $q = "INSERT INTO `users`( `user_name`, `password`, `email`, `fullname`, `city`)
     VALUES ('" . $usr . "','" . $pas . "','" . $eml . "','" . $fm . "','" . $ct . "')";

    // $q = "INSERT INTO `users`( `user_name`, `password`) 
    // VALUES ('" . $usr . "','" . $pas . "')";

    $qSelec = "select * from users where 1";
    $rs = mysqli_query($dbc, $qSelec);


    if ($rs) {
        $sqlUser = array();
        $sqlEm = array();

        while ($row = mysqli_fetch_assoc($rs)) {
            array_push($sqlUser, $row['user_name']);
            array_push($sqlEm, $row['email']);
        }

        if (in_array($usr, $sqlUser) or in_array($eml, $sqlEm) ) {
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

function sginup($dbc)
{

    echo '
    <form action="signUp.php" method="POST"  >
        <span class="req">
        <input class="reqInput" type="text" name="fullname"  placeholder="Your Full Name">
        </span>
            <br> <span class="req">       
        <input class="reqInput" type="email" name="email"  placeholder="E-mail">
        </span>
        <br> <span class="req">   
        <input class="reqInput" type="text" name="names"  placeholder="Username">   
        </span>
        <br><span class="req">
        <input class="reqInput" type="password" name="passs"  placeholder="Password">
        </span>
        <br>
        <input type="text" name="city"  placeholder="City">
            <br>
        <input type="submit" name="register" value="Sign Up">
    </form>
    <div><a href="login.php">Log In </a></div>
    ';

    if (isset($_POST['register'])) {

        if (empty($_POST['names']) or empty($_POST['passs']) or empty($_POST['email']) or empty($_POST['fullname'])) {
            echo '
            <div class="wrongUser">Fill all the fields please ! </div>
            ';
        } elseif (isset($_POST['names']) && isset($_POST['passs']) and isset($_POST['email']) && isset($_POST['fullname'])) {
            setUsers($dbc, $_POST['names'], $_POST['passs'], $_POST['email'], $_POST['fullname'], $_POST['city']);
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
    <title>SURVEY</title>
</head>
<body>
    <div class="login">
        <h3>Sign Up</h3>
       <?php sginup($dbc) ?>
       <div class="user"></div>
    </div>
    
</body>
</html>
