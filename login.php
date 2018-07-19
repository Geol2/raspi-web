<?php
    include ("config_db.php");
?>

<html>
    <head> </head>

    <body>

    <h1>LOGIN </h1>

    <form method = "POST" action = "/login_check.php">
        id <input type = "text" name = "id"> <br>
        pwd <input type = "password" name = "pwd"> <br>
        <input type = "submit" value = "login">
    </form>
    <button onclick="location.href='sign_up.php'"> sign up </button>
    </body>
</html>