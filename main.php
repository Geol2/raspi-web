<?php
/**
 * Created by PhpStorm.
 * User: big94
 * Date: 2018-07-20
 * Time: 오전 2:17
 */
session_start();
if(!isset($_SESSION['userid']))
{
    header('Location : ./login.php');
}

echo "홈(로그인) 성공";

echo "<a href=logout.php>logout</a>";

?>