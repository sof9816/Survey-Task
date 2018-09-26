<?php
include('file.php');
include('config/config.php');
// if (isset($_SESSION['rsltAnsr'])) {
//     unset($_SESSION['rsltAnsr']);
//     unset($_SESSION['Next']);
// }
// $_SESSION['surname'];
// $rsltAnsr = array();
// $_SESSION['rsltAnsr'] = $rsltAnsr;
// $_SESSION['next'] = "Next";

// if (isset($_POST['chsur'])) {
//     $_SESSION['surname'] = $_POST['chsur'];
//     header('Location: surv.php?pgid=1');

// }
class Survey
{
    var $pages = array();
    var $numOfpages = 1;
    var $qusetions = array();
    var $numOfQPerP = 1;
    var $answers = array();
    var $numOfAPerQ = 2;

    function __construct($p, $q, $a)
    {
        $this->pages[$p] = $p;
        $this->qusetions[$q . $p] = $q;
        $this->answers[$a . $q . $p] = $a;

    }
    public function addPage($pNum)
    {
        $this->pages[$pNum] = $pNum;
        echo '
            <script>
            ("#sur").append(add());
            </script>
            ';
        $this->numOfQPerP++;
    }
    public function addQus($pNum, $qNum)
    {
        $this->qusetions[$pNum . $qNum] = $qNum;
        $this->numOfQ++;
    }
    public function addAnsr($qNum, $pNum, $aNum)
    {
        $this->answers[$aNum . $qNum . $pNum] = $aNum;
        $this->numOfAPerQ++;
    }
    public function getPage($pNum)
    {
        return $this->pages[$pNum];
    }
    public function getQus($pNum, $qus)
    {
        return $qusetions[$pNum . $qus];
    }
    public function getAnsr($aNum, $qNum, $pNum)
    {
        return $this->answers[$aNum . $qNum . $pNum];
    }

}
function add($p, $q, $a)
{
    echo '<script> 
    var text = \'<label for="">
    Page ' . $p . '
</label>
     <button class="b glyphicon glyphicon-plus" name="addp"></button>
<hr>
<div class="page" id="page">
    <label for="" class="r">
        Question ' . $q . ' :
        <input type="text" class="q" name="qus">
    </label>
        <button class="b glyphicon glyphicon-plus" name="addq"></button>
    <div class="qus">
        <br>
        <br>
        <label for="" class="g">
            Answer ' . $a . ' :
            <input type="text" name="ansr">
        </label>
             <button class="b glyphicon glyphicon-plus" name="adda"></button>
    </div>
</div>\'
    $(document).ready(function(){    
    add(text);
    </script>';
}
function page($p)
{
    echo '

        <label for="">
            Page ' . $p . '
        </label>
             <button class="b glyphicon glyphicon-plus" name="addp"></button>
        <hr>
           
';
}
function qus($q, $a)
{
    echo '
    <label for="" class="r">
    Question ' . $q . ' :
    <input type="text" class="q" name="qus">
</label>
    <button class="b glyphicon glyphicon-plus" name="addq"></button>
<div class="qus">
    <br>
    <br>
    <label for="" class="g">
        Answer ' . $a . ' :
        <input type="text" name="ansr">
    </label>
         <button class="b glyphicon glyphicon-plus" name="adda"></button>
</div>
';
}
$survey = new Survey(1, 1, 1);

if (isset($_POST['addp'])) {
    $survey->addPage($survey->numOfpages + 1);
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
    <script src="script.js"></script> 
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
<!-- <div id="page"></div> -->
<?php echo '
<script>$


</script>'; ?>
        <form action="" method="POST">
            <div class="sur" id="sur">
                <?php page(1); ?> 
                <div class="page" id="page">
                <?php qus(1, 1); ?> 
                </div>
            </div>
        </form>
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

.r{
    color : red;
}
.g{
    color : green;
}
    .sur {
        width: 80%;
        margin: 50px auto 0 0;
    }
    .page{
        margin: 30px auto;   
        width:100%; 
        /* border:1px solid black; */

    }
    .qus{
        width:100%;
        border:1px solid black;
        border-top:none;
        border-left:none;
        border-right:none;
        padding: 0 10px 10px 10px;
    }
    label{      
        font-size : 20px !important;
        font-weight : bold !important;
        width:90%;
    }
  input.q{
    height : 40px;
    width :90% !important;
    margin: 0 auto;
    font-size : 16px;
}
input[type=text]{
    height : 40px;
    width :60% ;
    margin: 0 auto;
    font-size : 16px;

}

hr{
    border:1px solid;
}
    .b {
        /* margin-left: 10%; */
        float: right !important;
        height:40px !important;
        border-radius : 20px ;
        border : 1px solid black;
        background : #0074D9;
        color : white;
    }
    .b:hover{
        color : white;
        background : red;
    }
</style>