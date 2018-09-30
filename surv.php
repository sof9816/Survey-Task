<?php
include('file.php');
include('config/config.php');

$surname = $_SESSION['surname'];
$msg = "";   

// get survey id ---------------------------------------------------------------//
$survey_q = "select id from survey_ where survey_name ='" . $surname . "' ";
$rs1 = mysqli_query($dbc, $survey_q);
$surv_id = mysqli_fetch_assoc($rs1);
$sid = $surv_id['id'];

// get page id ---------------------------------------------------------------//
$pgid = $_GET['pgid'];

// get last page id -----------------------------------------------------------//
$question_q3 = "SELECT page_id FROM questions where survey_id ="
    . $sid . " ORDER BY id DESC LIMIT 1 ";
$rs4 = mysqli_query($dbc, $question_q3);
$pg_id_last = mysqli_fetch_assoc($rs4);
$pgIdLast = $pg_id_last['page_id'];

// get last qus number -----------------------------------------------------------//
$numOfQ = 0;
$qus_num = "SELECT * FROM questions where survey_id ="
    . $sid . " and page_id = " . $pgid . " ORDER BY id DESC LIMIT 1  ";
$rs8 = mysqli_query($dbc, $qus_num);
$row = mysqli_fetch_assoc($rs8);

for ($n = 1; $n < 6; $n++) {
    if (!empty($row['q' . $n])) {
        $numOfQ++;
    }
}


// array of result get it from survies.php  ---------------------------------------//
$rsltAnsr = $_SESSION['rsltAnsr'];

// array that takes the answers to put it in rsltAnsr  ----------------------------//
$slcs = array();

// array of result get it from survies.php  ---------------------------------------//
$next = $_SESSION['next'];


// ALTER TABLE answers AUTO_INCREMENT = 1;
// ALTER TABLE questions AUTO_INCREMENT = 1;
// ALTER TABLE results AUTO_INCREMENT = 1;
// ALTER TABLE surisdone AUTO_INCREMENT = 1;
// ALTER TABLE survey_ AUTO_INCREMENT = 1;



// get user id ---------------------------------------------------------------//
$uSelec = 'select * from users where ( user_name="'
    . $_SESSION['user'] . '" or email ="'
    . $_SESSION['user'] . '" )';
$rs0 = mysqli_query($dbc, $uSelec);
$row = mysqli_fetch_assoc($rs0);
$uid = $row['user_id'];

// check if the user done the survey ---------------------------------------//
$sqlStSelc = "SELECT `Done` FROM `surisdone`
 WHERE `user_id` = " . $uid . "  and  `sur_id` =" . $sid;
$rs7 = mysqli_query($dbc, $sqlStSelc);
$isDone = mysqli_fetch_assoc($rs7);
if ($isDone['Done'] == 1) {
    header('Location: done2.php');
}

//  if the user done the survey than set done ---------------------------------//
$done = 1;
$sqlSt = "INSERT INTO `surisdone`( `Done`, `user_id`, `sur_id`)
 VALUES (" . $done . "," . $uid . "," . $sid . ")";


if (isset($_POST['submit']) and $pgid <= $pgIdLast) {


    if (checkPostSet($numOfQ)) {
        $_SESSION['rsltAnsr'] = check($dbc, $pgid, $slcs, $rsltAnsr, $numOfQ);
        if ($pgid < $pgIdLast) {
            "surv.php?pgid=" . $pgid++;
        }
        // print_r($_SESSION['rsltAnsr']);
        if ($next == "Finish") {
            foreach ($_SESSION['rsltAnsr'] as $pgid => $aid) {
                for ($qusid = 0; $qusid < count($aid); $qusid++) {
                    echo "<br>";
                    pollSetOfSur($dbc, $sid, $pgid, $qusid + 1, $row['user_id'], $aid[$qusid]);

                }
            }
            $rs6 = mysqli_query($dbc, $sqlSt);
            if ($rs6) {
                header('Location: done2.php');
            } else {
                echo $GLOBALS['sqlSt'];
            }

        }
    }

}


