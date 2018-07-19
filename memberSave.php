<?php
/**
 * Created by PhpStorm.
 * User: big94
 * Date: 2018-07-19
 * Time: 오후 9:16
 */

include ("config_db.php");

$id = $_POST['id'];
$pwd = md5($_POST['pwd']);
$pwd2 = $_POST['pwd2'];
$email = $_POST['email'];

$query = "INSERT INTO LOGIN_INFO (id, pwd, email) values ('$id', '$pwd', '$email')";

if($conn -> query($query)){
    echo "<script> document.location.href='http://203.250.35.169/login.php'; </script>";
} else {
    echo "fail login";
}