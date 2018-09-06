<?php
include('file.php');
include("config/connection.php");
session_start();
function editUser($dbc, $user, $pass, $email, $fullname, $city)
{
    $usr = filter_var($user, FILTER_SANITIZE_ENCODED);
    $pas = filter_var($pass, FILTER_SANITIZE_ENCODED);
    $eml = filter_var($email, FILTER_VALIDATE_EMAIL);
    $fm = filter_var($fullname, FILTER_SANITIZE_STRING);
    $ct = filter_var($city, FILTER_SANITIZE_ENCODED);

    $rowAfterChange = array($usr, $pas, $eml, $fm, $ct);

    $q = "UPDATE `users` SET `user_name`='" . $usr . "',`password`='" . $pas . "',
    `email`='" . $eml . "',`fullname`='" . $fm . "',`city`='" . $ct . "' WHERE `user_name`='" . $_SESSION["user"] . "'";


    $qSelec = "select * from users where 1";
    $rs2 = mysqli_query($dbc, $qSelec);

    $uSelec = "SELECT  `user_name`, `password`, `email`, `fullname`, `city` FROM `users` WHERE user_name ='" . $usr . "'";
    $rs = mysqli_query($dbc, $uSelec);
    $rowBeforeChange = mysqli_fetch_row($rs);


    $notUserSelec = "SELECT * from users WHERE user_name !='" . $usr . "'";
    $rs3 = mysqli_query($dbc, $notUserSelec);
    $notUser = array();
    $notEm = array();
    while ($row = mysqli_fetch_assoc($rs3)) {
        array_push($notUser, $row['user_name']);
        array_push($notEm, $row['email']);
    }

    if ($rs) {
        $sqlUser = array();
        $sqlEm = array();

        $row = array();
        while ($row = mysqli_fetch_assoc($rs2)) {
            array_push($sqlUser, $row['user_name']);
            array_push($sqlEm, $row['email']);
        }
        if ($rowBeforeChange == $rowAfterChange) {
            echo '
            <div class="wrongUser">You did not do  changes !  </div>
            ';
        } elseif (in_array($usr, $sqlUser)
            and (in_array($usr, $notUser) or in_array($eml, $notEm))) {
            echo '
            <div class="wrongUser">This user already Exists !  </div>
            ';

        } else {
            mysqli_query($dbc, "ALTER TABLE users AUTO_INCREMENT = 1;");
            if (mysqli_query($dbc, $q)) {
                mysqli_close($dbc);
                echo '<div>Done you have edited successfully</div>
                ';
                $_SESSION['user'] = $usr;
                sleep(2);
                header('Location: index.php');
            } else {
                echo '<div>Error, check Your inputs</div>
                ';
            }
        }

    }

}

function edit($dbc)
{
    $uSelec = 'select * from users where ( user_name="'
        . $_SESSION['user'] . '" or email ="'
        . $_SESSION['user'] . '" )';
    $rs = mysqli_query($dbc, $uSelec);
    $row = mysqli_fetch_assoc($rs);


    echo '
    <form action="edit.php" method="POST"  >
        <span class="req">
        <input class="reqInput" type="text" name="fullname"  placeholder="Your Full Name" value="' . $row['fullname'] . '">
        
        </span>
            <br> <span class="req">       
        <input class="reqInput" type="email" name="email"  placeholder="E-mail" value="' . $row['email'] . '">
        
        </span>
        <br> <span class="req">   
        <input class="reqInput" type="text" name="names"  placeholder="Username" value="' . $row['user_name'] . '">
        
        </span>
        <br><span class="req">
        <input class="reqInput" type="text" name="passs"  placeholder="Password" value="' . $row['password'] . '">
        
        </span>
        <br>
        <input type="text" name="city"  placeholder="City" value="' . $row['city'] . '">
        
            <br>
        <input type="submit" name="edit" value="Confirm ">
    </form>
    
    <div><a href="index.php"> Back to Survey </a></div>
    ';

    if (isset($_POST['edit'])) {

        if (empty($_POST['names']) or empty($_POST['passs']) or empty($_POST['email']) or empty($_POST['fullname'])) {
            echo '
            <div class="wrongUser">Fill all the fields please ! </div>
            ';
        } elseif (isset($_POST['names']) and isset($_POST['passs']) and isset($_POST['email']) and isset($_POST['fullname'])) {
            editUser($dbc, $_POST['names'], $_POST['passs'], $_POST['email'], $_POST['fullname'], $_POST['city']);
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
        <h3>Edit Your info</h3>
       <?php edit($dbc) ?>
       <div class="user"></div>
    </div>
    
</body>
</html>
