<?php 
session_start();
include("config/connection.php");
function getUsers($dbc)
{
    $user = array();
    $q = "select * from users where 1";
    $rs = mysqli_query($dbc, $q);
    if ($rs) {
        while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
            array_push($user, $row['user_name']);
        }

        if (isset($_POST['name'])) {
            $sqlUser = $_POST['name'];
            if (in_array($sqlUser, $user)) {
                $_SESSION['user'] = $sqlUser;
                sleep(2);
                header('Location: index.php');
            } elseif ($sqlUser == null) {
                echo '
                <div class="wrongUser">Enter a username please ! <div>
                ';
            } else {
                echo '
                <div class="wrongUser"> The user Does not exists ! <div>
                ';
            }
        }
    }

}


function login($dbc)
{

    echo '
    <form action="login.php" method="POST" >
        <input type="text" name="name"  placeholder="username">
        <br>
        <input type="submit" name="submit" value="Login">
    </form>
    ';

    if (isset($_POST['submit'])) {
        getUsers($dbc);
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <div class="login">
        <h3>LOGIN</h3>
       <?php login($dbc) ?>
       <div class="user"></div>
    </div>
    
</body>
</html>



<Style>

    html { height: 100%; }

body {
       padding: 30px;
        color: #647086;
        text-align: left;
        font-family: 'Source Sans Pro', Arial, Helvetica, sans-serif;
        font-size: 18px;
        font-weight: bold;
        background: #f8f8f8;
        outline: 0;
    }
 .login {
    
    max-width: 800px;
    margin: 200px auto ;
    padding: 30px;
    box-shadow: 0px 7px 20px rgba(0,0,0,.1);
    background: rgba(244, 244, 244, 0.76);
}   
.wrongUser {
    background-color: #F00;
    color:white;
    display: inline-block;
    height: 30px;
    padding-left:10px;
    padding-top:2px;
    position: absolute;
    width: 230px;
    left:43%;
    top:51%

}
    .user {
        position: absolute;

    }
form {
  min-width: 500px;
  padding: 20px;
  border-radius: 2px;
  
}
.required:required {
  box-shadow: inset 5px 0 0 rgba(41, 99, 189, .8);
}
.required  {
  display: inline-block;
  padding: 0 5px;
  background: rgb(99, 112, 134);
  color: #f7f7fc;

}
form {     
  width: 300px;
  margin: 0 auto; 
}

input {
    box-shadow: 1px 1px 10px rgba(0,0,0,.1);
  height: auto ;
  margin: 5px 100px ;
  padding: 10px ;
  border: none;
  border-radius: 2px;
  font-size: 18px;
  cursor: text;
  width:250px;
  
}
input[type=submit] {
    width:100px;
  margin-left: 180px;
  font: bold 1em 'Source Sans Pro', Arial, Helvetica, sans-serif;
  color: white;
  border: 3px solid rgb(35, 97, 192);
  border-radius: 2px;
  cursor: pointer;
  background: #297dfc;
}

</Style>