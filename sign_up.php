<?php
include ("config_db.php");
session_start();

?>

    <html>

        <head> </head>

        <body>
        <h1>INPUT LOGIN </h1>
        <form name="join" method="post" action="/memberSave.php">
            <table border="1">
                <tr>
                    <td>ID</td>
                    <td><input type="text" size="30" name="id"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" size="30" name="pwd"></td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><input type="password" size="30" name="pwd2"></td>
                </tr>
                    <td>e-mail</td>
                    <td><input type="text" size="30" name="email"></td>
                </tr>
                <input type=submit value="submit"><input type=reset value="rewrite">
            </table>
        </form>
        </body>

    </html>