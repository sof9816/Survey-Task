<?php
include('file.php');
include('config\connection.php');
include('functions\template.php');
session_start();
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

// get the survey id  -------------------------------------------------------//
$surname = $_SESSION['surname'];
$survey_q = "select id from survey_ where survey_name ='" . $surname . "' ";
$rs1 = mysqli_query($dbc, $survey_q);
$surv_id = mysqli_fetch_assoc($rs1);
$sid = $surv_id['id'];

// get the user id ---------------------------------------------------------//
$user = $_SESSION['user'];
$q1 = 'select user_id from users where ( user_name="'
    . $user . '" or email ="'
    . $user . '" ) ;';
$rs = mysqli_query($dbc, $q1);
$row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
$uid = $row['user_id'];

// get the pages number ---------------------------------------------------------//
$question_q3 = "SELECT page_id FROM questions where survey_id ="
    . $sid . " ORDER BY id DESC LIMIT 1 ";
$rs4 = mysqli_query($dbc, $question_q3);
$pg_id_last = mysqli_fetch_assoc($rs4);
$numPage = $pg_id_last['page_id'];


function getQ($dbc, $pid, $sid, $uid)
{
// get the question  ---------------------------------------------------------//
    $question_q3 = "SELECT qus_id FROM results where survey_id ="
        . $sid . " and page_id ="
        . $pid . " and user_id ="
        . $uid;
    $rs4 = mysqli_query($dbc, $question_q3);

    $question_q2 = "SELECT * FROM questions where survey_id ="
        . $sid . " and page_id ="
        . $pid;
    $rs3 = mysqli_query($dbc, $question_q2);
    $qus = mysqli_fetch_assoc($rs3);

    while ($qid = mysqli_fetch_assoc($rs4)) {
        $q = $qus['q' . $qid['qus_id']];
        $a = getA($dbc, $pid, $sid, $qid['qus_id'], $uid);

        echo '<div class="questions">';
        echo $q . "<br><br>
        <div class='anr'>Answer : " . $a . "</div>
          <br>";
        echo '</div>';
    }
}

function getA($dbc, $pid, $sid, $qid, $uid)
{
// get the answer  ---------------------------------------------------------//
    $ansr_a3 = "SELECT * FROM results where survey_id ="
        . $sid . " and page_id ="
        . $pid . " and qus_id = " . $qid . " and user_id ="
        . $uid;
    $rs4 = mysqli_query($dbc, $ansr_a3);
    // echo  "<br>".$ansr_a3."<br>";
    $aid = @mysqli_fetch_assoc($rs4);

    // echo $aid['ansr_id'];

    $ansr_a2 = "SELECT * FROM answers where survey_id ="
        . $sid . " and page_id ="
        . $pid . " and qus_id = " . $qid;
    $rs3 = mysqli_query($dbc, $ansr_a2);
    $a = @mysqli_fetch_assoc($rs3);

    if(empty($a['a' . $aid['ansr_id']])){
        return "Empty choice";
    }
    return $a['a' . $aid['ansr_id']];

}


$sqlStSelc = "SELECT * FROM `surisdone`
 WHERE `user_id` = " . $uid . "  and  `sur_id` =" . $sid;
$rs7 = mysqli_query($dbc, $sqlStSelc);
$isDone = mysqli_fetch_assoc($rs7);

if ($isDone['Done'] != 1) {
    header('Location: index.php');
}



function getAnsr($dbc, $sid, $uid)
{

    for ($pid = 1; $pid <= $GLOBALS['numPage']; $pid++) {

        echo "<hr>
        <h3>Page number : " . $pid . " </h3>
        <br>";
        getQ($dbc, $pid, $sid, $uid);
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
                <a class="a" href="index.php">clasic survey</a>  
            </h3>
            <h3 class="sTitle">
                <a class="a " href="surveies.php ">Other surveies</a>
            </h3>
            <h3 class="sTitle">
                <a class="a" href="#">Create a survey</a> 
            </h3>
                <form method="post">
                    <input type="submit" name="logout" class="s" value="Logout"> 
                </form>
            </div>

 </div>
    <div class="login">
        <h3>Done</h3>
	<br>
	<h4>You finished this survey</h4>
    <h3>Your answers : <br><code>

        <?php getAnsr($dbc, $sid, $uid); ?> 
        <hr></h3>
        
    <br>

    </div>
    
</body>
</html>



<Style>
hr {
    border: 5px solid black;
}
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
        font-size: 18px ;
        background: #f8f8f8;
        outline: 0;
    }
 .login {
    
    max-width: 60%;
    margin: 100px auto ;
    padding: 30px;
    border : 5px solid ;
    border-radius : 20px;
    box-shadow: 0px 5px 50px rgba(0,0,0,.3);
    background: rgba(244, 244, 244, 0.76);
}   



</Style>