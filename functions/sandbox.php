    <?php

    // unsetCookie('plusUser');
    // session_start();
    function unsetCookie($name)
    {
        unset($_COOKIE[$name]);
        $res = setcookie($name, '', time() - 3600);
    }

    if (isset($_COOKIE['plusUser'])) {
        header('Location: done.php');
    }
    if (!isset($_SESSION['user'])) {
        // $_SESSION['user'] = "";
        session_unset();
        session_destroy();
        header('Location: login.php');
        // exit();

    }
   
    /* ----------------------------------------- */
    /* ######################################### */
    /* ############# sandbox ################### */
    /* ######################################### */
    /* ----------------------------------------- */
    function displayPoll($prompt, $choices, $pollNumber)
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

    function getQuestions($dbc)
    {
        $query = "select * from survey_qus where 1";
        $result = @mysqli_query($dbc, $query);
        echo '<form method ="post" action= "index.php" > ';

        if ($result) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $body = $row['question_body'];
                $index = $row['qus_id'];
                $choices = array('yes', 'Maybe', 'No');
                echo '<div class="questions">';
                displayPoll($body, $choices, $index);
                echo '</div>';



            }
            echo '
            <input type="submit" name="submit" value="Submit" class="submit" >  
            </form>';
        }
        for ($i = 1; $i < 3; $i++) {
            if (isset($_POST['submit'])) {
                for ($j = 1; $j < 3; $j++) {
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' and !isset($_POST['poll' . $j])) {
                        printM("<br><h3 style=\"color:red;\"> Please fill all the choices !<h3>", 1);
                        break 2;
                    }
                }
                pollSet($i, $dbc);
            }

        }

    }




    function pollSet($index, $dbc)
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
                    $selection_stmt = 'update poll set c_one = ' . $mod_c_one . ' where  id =' . $index;
                    break;
                case 1:
                    $selection_stmt = 'update poll set c_two = ' . $mod_c_two . '  where  id =' . $index;
                    break;
                case 2:
                    $selection_stmt = 'update poll set c_three = ' . $mod_c_three . '  where  id =' . $index;
                    break;

            }
        
            // $selection_one = "select * from poll where id =" . $index;
            // $process_one = mysqli_query($dbc, $selection_one);
            // $row2 = mysqli_fetch_array($process_one, MYSQLI_ASSOC);
            // if($row2 == $row ){

            // }
            // else {
            //     echo "<br>fill all the poll ";
            //     return;
            // }
            // while ($row2 = mysqli_fetch_array($process_one, MYSQLI_ASSOC)) {
            //     $mod_c_one_new = (int)$row['c_one'] ;
            //     $mod_c_two_new = (int)$row['c_two'] ;
            //     $mod_c_three_new = (int)$row['c_three'] ;
            // }

            $process = mysqli_query($dbc, $selection_stmt) or die(mysqli_connect_error());
            if ($process) {
                echo "<br>Your vote has been casted for poll" . $index . " => ";
                setcookie("plusUser", "+1", time() + (60 * 60 * 24 * 30), "index.php");
                header('Location: done.php');
            } else {

                printM("Error", $index);
            }
        } else {
            // printM("You made no choice !", $index);
        }
    }

    function printM($m, $i)
    {
        if ($i == 1) {
            echo $m;
        }
    }
    ?>

