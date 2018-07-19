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

        <form method = "POST" action = "sign_up.php">
            <input type = "submit" value = "sign_up">
        </form>
    </body>
</html>

<?php
/**
 * Created by PhpStorm.
 * User: big94
 * Date: 2018-07-19
 * Time: 오후 8:43
 */