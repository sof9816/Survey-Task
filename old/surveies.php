<?php
include('file.php');
include('config/config.php');
$_SESSION['surname'];
if (isset($_POST['chsur'])) {
    $_SESSION['surname'] = $_POST['chsur'];
    header('Location: surv.php?pgid=1');

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SURVEY</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
</head>
<body>
<div class="wrapAll">
        <div class="header">
            <h2 class="sTitle">
                <a class="a" href="edit.php"><?php getUser() ?></a> 
            </h2>
            <h3 class="sTitle">
                <a class="a" href="index.php">clasic survey</a>  
            </h3>
            <h3 class="sTitle">
                <a class="a current" href="surveies.php ">Other surveies</a>
            </h3>
            <h3 class="sTitle">
                <a class="a" href="#">Create a survey</a> 
            </h3>
                <form method="post">
                    <input type="submit" name="logout" class="s" value="Logout"> 
                </form>
            </div>
            <div class="wrapContent">
                <div class="sideNav">
                    <?php sideNav($dbc); ?>
                </div>
               

            </div>  <!--  end wrapContent-->


        <div class="footer">
            <?php footer(); ?>
        </div> <!--  end footer-->
    </div> <!--  end wrapAll -->
</body>
</html>