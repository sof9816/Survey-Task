<?php
include('file.php');
include('config/config.php');


function checkPostSet()
{
    $qusNumber = $_POST['qusNumber'];
    $pageNumber = $_POST['pageNumber'];
    $check = true;
    for ($pid = 1; $pid <= $pageNumber; $pid++) {

        for ($qid = 1; $qid <= $qusNumber; $qid++) {
            $qus = @$_POST['q' . $pid . $qid];
            if (empty($qus)) {
                $check = false;
            }
            for ($aid = 1; $aid <= 2; $aid++) {
                $ansr = @$_POST['a' . $pid . $qid . $aid];
                if (empty($ansr)) {
                    $check = false;
                }
            }

        }
    }
    return $check;
}
//ALTER TABLE questions AUTO_INCREMENT = 1;

$error = "";
if (isset($_POST['create'])) {
    if (isset($_POST['pageNumber'])
        and isset($_POST['surveyName'])
        and isset($_POST['qusNumber'])) {

        if (checkPostSet()) {
            $qusNumber = $_POST['qusNumber'];
            $pageNumber = $_POST['pageNumber'];
            $surveyName = $_POST['surveyName'];

            $newSurStmt = "INSERT INTO `survey_` (`survey_name`)
            SELECT * FROM (SELECT '$surveyName') AS tmp
            WHERE NOT EXISTS (
                SELECT `survey_name` FROM `survey_` WHERE `survey_name` = '$surveyName'
            ) LIMIT 1";
            $newSurQur = mysqli_query($dbc, $newSurStmt);
            if (mysqli_affected_rows($dbc) > 0) {
                $surIdStmt = "select id from survey_ where survey_name ='$surveyName'";
                $surIdQur = mysqli_query($dbc, $surIdStmt);
                $sidF = mysqli_fetch_assoc($surIdQur);
                $sid = $sidF['id'];

                for ($pid = 1; $pid <= $pageNumber; $pid++) {
                    $newPageStmt = "INSERT INTO `questions`( `survey_id`, `page_id`) VALUES ($sid,$pid)";
                    @mysqli_query($dbc, $newPageStmt);

                    for ($qid = 1; $qid <= $qusNumber; $qid++) {
                        $qus = @$_POST['q' . $pid . $qid];
                        $addQusStmt = "UPDATE `questions` SET `q$qid`= '$qus' WHERE `survey_id` = $sid and `page_id` = $pid";
                        @mysqli_query($dbc, $addQusStmt);
                        $newAnsrStmt = "INSERT INTO `answers`( `survey_id`, `page_id`,`qus_id`) VALUES ($sid,$pid,$qid)";
                        @mysqli_query($dbc, $newAnsrStmt);

                        for ($aid = 1; $aid <= 5; $aid++) {
                            $ansr = @$_POST['a' . $pid . $qid . $aid];
                            $addAnsrStmt = "UPDATE `answers` SET `a$aid`= '$ansr' WHERE `survey_id` = $sid and `page_id` = $pid and `qus_id` = $qid";
                            @mysqli_query($dbc, $addAnsrStmt);
                        }

                    }
                }
            } else {
                $error = 'Name of the survey is used';
            }
        } else {
            $error = "Fill all questions and at least 2 choices :) please";
        }


    } else {
        $error = "Pick a name for the survey and chose number of pages and question per page";
    }


}


// if (isset($_POST['addp'])) {
//     $survey->addPage($survey->numOfpages + 1);
// }
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- jQuery library -->
    <script src="js/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- <script src="js/script.js"></script>  -->

    <script>
                    $(document).ready(function(){
                        var page = 0;
                        var qus = 0;
                        var surName;
                        var fieldNum = /^[a-z]+$/i;
                        $("#sm").click(function () {
                        $(".sur").empty();
                        surName = $("#survey").val();
                        page = $("#pages").val();
                        qus = $("#qus").val();
                        if(qus < 1 || page < 1 || surName==""){
                            alert('Enter all Fields to show survey:) please');
                        return;
                        }
                        if ((page.match(fieldNum)) || (qus.match(fieldNum))) {
                            alert('Numbers only :) please');
                            page = 0;
                            qus = 0;
                        return;
                        }
                        if(qus > 5){
                            alert('5 Question per page only :) please');
                
                        return;
                        }                  
                            for (p = 1; p <=  page; p++) { 
                                $(".sur").append('<label for="">Page ' + p + ' : </label></a><hr><div class="page" id="page">');
                                for (q = 1; q <= qus; q++) { 
                                     $(".sur").append( '<label for="" class="r">Question '+ q +' : <input type="text" class="q" name="q' + p +''+ q +'" required></label>');
                                     for (a = 1; a <= 5; a++) {
                                        if(a==1 || a==2){
                                            $(".sur")
                                            .append( '<label for="" class="g">Choice '+ a +' : <input type="text" class="ansr" name="a' + p +''+ q +''+ a +'" required></label>');

                                         }else {
                                            $(".sur").append( '<label for="" class="g">Choice '+ a +' : <input type="text" class="ansr" name="a' + p +''+ q +''+ a +'"></label>');
                                         }

                                     }
                                }
                                $(".sur").append('</div>');
                                $(".sur").append('<hr>');
                            }

                            $(".sur").append('<input type="submit" class="submit" name="create" value="Create">');
                        });
                   
        });
    </script>
