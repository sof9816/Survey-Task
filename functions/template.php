<?php

/* ----------------------------------------- */
/* ######################################### */
/* ############# template ################## */
/* ######################################### */
/* ----------------------------------------- */


/* ----------------------------------------- */
/* ############# header #################### */
/* ----------------------------------------- */
function getUser()
{
    $q = 'select fullname from users where ( user_name="'
        . $_SESSION['user'] . '" or email ="'
        . $_SESSION['user'] . '" );';
    $rs = mysqli_query($GLOBALS['dbc'], $q);
    $row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
    echo $row['fullname'];

}
function head()
{
    echo '<h2 class="sTitle">' . getSurName() . '</h2>';
}


/* ----------------------------------------- */
/* ############# footer #################### */
/* ----------------------------------------- */

function footer()
{
    echo '<p>Created By Mustafa Naser</p>';
}

/* ----------------------------------------- */
/* ############# sideNav #################### */
/* ----------------------------------------- */

function sideNav($dbc)
{

    $q = 'select * from survey_ where 1;';
    $rs = mysqli_query($GLOBALS['dbc'], $q);

    echo '<form  method="POST">
    <ul> ';
    while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
        echo '
            <li> <span> <input type="submit" name="chsur" value="' . $row['survey_name'] . '"></span></li>
           
        ';
    }
    echo ' </ul></form>';

}


?>

