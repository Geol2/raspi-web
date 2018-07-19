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

echo "홈(로그인) 성공</br>";
echo "<a href=logout.php>logout</a> </br>";


$ip_print = $_SERVER['REMOTE_ADDR'];
echo "현재 접속한 장치의 아이피 : ".$ip_print."</br>";
?>