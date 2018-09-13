<?php
include('file.php');
include('config/config.php');

$surname = $_SESSION['surname'];

$survey_q = "select id from survey_ where survey_name ='" . $surname . "' ";
$rs1 = mysqli_query($dbc, $survey_q);
$surv_id = mysqli_fetch_assoc($rs1);

$question_q1 = "select page_id from questions where survey_id = " . $surv_id['id'];
$rs2 = mysqli_query($dbc, $question_q1);
$pg_id = mysqli_fetch_assoc($rs2);


$question_q3 = "SELECT page_id FROM questions where survey_id ="
    . $surv_id['id'] . " ORDER BY id DESC LIMIT 1 ";
$rs4 = mysqli_query($dbc, $question_q3);
$pg_id_last = mysqli_fetch_assoc($rs4);

$pgid = $_GET['pgid'];



echo $pgid;
if (isset($_POST['submit']) and $pgid <= $pg_id_last['page_id']) {
    "surv.php?pgid=" . $pgid++;
    // $pgid++;
}
echo $pgid;

    // $i = 1;
    // while ($i < 6) {
    //     echo $qus['q' . $i];
    //     $i++;
    // }
    // echo "<br>";






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
                <a class="a" href="surveies.php ">Other surveies</a>
            </h3>
            <h3 class="sTitle">
                <a class="a" href="#">Create a survey</a> 
            </h3>
                <form method="post">
                    <input type="submit" name="logout" class="s" value="Logout"> 
                </form>
            </div>
            <div class="content">
                <h1><?php head(); ?></h1>                 
                <?php getQuestionsOfSur($dbc, $pgid); ?>
            </div>  <!--  end content-->
            </div>  <!--  end wrapContent-->


        <div class="footer">
            <?php footer(); ?>
        </div> <!--  end footer-->
    </div> <!--  end wrapAll -->
</body>
</html>

<?php

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
function getQuestionsOfSur($dbc, $pgid)
{
    $question_q2 = "select * from questions where page_id ='" . $pgid . "' ";
    $rs3 = mysqli_query($dbc, $question_q2);
    $qus = mysqli_fetch_assoc($rs3);

    echo '<form method ="post" action= "surv.php?pgid=1" > ';
    $index = 1;
    if ($rs3) {
        while ($index < 6) {
            $question = $qus['q' . $index];
            $choices = array('yes', 'Maybe', 'No');
            echo '<div class="questions">';
            displayPollOfSur($question, $choices, $index);
            $index++;
            echo '</div>';
        }
        echo '
        <input type="submit" name="submit" value="Next" class="submit" >  
        </form>';
    }


}


// for ($i = 1; $i < 3; $i++) {
//     if (isset($_POST['submit'])) {
//         for ($j = 1; $j < 3; $j++) {
//             if ($_SERVER['REQUEST_METHOD'] == 'POST' and !isset($_POST['poll' . $j])) {
//                 printM("<br><h3 style=\"color:red;\"> Please fill all the choices !<h3>", 1);
//                 break 2;
//             }
//         }
//         pollSetOfSur($i, $dbc);
//     }

// }


function pollSetOfSur($index, $dbc)
{


    $selection_one = "select * from poll where id =" . $index;
    $process_one = mysqli_query($dbc, $selection_one);
    while ($row = mysqli_fetch_array($process_one, MYSQLI_ASSOC)) {
        $mod_c_one = (int)$row['c_one'] + 1;
        $mod_c_two = (int)$row['c_two'] + 1;
        $mod_c_three = (int)$row['c_three'] + 1;
    }

    if (isset($_POST['poll' . $index])) {
        $selection = $_POST['poll' . $index];

    } else {
        $selection = "";
    }

    if (strlen($selection) > 0) {

        switch ($selection) {
            case 0:
                $selectionStr = "yes";
                $selection_stmt = 'update poll set c_one = ' . $mod_c_one . '
                 where  id =' . $index;
                break;
            case 1:
                $selectionStr = "maybe";
                $selection_stmt = 'update poll set c_two = ' . $mod_c_two . ' 
                 where  id =' . $index;
                break;
            case 2:
                $selectionStr = "no";
                $selection_stmt = 'update poll set c_three = ' . $mod_c_three . '  
                where  id =' . $index;
                break;
        }
        $ansr_set = "UPDATE  `users`  set `ansr" . $index . "` = 
        '" . $selectionStr . "' where user_name = '" . $_SESSION["user"] . "'";
        $rsAnsr = mysqli_query($dbc, $ansr_set);

        $process = mysqli_query($dbc, $selection_stmt) or die(mysqli_connect_error());
        if ($process) {
            echo "<br>Your vote has been casted for poll" . $index . " => ";
            $rs = mysqli_query($GLOBALS['dbc'], $GLOBALS['q2']);
            header('Location: done.php');
        } else {

            printM("Error", $index);
        }
    } else {
        // printM("You made no choice !", $index);
    }
    echo $ansr_set;

}

?>