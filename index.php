<?php
include('file.php');
include('config/config.php');

$user = $_SESSION['user'];
$q1 = 'select done from users where ( user_name="'
    . $user . '" or email ="'
    . $user . '" ) ;';
$rs = mysqli_query($dbc, $q1);
$row = mysqli_fetch_array($rs, MYSQLI_ASSOC);


if ($row['done'] == 1) {
    ob_start();
    header('Location: done.php');
    ob_end_flush();
    exit();
}

function logout()
{
    $_SESSION['user'] = "";
    session_unset();
    session_destroy();
    // echo 'hi';
    mysqli_close($dbc);
    ob_start();
    header('Location: login.php');
    ob_end_flush();
    exit();

}
if (isset($_POST['logout'])) {
    logout();
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
                <a class="a" href="surveies.php ">Other surveies</a> 
            </h3>
            <h3 class="sTitle">
                <a class="a" href="create.php">Create a survey</a> 
            </h3>
                <form method="post">
                    <input type="submit" name="logout" class="s" value="Logout"> 
                </form>
            </div>
            <div class="wrapContent">
                <!-- <div class="sideNav">
                    <?php #sideNav($dbc); ?>
                </div> -->
                <div class="content">
                <h2 class="sTitle"><h1><code> Classic Survey </code></h1></h2>
                    <br>             
                     <?php getQuestions($dbc); ?>
                </div>  <!--  end content-->

            </div>  <!--  end wrapContent-->


        <div class="footer">
            <?php footer(); ?>
        </div> <!--  end footer-->
    </div> <!--  end wrapAll -->
</body>
</html>
