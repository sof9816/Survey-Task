<?php
include('file.php');
include('config/config.php');
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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link rel="stylesheet" href="style.css">
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
                <a class="a" href="#">Create a survey</a> 
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
                    <h1><?php head(); ?></h1>                 
                     <?php getQuestions($dbc); ?>
                </div>  <!--  end content-->

            </div>  <!--  end wrapContent-->


        <div class="footer">
            <?php footer(); ?>
        </div> <!--  end footer-->
    </div> <!--  end wrapAll -->
</body>
</html>
