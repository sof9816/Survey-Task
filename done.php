<?php
include('file.php');
include('functions\template.php');
include('config/connection.php');
session_start();

$user = $_SESSION['user'];

$q1 = 'select done from users where ( user_name="'
    . $user . '" or email ="'
    . $user . '" ) ;';
$rs = mysqli_query($dbc, $q1);
$row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
if ($row['done'] != 1) {
    ob_start();
    header('Location: index.php');
    ob_end_flush();
    exit();
}

function logout()
{
    $_SESSION['user'] = "";
    session_unset();
    session_destroy();
    mysqli_close($dbc);

    // echo 'hi';
    ob_start();
    header('Location: login.php');
    ob_end_flush();
    exit();

}
if (isset($_POST['logout'])) {
    logout();
}

function getAnsr($dbc)
{

    $query_ansr = "SELECT * from `users` where user_name = '" . $_SESSION["user"] . "'";
    // echo $query_ansr;
    $result2 = mysqli_query($dbc, $query_ansr);
    $ansr = mysqli_fetch_assoc($result2);

    $id = $ansr['user_id'];


    $query_qus = "SELECT * from survey_qus where 1 ";
    // echo $query_qus;
    $result1 = mysqli_query($dbc, $query_qus);


    if ($result1) {
        while ($qus = mysqli_fetch_assoc($result1)) {
            $q = $qus['question_body'];
            $index = $qus['qus_id'];
            $a = $ansr['ansr' . $index . ''];


            echo '<div class="questions">';
            echo $q . "<br><div class='anr'>Answer : " . $a . "</div>  <br>";
            echo '</div>';


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
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- jQuery library -->
    <script src="js/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
    <title>SURVEY</title>
</head>
<body>
<div class="wrapAll">
    <div class="header">
        <h2 class="sTitle">
            <a class="a" href="edit.php"><?php getUser() ?></a> 
        </h2>
        <h3 class="sTitle">
            <a class="a current" href="index.php">clasic survey</a>  
        </h3>
        <h3 class="sTitle">
            <a class="a " href="surveies.php ">Other surveies</a>
        </h3>
        <h3 class="sTitle">
                <a class="a" href="create.php">Create a survey</a> 
        </h3>
        <form method="post">
           <input type="submit" name="logout" class="s" value="Logout"> 
        </form>
    </div>
 </div>
    <div class="login">
        <h3>Done</h3>
	<br>
	<h4>You finished the survey</h4>
    <h3><hr>Your answers : <br><br> <code><?php getAnsr($dbc); ?> <hr></h3>
    <br>

    </div>
    
</body>
</html>



<Style>

html {
    height :100%;
}
.anr{
    color:green;
}
.questions {
    color : brown;
}

body {
        color: #647086;
        text-align: left;
        font-family: 'Source Sans Pro', Arial, Helvetica, sans-serif;
        font-size: 18px;
        font-weight: bold;
        background: #f8f8f8;
        outline: 0;
    }
 .login {
    
    max-width: 800px;
    margin: 100px auto ;
    padding: 30px;
    border : 5px solid ;
    border-radius : 20px;
    box-shadow: 0px 5px 50px rgba(0,0,0,.3);
    background: rgba(244, 244, 244, 0.76);
}   



</Style>