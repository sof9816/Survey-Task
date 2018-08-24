<?php
include('config/config.php');
function logout()
{
    $_SESSION['user'] = "";
    session_unset();
    session_destroy();
    header('Location: login.php');
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
    <link rel="stylesheet" href="style.css">
    <title>My Survey</title>
</head>

<body>
    <div class="wrapAll">
        <div class="header">
            <h2 class="sTitle">Survey<h2>
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
