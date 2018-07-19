<?php
/**
 * Created by PhpStorm.
 * User: big94
 * Date: 2018-07-20
 * Time: 오전 1:43
 */
include("config_db.php");

session_start();

$id = $_POST['id'];
$pwd = $_POST['pwd'];

$check = "SELECT * FROM id WHERE id='$id'";
$result = $conn->query($check);

if($result->num_rows==1){
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if($row['userpwd'] == $pwd){
        $_SESSION['userid'] = $id;

        if(isset($_SESSION['userid'])){
            header('Location: ./main.php');
        }
        else {
            echo "세션 저장 실패";
        }
    }
    else
        {
        echo "틀린 id나 패스워드";
    }
}
else {
    echo "틀린 id나 패스워드";
}

?>