</head>

<body>
    <div class="wrapAll">
        <div class="header">
            <h2 class="sTitle">
                <a class="a" href="edit.php">
                    <?php getUser() ?>
                </a>
            </h2>
            <h3 class="sTitle">
                <a class="a" href="index.php">clasic survey</a>
            </h3>
            <h3 class="sTitle">
                <a class="a" href="surveies.php ">Other surveies</a>
            </h3>
            <h3 class="sTitle">
                <a class="a current" href="create.php">Create a survey</a>
            </h3>
            <form method="post">
                <input type="submit" name="logout" class="s" value="Logout">
            </form>
        </div>
        <div class="content">
            <div>
                <h1>
                    <h2 class="sTitle">
                        <code>
                            Create A Survey
                        </code>
                    </h2>
                </h1>
             <br>  
                <form action="" method="POST">
                    <div class="surcrt">
                    <label for="">
                            Chose survey name : <input type="text" class="surName" id="survey"  name="surveyName">
                        </label>
                        <label for="">
                            Chose how many pages : <input type="text" id="pages" name="pageNumber">
                        </label>
                        <label for="">
                            Chose how many questions per page  : <input type="text" id="qus" name="qusNumber">
                        </label>
                        <br>
                        <br>
                        <h3><code>Note : max number of qustion per page is 5 and for the choices you acn put up to 5<br> (you can make only 2 choices if you want) </code></h3>
                    </div> 
                    <a id="sm"  class="submit">show survey</a>
                    <div class="sur">
                        <?php echo "<br><label class=\"r\"> $error </label><br>"; ?>
                        


                    </div>
                </form>
               
            </div>
            <!-- <form action="" method="POST">
                <div class="sur">
                    <?php //page($survey->getPage()); ?>
                    <div class="page">
                        <?php //qus($survey->getQus()); ?>
                        <div class="qus">
                            <?php //ansr($survey->getAnsr()); ?>
                        </div>
                    </div>
                </div>
            </form> -->


            <!-- <h2 class="sTitle"><h1><code> Classic Survey </code></h1></h2>
                    <br>             
                     <?php getQuestions($dbc); ?> -->
        </div>
        <!--  en
            <!-- <div class="wrapContent">
                <div class="sideNav">
                    <?php sideNav($dbc); ?>
                </div> -->


    </div>
    <!--  end wrapContent-->


    <div class="footer">
        <?php footer(); ?>
    </div>
    <!--  end footer-->
    </div>
    <!--  end wrapAll -->
</body>

</html>

<script type="text/JavaScript">
//     function add(text){
//         document.getElementById('sur').innerHTML = text;
//     }
</script>


<style>



    .sur{
          margin : 10px 0 100px 0;   
          height : 100%;       
    }
    .surcrt{
        margin : 50px;
    }
    .r {
        color: red;
    }

    .g {
        color: green;
    }

    .sur {
        width: 80%;
        margin: 50px auto 0 0;
    }

    .page {
        margin: 30px auto;
        width: 100%;
        /* border : 1px solid ;
        border-radius : 10px ; */

        /* border:1px solid black; */
    }

    /* .qus {
        width: 100%;
        border: 1px solid black;
        border-top: none;
        border-left: none;
        border-right: none;
        padding: 0 10px 10px 10px;
    } */

    label {
        font-size: 20px !important;
        margin-bottom : 10px;
        font-weight: bold !important;
        width: 90%;
    }

    input.q {
        height: 40px;
        width: 90% !important;
        margin: 0 auto;
        font-size: 16px;
    }

    .submit{
        padding : 5px;
        text-decoration : none;
    }
    .submit:hover{
        color :white;
        text-decoration : none;
    }
    .surName{
        width : 20% !important;
    }
    .ansr{
        display : inline;
        width : 15%;
        color : green ;

    }
    input[type=text] {
        height: 40px;
        width: 5%;
        padding : 10px;
        border-radius : 20px;
        border : 2px solid;
        margin: 0 auto;
        font-size: 16px;

    }

    hr {
        border: 1px solid;
    }

    .b {
        /* margin-left: 10%; */
        float: right !important;
        height: 40px !important;
        width: 40px;
        border-radius: 20px;
        border: 1px solid black;
        background: #0074D9;
        padding: 10px;
        color: white;
    }

    .b:hover {
        color: white;
        text-decoration: none;
        cursor: pointer;
        background: red;
    }
</style>


