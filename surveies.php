<?php
include('file.php');
include('config/config.php');
if (isset($_SESSION['rsltAnsr'])) {
    unset($_SESSION['rsltAnsr']);
    unset($_SESSION['Next']);
}
$_SESSION['surname'];
$rsltAnsr = array();
$_SESSION['rsltAnsr'] = $rsltAnsr;
$_SESSION['next'] = "Next";

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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- jQuery library -->
    <script src="js/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="js/bootstrap.min.js"></script>

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
                <a class="a" href="create.php">Create a survey</a> 
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