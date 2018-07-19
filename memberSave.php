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
$pwd2 = md5($_POST['pwd2']);
$email = $_POST['email'];

$query = "INSERT INTO LOGIN_INFO (id, pwd, email) values ('$id', '$pwd', '$email')";

if($conn -> query($query)){
    echo "<script> document.location.href='http://203.250.35.169/login.php'; </script>";
} else {
    echo "fail login";
}

if($pwd != $pwd2) {
    echo "비밀번호가 서로 다릅니다.";
    echo "<a href = sign_up.php> back page</a>";
    exit();
}

if($id == NULL || $pwd == NULL || $pwd2 == NULL || $email == NULL) {
    echo "빈 칸을 모두 채워야 합니다.";
    echo "<a href = sign_up.php> back page</a>";
    exit();
}

$check_id = "SELECT * FROM LOGIN_INFO WHERE id='$id' ";

$result = $conn->query($check_id);

if($result -> num_rows == 1) {
    echo "중복된 id입니다.";
    echo "<a href='sign_up.php'> back page </a>";
}

