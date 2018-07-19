<?php
    include ("config_db.php");
    session_start();
?>

<html>
    <head> </head>

    <body>

    <h1>LOGIN </h1>

    <form method = "POST" action = "login.php">
        id <input type = "text" name = "id"> <br>
        pw <input type = "password" name = "pw"> <br>
        <input type = "submit" value = "login">
    </form>
    <button onclick="location.href='sign_up.php'"> sign up </button>
    </body>
</html>