if ($pgid == $pgIdLast) {
    $_SESSION['next'] = "Finish";
    $next = $_SESSION['next'];

}




function displayPollOfSur($prompt, $choices, $pollNumber)
{
    echo '<td><b> ' . $prompt . '</b>
    <table border="0" >';

    for ($i = 0; $i < count($choices); $i++) {
        echo '<tr><td>
        <label class="container">' . $choices[$i] .
            '<input type="radio" name="poll' . $pollNumber . '" value="' . $i . '" > 
        <span class="checkmark"></span>
        </label></td></tr>';
    }

    echo '</table> 
        
        ';

}

function getQuestionsOfSur($dbc, $pgid, $sid)
{
    $question_q2 = "select * from questions where page_id ='" . $pgid . "' 
     and survey_id ='" . $sid . "'";
    $rs3 = mysqli_query($dbc, $question_q2);
    $qus = mysqli_fetch_assoc($rs3);


    echo '<form method ="post" action= "surv.php?pgid=' . $pgid . '"> ';
    $index = 1;
    if ($rs3) {
        while ($index < 6) {
            $question = $qus['q' . $index];
            if (empty($question)) {
                break;
            }
            $ansr_q = "select * from answers where page_id ='" . $pgid . "'
             and qus_id ='" . $index . "' and survey_id ='" . $sid . "'";

            $rs5 = mysqli_query($dbc, $ansr_q);
            $ansr = mysqli_fetch_assoc($rs5);

            $choices = array();
            $i = 1;
            while ($i < 6) {
                if (empty($ansr['a' . $i])) {
                    break;
                }
                array_push($choices, $ansr['a' . $i]);
                $i++;
            }
            echo '<div class="questions">';
            displayPollOfSur($question, $choices, $index);
            $index++;
            echo '</div>';
        }
        echo '
        <input type="submit" name="submit" value="' . $GLOBALS['next'] . '" class="submit" >  
        </form>';
    }


}

function checkPostSet($numOfQ)
{
    for ($j = 1; $j <= $numOfQ; $j++) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' and !isset($_POST['poll' . $j])) {
            $GLOBALS['msg'] = "Please fill all the choices !";
            // printM('
            // <script  type="text/javascript">
            // document.getElementById("fill").innerHTML = "Please fill all the choices !" ;
            // </script>', 1);


            return false;
        } else {
            $GLOBALS['msg'] = "";
        }
    }
    return true;
}

function check($dbc, $pgid, $slcs, $rsltAnsr, $numOfQ)
{
    for ($i = 1; $i <= $numOfQ; $i++) {

        $selection = $_POST['poll' . $i] + 1;
        array_push($slcs, $selection);
        $rsltAnsr[$pgid] = $slcs;

    }
    return $rsltAnsr;
}



function pollSetOfSur($dbc, $sid, $pgid, $qusid, $uid, $aid)
{
    $rsltStmt = "INSERT INTO `results`
        ( `survey_id`, `page_id`, `qus_id`, `user_id`, `ansr_id`)
         VALUES 
        (" . $sid . "," . $pgid . "," . $qusid . "," . $uid . "," . $aid . ")";

    $p1 = mysqli_query($dbc, $rsltStmt);
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
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="style.css"> -->

<!-- jQuery library -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->

<!-- Latest compiled JavaScript -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  -->

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
                <a class="a" href="surveies.php ">Other surveies</a>
            </h3>
            <h3 class="sTitle">
                <a class="a" href="create.php">Create a survey</a> 
            </h3>
                <form method="post">
                    <input type="submit" name="logout" class="s" value="Logout"> 
                </form>
            </div>
            <div class="content">
                <h1><?php head(); ?></h1><br>   
                <h3 style="color:red;" id="fill"><?php echo $msg; ?><h3><br>
                <?php getQuestionsOfSur($dbc, $pgid, $sid); ?>
            </div>  <!--  end content-->
            </div>  <!--  end wrapContent-->


        <div class="footer">
            <?php footer(); ?>
        </div> <!--  end footer-->
    </div> <!--  end wrapAll -->
</body>
</html>


